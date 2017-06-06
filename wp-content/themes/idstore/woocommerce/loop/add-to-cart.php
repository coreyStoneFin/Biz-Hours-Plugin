<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* writes out the custom product variant data for variable source products w/ nutrition info.
* BUT GABE, why didn't you put this in variable.php, where it belongs? Well, because woocommerce didn't support using the variable.php
* template in the shop / grid view, so I never realized it was a thing. Consider this file an almagation of the two.
*
*
*/


global $product;
$ajax_addtocart = etheme_get_option('ajax_addtocart');
$product_page_price = etheme_get_option('product_page_price');
$product_page_addtocart = etheme_get_option('product_page_addtocart');
if(isset($_GET['btn'])) {
	$product_page_addtocart = true;
}


if(!function_exists('eatfit_source_createDefinition')) {
	function eatfit_source_createDefinition($key,$name,$meta) {
		$nameKey = eatfit_woocommerce_getname($key);
		//just show an empty value for unfilled meta.
		$val = isset($meta[$nameKey]) ? $meta[$nameKey][0] : "";
		return sprintf('<li class="nutritionRow"><span class="label">%s</span><span class="value">%s</span></li>',$name,$val);
	}
}


//alrighty. If this a variable product with pricing, then instead of doing "select options",
//if the product has multiple size options, display them. If any of the variations have calorie data, add the dropdown.
$isVariable = $product->product_type == 'variable';
$hasSizeVariation = false;
$postmetas = array();
$postmeta = null;
$attributes = array();
$productVariations = array();

// global $asdf;
// if(!isset($asdf))
//   $asdf = 0;
// $asdf = $asdf + -1;
if($isVariable) {
	//it's var5iable. Check out the variations and set $hasSizeVariation IF there are any size variations.
	$postmetas[$product->id] = get_post_meta($product->id);
	$productVariations = $product->get_available_variations();
	$attributes = $product->get_variation_attributes();
	//only do this on the size variation
	if (isset($attributes['pa_size']) == true && empty($attributes['pa_size']) != true) {
		if(isset($postmetas[$product->id]["_default_attributes"]) && isset($postmetas[$product->id]["_default_attributes"]["pa_size"])) {
			$defaultSizeVariation = $postmetas[$product->id]["_default_attributes"]["pa_size"];
			$defaultAttr = unserialize($postmetas[$product->id]["_default_attributes"][0]);
			//hey, you should shorten this to a one liner! NO! BAD! php is stupid and won't let you do an index on the result of a function call
			$defaultAttrValue = $defaultAttr["pa_size"];
		} else {
			//leave it empty - code will just select the first attribute automatically.
			$defaultAttrValue = "";
		}

//		logDie($defaultAttr["pa_size"]);
		//then we have size variations
		$hasSizeVariation = true;
		// if($asdf > 1)
		// 	logDie($attributes);
		foreach($productVariations as $variation) {
			$varid = $variation['variation_id'];
			//product id is the parent product, we need to check out the variations and see if any of THEM have calorie info.
			$postmeta =$postmetas[$varid] = get_post_meta($varid);
			if($hasSizeVariation) {
				//don't break, just continue to finish preloading all the postmeta data
				continue;
			}
		}
	}
}

if($hasSizeVariation) {
	//die(var_export($variations,true));
	//todo make sure you don't break the ajax cart add.
	/*
	* print out the buttons, then the nutrition info, per variant. Tie them together
	* with IDs so they can be toggled by EatFit.ProductTemplate js
	* the styles need to be compatible with scrolling.
	*/

	//make the displayed variations unique to the size attribute.
	//this cuts out valid variations but we just don't have to put them in.
	$seenSizes = array();
	$available_variations = array_filter($productVariations, function($a)
	{
			$sizeName = $a['attributes']['attribute_pa_size'];
			if(isset($seenSizes[$sizeName]))
				return false;
			$seenSizes[$sizeName] = true;
			return true;
	});
	// sort them by the size variation
	usort($available_variations, function($a, $b)
	{
			return strcmp($a['attributes']['attribute_pa_size'], $b['attributes']['attribute_pa_size']);
	});
	$isSingleVariation = false;//count($available_variations) <= 1;
	if($isSingleVariation) {
		//don't write out the buttons
	} else {
		?>
		<ul class="clearfix product-variant-toplevel-options">
		<?php
		$first = true;
		//there's at least one variation.
		foreach($available_variations as $variation) {
			$varid = $variation['variation_id'];
			$variationMeta = $postmetas[$varid];
			//we could pull the size from the postmeta, but it's already available here!
			$sizeName = $variation['attributes']['attribute_pa_size'];

			if($first && $defaultAttrValue == "") {
				$defaultAttrValue = $sizeName;
			}

			$first = false;
			$selectedStyle = $sizeName == $defaultAttrValue ? "selected" : "";
			?>
			<li class="<?php echo $selectedStyle ?>" ><div class="btn-cont size-variation" data-variationid="<?php echo $varid ?>">
				<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
						sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="toggler button %s product_type_%s" data-variation-id="%s" >%s</a>',
							esc_url( $product->add_to_cart_url() . '?size=' . $sizeName ),
							esc_attr( $product->id ),
							esc_attr( $product->get_sku() ),
							($product->is_purchasable() && $ajax_addtocart) ? ' etheme_add_to_cart_button' : '',
							esc_attr( $product->product_type ),
							esc_attr($varid),
							esc_html( $sizeName )
						),
					$product );	?>
					</div></li>
					<?php
				}
			?>
		</ul>
		<?php
	}

	//now write out the calorie info
	?>
	<div class="variant-tab-content">
	<?php
foreach($available_variations as $variation) {
	$varid = $variation['variation_id'];
	$variationMeta = $postmetas[$varid];
	//we could pull the size from the postmeta, but it's already available here!
	$sizeName = $variation['attributes']['attribute_pa_size'];
	$divClass = $sizeName == $defaultAttrValue ? "selected" : "";
	//put the variant id in a class - javascript will ahve to scope dom queries.
	//because an item may be in multiple categories and displayed more than once on the page.
	$divClass = $divClass . " variant-" . $varid;
	//logDie($product_page_price);
	//fun fact! woocommerce variable products, when there is only one variation, won't have the price_html set for some reason.
	$thePrice = $variation['price_html'];
	if($thePrice == '')
	 	$thePrice = '<span class="price">' . $product->get_price_html() . '</span>';
	?>
		<div class="product-variant-details <?php echo $divClass ?>"  style="" >
			<?php if($product_page_price): ?>
				<div class="nutritionRow priceRow clearfix">
					<span class='label'>Price:</span><span class="value"><?php echo str_replace('class="amount"','',$thePrice) ?></span>
				</div>
			<?php endif; ?>
			<fieldset class="nutrition-block">
				<legend>Nutrition Information</legend>
				<ul class="nutritionList">
					<?php
					foreach(eatfit_sourcefields() as $fld) {
						echo eatfit_source_createDefinition($fld['key'],$fld['descr'],$variationMeta);
					}
					?>
				</ul>
			</fieldset>
			<div class='product-variant-cart'>

				<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
					<?php if ( ! empty( $available_variations ) ) : ?>
						<input type='hidden' name='attribute_pa_size' value="<?php echo $sizeName ?>" />
						<!-- comment out the attributes table - only support a size attribute for now.  -->
						<?php if(false/* && true && count($attributes) > 1*/) : ?>
							<table class="variations" cellspacing="0">
								<tbody>
									<?php
										$loop = 0;
										foreach ( $attributes as $name => $options ) :
											$loop++;
											if($name == 'pa_size')
												continue;
											?>
										<tr>
											<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
											<td class="value"><select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>">
												<option value=""><?php echo __( 'Choose an option', ETHEME_DOMAIN ) ?>&hellip;</option>
												<?php
													if ( is_array( $options ) ) {

														if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
															$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
														} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
															$selected_value = $selected_attributes[ sanitize_title( $name ) ];
														} else {
															$selected_value = '';
														}

														// Get terms if this is a taxonomy - ordered
														if ( taxonomy_exists( $name ) ) {

															$orderby = wc_attribute_orderby( $name );

															switch ( $orderby ) {
																case 'name' :
																	$args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
																break;
																case 'id' :
																	$args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
																break;
																case 'menu_order' :
																	$args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
																break;
															}

															$terms = get_terms( $name, $args );

															foreach ( $terms as $term ) {
																if ( ! in_array( $term->slug, $options ) )
																	continue;

																echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
															}
														} else {

															foreach ( $options as $option ) {
																echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
															}

														}
													}
												?>
											</select> <?php
												if ( sizeof($attributes) == $loop )
													echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', ETHEME_DOMAIN ) . '</a>';
											?></td>
										</tr>
											<?php endforeach;?>
								</tbody>
							</table>
						<?php endif ?>
						<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

						<div class="single_variation_wrap" style="">
							<?php do_action( 'woocommerce_before_single_variation' ); ?>

							<div class="single_variation"></div>

							<div class="variations_button">
								<?php //woocommerce_quantity_input(); ?>
								<div class="quantity buttons_added">
									<!-- <div class="quantityButtonContainer"> -->
										<button type="button" value="-" class="minus"><i class="icon-minus"></i>&nbsp;</button>
										<input type="text" step="1" name="quantity" value="1" title="Qty" class="input-text qty text" size="4">
										<button type="button" value="+" class="plus"><i class="icon-plus"></i>&nbsp;</button>
									<!-- </div> -->
								</div>
								<button type="submit" class="single_add_to_cart_button active button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
							</div>

							<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
							<!--  can't user esc_attr( $post->ID ); because we're in the loop now-->
							<input type="hidden" name="product_id" value="<?php echo $product->id ?>" />
							<!-- todo let javascript set this when there's multiple options. -->
							<input type="hidden" name="variation_id" value="<?php echo  $varid ?>" />

							<?php do_action( 'woocommerce_after_single_variation' ); ?>
						</div>

						<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

					<?php else : ?>

						<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', ETHEME_DOMAIN ); ?></p>

					<?php endif; ?>

				</form>
 

				<?php
				// echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				// 	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s" data-variation-id="%s" >%s</a>',
				// 		esc_url( $product->add_to_cart_url() . '?size=' . $sizeName ),
				// 		esc_attr( $product->id ),
				// 		esc_attr( $product->get_sku() ),
				// 		($product->is_purchasable() && $ajax_addtocart) ? ' etheme_add_to_cart_button' : '',
				// 		esc_attr( $product->product_type ),
				// 		esc_attr($varid),
				// 		"Add"
				// 	),
				// $product );
			?>
			</div>
		</div>
	<?php } ?> 
	</div> 
<?php
} else {
	//just display a simple button for any other product type.
?>
	<div class="btn-cont">
		<?php
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			($product->is_purchasable() && $ajax_addtocart) ? ' etheme_add_to_cart_button' : '',
			esc_attr( $product->product_type ),
			esc_html( $product->add_to_cart_text() )
		),
	$product );
	?>
	</div>
	<?php
	}
?>