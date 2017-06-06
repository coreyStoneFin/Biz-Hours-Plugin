<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); ?>

        <div class="container">
            <div class="row">
                <div class="span12 grid_content">
                    <h1 class="notFound"><?php _e('<strong>404</strong>', ETHEME_DOMAIN); ?></h1>
    				
    				<p><?php _e('Sorry, but the page you are looking for is not found. Please, make sure you’ve typed the current  URL.', ETHEME_DOMAIN); ?> <br />
    				
    				<p><?php get_search_form(); ?></p>
    				
    				<p><a class="button medium arrow-left" href="javascript: history.go(-1)"><?php _e('Return to Previous Page', ETHEME_DOMAIN); ?></a></p>
    				
    				<div class="clear"></div>
                </div>
    		</div>
		</div><!-- .container -->
<?php get_footer(); ?>