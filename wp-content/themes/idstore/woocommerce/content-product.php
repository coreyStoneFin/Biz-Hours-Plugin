<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;
$product_page_productname = etheme_get_option('product_page_productname');
$product_page_price = etheme_get_option('product_page_price');
$product_page_addtocart = etheme_get_option('product_page_addtocart');
// Store loop count we're currently on
if (empty($woocommerce_loop['loop'])) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
}

// Ensure visibility
if (!$product || !$product->is_visible()) {
    return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
//if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
//	$classes[] = 'first';
//}
if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns']) {
    $classes[] = 'last';
    $classes[] = ' product-grid';
}
$product_sidebar = etheme_get_option('product_page_sidebar');
if ($woocommerce_loop['columns'] == 4 && !$product_sidebar) {
    $classes[] = ' span3';
    $classes[] = ' product-grid';
} elseif ($product_per_row == 4) {
    $classes[] = ' span2';
    $classes[] = ' product-grid';
} else {
    $classes[] = ' span3';
    $classes[] = ' product-grid';
}

?>
<li <?php post_class( $classes ); ?> style="list-style-type: none;">

    <div class="img-wrapper">
        <?php
        /**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');

        ?>
    </div>
    <div class="product-name-price">
        <div class="product-name">
            <a href="<?php the_permalink(); ?>">
                <?php
                 echo get_the_title();

                ?>
            </a>
        </div>
        <div class="clear"></div>
    </div>
    <div class="product-information">
        <?php etheme_print_stars() ?>

        <div
            class="product-descr"><?php echo apply_filters('woocommerce_short_description', $post->post_excerpt) ?></div>
        <div class="addtocont">


            <?php
            /**
	 * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            if ($product_page_price) {
       //         do_action('woocommerce_after_shop_loop_item_title');
            }

            ?>


            <?php

            /**
	 * woocommerce_after_shop_loop_item hook.
             *
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            if ($product_page_addtocart) {
                do_action('woocommerce_after_shop_loop_item');
            }


            ?>
        </div>

        <div class="clear"></div>

</li>
