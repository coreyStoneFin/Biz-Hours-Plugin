
(function ($) {
	//because braces are overrated and this is way cooler than typing out two function calls.
	window.EatFit = {
		init : function () {
			for (var prop in EatFit)
				if (EatFit.hasOwnProperty(prop))
					if (typeof EatFit[prop].init == 'function')
						EatFit[prop].init();
		}
	};

	//EatFit.product.custom = (function() {
	//	var fixCarbsSelector = function() {
	//		$("#component_options_1422435272").val("please pick something");
	//		$(".composite_add_to_cart_button").addClass('disabled');
	//		$(".composite_add_to_cart_button").prop('disabled', true);
	//	}
	//	return {
	//		init : fixCarbsSelector
	//	}
	//})();

	//if($("#component_options_1422435272").size() > 0) {
		$(document).ajaxComplete(function (event, xhr, settings) {
			//debugger;
			if(settings.data !== undefined) {
				//debugger;
				var theID = settings.data.split('&')[1].split('=')[1];
				if (theID == eatfit_custom_params.empty_product_id) {
					$("[data-nav_title='Carbs']").find('.component_data').hide();
					//$('select#notused > option.attached.enabled').attr('selected', true);
					//$('select#notused').trigger('change');
					//$(".composite_add_to_cart_button").addClass('disabled');
					//$(".composite_add_to_cart_button").prop('disabled', false);
				}
			}
		});

	jQuery("img[alt='prodz_n0t_uzed']").closest('tr').detach()
	//}
	//$(window).load(function(){
	//	$("#component_options_1422435272").val("Please select an option");
	//	$(".composite_add_to_cart_button").addClass('disabled');
	//	$(".composite_add_to_cart_button").prop('disabled', true);
	//});
	//$(window).load(function(){
	//	//debugger;
	//	$(".composite_add_to_cart_button").addClass('disabled');
	//	$(".composite_add_to_cart_button").prop('disabled', true);
	//	$("#component_options_1422435272").val("please pick something");
    //
	//});


	EatFit.ProductTemplate = (function () {
		//wires the size (regular, small) buttons to act as tabs for the variant information.
		var wireProductVariantSwitchers = function () {
			$(".product-variant-toplevel-options .btn-cont.size-variation a.toggler").on('click', function () {
				//display variation data with custom fields on product variants in the category and grid view.
				var $dis = $(this);
				var $container = $dis.parents(".product-information");
				//toggle the button, then the variant details.
				var $theButtonContainer = $dis.parents("li").first();
				$theButtonContainer.parent().find("li").removeClass("selected");
				$theButtonContainer.addClass("selected");
				//toggle the variant-details.

				var varid = $dis.parents(".btn-cont").data("variationid");
				var $matchingVariantDetails = $container.find(".variant-tab-content .product-variant-details.variant-" + varid);
				$('.variant-tab-content .product-variant-details', $container).not($matchingVariantDetails.addClass('selected')).removeClass("selected")
				return false;
			});
		};

		//rewires the hoverintent on the top minicart widget if it was updated
		var handleAjaxCartAdd = function () {
			$("body").on('added_to_cart', function (e, fragments, cart_hash) {
				var doUpdateMiniCart = false;
				$.each(fragments, function (key, value) {
					if (key == '#top-cart')
						return !(doUpdateMiniCart = true);
				});
				if (doUpdateMiniCart) {
					setupHoverIntent();
				}
			});
			setupHoverIntent();
		};
		var setupHoverIntent = function () {
			$('.shopping-cart-wrapper').hoverIntent(function () {
				$(".cart-popup").stop().slideDown(100);
			}, function () {
				$(".cart-popup").stop().slideUp(100);
			});
		};
		// Jeff modified fixupMinusQuantityClick and added fixupPlusQuantityClick to make quantity buttons on products work
		var fixupMinusQuantityClick = function () {
			$("body").on('click', '.product-grid .variations_button button.minus', function () {
				var $btn = $(this);
				var $qty = $btn.siblings("input.qty");
				var val = parseInt($qty.val());
				//alert("hey i pressed minus button!");
				if (val < 1)
					$qty.val(1);
				else if (val == 1)
					return false;
				else
					$qty.val(val-1);
			});
		}

		var fixupPlusQuantityClick = function () {
			$("body").on('click', '.product-grid .variations_button button.plus', function () {
				var $btn = $(this);
				var $qty = $btn.siblings("input.qty");
				var val = parseInt($qty.val());
				//alert("hey i pressed plus button!");
				if (val > 9999)
					$qty.val(9999);
				else if (val == 9999)
					return false;
				else
					$qty.val(val+1);
			});
		}



		var _init = function () {
			wireProductVariantSwitchers();
			handleAjaxCartAdd();
			fixupMinusQuantityClick();
			fixupPlusQuantityClick();

		}
		return {
			init : _init
		}
	})();

	EatFit.CartUtils = (function () {
		var fixToTopOnScroll = function () {
			//only add the scroll event listener if the cart actually exists.
			var $cart = $("#woocommerce_widget_cart-3");
			if ($cart.length == 0)
				return;
			var $parent = $cart.parents(".container").first();

			var scrollFunc = function () {
				var scrollTop = $(this).scrollTop();
				// var headerHeight = 150$('.header-top').height() + $('.header-bg').height();
				if (scrollTop > 200) {
					if (!$cart.hasClass('fixed-sidebar')) {
						// $cart.width($cart.parent().width());
						$cart.stop().addClass('fixed-sidebar');
					}
				} else {
					if ($cart.hasClass('fixed-sidebar'))
						$cart.stop().removeClass('fixed-sidebar');
				}
			};
			$(window).scroll(scrollFunc);
			scrollFunc();
		}
		return {
			init : fixToTopOnScroll
		}
	})();

	////////-------   added by Carl
	//$('.warningBlock')  // my text box
	//$('#local_pickup_time_select')  // my select box
	//mDt.setDate(mDt.getDate() + 2);  // two days out
	//new Date((jQuery('#local_pickup_time_select').find(":selected").val()))  //date from selector
	$('#local_pickup_time_select').bind("change", function () {

		var needWarn = false;
		if (jQuery('#local_pickup_time_select').find(":selected").val() != 'As Soon As Possible') {
			var currentDate = new Date();
			var selectedDate = new Date((jQuery('#local_pickup_time_select').find(":selected").val()));
			var twoDaysOut = new Date(currentDate.setDate(currentDate.getDate() + 2));
			if (selectedDate.getDate() < twoDaysOut.getDate()) {
				needWarn = true;
			}
		} else {
			needWarn = true;
		}
		if (needWarn) {
			$('.warningBlock').show();
		} else {
			$('.warningBlock').hide();
		}

	});
	$.fn.rockSlide = function (options) {
		return this.each(function () {
			var settings = $.extend({
					extraPx : 0
				}, options || {});

			var $theBox = $(this);
			var $slides = $theBox.children(".rock-product-slide");
			var $slidesInView = 2;
			if ($slides == null) //then whoever made the page burried the boxes more than one layer deep on the nesting and we have to use the more costly find...
			{
				$slides = $theBox.find(">.rock-product-slide");
			}
			$slides.find('a.product-image ').contents().unwrap(); //this makes the images un-clickable, otherwise they'd take you to the product page.
			$slides.find('div.product-grid img').each(function (index, el) {
				$(el).attr("style", "display:block;margin:auto;")
			})
			if ($slides.length > 1) {
				settings.offset = ($slides.get(1).offsetLeft - $slides.get(0).offsetLeft - $slides.get(0).offsetWidth);
			}
			//throw the original title into a data attribute so we can reference it as we scroll...
			var $titleBox = $theBox.parents('.food-slider').find('.slider-title');
			$titleBox.data("originalTitle", $titleBox.text());
			var setTitle = function (counter) {
				if (counter) {
					$titleBox.html($titleBox.data("originalTitle") + '<br />(' + (currentIndex + 1) + " of " + $slides.length + ")");
					$titleBox.width('100%');
				} else {
					$titleBox.html($titleBox.data("originalTitle"));
					$titleBox.width('auto');
				}
			}
			var sliderBoxWidth = 300;
			var setSliderSize = function () {
				var $parent = $theBox.parent();
				sliderBoxWidth = $parent.innerWidth();
				$theBox.width(sliderBoxWidth); //force our container to be the same size as it's parent - this way it doesn't go underneith stuff.
				delay = 0;

				$slidesInView = parseInt($theBox.width() * 1.0 / $slides.get(1).offsetWidth);

				if ($slidesInView == 1) {
					setTitle(true);
				} else {
					setTitle(false);
				}
				lineUpScroll();
			}
			$(window).on("resize", setSliderSize); //then again each time the window is resized.

			var scrollAnimation = false;
			var delay = 500;
			var lineUpScroll = function () {
				//figure out our current scroll position
				var currentScroll = $theBox.scrollLeft();
				//figure out it's closest element position
				var newSlidePosition = 0;
				var distanceToNeighbor = 999999;
				$slides.each(function (index, el) {
					var currentSlideGlobalPosition = el.offsetLeft; //find it's position on the page
					var boxPosition = el.parentElement.offsetLeft; //find the position of it's parenet that we're scrolling inside of
					newSlideRelPosition = currentSlideGlobalPosition - boxPosition; //then find the slide's relative position inside it's parent
					var proximity = Math.abs(currentScroll - newSlideRelPosition);
					if (proximity < distanceToNeighbor) {
						distanceToNeighbor = proximity;
						currentIndex = index;
						newSlidePosition = newSlideRelPosition;
					}
				});

				//scroll it to it's closest element position
				if ($slidesInView == 1) {
					setTitle(true);
				} else {
					setTitle(false);
				}
				delay = Math.abs((newSlidePosition + settings.offset - currentScroll) * 250.0 / sliderBoxWidth); //time proportional to the distance
				$theBox.animate({
					scrollLeft : newSlidePosition + settings.offset
				}, delay, "easeOutExpo", function () {
					scrollAnimation = false;
				});

			}

			//function to move the scroller via a button
			var boxesToMove = 1;
			var currentIndex = 0;

			var makeItScroll = function () {

				var newSlideRelPosition = 999999;
				var indexToGoTo = currentIndex + boxesToMove;
				if (indexToGoTo < 0) {
					indexToGoTo = $slides.length - 1 + indexToGoTo;
					//need to specify index of the left most slide when scrolled all the way to the right - we may need to specify index n-2....
				}
				if (indexToGoTo >= $slides.length) {
					//then we need to go all the way to the left
					indexToGoTo = 0;
					newSlideRelPosition = 0;
				} else if (indexToGoTo == $slides.length - 1) { //we're going to the very right side...
					newSlideRelPosition = $theBox.prop("scrollWidth");
				} else {
					delay = 225;
					while (newSlideRelPosition - 20 > $theBox.prop("scrollWidth") - $theBox.width()) {
						var $newItem = $slides.get(indexToGoTo); // get our new slide
						var currentSlideGlobalPosition = $newItem.offsetLeft; //find it's position on the page
						var boxPosition = $newItem.parentElement.offsetLeft; //find the position of it's parenet that we're scrolling inside of
						newSlideRelPosition = currentSlideGlobalPosition - boxPosition; //then find the slide's relative position inside it's parent
						if (newSlideRelPosition - 20 > $theBox.prop("scrollWidth") - $theBox.width()) {
							delay = 725;
							if (boxesToMove > 0) { //we're scrolling off the end, so go back to the beginning
								indexToGoTo = 0;
								newSlideRelPosition = 0;
							} else { //we're probably going to the left from the beginning, so hunt for the correct right-side index
								indexToGoTo -= 1; //for next loop
							}
						}
					}
					newSlideRelPosition = newSlideRelPosition + settings.offset;
				}
				currentIndex = indexToGoTo;
				if ($slidesInView == 1) {
					setTitle(true);
				} else {
					setTitle(false);
				}
				$theBox.animate({
					scrollLeft : newSlideRelPosition
				}, delay, "easeOutExpo", function () {
					scrollAnimation = false;
				});

			}

			// wire up the next/prev buttons
			var nextButton = $(".next.arrow[data-groupid='" + $theBox.data("groupid") + "']");
			nextButton.on("click", function () {
				boxesToMove = 1;
				makeItScroll();
			});

			var prevButton = $(".prev.arrow[data-groupid='" + $theBox.data("groupid") + "']");
			prevButton.on("click", function () {
				boxesToMove = -1;
				makeItScroll();
			});

			$theBox.dragscrollable({
				dragSelector : 'div',
				acceptPropagatedEvent : true,
				doneDraggingCallback : function () {
					delay = 500;
					lineUpScroll();
				}
			});

			simulateTouchEvents($theBox, false);

		})
	};

	/*
	 * jQuery dragscrollable Plugin
	 * version: 1.0 (25-Jun-2009)
	 * Copyright (c) 2009 Miquel Herrera
	 *
	 * Dual licensed under the MIT and GPL licenses:
	 *   http://www.opensource.org/licenses/mit-license.php
	 *   http://www.gnu.org/licenses/gpl.html
	 *

	dragscrollable downloaded from:  https://code.google.com/p/scroll-viewer/source/browse/src/viewer/lib/jquery/dragscrollable.js?r=c826b225d98214860795cae6c1f8aed5d609d693
	CUSTOMIZED TO INCLUDE CALLBACK BY Carl Steffen (carl@stonefin.com)
	 */
	$.fn.dragscrollable = function (options) {
		// extend the options from pre-defined values:

		return this.each(function () {

			var settings = $.extend({
					dragSelector : '>:first',
					acceptPropagatedEvent : true,
					preventDefault : true,
					// Hovav:
					allowY : true,
					doneDraggingCallback : function () {}
				}, options || {});

			var $theBox = $(this);

			var dragscroll = {
				mouseDownHandler : function (event) {
					// mousedown, left click, check propagation
					if (event.which != 1 ||
						(!event.data.acceptPropagatedEvent && event.target != this)) {
						return false;
					}

					// Initial coordinates will be the last when dragging
					event.data.lastCoord = {
						left : event.clientX,
						top : event.clientY
					};

					$.event.add(document, "mouseup",
						dragscroll.mouseUpHandler, event.data);
					$.event.add(document, "mousemove",
						dragscroll.mouseMoveHandler, event.data);
					if (event.data.preventDefault) {
						event.preventDefault();
						return false;
					}
				},
				mouseMoveHandler : function (event) { // User is dragging
					// How much did the mouse move?
					var delta = {
						left : (event.clientX - event.data.lastCoord.left),
						top : ((settings.allowY) ? event.clientY - event.data.lastCoord.top : 0)
					};

					// Set the scroll position relative to what ever the scroll is now
					event.data.scrollable.scrollLeft(
						event.data.scrollable.scrollLeft() - delta.left);
					event.data.scrollable.scrollTop(
						event.data.scrollable.scrollTop() - delta.top);

					// Save where the cursor is
					event.data.lastCoord = {
						left : event.clientX,
						top : event.clientY
					}
					if (event.data.preventDefault) {
						event.preventDefault();
						return false;
					}

				},
				mouseUpHandler : function (event) { // Stop scrolling
					$.event.remove(document, "mousemove", dragscroll.mouseMoveHandler);
					$.event.remove(document, "mouseup", dragscroll.mouseUpHandler);
					if (event.data.preventDefault) {
						event.preventDefault();
						options.doneDraggingCallback.call(this);
						return false;
					}

				}
			}

			// set up the initial events
			$theBox.each(function () {
				// closure object data for each scrollable element
				var data = {
					scrollable : $(this),
					acceptPropagatedEvent : settings.acceptPropagatedEvent,
					preventDefault : settings.preventDefault
				}
				// Set mouse initiating event on the desired descendant
				$(this).find(settings.dragSelector).
				bind('mousedown', data, dragscroll.mouseDownHandler);
			})
		})
	};
	//end plugin dragscrollable


	function simulateTouchEvents(oo, bIgnoreChilds) {
		if (!$(oo)[0]) {
			return false;
		}

		if (!window.__touchTypes) {
			window.__touchTypes = {
				touchstart : 'mousedown',
				touchmove : 'mousemove',
				touchend : 'mouseup'
			};
			window.__touchInputs = {
				INPUT : 1,
				TEXTAREA : 1,
				SELECT : 1,
				OPTION : 1,
				'input' : 1,
				'textarea' : 1,
				'select' : 1,
				'option' : 1
			};
		}

		$(oo).bind('touchstart touchmove touchend', function (ev) {
			var bSame = (ev.target == this);
			if (bIgnoreChilds && !bSame) {
				return;
			}

			var b = (!bSame && ev.target.__ajqmeclk), // Get if object is already tested or input type
			e = ev.originalEvent;
			if (b === true || !e.touches || e.touches.length > 1 || !window.__touchTypes[e.type]) {
				return;
			} //allow multi-touch gestures to work

			var oEv = (!bSame && typeof b != 'boolean') ? $(ev.target).data('events') : false,
			b = (!bSame) ? (ev.target.__ajqmeclk = oEv ? (oEv['click'] || oEv['mousedown'] || oEv['mouseup'] || oEv['mousemove']) : false) : false;

			if (b || window.__touchInputs[ev.target.tagName]) {
				return;
			} //allow default clicks to work (and on inputs)

			// https://developer.mozilla.org/en/DOM/event.initMouseEvent for API
			var touch = e.changedTouches[0],
			newEvent = document.createEvent("MouseEvent");
			newEvent.initMouseEvent(window.__touchTypes[e.type], true, true, window, 1,
				touch.screenX, touch.screenY,
				touch.clientX, touch.clientY, false,
				false, false, false, 0, null);

			touch.target.dispatchEvent(newEvent);
			//e.preventDefault();
			//ev.stopImmediatePropagation();
			//ev.stopPropagation();
			//ev.preventDefault();
		});
		return true;
	};

	$('.rockSlider').rockSlide({
		offset : 0
	});

	/// a section for the checkout page!!!



	///////////// -----  done adding by carl
	///
	///cool plugin to insert an event handler at the top of the event stack - cheating the order of things :-)
	$.fn.bindFirst = function (name, fn) {
		// bind as you normally would
		// don't want to miss out on any jQuery magic
		this.bind(name, fn);

		// Thanks to a comment by @Martin, adding support for
		// namespaced events too.
		var handlers = this.data('events')[name.split('.')[0]];
		// take out the handler we just inserted from the end
		var handler = handlers.pop();
		// move it at the beginning
		handlers.splice(0, 0, handler);
	};

	var datePickerFilter = function(){

		jQuery('style#bdit_style').remove();
		if($('ul#checkout_method_field > li.active').attr("id") != "local_pickup") {

			var $select_target = jQuery('select#local_pickup_time_select');
			if ($select_target.length) {

			var contents = "";
			if ($select_target.val().indexOf('Friday') >= 0) {
				//hide daylength bdits that aren't guaranteed
				contents = '<style type="text/css" id="bdit_style">ul#shipping_method > li:not([data-guaranteed-bdit="1"]){display: none;}</style>';
				jQuery('ul#shipping_method > li[data-guaranteed-bdit="1"]').find('input').last().click();
				jQuery('head').append(contents);
			}
			else if ($select_target.val().indexOf('Tuesday') >= 0) {
				contents = '<style type="text/css" id="bdit_style">ul#shipping_method > li:not([data-bdit="1"]){display: none;}</style>';
				jQuery('ul#shipping_method > li[data-bdit="1"]').find('input').last().click();
				jQuery('head').append(contents);
				//hide 2+ bdits
			}
			else {
				jQuery('style#bdit_style').remove();
				jQuery('input.shipping_method:visible').last().click();
				//unhide any hidden methods from this method thingy
			}
			//debugger;
		}
		}
	}

	datePickerFilter();
	////


	var checkoutShippingMethodChanged = function() {
//debugger;
		if (!$(this).hasClass('active') && $(this).hasClass('tabs')) {
			$('ul#checkout_method_field > li').removeClass('active');
			$(this).addClass('active')

		}

		var $target = jQuery('ul#checkout_method_field > li.active');
		if ($target.length){
			var methodType = "";
		switch ($target.attr("id")) {
			case "local_pickup":
				methodType = "Local Pickup";
				jQuery("div#local-pickup-time-select").contents().each(function () {
					if (this.nodeType === 3) this.nodeValue = $.trim($(this).text()).replace(/Delivery Time/g, "Pickup Time")
					if (this.nodeType === 1) $(this).html($(this).html().replace(/Delivery Time/g, "Pickup Time"))
				});
				// jQuery('style#bdit_style').remove();
				// jQuery('style#shipping_method_style').remove();
				// jQuery('head').append(contents);
				// jQuery('input.shipping_method:visible').last().click();
				//choose a store location
				jQuery('div.shipping_address').hide();
				jQuery('div.shipping_address').prevAll().hide();
				jQuery('.notice_ship_only').hide();

				// jQuery('input[value*="local_pickup"]').last().click();
				jQuery('input[data-method-name*="'+methodType+'"]').last().click();
				//jQuery('input[value="local_pickup"]').click();


				break;
			case "local_delivery":
				methodType = "Local Delivery";
				jQuery("div#local-pickup-time-select").contents().each(function () {
					if (this.nodeType === 3) this.nodeValue = $.trim($(this).text()).replace(/Pickup Time/g, "Delivery Time")
					if (this.nodeType === 1) $(this).html($(this).html().replace(/Pickup Time/g, "Delivery Time"))
				});
				// jQuery('style#bdit_style').remove();
				// jQuery('style#shipping_method_style').remove();
				// jQuery('head').append(contents);
				//jQuery('input.shipping_method:visible').last().click();
				//limit to local delivery
				if (jQuery('[name="ship_to_different_address"]').prop('checked')) {
					jQuery('div.shipping_address').show();
				}
				jQuery('div.shipping_address').prevAll().show();
				jQuery('.notice_ship_only').show();

				// jQuery('input[value*="local_delivery"]').last().click();
				jQuery('input[data-method-name*="'+methodType+'"]').last().click();
				//jQuery('input[value="local_delivery"]').click();

				break;
			case "ups_rate":
				methodType = "UPS";
				jQuery("div#local-pickup-time-select").contents().each(function () {
					if (this.nodeType === 3) this.nodeValue = $.trim($(this).text()).replace(/Pickup Time/g, "Delivery Time")
					if (this.nodeType === 1) $(this).html($(this).html().replace(/Pickup Time/g, "Delivery Time"))
				});

				//jQuery('input.shipping_method:visible').last().click();
				if(jQuery('[name="ship_to_different_address"]').prop('checked')) {
					jQuery('div.shipping_address').show();
				}
					jQuery('div.shipping_address').prevAll().show();
					jQuery('.notice_ship_only').show();

				jQuery('input[data-method-name*="'+methodType+'"]').last().click();

				//allow
				break;
			default:

				//something broke
				break;
		}


		var data = {
			'action': 'get_available_Dates',
			'preferred_method': $target.attr("id"),
			'days_in_transit': 2,
			'days_in_transit_guaranteed': true
		};
		jQuery.post(eatfit_custom_params.ajaxurl, data, function (response) {
			//debugger;
			var $select_target = jQuery('select#local_pickup_time_select');
			$select_target.html(response);
			$select_target.on('change', datePickerFilter);
			//debugger;
			//replace select menu with new options
		});

			var contents = '<style type="text/css" id="shipping_method_style">ul#shipping_method > li:not([data-method-name*="' + methodType + '"]){display: none;}ul#shipping_method > li[data-sf-rate-id*=usps]{display: block !important;}</style>';
			jQuery('style#bdit_style').remove();
			jQuery('style#shipping_method_style').remove();
			jQuery('head').append(contents);

			$(this).trigger("shipping_method_changed");
	}

	};



jQuery('a#tab_4').on('click', checkoutShippingMethodChanged);
	jQuery('ul#checkout_method_field > li').on('click', checkoutShippingMethodChanged);
	//jQuery('[name=shipping_options_choice]').change(checkoutShippingMethodChanged);
	checkoutShippingMethodChanged();
	var checkoutMethodChanged = function () {
		//$(this).attr("value") = 1 for guest, 2 for create an account, 0 for login
		var $target = jQuery('.method-radio input[name=method]:checked');
		switch ($target.attr("value")) {
		case "0": //LOGIN
			//show the login box, hide the new account stuff.
			jQuery('.existingCustomerBox').show();
			jQuery('.createAccountInfo').hide(); //hide new account stuff
			jQuery('.continueCreateAccunt').hide(); //hide the continue button under new account stuff
			jQuery('.continueAsGuest').hide(); //hide the continue as guest button
			//$('#billing_email_field').hide();         //hide the email field in teh billing area - it gets autopopulated from the email box here..
			jQuery('#createaccount').prop("checked", false); //go set the createAccount checkbox - not sure if woocommerce needs it, so I just hid it and take care of setting value
			break;
		case "1": //GUEST ACCOUNT
			//hide the login box AND the new acount stuff
			jQuery('.continueCreateAccunt').show();
			jQuery('.continueAsGuest').show().prop("display", "inline-block");
			//$('#billing_email_field').show();           //well get this below
			jQuery('.createAccountInfo').hide();
			jQuery('.existingCustomerBox').hide();
			jQuery('#createaccount').prop("checked", false);
			break;
		default: //CREATE AN ACCOUNT
			//show the new account stuff and hide the login box
			jQuery('.continueCreateAccunt').show();
			jQuery('.createAccountInfo').show();
			jQuery('.existingCustomerBox').hide();
			jQuery('.continueAsGuest').hide();
			// $('#billing_email_field').hide();
			jQuery('#createaccount').prop("checked", true);
			checkPass();

		}
	};

	var passLogin = jQuery('#password');
	var pass1 = jQuery('.newPasswordBox input');
	var pass2 = jQuery('.newPasswordBox2 input');

	var checkPass = function () {

		//Store the Confimation Message Object ...
		var message = jQuery('.passwordStatus');

		//Set the colors we will be using ...
		var goodColor = "#66cc66";
		var badColor = "#ff6666";
		//Compare the values in the password field and the confirmation field
		if (pass1.attr('value') == pass2.attr('value') && pass2.attr('value') == "") {
			return;
		}
		if (pass1.attr('value') == pass2.attr('value')) {
			//The passwords match.
			//Set good color and inform user of correct password
			pass1.attr("style", "background-color:" + goodColor);
			pass2.attr("style", "background-color:" + goodColor);
			message.attr("style", "color:" + goodColor);

			message.html("Passwords Match!");
		} else {
			//The passwords do not match.
			//Set bad color and notify the user.
			pass1.attr("style", "background-color:" + badColor);
			pass2.attr("style", "background-color:" + badColor);
			message.attr("style", "color:" + badColor);
			message.html("Passwords Do Not Match!");
		}
	};

	var poorValidate = function () {

		if (pass1.attr('value') != pass2.attr('value') && jQuery('.method-radio input[name=method]:checked').attr("value") == 2) {
			checkPass();
			var $target = jQuery('#tab_1');
			$target.click();
			$('html, body').animate({
				scrollTop : $target.offset().top - topOffset
			}, 400);
			alert("Your passwords do not match");
			return false;
		} else {
			$('#place_order').click();
		}

	}

	jQuery('#fakeSubmitOrder').on("click", poorValidate);

	//jQuery('#place_order').bindFirst("click", function () { alert("asfdasdf") });

	pass1.on("input", checkPass);
	pass2.on("input", checkPass);

	passLogin.on("input", function () {
		pass1.attr('value', $(event.target).attr('value'));
	});

	pass1.on("input", function () {
		passLogin.attr('value', $(event.target).attr('value'));
	});

	jQuery('.method-radio input:radio').change(checkoutMethodChanged);
	checkoutMethodChanged();
	var loginChanging = false;
	jQuery('.newPEmailBox input:text').on("input", function () {
		if (!loginChanging) {
			loginChanging = true;
			var val = $(event.target).attr("value");
			$('#billing_email').attr("value", val);
			$('#username').attr("value", val);
			loginChanging = false;
		}
	});

	jQuery('#billing_email').on("input", function () {
		if (!loginChanging) {
			loginChanging = true;
			var val = $(event.target).attr("value");
			$('.newPEmailBox input:text').attr("value", val);
			$('#username').attr("value", val);
			loginChanging = false;
		}
	});

	jQuery('#username').on("input", function () {
		if (!loginChanging) {
			loginChanging = true;
			var val = $(event.target).attr("value");
			$('#billing_email').attr("value", val);
			$('.newPEmailBox input:text').attr("value", val);
			loginChanging = false;
		}
	});
	jQuery('.newPasswordBox').on("input", function () {
		$('#account_password').attr("value", $(this).find('input').attr("value"));
	});

	var topOffset = jQuery('.demo_store').outerHeight();

	jQuery('.leaveTab1').off().on("click", function () {
		var $target = jQuery('#tab_3');
		$target.click();
		$('html, body').animate({
			scrollTop : $target.offset().top - topOffset
		}, 400);
		jQuery('.composited-product-quantity').parent().parent().parent().parent().siblings('.product-total').remove();
		jQuery('#billing_first_name').focus();
		return false;
	}); //add our new one

	jQuery('.leaveTab3').off().on("click", function () {
		var $target = jQuery('#tab_4');
		$target.click();
		$('html, body').animate({
			scrollTop : $target.offset().top - topOffset
		}, 400);
		jQuery('.composited-product-quantity').parent().parent().parent().parent().siblings('.product-total').remove();
		jQuery('#order_comments').focus();
		return false;
	}); //add our new one


	jQuery('.leaveTab4').off().on("click", function () {
		var $target = jQuery('#tab_5');
		$target.click();
		$('html, body').animate({
			scrollTop : $target.offset().top - topOffset
		}, 400);
		jQuery('.composited-product-quantity').parent().parent().parent().parent().siblings('.product-total').remove();

		return false;
	}); //add our new one


	jQuery('#tab_5').on("click", function () {
		jQuery('.composited-product-quantity').parent().parent().parent().parent().siblings('.product-total').remove();
		//var data = {
		//	action: 'get_refreshed_fragments',
		//};
		//$.post( eatfit_custom_params.ajax_url, data, function(response, a, b, c, d){
		//	debugger;
		//});
	});

	//onready
	$(window.EatFit.init);

	//wire up stuff for the build your own feast.

	var $compositRows = $('.variation-Ounces,.variation-Cups').parent('.variation').parent('.product-name');
	if(window.location.href.indexOf('checkout') > -1) {
		var $compositRows = $('dl.component').parent('.product-name');
	}
	$compositRows.siblings('.product-thumbnail,.product-quantity,.product-subtotal,.product-price,.product-remove').remove();
	$compositRows.attr('colspan', 7).attr("style", "text-align:right!important;border-top:none;").children('.variation').css("float", "right");

	$('.composited-product-quantity').parent().parent().parent().parent().siblings('.product-total').remove();
	$('.composited-product-quantity').remove();

	var $msg = $('.woocommerce-message');
	if ($msg.length) {
		if ($msg.html().indexOf("successfully added to your cart") > -1) {
			$('.cart.composite_data.multistep').attr('data-' + 'bto_style', 'progressive')
		}
	}

	$("ul#login_register_switch > li").on('click', function(){
		if(!$(this).hasClass('active')) {
			$('div#login_register_switchee').toggle();
			$('ul#login_register_switch > li').toggleClass('active');
		}
	});
	$(document).ajaxSend(function(event, XHR, options){
		//debugger;
		if(options.url.indexOf("update_order_review") > 0){
			//if($('div#place_order_block_div').length > 0){
			//	var blockDiv = $('div#place_order_block_div');
			//	$(blockDiv).show();
			//}
			//else {
			//	var theLink = $('a#fakeSubmitOrder');
			//	var fakeButtonPosition = $(theLink).position();
            //
			//	var width = $(theLink).outerWidth();
			//	var height = $(theLink).outerHeight();
			//	var blockDiv = document.createElement('div');
			//	$(blockDiv).attr('style', 'width:' + width + 'px;height:' + height + 'px;position:absolute;z-index:9000;opacity:.6;background:rgba(255,255,255,1);');
			//	$(blockDiv).attr('id', 'place_order_block_div');
			//	$(theLink).wrap('<div></div>');
			//	$(theLink).after(blockDiv);
			//}
			$('a#fakeSubmitOrder').block({message: '',
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}});
			$('a#fakeSubmitOrder').css('pointer-events', 'none');
			$('a#fakeSubmitOrder').css('cursor', 'default');

		}
	});
	$(document).ajaxComplete(function(event, XHR, options){
		//debugger;
		if(options.url.indexOf("update_order_review")>0){
			$('a#fakeSubmitOrder').unblock();
			$('a#fakeSubmitOrder').css('pointer-events', '');
			$('a#fakeSubmitOrder').css('cursor', '');
		}
	});
})(jQuery);
