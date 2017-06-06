<?php 

add_action('wp_ajax_etheme_import_ajax', 'etheme_import_data');

function etheme_import_data() {
	
	// Load Importer API
	require_once ABSPATH . 'wp-admin/includes/import.php';
	$importerError = false;
	$file = get_template_directory() ."/code/dummy/Dummy.xml";
	
	//check if wp_importer, the base importer class is available, otherwise include it
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ) 
			require_once($class_wp_importer);
		else 
			$importerError = true;
	}
	
	if($importerError !== false) {
		echo ("The Auto importing script could not be loaded. Please use the wordpress importer and import the XML file that is located in your themes folder manually.");
	} else {
		
		if(class_exists('WP_Importer')){
			try{
				$importer = new WP_Import();
				
				$importer->fetch_attachments = true;
				
				$importer->import($file);	
				
				etheme_update_options();
				etheme_update_widgets();
				etheme_update_menus();
				
				
			} catch (Exception $e) {
				echo ("Error while importing");
			}

		}
		
	}
		
	
	die();
}

function etheme_update_options() {
	$home_id = 218;
	$blog_id = 219;
	$shop_id = 223;
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $home_id );
    add_post_meta($home_id, '_wp_page_template', 'frontpage.php');
    update_option( 'page_for_posts', $blog_id );
    update_option( 'woocommerce_shop_page_id', $shop_id );
}

function etheme_update_widgets(){

    $widgets = array(
	    'primary-widget-area' => array(
	        'categories-1',
	        'etheme-recent-posts-2',
	        'text-3'
	    ),
	    'product-widget-area' => array(
	        'etheme-subcategories-4',
	        'etheme-recent-posts-5',
	        'text-6'
	    )
	);
	
	$demoText = '                
<div class="banner banner-transform">
  <img src="'.get_template_directory_uri().'/images/Custom-banner1.jpg">
  <div class="mask">
        <h2>Nice Demo Banner</h2>
        <p>It is a long established fact that a reader will be 
        distracted by the readable content of page when 
        looking at its layout.</p>
        <a href="#" class="button">Read More</a>
    </div>
</div>';

	$demo_widget_content[3] = array ( 'title' => 'CUSTOM HTML', 'text' => $demoText);
	
	$demo_widget_content[6] = array ( 'title' => 'CUSTOM TEXT', 'text' => $demoText);
	
	update_option( 'widget_text', $demo_widget_content );
	
	update_option('sidebars_widgets', $widgets);
}

function etheme_update_menus(){
    $menuname = 'Top navigation';
	$bpmenulocation = 'top';
	
	$menu_exists = wp_get_nav_menu_object( $menuname );
	
	if( !$menu_exists){
	    $menu_id = wp_create_nav_menu($menuname);
	
	    if( !has_nav_menu( $bpmenulocation ) ){
	        $locations = get_theme_mod('nav_menu_locations');
	        $locations[$bpmenulocation] = $menu_id;
	        set_theme_mod( 'nav_menu_locations', $locations );
	    }
	    
    }
    
	$pages = array(
		get_page_by_title('Home'),
		get_page_by_title('Shop'),
		get_page_by_title('Blog')
	);
	
	$pages_child = array(
		get_page_by_title('About Us'),
		get_page_by_title('Alert boxes'),
		get_page_by_title('Blockquote'),
		get_page_by_title('Buttons'),
		get_page_by_title('Charts'),
		get_page_by_title('Columns'),
		get_page_by_title('Dropcap'),
		get_page_by_title('List Styles'),
		get_page_by_title('Maps'),
		get_page_by_title('Progress Bars'),
		get_page_by_title('Shop Shortcodes'),
		get_page_by_title('Tables'),
		get_page_by_title('Tabs'),
		get_page_by_title('Team Members'),
		get_page_by_title('Tooltip'),
		get_page_by_title('Video')
	);
	
	etheme_add_menu_items($pages,0,$menu_id);
    
    $shortcodes_page = get_page_by_title('Shortcodes');
    
    $shortcodes_page_id = etheme_add_menu_item($shortcodes_page, 0, $menu_id);
    
	etheme_add_menu_items($pages_child,$shortcodes_page_id,$menu_id);
    
}

function etheme_add_menu_items($pages, $parent = 0, $menu_id){
	foreach($pages as $page) {
		
		etheme_add_menu_item($page, $parent, $menu_id);
	}
}
function etheme_add_menu_item($page, $parent = 0, $menu_id){
		
		$itemData =  array(
		    'menu-item-object-id' => $page->ID,
		    'menu-item-parent-id' => $parent,
		    'menu-item-object'    => 'page',
		    'menu-item-type'      => 'post_type',
		    'menu-item-status'    => 'publish'
		);
		
		return wp_update_nav_menu_item($menu_id, 0, $itemData);
	
}