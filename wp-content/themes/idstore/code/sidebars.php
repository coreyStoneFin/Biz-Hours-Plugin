<?php 
/* Functions for unlimited sidebars */

/**
*
*	Function for adding sidebar (AJAX action) 
*/

function etheme_add_sidebar(){
	if (!wp_verify_nonce($_GET['_wpnonce_etheme_widgets'],'etheme-add-sidebar-widgets') ) die( 'Security check' );
	if($_GET['etheme_sidebar_name'] == '') die('Empty Name');
	$option_name = 'etheme_custom_sidebars';
	if(!get_option($option_name) || get_option($option_name) == '') delete_option($option_name); 
	
	$new_sidebar = $_GET['etheme_sidebar_name'];	
	
	
	if(get_option($option_name)) {
		$et_custom_sidebars = etheme_get_stored_sidebar();
		$et_custom_sidebars[] = trim($new_sidebar);
		$result = update_option($option_name, $et_custom_sidebars);
	}else{
		$et_custom_sidebars[] = $new_sidebar;
		$result2 = add_option($option_name, $et_custom_sidebars);
	}
	
	
	if($result) die('Updated');
	elseif($result2) die('added');
	else die('error');
}

/**
*
*	Function for deleting sidebar (AJAX action) 
*/

function etheme_delete_sidebar(){
	$option_name = 'etheme_custom_sidebars';
	$del_sidebar = trim($_GET['etheme_sidebar_name']);
		
	if(get_option($option_name)) {
		$et_custom_sidebars = etheme_get_stored_sidebar();
		
		foreach($et_custom_sidebars as $key => $value){
			if($value == $del_sidebar)
				unset($et_custom_sidebars[$key]);
		}
		
		
		$result = update_option($option_name, $et_custom_sidebars);
	}
	
	if($result) die('Deleted');
	else die('error');
}

/**
*
*	Function for registering previously stored sidebars
*/
function etheme_register_stored_sidebar(){
	$et_custom_sidebars = etheme_get_stored_sidebar();
	if(is_array($et_custom_sidebars)) {
		foreach($et_custom_sidebars as $name){
			register_sidebar( array(
				'name' => ''.$name.'',
				'id' => $name,
				'class' => 'etheme_custom_sidebar',
				'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
	}

}

/**
*
*	Function gets stored sidebar array
*/
function etheme_get_stored_sidebar(){
	$option_name = 'etheme_custom_sidebars';
	return get_option($option_name);
}


/**
*
*	Add form after all widgets
*/
function etheme_sidebar_form(){
	?>
	
	<form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="etheme_add_sidebar_form">
		<h2>Custom Sidebar</h2>
		<?php wp_nonce_field( 'etheme-add-sidebar-widgets', '_wpnonce_etheme_widgets', false ); ?>
		<input type="text" name="etheme_sidebar_name" id="etheme_sidebar_name" />
		<button type="submit" class="button-primary" value="add-sidebar">Add Sidebar</button>
	</form>
	<script type="text/javascript">
		var sidebarForm = jQuery('#etheme_add_sidebar_form');
		var sidebarFormNew = sidebarForm.clone();
		sidebarForm.remove();
		jQuery('#widgets-right').append(sidebarFormNew);
		
		sidebarFormNew.submit(function(e){
			e.preventDefault();
			var data =  {
				'action':'etheme_add_sidebar',
				'_wpnonce_etheme_widgets': jQuery('#_wpnonce_etheme_widgets').val(),
				'etheme_sidebar_name': jQuery('#etheme_sidebar_name').val(),
			};
			//console.log(data);
			jQuery.ajax({
				url: ajaxurl,
				data: data,
				success: function(response){
					console.log(response);
					window.location.reload(true);
					
				},
				error: function(data) {
					console.log('error');
					
				}
			});
		});
		
	</script>
	<?php
}

add_action( 'sidebar_admin_page', 'etheme_sidebar_form', 30 );
add_action('wp_ajax_etheme_add_sidebar', 'etheme_add_sidebar');
add_action('wp_ajax_etheme_delete_sidebar', 'etheme_delete_sidebar');
add_action( 'widgets_init', 'etheme_register_stored_sidebar' );

add_action( 'widgets_init', 'etheme_widgets_init' );

function etheme_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', ETHEME_DOMAIN),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', ETHEME_DOMAIN ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Single product sidebar.
	register_sidebar( array(
		'name' => __( 'Single product sidebar', ETHEME_DOMAIN ),
		'id' => 'product-single-widget-area',
		'description' => __( 'Single product sidebar widget area', ETHEME_DOMAIN ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Products sidebar.
	register_sidebar( array(
		'name' => __( 'Product Page sidebar', ETHEME_DOMAIN ),
		'id' => 'product-widget-area',
		'description' => __( 'Product Page sidebar', ETHEME_DOMAIN ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	
	// Under products
	register_sidebar( array(
		'name' => __( 'Under Products', ETHEME_DOMAIN ),
		'id' => 'under-product-widget-area',
		'description' => __( 'Under Products widget area', ETHEME_DOMAIN ),
		'before_widget' => '<div class="page-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	// Area 4, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The First Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'first-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The First Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 5, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Second Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'second-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Second Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 6, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Third Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'third-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Third Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 7, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Fourth Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'fourth-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Fourth Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 7, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Fifth Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'fifth-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Fifth Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );

	// Area 15, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Sixth Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'sixth-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Sixth Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 16, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Seventh Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'seventh-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Seventh Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 17, located in the footer. 
	register_sidebar( array(
		'name' => __( 'The Eighth Footer Widget Area', ETHEME_DOMAIN ),
		'id' => 'eighth-footer-widget-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'The Eighth Footer Widget Area', ETHEME_DOMAIN ),
        'before_title' => '<span class="footer_title">',
        'after_title' => '</span>'
	) );
	// Area 10, located in the footer.
	register_sidebar( array(
		'name' => __( 'Payments Area', ETHEME_DOMAIN ),
		'id' => 'payments-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'Payments Area', ETHEME_DOMAIN ),
        'before_title' => '<h5>',
        'after_title' => '</h5>'
	) );
	// Area 11, located in the footer.
	register_sidebar( array(
		'name' => __( 'Payments Area', ETHEME_DOMAIN ),
		'id' => 'payments-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'Payments Area', ETHEME_DOMAIN ),
        'before_title' => '<h5>',
        'after_title' => '</h5>'
	) );
	// Area 12, located in the footer.
	register_sidebar( array(
		'name' => __( 'Copyrights', ETHEME_DOMAIN ),
		'id' => 'copyrights-area',
		'before_widget' => '',
		'after_widget' => '',
		'description' => __( 'Copyrights', ETHEME_DOMAIN ),
        'before_title' => '<h5>',
        'after_title' => '</h5>'
	) );
}


/* Get page sidebar position */

function etheme_get_page_sidebar($blog = false) {

	$result = array(
		'position' => '',
		'responsive' => '',
		'sidebarname' => ''
	);
	

	$result['responsive'] = etheme_get_option('blog_sidebar_responsive');
	$result['position'] = etheme_get_option('blog_sidebar');
	$page_sidebar_state = etheme_get_custom_field('sidebar_state', $blog);
	$widgetarea = etheme_get_custom_field('widget_area', $blog);
	
	if($widgetarea != '') {
		$result['sidebarname'] = 'custom';
	}
	if($page_sidebar_state != '') {
		$result['position'] = $page_sidebar_state;
	}
	if($result['position'] == 'no_sidebar') $result['position'] = false;
	
	return $result;
	
}

/* Get shop sidebar position */

function etheme_get_shop_sidebar() {

	$result = array(
		'product_sidebar' => '',
		'responsive' => '',
		'grid_sidebar' => '',
		'product_per_row' => 3
	);
	
	$result['product_sidebar'] = etheme_get_option('product_page_sidebar');
	$result['responsive'] = etheme_get_option('blog_sidebar_responsive');         
	$result['grid_sidebar'] = etheme_get_option('grid_sidebar');
    $result['product_per_row'] = etheme_get_option('prodcuts_per_row');
    
    if(isset($_GET['cols'])){
        $result['product_per_row'] = $_GET['cols'];
    }
    if(isset($_GET['sb']) && $_GET['sb'] == 0){
        $result['product_sidebar'] = false;
    }
    
     
    if($result['product_per_row'] == 6){
        $result['product_sidebar'] = false;
    }
    
	return $result;
	
}
