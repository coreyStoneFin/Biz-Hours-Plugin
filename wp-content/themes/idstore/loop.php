<?php
/**
 * The loop that displays posts.
 *
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"></span> Older posts', ETHEME_DOMAIN) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav"></span>', ETHEME_DOMAIN) ); ?></div>
	    <div class="clear"></div>
    </div><!-- #nav-above -->
<?php endif; ?>

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
	        		<a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
	        			<a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		        		
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
        	
<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"></span> Older posts', ETHEME_DOMAIN ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav"></span>', ETHEME_DOMAIN ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>
