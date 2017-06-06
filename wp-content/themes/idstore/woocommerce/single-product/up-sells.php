<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();
$product_per_row = etheme_get_option('prodcuts_per_row');

if ( sizeof( $upsells ) == 0 ) return;

$args = array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> 20,
	'no_found_rows' 		=> 1,
	'orderby' 				=> 'rand',
	'post__in' 				=> $upsells
);

$products = new WP_Query( $args );
$upsells_count = 0;
if ( $products->have_posts() ) : ?>

    <div class="food-slider upsells columns<?php echo $product_per_row ?>">
		<div class="titleRow">
        <h2 class="slider-title"><?php _e('You may also like&hellip;', ETHEME_DOMAIN) ?></h2>
		<div class = "slideButtons">
		<div class="prev <?php echo $arrowClass; ?> arrow<?php echo $rand ?>" data-groupID='<?php echo $rand ?>' style="cursor: pointer; ">&nbsp;</div>
        <div class="next <?php echo $arrowClass; ?> arrow<?php echo $rand ?>" data-groupID='<?php echo $rand ?>' style="cursor: pointer; ">&nbsp;</div>
		</div>
		</div>
        <div class="slider-<?php echo $rand ?>" <?php if($upsells_count < 5): ?>style="height:auto;"<?php endif; ?>>
            <div class="rockSlider" data-groupID='<?php echo $rand ?>'>
               	$itemCounter = 0;
			<?php while ( $products->have_posts() ) : $products->the_post(); $upsells_count++; ?>
				<div class="slide rock-product-slide" data-itemNumber="<?php echo $itemCounter ?>">
				<?php woocommerce_get_template_part( 'content', 'product' ); ?>
				</div> 
				<?php 
				$itemCounter =$itemCounter+1;
			endwhile; // end of the loop. ?>
            </div>
        </div>
        <?php if($upsells_count > 1): ?>
        	<?php
        		$arrowClass = '';
        		if($upsells_count < 4) {
	        		$arrowClass = 'hidden-desktop';
        		}
        	?>
        <?php endif; ?>
			
                           
    </div><!-- product-slider -->     
    
<?php endif; 

wp_reset_query();