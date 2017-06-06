<?php
/**
 * The template for displaying the footer.
 *
 */
?>
<?php global $etheme_responsive; ?>
      <div class="container_footer_bg">
        <div class="container">
              <div class="row footer_container">
	               <div class="span3 footer_block1 f-contacts">
		               <?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>

	               <div class="span3 footer_block1 footer-big-block">
		               <?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>


	                <div class="span3 footer_block tweets-block">
		                <?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>

	                <div class="span3 footer_block tweets-block">
	                    <?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>

	            <hr class="footer-hr">
                <div class="footer-menu-wrap">
	                <div class="span3 footer_block1">
		                <?php if ( is_active_sidebar( 'fifth-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'fifth-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>

		            <div class="span3 footer_block1">
		                <?php if ( is_active_sidebar( 'sixth-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'sixth-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>


					<div class="span3 footer_block1">
						<?php if ( is_active_sidebar( 'seventh-footer-widget-area' ) ) : ?>
							<?php dynamic_sidebar( 'seventh-footer-widget-area' ); ?>
						<?php endif; ?>
					</div>

	                <div class="span3 footer_block1">
		                <?php if ( is_active_sidebar( 'eighth-footer-widget-area' ) ) : ?>
		                    <?php dynamic_sidebar( 'eighth-footer-widget-area' ); ?>
		                <?php endif; ?>
	                </div>
                </div>

            </div>
        </div>
      </div>
      <div class="footer-black-bg">
      <div class="container no-bg">
      <div class="row after_footer">
        <div class="span6" id="after_footer_menu">
            <?php if ( !is_active_sidebar( 'copyrights-area' ) ) : ?>
				<?php etheme_footer_demo(8); ?>
            <?php else: ?>
                <?php dynamic_sidebar( 'copyrights-area' ); ?>
            <?php endif; ?>

            <div class="span6 footer-copyright">
                <span class="copyright"><?php etheme_option('copyright') ?></span>

            </div>
        </div>

        <div class="span6" id="after_footer_payments">
            <?php if ( !is_active_sidebar( 'payments-area' ) ) : ?>
				<?php etheme_footer_demo(9); ?>
            <?php else: ?>
                <?php dynamic_sidebar( 'payments-area' ); ?>
            <?php endif; ?>
        </div>


      </div>

		<?php if(etheme_get_option('to_top') != 'disable'): ?>
		    <div id="back-to-top" class="btn-style-<?php etheme_option('to_top') ?>"><a href="#top" id="top-link" ><span><?php _e('Back to top',ETHEME_DOMAIN) ?></span></a></div>
		<?php endif ;?>
      </div>
  </div>
  <?php if(etheme_get_option('responsive')): ?>
        	<div class="span12 responsive-switcher visible-phone visible-tablet <?php if(!$etheme_responsive) echo 'visible-desktop'; ?>">
            	<?php _e('Mobile version',  ETHEME_DOMAIN) ?>:
            	<?php if($etheme_responsive): ?>
            		<a href="<?php echo home_url(); ?>/?responsive=off"><?php _e('Enabled',  ETHEME_DOMAIN) ?></a>
            	<?php else: ?>
            		<a href="<?php echo home_url(); ?>/?responsive=on"><?php _e('Disabled',  ETHEME_DOMAIN) ?></a>
            	<?php endif; ?>
        	</div>

        <?php endif; ?>
  </div> <!-- .wrapper -->
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?> 
</body>
</html>
