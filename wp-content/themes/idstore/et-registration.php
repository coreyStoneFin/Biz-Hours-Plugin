<?php
/**
 * Template Name: Custom Registration Page
 */
//Check whether the user is already logged in
if (!$user_ID) {
        $blog_layout = etheme_get_option('blog_layout');
        $blog_sidebar = etheme_get_option('blog_sidebar');
        $blog_sidebar_responsive = etheme_get_option('blog_sidebar_responsive');
        get_header();
        $captcha_instance = new ReallySimpleCaptcha();
		$captcha_instance->bg = array( 244, 80, 80 );
		$word = $captcha_instance->generate_random_word();
		$prefix = mt_rand();
		$img_name = $captcha_instance->generate_image( $prefix, $word );
		$captcha_img = ETHEME_CODE_URL.'/inc/really-simple-captcha/tmp/'.$img_name;
        ?>
        <div class="container">
            <div class="row">
	            <?php blog_breadcrumbs(); ?>
                <div class="span12 grid_content with-sidebar-<?php echo $blog_sidebar ?>">			
                   <?php
                    if(get_option('users_can_register')) {
                        ?>
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <div id="result"></div> 
                        
                        <form id="wp_signup_form" action="" method="post" class="register">
                            <div class="login-fields">
                                <p class="form-row form-row-first register-head">
                                    <i class="icon-user"></i>
                                    <span class="register-span-big"><?php _e('New Customer?', ETHEME_DOMAIN); ?></span>
                                    <span class="register-span-small"><?php _e('Please, register your account to continue.', ETHEME_DOMAIN); ?></span>
                                </p>
                    			<p class="form-row form-row-first">
                                    <label><?php _e( "Enter your username", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                    				<input type="text" name="username" class="text" value="" />
                    			</p>
                    			<p class="form-row">
                                    <label><?php _e( "Enter your E-mail address", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                    				<input type="text" name="email" class="text" value="" />
                    			</p>
                    			<p class="form-row">
                                    <label><?php _e( "Enter your password", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                    				<input type="password" name="pass" class="text" value="" />
                    			</p>
                    			<p class="form-row form-row-last">
                                    <label><?php _e( "Re-enter your password", ETHEME_DOMAIN ) ?> <span class="required">*</span></label>
                    				<input type="password" name="pass2" class="text" value="" />
                    			</p>
                    			<div class="clear"></div>
                			</div>
							<div class="captcha-block">
								<img src="<?php echo $captcha_img; ?>">
								<input type="text" name="captcha-word" class="captcha-input">
								<input type="hidden" name="captcha-prefix" value="<?php echo $prefix; ?>">
							</div>
                			<p class="form-row right">
                				<button class="button fl-r submitbtn" type="submit"><span><?php _e( "Register", ETHEME_DOMAIN ) ?></span></button>
                                <div class="clear"></div>
                			</p>
                        </form>
                        <script type="text/javascript">
                            jQuery(".submitbtn").click(function() {
                                jQuery('#result').html('<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" class="loader" />').fadeIn();
                                var input_data = jQuery('#wp_signup_form').serialize();
                                input_data += '&action=et_register_action';
                                jQuery.ajax({
                                    type: "GET",
                                    dataType: "JSON",
                                    url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                    data: input_data,
                                    success: function(response){
                                        jQuery('.loader').remove();
                                        if(response.status == 'error') {
                                        	var msgHtml = '<span class="error">' + response.msg + '</span>';
                                            jQuery('<div>').html(msgHtml).appendTo('div#result').hide().fadeIn('slow');
                                            
                                        } else {
                                        	var msgHtml = '<span class="success">' + response.msg + '</span>';
                                            jQuery('<div>').html(msgHtml).appendTo('div#result').hide().fadeIn('slow');
                                            jQuery('#wp_signup_form').find("input[type=text], input[type=password], textarea").val("");
                                        }
                                    }
                                });
                                return false;
                            });
                        </script>
                        <?php
                    }
                    else _e( '<span class="error">Registration is currently disabled. Please try again later.<span>', ETHEME_DOMAIN );
                    ?>
                </div>
                <div class="clear"></div>
    		</div>
		</div><!-- .container -->
        <?php
        get_footer();
}
else {
    echo "<script type='text/javascript'>window.location='". home_url() ."'</script>";
}
?>