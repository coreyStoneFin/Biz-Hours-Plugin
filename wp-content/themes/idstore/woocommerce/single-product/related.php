<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related(20); 
$product_per_row = etheme_get_option('prodcuts_per_row');

if ( sizeof($related) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> 20,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related
) );

$products = new WP_Query( $args );

$rand = rand(1000,99999);

$woocommerce_loop['columns'] 	= $columns;
$related_count = 0;

if ( $products->have_posts() ) : ?>
    <div class="food-slider related columns<?php echo $product_per_row?>">
		<div class="titleRow">
        <h2 class="slider-title"><?php _e('Related Products', ETHEME_DOMAIN); ?></h2>
		<div class = "slideButtons">
		<div class="prev arrow <?php echo $arrowClass; ?> arrow<?php echo $rand ?>" data-groupID='<?php echo $rand ?>' style="cursor: pointer; ">&nbsp;</div>
		<div class="next arrow <?php echo $arrowClass; ?> arrow<?php echo $rand ?>" data-groupID='<?php echo $rand ?>' style="cursor: pointer; ">&nbsp;</div>
		</div>
		</div>
        <div class="slider-<?php echo $rand ?>" <?php if($related_count < 5): ?>style="height:auto;"<?php endif; ?>>
            <div class="rockSlider" data-groupID='<?php echo $rand ?>'>
            <?php $itemCounter = 0; ?>
			<?php while ( $products->have_posts() ) : $products->the_post();  $related_count++; ?>
		      <div class="slide rock-product-slide" data-itemNumber="<?php echo $itemCounter ?>">
				<?php woocommerce_get_template_part( 'content', 'product' ); ?>
	           </div> 
			<?php 
				$itemCounter =$itemCounter+1;
			endwhile; // end of the loop. ?>
            </div>
        </div>
        <?php if($related_count > 1): ?>
        
        	<?php
        		$arrowClass = '';
        		if($related_count < 4) {
	        		$arrowClass = 'hidden-desktop';
        		}
        	?>
        	
        <?php endif; ?>
             
    </div><!-- product-slider -->     
    <?php if($related_count > 1): ?>
        
    <?php endif; ?>
	
<?php endif; 

wp_reset_query();
