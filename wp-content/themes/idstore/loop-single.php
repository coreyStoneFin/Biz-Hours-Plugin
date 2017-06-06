<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 */
?>
<?php $showNav = etheme_get_option('posts_nav'); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php if($showNav): ?>
			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', ETHEME_DOMAIN) . '</span> %title' ); ?></div>
				<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', ETHEME_DOMAIN ) . '</span>' ); ?></div>
			</div><!-- #nav-above -->
            <div class="clear"></div>
        <?php endif; ?>
        <?php 
            $blog_layout = etheme_get_option('blog_layout');
            if(etheme_get_custom_field('post_layout') && etheme_get_custom_field('post_layout') != 'global'){
                $blog_layout = etheme_get_custom_field('post_layout');
            }
            $blog_slider = etheme_get_option('post_img_slider');
            switch ($blog_layout){ 
            	case 'default':
                    $imH = 870;
                    $imW = 870;
            	break;
            	case 'portrait':
                    $imH = 340;
                    $imW = 260;
            	break;
            	case 'horizontal':
                    $imH = 300;
                    $imW = 300;
            	break;
                default:
                    $blog_layout = 'default';
                    $imH = 870;
                    $imW = 870;
            
            }
            
            $imgUrls = etheme_get_images($imW,$imH,false);
        ?>
        
        	<div class="blog-post post-<?php echo $blog_layout; ?>">
        	
        		<?php if($blog_layout == 'default' || $blog_layout == 'horizontal'): ?>
        			<span class="post-title"><?php the_title(); ?></span>
	        	<?php endif; ?>
	        	
				
        		<?php if($blog_layout == 'horizontal'): ?>
	                 <div class="post-information">
	                    <div class="blog_icon_date">
	<span class="blog_icon_title"><i class="icon-calendar"></i></span>
	                        <?php etheme_posted_on(); ?>
	                    </div>
	                    <div class="blog_icon_author">
	<span class="blog_icon_title"><i class="icon-user"></i></span>
	                        <?php the_author_posts_link(); ?> 
	                    </div>
	                    <div class="blog_icon_comment">
	                       <span class="blog_icon_title"><i class="icon-comments"></i>&nbsp;</span><?php comments_popup_link( __( 'Leave a comment', ETHEME_DOMAIN ), __( '1 Comment', ETHEME_DOMAIN ), __( '% Comments', ETHEME_DOMAIN ) ); ?>
	                    </div>
	                    <div class="blog_icon_webdesign">
	<span class="blog_icon_title"><i class="icon-folder-open"></i></span>
	        				<?php if ( count( get_the_category() ) ) : ?>
	        					<span class="cat-links">
	        						<?php printf( __( '%1$s', ETHEME_DOMAIN ), etheme_get_the_category_list( ', ' ) ); ?>
	        					</span>
	        				<?php endif; ?>
	                    </div>
	                </div>
	                <div class="clear"></div>
	        	<?php endif; ?>
	        	
				<?php if($imgUrls):
					?>
						<div class="attachments-slider nav-type-<?php etheme_option('slider_nav_type'); ?> post-images">
							<ul class="slides">
								<?php if(!$blog_slider): ?>
									<li><a href="<?php the_permalink(); ?>"><img src="<?php echo $imgUrls[0]; ?>"></a></li>
								<?php else: ?>
									<?php foreach ($imgUrls as $key => $value): ?>
										<li><a href="<?php the_permalink(); ?>"><img src="<?php echo $value; ?>"></a></li>
									<?php endforeach ?>
								<?php endif; ?>
							</ul>
						</div>
        				<?php if($blog_slider): ?>				
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
				
				<?php endif; ?>
				
        		<?php if($blog_layout == 'default'): ?>
	                 <div class="post-information">
	                    <div class="blog_icon_date">
	<span class="blog_icon_title"><i class="icon-calendar"></i></span>
	                        <?php etheme_posted_on(); ?>
	                    </div>
	                    <div class="blog_icon_author">
	<span class="blog_icon_title"><i class="icon-user"></i></span>
	                        <?php the_author_posts_link(); ?> 
	                    </div>
	                    <div class="blog_icon_comment">
	                       <span class="blog_icon_title"><i class="icon-comments"></i>&nbsp;</span><?php comments_popup_link( __( 'Leave a comment', ETHEME_DOMAIN ), __( '1 Comment', ETHEME_DOMAIN ), __( '% Comments', ETHEME_DOMAIN ) ); ?>
	                    </div>
	                    <div class="blog_icon_webdesign">
	<span class="blog_icon_title"><i class="icon-folder-open"></i></span>
	        				<?php if ( count( get_the_category() ) ) : ?>
	        					<span class="cat-links">
	        						<?php printf( __( '%1$s', ETHEME_DOMAIN ), etheme_get_the_category_list( ', ' ) ); ?>
	        					</span>
	        				<?php endif; ?>
	                    </div>
	                </div>
	                <div class="clear"></div>
	        	<?php endif; ?>
                
                <div class="blog-content">
	        		<?php if($blog_layout == 'portrait'): ?>
	        			<span class="post-title"><?php the_title(); ?></span>
		        		
		                 <div class="post-information">
		                    <div class="blog_icon_date">
		<span class="blog_icon_title"><i class="icon-calendar"></i></span>
		                        <?php etheme_posted_on(); ?>
		                    </div>
		                    <div class="blog_icon_author">
		<span class="blog_icon_title"><i class="icon-user"></i></span>
		                        <?php the_author_posts_link(); ?> 
		                    </div>
		                    <div class="blog_icon_comment">
		                       <span class="blog_icon_title"><i class="icon-comments"></i>&nbsp;</span><?php comments_popup_link( __( 'Leave a comment', ETHEME_DOMAIN ), __( '1 Comment', ETHEME_DOMAIN ), __( '% Comments', ETHEME_DOMAIN ) ); ?>
		                    </div>
		                    <div class="blog_icon_webdesign">
		<span class="blog_icon_title"><i class="icon-folder-open"></i></span>
		        				<?php if ( count( get_the_category() ) ) : ?>
		        					<span class="cat-links">
		        						<?php printf( __( '%1$s', ETHEME_DOMAIN ), etheme_get_the_category_list( ', ' ) ); ?>
		        					</span>
		        				<?php endif; ?>
		                    </div>
		                </div>
		        	<?php endif; ?>
		        	
                	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
                			<div class="entry-summary">
                				<?php the_excerpt(); ?>
                			</div><!-- .entry-summary -->
                	<?php else : ?>
                			<div class="entry-content">
                				<?php the_content( __( '<span class="button fl-r"><span>Read More</span></span><br/>', ETHEME_DOMAIN ) ); ?>
                				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', ETHEME_DOMAIN ), 'after' => '</div>' ) ); ?>
                			</div><!-- .entry-content -->
                	<?php endif; ?> 
                </div>
                <div class="clear"></div>
				
        	</div>
        	                        
            <?php edit_post_link( __( 'Edit', ETHEME_DOMAIN ), '<span class="edit-link">', '</span>' ); ?>

            <?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>