<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

<div class="row">
    <div class="span12">
        <div class="tabs">
		<?php $i=0; foreach ( $tabs as $key => $tab ) : $i++; ?>
				<a href="#tab<?php echo $i; ?>" id="tab_<?php echo $i; ?>" class="tab-title <?php if($i==1): ?> opened<?php endif; ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
			<div id="content_tab_<?php echo $i; ?>" class="tab-content" <?php if($i==1): ?> style="display: block;" <?php endif; ?>>
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>

		<?php endforeach; ?>
        
        <?php if (etheme_get_custom_field('_etheme_custom_tab1_title') && etheme_get_custom_field('_etheme_custom_tab1_title') != '' ) : ?>
            <a href="#tab7" id="tab_7" class="tab-title"><?php etheme_custom_field('_etheme_custom_tab1_title'); ?></a>
            <div id="content_tab_7" class="tab-content">
        		<?php echo do_shortcode(etheme_get_custom_field('_etheme_custom_tab1')); ?>
            </div>              
        <?php endif; ?>	 
        
        <?php if (etheme_get_custom_field('_etheme_custom_tab2_title') && etheme_get_custom_field('_etheme_custom_tab2_title') != '' ) : ?>
            <a href="#tab8" id="tab_8" class="tab-title"><?php etheme_custom_field('_etheme_custom_tab2_title'); ?></a>
            <div id="content_tab_8" class="tab-content">
        		<?php echo do_shortcode(etheme_get_custom_field('_etheme_custom_tab2')); ?>
            </div>              
        <?php endif; ?>	 
        
        <?php if (etheme_get_option('custom_tab_title') && etheme_get_option('custom_tab_title') != '' ) : ?>
            <a href="#tab9" id="tab_9" class="tab-title"><?php etheme_option('custom_tab_title'); ?></a>
            <div id="content_tab_9" class="tab-content">
        		<?php echo do_shortcode(etheme_get_option('custom_tab')); ?>
            </div>              
        <?php endif; ?>	

		</div>
	</div>
</div>

<?php endif; ?>