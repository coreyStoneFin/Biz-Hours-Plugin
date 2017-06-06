<?php
/**
 * The Template for displaying single portfolio project.
 *
 */

$blog_layout = etheme_get_option('blog_layout');
get_header(); ?>
        <div class="container">
            <div class="row">
	            <?php blog_breadcrumbs(); ?>
	            
                <div class="span12 grid_content with-sidebar-<?php echo $blog_sidebar ?>">
				
				
				<?php /* If there are no posts to display, such as an empty archive page */ ?>
				<?php if ( ! have_posts() ) : ?>
					<div id="post-0" class="post error404 not-found">
						<h1 class="entry-title"><?php _e( 'Not Found', ETHEME_DOMAIN); ?></h1>
						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', ETHEME_DOMAIN); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</div><!-- #post-0 -->
				<?php endif; ?>
				<?php while ( have_posts() ) : the_post(); ?>
				
				        <?php 
				            $blog_layout = etheme_get_option('blog_layout');
				            if(etheme_get_custom_field('post_layout') && etheme_get_custom_field('post_layout') != 'global'){
				                $blog_layout = etheme_get_custom_field('post_layout');
				            }
				        ?>
				            <div class="portfolio-single-item row">
				
					    
								<?php
								$args = array(
								    'post_type' => 'attachment',
								    'numberposts' => '5',
								    'post_status' => null,
								    'post_parent' => $post->ID,
									'orderby' => 'menu_order',
									'order' => 'ASC',
									'exclude' => get_post_thumbnail_id()
								);
								$attachments = get_posts($args);
								if($attachments || has_post_thumbnail()):
								?>
								<div class="attachments-slider nav-type-<?php etheme_option('slider_nav_type'); ?> span6">
									<ul class="slides">
										<?php if(has_post_thumbnail()): ?>
											<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
											<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
											<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
											<li>
												<a <?php if(etheme_get_option('port_use_lightbox')): ?> href="<?php echo $full_image[0]; ?>" rel="lightbox['gallery']"<?php endif; ?>><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
											</li>
										<?php endif; ?>
										<?php foreach($attachments as $attachment): ?>
											<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
											<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
											<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
											<li>
												<a <?php if(etheme_get_option('port_use_lightbox')): ?>href="<?php echo $full_image[0]; ?>" rel="lightbox['gallery']"<?php endif; ?>><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
														
								<script type="text/javascript">
									jQuery(window).load(function() {
										jQuery('.attachments-slider').flexslider({
											animation: "slide",
											slideshow: false,
											animationLoop: false,
											controlNav: false
										});
									});
								</script>
								
								<?php endif; ?>
								
				                    <div class="portfolio-content span6">
				                        <h3><?php the_title(); ?></h3>
				                        <div class="post-information">
											<div class="blog_icon_date">
												<span class="blog_icon_title"><i class="icon-calendar"></i></span>
												<?php echo get_the_date(); ?>
											</div>
								            <div class="blog2_icon_author">
								               	<span class="blog_icon_title"><i class="icon-user"></i></span>
								                <?php the_author(); ?> 
								            </div>
				                            <?php if(etheme_get_option('portfolio_comments')): ?>
					                            <div class="blog2_icon_comment">
					                               <span class="blog_icon_title"><i class="icon-comments"></i>&nbsp;</span><?php comments_popup_link( __( 'Leave a comment', ETHEME_DOMAIN ), __( '1 Comment', ETHEME_DOMAIN ), __( '% Comments', ETHEME_DOMAIN ) ); ?>
					                            </div>
				                            <?php endif; ?>
				                            
				                         <div class="clear"></div>
				                        </div>
				                        	<?php if ( is_search() ) : // Only display excerpts for archives and search. ?>
				                        			<div class="entry-summary">
				                        				<?php the_excerpt(); ?>
				                        			</div><!-- .entry-summary -->
				                        	<?php else : ?>
				                        			<div class="entry-content">
				                        				<?php the_content(); ?>
				                        			</div><!-- .entry-content -->
				                        	<?php endif; ?> 
				                        	<div class="clear"></div>
				                        
					                        	
					                        <h2><?php _e('Project Details:', ETHEME_DOMAIN); ?></h2>
					                         <table class="table table-bordered item-information">
						                         
						                         
						                         <?php $categories = wp_get_post_terms($post->ID, 'categories'); if(count($categories) > 0): ?>
							                         <tr>
								                         <td class="a-right"><?php _e('Categories:', ETHEME_DOMAIN); ?></td>
								                         <td>
								                         	<?php	
																foreach($categories as $category) {
																	?>
																		<?php echo $category->name; ?><br>
																	<?php 
																}
								                         	?>
								                         	
								                         </td>
							                         </tr>
						                         <?php endif; ?>
						                         
						                         <?php if(etheme_get_custom_field('client') != ''): ?>
							                         <tr>
								                         <td class="a-right"><?php _e('Client:', ETHEME_DOMAIN); ?></td>
								                         <td>
								                         	<?php if(etheme_get_custom_field('client_url') != ''): ?><a href="<?php etheme_custom_field('client_url'); ?>" target="_blank"><?php endif;?>
								                         		<?php etheme_custom_field('client'); ?>
								                         	<?php if(etheme_get_custom_field('client_url') != ''): ?></a><?php endif;?>
								                         </td>
							                         </tr>
						                         <?php endif; ?>
						                         
						                         <?php if(etheme_get_custom_field('copyright') != ''): ?>
							                         <tr>
								                         <td class="a-right"><?php _e('Copyright:', ETHEME_DOMAIN); ?></td>
								                         <td>
								                         	<?php if(etheme_get_custom_field('copyright_url') != ''): ?><a href="<?php etheme_custom_field('copyright_url'); ?>" target="_blank"><?php endif;?>
								                         		<?php etheme_custom_field('copyright'); ?>
								                         	<?php if(etheme_get_custom_field('copyright_url') != ''): ?></a><?php endif;?>
								                         </td>
							                         </tr>	
						                         <?php endif; ?>	                         
					                         </table>
					                         
					                         <?php if(etheme_get_custom_field('project_url') != ''): ?>
						                         
						                         <a href="<?php etheme_custom_field('project_url'); ?>" target="_blank" class="button fl-r active big arrow-right"><span><?php _e('Visit Project Site', ETHEME_DOMAIN); ?></span></a>
						                         
					                         <?php endif; ?>
					                         
				                         <div class="clear"></div>
				                    </div>
				                </div>  
				
				<?php endwhile; // End the loop. Whew. ?>
								
    			</div><!-- #content -->
    			
                <div class="clear"></div>
    		</div>
    		
    		<?php 
    			if(etheme_get_option('recent_projects')) {
	    			echo etheme_get_recent_portfolio(8, __('Recent Works', ETHEME_DOMAIN), $post->ID);
    			}
    			
    			if(etheme_get_option('portfolio_comments')) {
	    			comments_template( '', true );
    			}
    		?>
    		
		</div><!-- .container -->
<?php get_footer(); ?>
