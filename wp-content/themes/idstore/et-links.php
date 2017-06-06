<ul class="header-links">
    <?php if ( is_user_logged_in() ) : ?>
        <?php if(class_exists('Woocommerce')): ?> <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Your Account', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
        <span class="delimeter">/</span> <li class="no"><a class="black" href="<?php echo wp_logout_url(home_url()); ?>"><?php _e( 'Logout', ETHEME_DOMAIN ); ?></a></li>
    <?php else : ?>
        <?php 
            $reg_id = etheme_tpl2id('et-registration.php'); 
            $reg_url = get_permalink($reg_id);
        ?>    
        <?php if(class_exists('Woocommerce')): ?><li class="no"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Sign In', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
        <span class="delimeter">/</span> <?php if(!empty($reg_id)): ?><li><a href="<?php echo $reg_url; ?>"><?php _e( 'Register', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
    <?php endif; ?>
</ul>