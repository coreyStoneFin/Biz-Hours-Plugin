<?php
add_filter('upload_mimes', 'etheme_upload_mimes');
function etheme_upload_mimes($mimes) {
    $mimes = array_merge($mimes, array(
        'ico' => 'image/x-icon'
    ));
    return $mimes;
}
function etheme_get_files( $path='', $ext='css', $filter='', $format=TRUE ) {
	if (!$path) $path = CHILD_DIR . '/';
	$files = array();
	if ( is_dir($path) ) {
		if ($dir = opendir($path) ) { 
			while ( ($file = readdir($dir)) !== FALSE ) {
				if( !$filter || ($filter && stristr($file, $filter) !== FALSE ) ) {
					if(stristr($file, '.'.$ext) !== FALSE) {
						if ($format) $files[] = substr($file,strlen($filter),-1 - strlen($ext));
						else $files[] = $file; } } } } }	
	if ($files) return $files;
	else return false;
}
add_action( 'init', 'etheme_register_framework' );
function etheme_register_framework() {
	register_post_type( 'ethemeframework', array(
		'labels' => array(
			'name' => __( 'Etheme Framework' ),
		),
		'public' => true,
		'show_ui' => false,
		'capability_type' => 'post',
		'exclude_from_search' => true,
		'hierarchical' => false,
		'rewrite' => false,
		'supports' => array( 'title', 'editor' ),
		'can_export' => true,
		'show_in_nav_menus' => false,
	) );
}
function etheme_framework_post_id( $title = '' ) {
	global $wpdb;
	return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '{$title}' AND post_type = 'ethemeframework' AND post_status != 'trash'");
}
function etheme_add_upload_product_setting($page_id, $id, $title = '') {
	$title = $title ? $title : __( 'Upload Image', ETHEME_DOMAIN );
	$output = '';
	$formid = $id;
    
	$saved_file = etheme_get_custom_field('_'.$id);

	$uploadclass = ( $saved_file ) ? 'has-file' : '';
	$output .= '<h4 class="upload_title">'.$title.'</h4>';
	$output .= '<input type="text" name="etheme_product[_'.$id.']" id="'.$id.'" value="'.$saved_file.'" class="upload '.$uploadclass.'" />';
	$output .= '<input id="'.$id.'" class="upload_button button button-highlighted " type="button" value="Upload" rel="'.$page_id.'" />';
	$output .= '<div class="screenshot etheme clear" id="'.$id.'">';
	  if ( $saved_file != '' ) 
	  { 
		$remove = '<a href="#" class="remove etheme">Remove</a>';
		$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $saved_file );
		if ( $image ) 
		{
		  $output .= '<img src="'.$saved_file.'" alt="" />'.$remove.'';
		} 
		else 
		{
		  $parts = explode( "/", $saved_file );
		  for( $i = 0; $i < sizeof($parts); ++$i ) 
		  {
			$title = $parts[$i];
		  }
		  $output .= '<div class="no_image"><a href="'.$saved_file.'">'.$title.'</a>'.$remove.'</div>';
		}
	  }
	$output .= '</div>';
    return $output; 
}

