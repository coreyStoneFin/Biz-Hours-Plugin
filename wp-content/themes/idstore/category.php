<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

$blog_layout = etheme_get_option('blog_layout');
$blog_sidebar = etheme_get_option('blog_sidebar');
$blog_sidebar_responsive = etheme_get_option('blog_sidebar_responsive');

get_header(); ?>
        <div class="container">
            <div class="row">
	            <?php blog_breadcrumbs(); ?>
                <?php if($blog_sidebar_responsive == 'top'): ?>
                    <div class="span3 sidebar_grid sidebar_<?php echo $blog_sidebar ?>">
                        <?php get_sidebar(); ?>
                    </div>
                <?php endif; ?>
                <div class="<?php echo ($blog_sidebar)? 'span9':'span12'; ?> grid_content with-sidebar-<?php echo $blog_sidebar ?>">
    				<?php
    				/* Run the loop for the category page to output the posts.
    				 * If you want to overload this in a child theme then include a file
    				 * called loop-category.php and that will be used instead.
    				 */
    				get_template_part( 'loop', 'category' );
    				?>
    			</div><!-- #content -->
                <?php if($blog_sidebar_responsive == 'bottom'): ?>
                    <div class="span3 sidebar_grid sidebar_<?php echo $blog_sidebar ?>">
                        <?php get_sidebar(); ?>
                    </div>
                <?php endif; ?>
                <div class="clear"></div>
    		</div>
		</div><!-- .container -->
<?php get_footer(); ?>
