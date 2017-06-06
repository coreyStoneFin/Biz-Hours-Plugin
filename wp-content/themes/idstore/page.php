<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

global $wp_query;

extract(etheme_get_page_sidebar());

get_header(); ?>
        <div class="container <?php echo $sidebarname; ?>">
            <div class="row">
	            <?php blog_breadcrumbs(); ?>
                <?php if($position && $responsive == 'top'): ?>
                    <div class="span3 sidebar_grid sidebar_<?php echo $position ?>">
                        <?php get_sidebar($sidebarname); ?>
                    </div>
                <?php endif; ?>
                <div class="<?php echo ($position)? 'span9':'span12'; ?> grid_content with-sidebar-<?php echo $position ?>">
                	<?php $post_id = $wp_query->get_queried_object_id();
        			$title = get_post_field( 'post_title', $post_id ); ?>
                    <h1 class="page-title"><?php echo $title; ?></h1>
    				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    					<?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '' . __( 'Pages:', ETHEME_DOMAIN ), 'after' => '' ) ); ?>
                        <?php edit_post_link( __( 'Edit', ETHEME_DOMAIN ), '', '' ); ?>
    				<?php endwhile; ?>
                    <?php else : ?>
    					<p><strong><?php _e( 'Not Found', ETHEME_DOMAIN ); ?></strong></p>
    					<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', ETHEME_DOMAIN ); ?></p>
    					<?php get_search_form(); ?>
    				<?php endif; ?>
                    <div class="clear"></div>    			
                </div>
                <?php if($position && $responsive == 'bottom'): ?>
                    <div class="span3 sidebar_grid sidebar_<?php echo $position ?>">
                        <?php get_sidebar($sidebarname); ?>
                    </div>
                <?php endif; ?>
                <div class="clear"></div>
    		</div>
		</div><!-- .container -->
<?php get_footer(); ?>