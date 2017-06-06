<?php
add_action("admin_init", "etheme_add_meta_boxes");
function etheme_add_meta_boxes(){
    
    $post_type = 'post';
    
	add_meta_box("etheme-post-meta-box", __( "Custom Settings", ETHEME_DOMAIN ), "etheme_post_meta_box", $post_type, "normal", "low");
}
function etheme_post_meta_box() {
    global $post;
?>

<input type="hidden" name="etheme_post_meta_box_nonce" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />
<div class="format-settings">
	<div class="format-setting-label">
		<h3 class="label">Post Layout</h3>
	</div>
	<div class="format-setting type-select no-desc">
		<div class="format-setting-inner">
			<label>Use Global<input type="checkbox" name="etheme_post[post_layout][global]" value="1" <?php if('global' == etheme_get_custom_field('post_layout')) echo 'checked="checked"'; ?> data-related="option-post-layout" class="ios-switch option-tree-ui-checkbox use-global"><div class="switch"></div></label>
		</div>
	</div>
</div>

<div class="format-settings option-post-layout <?php if('global' == etheme_get_custom_field('post_layout')) echo 'option-disabled'; ?>">
	<div class="format-setting type-radio-image no-desc">
		<div class="format-setting-inner">
			<div class="option-tree-ui-radio-images">
				<p style="display:none">
					<input type="radio" name="etheme_post[post_layout][value]" id="blog_layout-0" value="default" <?php checked('default', etheme_get_custom_field('post_layout')); ?> class="option-tree-ui-radio option-tree-ui-images">
					<label for="blog_layout-0">Default</label>
				</p>
				<img src="<?php echo get_template_directory_uri() ?>/code/css/images/blog_1.jpg" alt="Default" title="Default" class="option-tree-ui-radio-image  <?php if('default' == etheme_get_custom_field('post_layout')) echo 'option-tree-ui-radio-image-selected'; ?>">
			</div>
			
			<div class="option-tree-ui-radio-images">
				<p style="display:none">
					<input type="radio" name="etheme_post[post_layout][value]" id="blog_layout-1" value="portrait" <?php checked('portrait', etheme_get_custom_field('post_layout')); ?> class="option-tree-ui-radio option-tree-ui-images">
					<label for="blog_layout-1">Portrait Images</label>
				</p>
				<img src="<?php echo get_template_directory_uri() ?>/code/css/images/blog_2.jpg" alt="Portrait Images" title="Portrait Images" class="option-tree-ui-radio-image <?php if('portrait' == etheme_get_custom_field('post_layout')) echo 'option-tree-ui-radio-image-selected'; ?>">
			</div>
			<div class="option-tree-ui-radio-images">
				<p style="display:none">
					<input type="radio" name="etheme_post[post_layout][value]" id="blog_layout-2" value="horizontal" <?php checked('horizontal', etheme_get_custom_field('post_layout')); ?> class="option-tree-ui-radio option-tree-ui-images">
					<label for="blog_layout-2">Portrait Images 2</label>
				</p>
				<img src="<?php echo get_template_directory_uri() ?>/code/css/images/blog_3.jpg" alt="Portrait Images 2" title="Portrait Images 2" class="option-tree-ui-radio-image <?php if('horizontal' == etheme_get_custom_field('post_layout')) echo 'option-tree-ui-radio-image-selected'; ?>">
			</div>
		</div>
	</div>
</div>
<?php
}
add_action('save_post', 'etheme_post_meta_box_save', 1, 2);
function etheme_post_meta_box_save($post_id, $post) {

	//	verify the nonce
	if ( !isset($_POST['etheme_post_meta_box_nonce']) || !wp_verify_nonce( $_POST['etheme_post_meta_box_nonce'], plugin_basename(__FILE__) ) )
		return $post->ID;
	//	don't try to save the data under autosave, ajax, or future post.
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if ( defined('DOING_AJAX') && DOING_AJAX ) return;
	if ( defined('DOING_CRON') && DOING_CRON ) return;
	//	is the user allowed to edit the post or page?
	if ( ('page' == $_POST['post_type'] && !current_user_can('edit_page', $post->ID)) || !current_user_can('edit_post', $post->ID ) )
		return $post->ID;
	$product_defaults = array(
        'post_layout' => ''
	); 
	$product = wp_parse_args($_POST['etheme_post'], $product_defaults);
	//	store the custom fields
	foreach ( (array)$product as $key => $value ) {
		if ( $post->post_type == 'revision' ) return; // don't try to store data during revision save
		
		if($value['global'] == 1) {
			update_post_meta($post->ID, $key, 'global');
		} else {
			if ( $value['value'] )
				update_post_meta($post->ID, $key, $value['value']);
			else
				update_post_meta($post->ID, $key, 'global');
		}
		

	}
}