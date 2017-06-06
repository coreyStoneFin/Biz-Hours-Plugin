<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>
<div class="container">
    <div class="row">
        <div class="span12 breadcrumbs">
            <?php 
                do_action('woocommerce_before_main_content'); 
                $product_per_row = etheme_get_option('prodcuts_per_row'); 
                $product_sidebar = etheme_get_option('product_page_sidebar');
                if($product_per_row == 5){
                    $product_sidebar = false;
                }
            ?>  <a class="back-to" href="javascript: history.go(-1)"><span>&lsaquo;</span> <?php _e('Return to Previous Page', ETHEME_DOMAIN); ?></a>    
         
        </div>
    </div>
</div>
<div class="container">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>
	<?php endwhile; // end of the loop. ?>

	<?php do_action('woocommerce_after_main_content'); ?>
    <div class="clear"></div>
</div><!-- .container -->
<?php get_footer('shop'); ?>