<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 */
?>
<?php 
	$blog = et_is_blog();
	$page_sidebar = etheme_get_custom_field('widget_area', $blog);
?>

<div id="primary" class="widget-area" role="complementary">

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :   
		dynamic_sidebar($page_sidebar);  
	else :   
		/* No widget */  
	endif; ?>
	
</div><!-- #primary .widget-area -->
