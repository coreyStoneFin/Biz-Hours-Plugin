<?php

add_action('admin_init', 'etheme_load_admin_styles');
function etheme_load_admin_styles() {
	wp_enqueue_style('farbtastic');
	wp_enqueue_style('etheme_admin_css', ETHEME_CODE_CSS_URL.'/admin.css');
}
add_action('admin_init','etheme_add_admin_script');

function etheme_add_admin_script(){
	add_thickbox();
 	wp_enqueue_script('theme-preview');
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
	wp_enqueue_script('farbtastic');
	wp_enqueue_script('etheme_admin_js', ETHEME_CODE_JS_URL.'/admin.js');	
    wp_enqueue_style("font-awesome",get_template_directory_uri().'/css/font-awesome.min.css');
}
