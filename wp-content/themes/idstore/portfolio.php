<?php
/**
 * Template Name: Portfolio
 *
 */
 ?>
<?php
get_header(); ?>
        <div class="container">
            <div class="row">
                <div class="span12 grid_content">
                	<?php blog_breadcrumbs(); ?>
                	<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php 
					
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$args = array(
							'post_type' => 'etheme_portfolio',
							'paged' => $paged,	
							'posts_per_page' => etheme_get_option('portfolio_count'),
						);
						$loop = new WP_Query($args);
					?>
					
           			<?php if ( $loop->have_posts() ) : ?>
	           			<ul class="portfolio-filters">
							<li><a href="#" data-filter="*"><?php _e('Show All', ETHEME_DOMAIN); ?></a>/</li>
	           				<?php 
								$categories = get_terms('categories');
								$catsCount = count($categories);
								$_i=0;
								foreach($categories as $category) {
									$_i++;
									?>
										<li><a href="#" data-filter=".sort-<?php echo $category->slug; ?>"><?php echo $category->name; ?></a><?php if($catsCount != $_i): ?>/<?php endif; ?></li>
									<?php 
								}
		           				
	           				?>
						</ul>
           				<div class="row portfolio masonry">
							<?php /* Start the Loop */ ?>
							<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			
								<?php
									get_template_part( 'content', 'portfolio' );
								?>
			
							<?php endwhile; ?>
						</div>
						
						
						<?php etheme_portfolio_pagination($loop, $paged); ?>
						
					<?php else : ?>
                        <h3 class="page-title"><?php _e( 'Nothing Found', ETHEME_DOMAIN ); ?></h3>
        			<?php endif; ?>
        			
        			</style>
    			</div><!-- #content -->
                <div class="clear"></div>
    		</div>
		</div><!-- .container -->
<?php get_footer(); ?>