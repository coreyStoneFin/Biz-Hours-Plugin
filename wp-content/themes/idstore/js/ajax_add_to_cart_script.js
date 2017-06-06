jQuery( function( $ ) {
	//this duplicates the script found in the plugin, I THINK. check out the ajax_add_to_cart plugin and check for differences, see if they're necessary or what's going on.
	//AHH I also add a 'var' in front of the 'item = {};' bit on line 20.
	return;
	//http://plugins.svn.wordpress.org/woocommerce-ajax-add-to-cart-for-variable-products/trunk/js/add-to-cart-variation.js
	// wc_add_to_cart_params is required to continue, ensure the object exists
	if ( typeof wc_add_to_cart_params === 'undefined' )
		return false;

	// Ajax add to cart
	//!!! the .product-variant-cart is specific to the customized eatfit theme.
	$( document ).on( 'click', '.product-variant-cart .single_add_to_cart_button', function() {

		$variation_form = $( this ).closest( '.variations_form' );
		var var_id = $variation_form.find( 'input[name=variation_id]' ).val();

		var product_id = $variation_form.find( 'input[name=product_id]' ).val();
		var quantity = $variation_form.find( 'input[name=quantity]' ).val();

		//attributes = [];
		var item = {};

		$variation_form.find('[name^=attribute]').each(function() {

			var attribute = $(this).attr("name");
			var attributevalue = $(this).val();

			item[attribute] = attributevalue;
		});

		//item = JSON.stringify(item);
		//alert(item);
		//return false;

		// AJAX add to cart request

		var $thisbutton = $( this );

		if ( $thisbutton.is( '.product-variant-cart .single_add_to_cart_button' ) ) {

			$thisbutton.removeClass( 'added' );
			$thisbutton.addClass( 'loading' );

			var data = {
				action: 'woocommerce_add_to_cart_variable_rc',
				product_id: product_id,
				quantity: quantity,
				variation_id: var_id,
				variation: item
			};

			// Trigger event
			$( 'body' ).trigger( 'adding_to_cart', [ $thisbutton, data ] );

			// Ajax action
			$.post( wc_add_to_cart_params.ajax_url, data, function( response ) {

				if ( ! response )
					return;

				var this_page = window.location.toString();

				this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

				$thisbutton.removeClass('loading');

				if ( response.error && response.product_url ) {
					window.location = response.product_url;
					return;
				}

				fragments = response.fragments;
				cart_hash = response.cart_hash;

				// Block fragments class
				if ( fragments ) {
					$.each(fragments, function(key, value) {
						$(key).addClass('updating');
					});
				}

				// Block widgets and fragments
				$('.shop_table.cart, .updating, .cart_totals,.widget_shopping_cart_top').fadeTo('400', '0.6').block({message: null, overlayCSS: {background: 'transparent url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } } );

				// Changes button classes
				$thisbutton.addClass( 'added' );


				// View cart text
				if ( ! wc_add_to_cart_params.is_cart && $thisbutton.parent().find( '.added_to_cart' ).size() === 0 ) {
					$thisbutton.after( ' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +
					wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>' );
				}


				// Replace fragments
				if ( fragments ) {
					$.each(fragments, function(key, value) {
						$(key).replaceWith(value);
					});
				}

				// Unblock
				$('.widget_shopping_cart, .updating, .widget_shopping_cart_top').stop(true).css('opacity', '1').unblock();

				// Cart page elements
				$('.widget_shopping_cart_top').load( this_page + ' .widget_shopping_cart_top:eq(0) > *', function() {

					$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');

					$('.widget_shopping_cart_top').stop(true).css('opacity', '1').unblock();

					$('body').trigger('cart_page_refreshed');
				});

				// Cart page elements
				$('.shop_table.cart').load( this_page + ' .shop_table.cart:eq(0) > *', function() {

					$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');

					$('.shop_table.cart').stop(true).css('opacity', '1').unblock();

					$('body').trigger('cart_page_refreshed');
				});

				$('.cart_totals').load( this_page + ' .cart_totals:eq(0) > *', function() {
					$('.cart_totals').stop(true).css('opacity', '1').unblock();
				});

				// Trigger event so themes can refresh other areas
				$('body').trigger( 'added_to_cart', [ fragments, cart_hash ] );
			});

			return false;

		} else {
			return true;
		}

	});

});
