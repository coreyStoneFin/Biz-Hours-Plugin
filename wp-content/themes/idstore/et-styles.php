<?php
    foreach(etheme_get_chosen_google_font() as $font) {
	    ?>
	    	<link href='//fonts.googleapis.com/css?family=<?php echo $font; ?>' rel='stylesheet' type='text/css'/>
	    <?php
    }


$selectors = Array();
$selectors['active_color'] = '
	a:hover,
    .blog1_icon_container a:hover,
    .blog_icon_container a:hover,
    .product_meta a:hover,
    .logo-text-red,
    .text-banner a h1:hover,
    .cart_table_item .product-name a:hover,
    #breadcrumb a:hover, .back-to:hover, .back-to:hover span,
    .block-with-icon:hover i,
    .shopping_cart_wrap ul > li > a:hover,
    .menu > ul > li.over > a,
    .menu > ul > li.active > a,
    .menu > ul > li > a:hover,
    .product-grid .product-name a:hover,
    .product_short_description p > a:hover,
    ins span,
    .description_share_this a:hover,
    .lost_password:hover,
    .product_tabs:hover,
    .notFound strong,
    .mega-menu > ul > li > ul > li > a:hover,
    .cats .block-content
    .wpsc_categories > li > a:hover,
    .cats .block-content .wpsc_categories > li ul > li a:hover,
    .cats .block-content .wpsc_categories li > ul > li:hover,
    .cats.acc_enabled .block-content .wpsc_category_title a:hover,
    .grid_pagination a:hover,
    .menu-custom-footer-container ul > li > a:hover,
    .grid_bottom_pagination a:hover,
    .list_product_text_title a:hover,
    #categories-2 > ul > li:hover,
    #categories-2 > ul > li a:hover,
    #nav-above .nav-next a:hover,
    #nav-above .nav-previous a:hover,
    .widget_layered_nav ul li:hover,
    .widget_layered_nav ul li.chosen a:before,
    .blog1_post_title a:hover,
    .blog_icon_comment:hover,
    .blog_icon_webdesign:hover,
    .blog2_icon_comment:hover,
    .blog2_icon_webdesign:hover,
    .blog2_post_title a:hover,
    .footer_menu a:hover,
    .tweets1 a:hover,
    .form-row .button:hover,
    .footer_copyright_menu a:hover,
    #back-to-top a:hover,
	.member-details i:hover,
    .product-slider .prev:hover,
    .product-slider .prev:focus,
    .product-slider .next:hover,
    .product-slider .next:focus,
    .menu > ul > li > ul > li a:hover,
    .menu .current-menu-item > a,
    .menu .current-menu-item > a:hover,
    #nav-below .nav-next a:hover,
    #nav-below .nav-previous a:hover,
    .typography-block > .nav-tabs .active a,
    .etheme-popup-content .clear .button,
    .etheme-popup-content .button.cont-shop:hover,
    .current-parent h5 a,
    .current-cat > a,
    .cats .block-content .wpsc_categories li a:hover,
    .cats .block-content .wpsc_categories li:hover,
    .category-block h3:hover,
    .menu .sub-menu .current-menu-item > a,
    .footer-home:hover i,
    .footer-phone:hover i,
    .footer-mail:hover i,
    .et-menu-title i.icon-reorder:hover,
    .widget-container a:hover,
    .portfolio-filters li a.selected,
    .portfolio-item h2 a:hover,
    #back-to-top.btn-style-modern a:hover span:after,
    .back-to:hover:before,
    #back-to-top.btn-style-modern a:hover span,
    .cart-collaterals .shipping_calculator a:hover,
    #top-cart .cart-popup a:hover
';


global $etheme_color_version;

if($etheme_color_version=='dark') {
    $selectors['active_color_dark'] = '
		mark,
		.default-menu > ul > li > ul li:hover > a,
		#top-cart a > span .amount,
        #top-cart .cart-popup a:hover,
		.tabs .tab-title:hover,
		.tabs .tab-title.opened:hover,
		.left-titles a.opened:hover,
		.widget_layered_nav ul li a:hover,
		.widget_layered_nav ul li span:hover,
		.post-title:hover,
		.typography-block > .nav-tabs li:hover a,
		.p-table li:hover,
		.p-table-2 li:hover,
		.et-mobile-menu li > a:hover,
		.widget-container a:hover,
		.tabs .tab-title:hover,
        .modal-body .thumbnail:hover i,
        .the-icons li:hover i,
        .the-icons li:hover,
        .back-to:hover:before,
        .tabs.checkout-accordion .tab-title.opened:hover span,
        .tabs.checkout-accordion .tab-title:hover span,
        .form-row .button:hover
    ';
    $selectors['active_bg_dark'] = '
		.header-top-variant4,
		.header-top-variant4 .container,
		.header-top-variant5 .container,
        #top-cart .cart-popup a.emptycart:hover,
		#contact_button .button:hover,
		.widget_layered_nav ul li.chosen a,
		.widget_price_filter .price_slider_wrapper .button:hover,
		div.pp_woocommerce #respond #commentform #submit:hover,
		.cart-collaterals .shipping_calculator .button:hover,
		.form-row .button:hover,
		.et-mobile-menu li .open-child:hover,
        .etheme_cp_btn_show:hover,
        .etheme-popup-content .clear .button,
        .products-list .product-grid .button:hover,
        .blog-content .button:hover,
        .grid_pagination span.current,
        .grid_bottom_pagination span.current

    ';
    $selectors['active_border_dark'] = '
		blockquote,
		div.pp_woocommerce .pp_content_container,
		.etheme-popup-content,
		.member-details,
		.p-table,
		.p-table-2,
		.p-table-3,
        .etheme_cp .etheme_cp_head,
        .nav-tabs > .active > a,
        .typography-block > .nav-tabs li:hover,
        .typography-block > .nav-tabs li.active:hover,
        .modal
	';
}



$selectors['active_bg'] = '
    #searchform .button:hover,
    .header-type-variant2 #searchform:hover .button:hover,
    #submit:hover,
    .button:hover,
    .button.active,
    .dropcap.dark,
    .et-menu-title,
    .cbp-qtprogress,
    .banner a.info:hover,
    .product_short_description_addtocart:hover,
    .more-views-arrow.prev:hover,
    .more-views-arrow.next:hover,
    .widget_price_filter .ui-slider .ui-slider-range,
    .list_product_addtocart:hover,
    #cart_procced_to_check_button,
    .product-slider .prev:hover,
    .product-slider .prev:focus,
    .product-slider .next:hover,
    .product-slider .next:focus,
    #back-to-top a:hover,
    .grid_pagination a:hover,
    .progress-bar > div,
    .grid_bottom_pagination a:hover,
    .prev.page-numbers:hover,
    .next.page-numbers:hover,
    .tp-leftarrow:hover,
    .tp-rightarrow:hover,
    .cats.acc_enabled .block-content .categories-group.has-subnav .btn-show:hover,
    .nav-type-small .flex-direction-nav a:hover,
    .header-top-variant4,
    .header-top-variant4 .container,
    .header-top-variant5,
    .header-top-variant5 .container,
    #back-to-top.btn-style-standart a:hover,
    .grid_pagination span.current,
    .grid_bottom_pagination span.current
';


$selectors['brown_bg'] = '

';

$selectors['active_bg2'] = '
    .button.active:hover
';
$selectors['active_border'] = '
    .menu > ul > li.over > a,
    .menu > ul > li.active > a,
    .menu > ul > li > a:hover,
    .menu .current-menu-item > a,
    .menu .current-menu-item > a:hover,
    .cta-block,
    .products_grid .product-grid:hover,
    .product-slide .product-grid:hover,
    #back-to-top a:hover,
    #submit:hover,
    .button:hover,
    .typography-block > .nav-tabs li.active,
    .menu > ul > li ul,
    .mega-menu > ul > li > ul
';

$selectors['footer_bg'] = '
    .container_footer_bg,
    .footer_container
';

?>
<div id="styles-bg">
<style type="text/css">
    <?php $bg = etheme_get_option('background_img'); ?>
    body {
        background-color: <?php echo $bg['background-color']; ?> ;
        background-image: url(<?php echo $bg['background-image']; ?>) ;
        background-attachment: <?php echo $bg['background-attachment']; ?> ;
        background-repeat: <?php echo $bg['background-repeat']; ?> ;
        background-position: <?php echo $bg['background-position']; ?> ;
        <?php if(etheme_get_option('background_cover') == 'enable'): ?>
        	background-size: cover;
        <?php endif; ?>
    }
</style>
</div>

<style type="text/css">
    <?php $h1 = etheme_get_option('h1'); ?>
    <?php $h2 = etheme_get_option('h2'); ?>
    <?php $h3 = etheme_get_option('h3'); ?>
    <?php $h4 = etheme_get_option('h4'); ?>
    <?php $h5 = etheme_get_option('h5'); ?>
    <?php $h6 = etheme_get_option('h6'); ?>
    <?php $sfont = etheme_get_option('sfont'); ?>

    body {
	    <?php if($sfont['font-color'] != '') :?>      color: <?php echo $sfont['font-color'].';'; endif; ?>
	    <?php if($sfont['font-family'] != ''): ?>     font-family: <?php echo $sfont['font-family'].';'; endif; ?>
	    <?php if($sfont['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $sfont['google-font']).';'; endif; ?>
	    <?php if($sfont['font-size'] != ''): ?>       font-size: <?php echo $sfont['font-size'].';'; endif; ?>
	    <?php if($sfont['font-style'] != ''): ?>      font-style: <?php echo $sfont['font-style'].';'; endif; ?>
	    <?php if($sfont['font-weight'] != ''): ?>     font-weight: <?php echo $sfont['font-weight'].';'; endif; ?>
	    <?php if($sfont['font-variant'] != ''): ?>    font-variant: <?php echo $sfont['font-variant'].';'; endif; ?>
	    <?php if($sfont['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $sfont['letter-spacing'].';'; endif; ?>
	    <?php if($sfont['line-height'] != ''): ?>     line-height: <?php echo $sfont['line-height'].';'; endif; ?>
	    <?php if($sfont['text-decoration'] != ''): ?> text-decoration:  <?php echo $sfont['text-decoration'].';'; endif; ?>
	    <?php if($sfont['text-transform'] != ''): ?>  text-transform:  <?php echo $sfont['text-transform'].';'; endif; ?>
    }

    h1 {
	    <?php if($h1['font-color'] != '') :?>      color: <?php echo $h1['font-color'].';'; endif; ?>
	    <?php if($h1['font-family'] != ''): ?>     font-family: <?php echo $h1['font-family'].';'; endif; ?>
	    <?php if($h1['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $h1['google-font']).';'; endif; ?>
	    <?php if($h1['font-size'] != ''): ?>       font-size: <?php echo $h1['font-size'].';'; endif; ?>
	    <?php if($h1['font-style'] != ''): ?>      font-style: <?php echo $h1['font-style'].';'; endif; ?>
	    <?php if($h1['font-weight'] != ''): ?>     font-weight: <?php echo $h1['font-weight'].';'; endif; ?>
	    <?php if($h1['font-variant'] != ''): ?>    font-variant: <?php echo $h1['font-variant'].';'; endif; ?>
	    <?php if($h1['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $h1['letter-spacing'].';'; endif; ?>
	    <?php if($h1['line-height'] != ''): ?>     line-height: <?php echo $h1['line-height'].';'; endif; ?>
	    <?php if($h1['text-decoration'] != ''): ?> text-decoration:  <?php echo $h1['text-decoration'].';'; endif; ?>
	    <?php if($h1['text-transform'] != ''): ?>  text-transform:  <?php echo $h1['text-transform'].';'; endif; ?>
    }
    h2 {
	    <?php if($h2['font-color'] != '') :?>      color: <?php echo $h2['font-color'].';'; endif; ?>
	    <?php if($h2['font-family'] != ''): ?>     font-family: <?php echo $h2['font-family'].';'; endif; ?>
	    <?php if($h2['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $h2['google-font']).';'; endif; ?>
	    <?php if($h2['font-size'] != ''): ?>       font-size: <?php echo $h2['font-size'].';'; endif; ?>
	    <?php if($h2['font-style'] != ''): ?>      font-style: <?php echo $h2['font-style'].';'; endif; ?>
	    <?php if($h2['font-weight'] != ''): ?>     font-weight: <?php echo $h2['font-weight'].';'; endif; ?>
	    <?php if($h2['font-variant'] != ''): ?>    font-variant: <?php echo $h2['font-variant'].';'; endif; ?>
	    <?php if($h2['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $h2['letter-spacing'].';'; endif; ?>
	    <?php if($h2['line-height'] != ''): ?>     line-height: <?php echo $h2['line-height'].';'; endif; ?>
	    <?php if($h2['text-decoration'] != ''): ?> text-decoration:  <?php echo $h2['text-decoration'].';'; endif; ?>
	    <?php if($h2['text-transform'] != ''): ?>  text-transform:  <?php echo $h2['text-transform'].';'; endif; ?>
    }
    h3 {
	    <?php if($h3['font-color'] != '') :?>      color: <?php echo $h3['font-color'].';'; endif; ?>
	    <?php if($h3['font-family'] != ''): ?>     font-family: <?php echo $h3['font-family'].';'; endif; ?>
	    <?php if($h3['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $h3['google-font']).';'; endif; ?>
	    <?php if($h3['font-size'] != ''): ?>       font-size: <?php echo $h3['font-size'].';'; endif; ?>
	    <?php if($h3['font-style'] != ''): ?>      font-style: <?php echo $h3['font-style'].';'; endif; ?>
	    <?php if($h3['font-weight'] != ''): ?>     font-weight: <?php echo $h3['font-weight'].';'; endif; ?>
	    <?php if($h3['font-variant'] != ''): ?>    font-variant: <?php echo $h3['font-variant'].';'; endif; ?>
	    <?php if($h3['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $h3['letter-spacing'].';'; endif; ?>
	    <?php if($h3['line-height'] != ''): ?>     line-height: <?php echo $h3['line-height'].';'; endif; ?>
	    <?php if($h3['text-decoration'] != ''): ?> text-decoration:  <?php echo $h3['text-decoration'].';'; endif; ?>
	    <?php if($h3['text-transform'] != ''): ?>  text-transform:  <?php echo $h3['text-transform'].';'; endif; ?>
    }
    h4 {
	    <?php if($h4['font-color'] != '') :?>      color: <?php echo $h4['font-color'].';'; endif; ?>
	    <?php if($h4['font-family'] != ''): ?>     font-family: <?php echo $h4['font-family'].';'; endif; ?>
	    <?php if($h4['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $h4['google-font']).';'; endif; ?>
	    <?php if($h4['font-size'] != ''): ?>       font-size: <?php echo $h4['font-size'].';'; endif; ?>
	    <?php if($h4['font-style'] != ''): ?>      font-style: <?php echo $h4['font-style'].';'; endif; ?>
	    <?php if($h4['font-weight'] != ''): ?>     font-weight: <?php echo $h4['font-weight'].';'; endif; ?>
	    <?php if($h4['font-variant'] != ''): ?>    font-variant: <?php echo $h4['font-variant'].';'; endif; ?>
	    <?php if($h4['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $h4['letter-spacing'].';'; endif; ?>
	    <?php if($h4['line-height'] != ''): ?>     line-height: <?php echo $h4['line-height'].';'; endif; ?>
	    <?php if($h4['text-decoration'] != ''): ?> text-decoration:  <?php echo $h4['text-decoration'].';'; endif; ?>
	    <?php if($h4['text-transform'] != ''): ?>  text-transform:  <?php echo $h4['text-transform'].';'; endif; ?>
    }
    h5 {
	    <?php if($h5['font-color'] != '') :?>      color: <?php echo $h5['font-color'].';'; endif; ?>
	    <?php if($h5['font-family'] != ''): ?>     font-family: <?php echo $h5['font-family'].';'; endif; ?>
	    <?php if($h5['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $h5['google-font']).';'; endif; ?>
	    <?php if($h5['font-size'] != ''): ?>       font-size: <?php echo $h5['font-size'].';'; endif; ?>
	    <?php if($h5['font-style'] != ''): ?>      font-style: <?php echo $h5['font-style'].';'; endif; ?>
	    <?php if($h5['font-weight'] != ''): ?>     font-weight: <?php echo $h5['font-weight'].';'; endif; ?>
	    <?php if($h5['font-variant'] != ''): ?>    font-variant: <?php echo $h5['font-variant'].';'; endif; ?>
	    <?php if($h5['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $h5['letter-spacing'].';'; endif; ?>
	    <?php if($h5['line-height'] != ''): ?>     line-height: <?php echo $h5['line-height'].';'; endif; ?>
	    <?php if($h5['text-decoration'] != ''): ?> text-decoration:  <?php echo $h5['text-decoration'].';'; endif; ?>
	    <?php if($h5['text-transform'] != ''): ?>  text-transform:  <?php echo $h5['text-transform'].';'; endif; ?>
    }
    h6 {
	    <?php if($h6['font-color'] != '') :?>      color: <?php echo $h6['font-color'].';'; endif; ?>
	    <?php if($h6['font-family'] != ''): ?>     font-family: <?php echo $h6['font-family'].';'; endif; ?>
	    <?php if($h6['google-font'] != ''): ?>     font-family: <?php echo str_replace("+", " ", $h6['google-font']).';'; endif; ?>
	    <?php if($h6['font-size'] != ''): ?>       font-size: <?php echo $h6['font-size'].';'; endif; ?>
	    <?php if($h6['font-style'] != ''): ?>      font-style: <?php echo $h6['font-style'].';'; endif; ?>
	    <?php if($h6['font-weight'] != ''): ?>     font-weight: <?php echo $h6['font-weight'].';'; endif; ?>
	    <?php if($h6['font-variant'] != ''): ?>    font-variant: <?php echo $h6['font-variant'].';'; endif; ?>
	    <?php if($h6['letter-spacing'] != ''): ?>  letter-spacing: <?php echo $h6['letter-spacing'].';'; endif; ?>
	    <?php if($h6['line-height'] != ''): ?>     line-height: <?php echo $h6['line-height'].';'; endif; ?>
	    <?php if($h6['text-decoration'] != ''): ?> text-decoration:  <?php echo $h6['text-decoration'].';'; endif; ?>
	    <?php if($h6['text-transform'] != ''): ?>  text-transform:  <?php echo $h6['text-transform'].';'; endif; ?>
    }
</style>

<div id="styles-main-color">
    <style type="text/css">
        <?php echo jsString($selectors['active_color']); ?>              { color: <?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#fc5a5a' ?>; }

        <?php echo jsString($selectors['active_bg']); ?>                 { background-color: <?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#fc5a5a' ?>; }

        <?php echo jsString($selectors['active_border']); ?>             { border-color: <?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#fc5a5a' ?>;}

        <?php if($etheme_color_version=='dark'): ?>

	        <?php echo jsString($selectors['active_color_dark']); ?>              { color: <?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#fc5a5a' ?>; }

	        <?php echo jsString($selectors['active_bg_dark']); ?>                 { background-color: <?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#fc5a5a' ?>; }

	        <?php echo jsString($selectors['active_border_dark']); ?>             { border-color: <?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#fc5a5a' ?>;}

        <?php endif; ?>

    </style>
</div>
<div id="styles-hover-color">
    <style type="text/css">
        <?php echo jsString($selectors['active_bg2']); ?>                { background-color: <?php echo (etheme_get_option('activehovercol')) ? etheme_get_option('activehovercol') : '#e73434' ?>; }
    </style>
</div>
<div id="styles-footer-color">
    <style type="text/css">
        <?php echo jsString($selectors['footer_bg']); ?>                { background-color: <?php echo (etheme_get_option('footer_bg')) ? etheme_get_option('footer_bg') : '#222' ?>; }
    </style>
</div>
<style type="text/css">

    <?php if ( etheme_get_option('sale_icon') ) : ?>
        .label-icon.sale-label {
            width: <?php echo (etheme_get_option('sale_icon_width')) ? etheme_get_option('sale_icon_width') : 50 ?>px;
            height: <?php echo (etheme_get_option('sale_icon_height')) ? etheme_get_option('sale_icon_height') : 50 ?>px;
        }
        .label-icon.sale-label { background-image: url(<?php echo (etheme_get_option('sale_icon_url')) ? etheme_get_option('sale_icon_url') : get_template_directory_uri() .'/images/sale.png' ?>); }
    <?php endif; ?>

    <?php if ( etheme_get_option('new_icon') ) : ?>
        .label-icon.new-label {
            width: <?php echo (etheme_get_option('new_icon_width')) ? etheme_get_option('new_icon_width') : 50 ?>px;
            height: <?php echo (etheme_get_option('new_icon_height')) ? etheme_get_option('new_icon_height') : 50 ?>px;
        }
        .label-icon.new-label { background-image: url(<?php echo (etheme_get_option('new_icon_url')) ? etheme_get_option('new_icon_url') : get_template_directory_uri() .'/images/new.png' ?>); }

    <?php endif; ?>
</style>
<script type="text/javascript">
    var active_color_selector = '<?php echo jsString($selectors['active_color']); ?>';
    var active_bg_selector = '<?php echo jsString($selectors['active_bg']); ?>';
    var active_border_selector = '<?php echo jsString($selectors['active_border']); ?>';
    var active_color_default = '<?php echo (etheme_get_option('activecol')) ? etheme_get_option('activecol') : '#ff4949' ?>';
    var bg_default = '<?php etheme_option('backgroundcol') ?>';
    var pattern_default = '<?php etheme_option('background_img') ?>';
    var view_mode_default = '<?php echo etheme_get_option('view_mode'); ?>';

    <?php do_action('new_colors'); ?>

    var successfullyAdded2 = '';
    <?php if(class_exists('WooCommerce')): ?>
	    successfullyAdded2 = '<?php _e('was successfully added to your shopping cart.',ETHEME_DOMAIN) ?><div class="clear"><a class="button cont-shop"><span><?php _e('Continue Shopping',ETHEME_DOMAIN) ?></span></a><a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button fl-r"><span><?php _e('Checkout',ETHEME_DOMAIN) ?></span></a></div>';
	    		
    <?php endif; ?>

</script>