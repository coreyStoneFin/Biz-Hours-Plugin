<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
    do_action( 'woocommerce_before_single_product' );
    $product_layout = etheme_get_option('single_product_layout');
?>
<div class="clear"></div>
 <?php edit_post_link(); ?> 
<div itemscope="" itemtype="http://schema.org/Product">
    <div id="product-page" class="product_layout_<?php echo $product_layout; ?> row product">

    	<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
        <div class="span4 product_description_mainblock productcol summary">
    		<?php do_action( 'woocommerce_single_product_summary' ); ?>

    	</div><!-- .summary -->
        <div class="span3 product_description_banner">
    		<?php if (etheme_get_option('right_banners') && etheme_get_option('right_banners') != '' ) : ?>
    			<?php etheme_option('right_banners',true); ?>
            <?php else: ?>
                <?php dynamic_sidebar( 'product-single-widget-area' ); ?>
            <?php wp_reset_query(); ?>
    		<?php endif; ?>
        </div>
        <div class="clear"></div>

    </div><!-- #product-<?php the_ID(); ?> -->
<?php do_action( 'woocommerce_after_single_product_summary' ); ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>
</div>
