<?php
/**
 * The Header for our theme.
 *
 */
?>
<?php global $etheme_responsive; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

		<meta property='og:title' content="Source. Eat Fit - Love what you eat" />
		<meta property='og:description' content="Delicious, nutritious, ready to go chef prepared meals!" />
		<meta property='og:type' content="website" />       
		<meta property='og:image' content="https://www.sourceeatfit.com/wp-content/uploads/2014/10/sourcelogo.png" />      
		<meta property='og:url' content="https://www.sourceeatfit.com/" />
		
<?php if($etheme_responsive): ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?php endif; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', ETHEME_DOMAIN ), max( $paged, $page ) );

	?></title>
	<link rel="shortcut icon" href="<?php etheme_option('favicon',true) ?>" />
    <link rel="profile" href="//gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_head();
?>
<?php $header_type = apply_filters('custom_header_filter',@$header_type); ?>
<!-- style????  -->
    <?php
        get_template_part( 'et-styles' );
        if($etheme_responsive){
            get_template_part('large-resolution');
        }
    ?>
<!-- end style????  -->

<!-- all SCRIPT should be below this unless there's an explicit reason not to -->
	<!--[if IE]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <script type="text/javascript">
        var etheme_wp_url = '<?php echo home_url(); ?>';
        var succmsg = '<?php _e('All is well, your e&ndash;mail has been sent!', ETHEME_DOMAIN); ?>';
        var menuTitle = '<?php _e('Menu', ETHEME_DOMAIN); ?>';
        var nav_accordion = false;
        var ajaxFilterEnabled = <?php echo (etheme_get_option('ajax_filter')) ? 1 : 0 ; ?>;
        var isRequired = ' <?php _e('Please, fill in the required fields!', ETHEME_DOMAIN); ?>';
        var someerrmsg = '<?php _e('Something went wrong', ETHEME_DOMAIN); ?>';
		var successfullyAdded = '<?php _e('Successfully added to your shopping cart', ETHEME_DOMAIN); ?>';
    </script>

<!-- all SCRIPT should be above this unless there's an explicit reason not to -->


</head>
<body <?php $fixed = ''; if(etheme_get_option('fixed_nav')) $fixed .= ' fixNav-enabled '; if($header_type == 'variant6' && is_front_page()) $fixed .= ' header-overlapped '; body_class('no-svg '.etheme_get_option('main_layout').' banner-mask-'.etheme_get_option('banner_mask').$fixed); ?>>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-20862821-5', 'auto');
  ga('send', 'pageview');

</script>

	<div class="wrapper">

    <?php if(etheme_get_option('loader')): ?>
    <div id="loader">
        <div id="loader-status">
            <p class="center-text">
                <em><?php _e('Loading the content...', ETHEME_DOMAIN); ?></em>
                <em><?php _e('Loading depends on your connection speed!', ETHEME_DOMAIN); ?></em>
            </p>
        </div>
    </div>
    <?php endif; ?>

	<?php if((etheme_get_option('search_form') || (class_exists('Woocommerce') && !etheme_get_option('just_catalog') && etheme_get_option('cart_widget')) || etheme_get_option('top_links') || etheme_get_option('header_phone') != '')): ?>
		<div class="header-top header-top-<?php echo $header_type; ?> <?php if($header_type == "default") echo 'hidden-desktop'; ?>">
			<div class="container">
				<div class="row header-variant2">
          <div class='span5'>
            <span class="header-phone"><a title="We're friendly" href='tel:<?php etheme_option('header_phone') ?>'><span class="friendlyText">Call:</span> <strong><?php etheme_option('header_phone') ?></strong></a></span>
            <span class="header-hours"><a href="/contact-us"><?= do_shortcode('[businesshours closed=""] <span class="friendlyText">Visit: </span><strong>{{TodayOpen}} to {{TodayClose}}</strong>[/businesshours]') ?></a></span>
          </div>
          <div class="span7">
          	<?php if(etheme_get_option('search_form')): ?>
                <div class="search_form">
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
            <?php if(class_exists('Woocommerce') && !etheme_get_option('just_catalog') && etheme_get_option('cart_widget')): ?>
                <div id="top-cart" class="shopping-cart-wrapper widget_shopping_cart">
                    <?php $cart_widget = new Etheme_WooCommerce_Widget_Cart(); $cart_widget->widget(); ?>
                </div>
            <?php endif ;?>
		        <?php if(etheme_get_option('top_links')): ?>
			         <?php  get_template_part( 'et-links' ); ?>
            <?php endif; ?>
          </div>
				</div>
			</div>
		</div>
	<?php endif; ?>


   <?php if(etheme_get_option('fixed_nav')): ?>
	    <div class="fixed-header-area visible-desktop">
		    <div class="fixed-header container">
			    <div class="row">
		            <div class="span3 logo">
	                    <?php etheme_logo(); ?>
		            </div>
		            <div id="main-nav" class="span9">
		                <?php etheme_header_wp_navigation(); ?>
		            </div>
			        <div class="clear"></div>
			    </div>
		    </div>
	    </div>
    <?php endif; ?>

    <div class="header-bg header-type-<?php echo $header_type; ?>">
    <div class="container header-area">

        <header class="row header ">
            <div class="span5 logo">
                <?php etheme_logo(); ?>
            </div>

	        <?php if($header_type == 'default'): ?>
	            <div class="span3 visible-desktop">
	                <?php if(etheme_get_option('header_phone') && etheme_get_option('header_phone') != ''): ?>
	                    <span class="search_text">
	                        <?php etheme_option('header_phone') ?>
	                    </span>
	                <?php endif; ?>
		            <?php if(etheme_get_option('search_form')): ?>
		                <div class="search_form">
		                    <?php get_search_form(); ?>
		                </div>
	                <?php endif; ?>
	            </div>

	            <div class="span3 shopping_cart_wrap visible-desktop">

	                <?php if(class_exists('Woocommerce') && !etheme_get_option('just_catalog') && etheme_get_option('cart_widget')): ?>
	                    <div id="top-cart" class="shopping-cart-wrapper widget_shopping_cart">
	                        <?php $cart_widget = new Etheme_WooCommerce_Widget_Cart(); $cart_widget->widget(); ?>
	                    </div>
	                <?php endif ;?>
	                <div class="clear"></div>
	                <?php if(etheme_get_option('top_links')): ?>
	                    <?php  get_template_part( 'et-links' ); ?>
	                <?php endif; ?>
	            </div>
	    	<?php endif; ?>

		    <?php if($header_type == 'variant2' || $header_type == 'variant5' || $header_type == 'variant6'): ?>
	            <div id="main-nav">
	                <?php etheme_header_wp_navigation(); ?>
	            </div>
		    <?php endif; ?>
        </header>
	    <?php if($header_type == 'default' || $header_type == 'variant3') etheme_header_menu(); ?>
    </div>
    <?php if($header_type == 'variant4') etheme_header_menu(); ?>

</div>
