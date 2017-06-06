<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$args = array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> 20,
	'no_found_rows' 		=> 1,
	'orderby' 				=> 'rand',
	'post__in' 				=> $crosssells
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= 2;

$crosssells_count = 0;

if ( $products->have_posts() ) : ?>
    <div class="food-slider cross-sells columns4">
		<div class="titleRow">
        <h2 class="slider-title"><?php _e('You may be interested in&hellip;', ETHEME_DOMAIN) ?></h2>
		<div class = "slideButtons">
		<div class="prev <?php echo $arrowClass; ?> arrow<?php echo $rand ?>" data-groupID='99' style="cursor: pointer; ">&nbsp;</div>
		<div class="next <?php echo $arrowClass; ?> arrow<?php echo $rand ?>" data-groupID='99' style="cursor: pointer; ">&nbsp;</div>
		</div></div>
        <div class="slider-99">
            <div class="rockSlider" data-groupID='99'>
            <?php $itemCounter = 0; ?>
			<?php while ( $products->have_posts() ) : $products->the_post(); $crosssells_count++; ?>
		      <div class="slide rock-product-slide" data-itemNumber="<?php echo $itemCounter ?>">
				<?php woocommerce_get_template_part( 'content', 'product' ); ?>
	           </div> 
			<?php 
				$itemCounter =$itemCounter+1;
			endwhile; // end of the loop. ?>
            </div>
        </div>
        <?php if($crosssells_count > 1): ?>
            <?php
        		$arrowClass = '';
        		if($crosssells_count < 4) {
	        		$arrowClass = 'hidden-desktop';
        		}
        	?>
        <?php endif; ?>

			
                           
    </div><!-- product-slider -->     
<?php endif; 

wp_reset_query();
