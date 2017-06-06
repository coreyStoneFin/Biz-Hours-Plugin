<?php
/**
 * The template for displaying attachments.
 *
 */

get_header(); ?>
        <div class="container">
            <div class="row">
                <div class="span12 grid_content">
        			<?php
        			/* Run the loop to output the attachment.
        			 * If you want to overload this in a child theme then include a file
        			 * called loop-attachment.php and that will be used instead.
        			 */
        			get_template_part( 'loop', 'attachment' );
        			?>
    			</div><!-- #content -->
                <div class="clear"></div>
    		</div>
		</div><!-- .container -->
<?php get_footer(); ?>