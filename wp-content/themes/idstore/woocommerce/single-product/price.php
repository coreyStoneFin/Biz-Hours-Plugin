<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
?>
<div class="main-info product_meta" itemprop="offers" itemscope itemtype="http://schema.org/Offer">               
    <div itemprop="price" class="price-block">   
        <?php echo $product->get_price_html(); ?>
    </div>	   
	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

    <div class="product-stock">
    
       <?php etheme_print_stars(true); ?>
    
    	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && $product->get_sku() ) : ?>
    		<span class="product-code"><?php _e('SKU:', ETHEME_DOMAIN); ?> <span class="sku"><?php echo $product->get_sku(); ?></span></span>
    	<?php endif; ?>
        
        <?php
        	// Availability
        	$availability = $product->get_availability();
        	
        	if ($availability['availability']) :
        		echo apply_filters( 'woocommerce_stock_html', '<span class="stock '.$availability['class'].'">'.__('Availability:', ETHEME_DOMAIN).' <span>'.$availability['availability'].'</span></span>', $availability['availability'] );
            endif;
        ?>        

    </div>
    <div class="clear"></div>
</div>
<hr />