<?php
$blog_layout = etheme_get_option('blog_layout');
$blog_sidebar = etheme_get_option('blog_sidebar');
$blog_sidebar_responsive = etheme_get_option('blog_sidebar_responsive');
get_header(); ?>
        <div class="container">
            <div class="row">
                <?php if($blog_sidebar_responsive == 'top'): ?>
                    <div class="span3 sidebar_grid sidebar_<?php echo $blog_sidebar ?>">
                        <?php get_sidebar(); ?>
                    </div>
                <?php endif; ?>
                <div class="<?php echo ($blog_sidebar)? 'span9':'span12'; ?> grid_content with-sidebar-<?php echo $blog_sidebar ?>">
           			<?php if ( have_posts() ) : ?>
        				<h3 class="page-title">
        					<?php if ( is_day() ) : ?>
        						<?php printf( __( 'Daily Archives: %s', ETHEME_DOMAIN ), '<span>' . get_the_date() . '</span>' ); ?>
        					<?php elseif ( is_month() ) : ?>
        						<?php printf( __( 'Monthly Archives: %s', ETHEME_DOMAIN ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', ETHEME_DOMAIN ) ) . '</span>' ); ?>
        					<?php elseif ( is_year() ) : ?>
        						<?php printf( __( 'Yearly Archives: %s', ETHEME_DOMAIN ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', ETHEME_DOMAIN ) ) . '</span>' ); ?>
        					<?php else : ?>
        						<?php _e( 'Blog Archives', ETHEME_DOMAIN ); ?>
        					<?php endif; ?>
        				</h3>
        				
        				<?php
        					/* Include the Post-Format-specific template for the content.
        					 * If you want to overload this in a child theme then include a file
        					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
        					 */
        					get_template_part( 'loop', 'archive' );
        				?>
        
        				
        			<?php else : ?>
                        <h3 class="page-title"><?php _e( 'Nothing Found', ETHEME_DOMAIN ); ?></h3>
        			<?php endif; ?>
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