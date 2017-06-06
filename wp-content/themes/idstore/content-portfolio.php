<?php 
$postId = get_the_ID();

$categories = wp_get_post_terms($postId, 'categories');
$catsClass = '';
foreach($categories as $category) {
	$catsClass .= ' sort-'.$category->slug;
}

$columns = etheme_get_option('portfolio_columns');

if($_GET['col']) {
	$columns = $_GET['col'];
}

switch($columns) {
	case 1:
		$span = '';
	break;
	case 2:
		$span = 'span6';
	break;
	case 3:
		$span = 'span4';
	break;
	case 4:
		$span = 'span3';
	break;
	default:
		$span = 'span4';
	break;
}



?>
<div class="portfolio-item <?php echo $span; ?> <?php echo $catsClass; ?>">        
	<div class="portfolio-image <?php if($columns == 1) echo 'span4'; ?>">
        <?php the_post_thumbnail() ?>
        <div class="portfolio-mask"></div>
        <div class="portfolio-descr">
	        <?php if($columns != 1) : ?>
			    <h3><?php the_title(); ?><h3>
		    <?php endif; ?>
	        
			<?php if (has_post_thumbnail( $postId ) ): ?>
				<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
			
				<?php if(etheme_get_option('port_use_lightbox')): ?><a class="button small btn-icon btn-enlarge" rel="lightbox[portfolio]" href="<?php echo $url; ?>"><i class="icon-fullscreen"></i></a><?php endif; ?>
			<?php endif; ?>
        	<a class="button small active btn-icon btn-link" href="<?php the_permalink($postId); ?>"><i class="icon-link"></i></a>
	        
        </div>
    </div>
    <?php if($columns == 1): ?>
    	<div class="span8">
	    	
	    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
            
	    	<p><?php the_content(); ?></p>
	         
	    	<a href="<?php the_permalink(); ?>" class="button fl-r"><?php _e('Read More', ETHEME_DOMAIN); ?></a>
	    	
    	</div>
    <?php endif; ?>
</div>