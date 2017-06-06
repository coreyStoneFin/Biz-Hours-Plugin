<?php
/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
	  
	  
	function etheme_theme_settings_defaults() {
		$defaults = array();
		return apply_filters('etheme_theme_settings_defaults', $defaults);
	}
	
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
   
   $sections = array(
        array(
            'id'       => 'general',
            'title'    => 'General',
            'icon'     => 'icon-cog'
        ),
        array(
            'id'       => 'color_scheme',
            'title'    => 'Color Scheme',
            'icon'     => 'icon-picture'
        ),
        array(
            'id'       => 'typography',
            'title'    => 'Typography',
            'icon'     => 'icon-text-height'
        ),
        array(
            'id'       => 'header',
            'title'    => 'Header',
            'icon'     => 'icon-cogs'
        ),
        array(
            'id'       => 'shop',
            'title'    => 'Shop',
            'icon'     => 'icon-shopping-cart'
        ),
        array(
            'id'       => 'product_grid',
            'title'    => 'Products Page Layout',
            'icon'     => 'icon-th'
        ),
        array(
            'id'       => 'single_product',
            'title'    => 'Single Product Page',
            'icon'     => 'icon-file-alt'
        ),
        array(
            'id'       => 'blog_page',
            'title'    => 'Blog Layout',
            'icon'     => 'icon-indent-right'
        ),
        array(
            'id'       => 'portfolio',
            'title'    => 'Portfolio',
            'icon'     => 'icon-briefcase'
        ),
        array(
            'id'       => 'contact_form',
            'title'    => 'Contact Form',
            'icon'     => 'icon-envelope'
        ),
        array(
            'id'       => 'responsive',
            'title'    => 'Responsive',
            'icon'     => 'icon-mobile-phone'
        ),
        array(
            'id'       => 'custom_css',
            'title'    => 'Custom CSS',
            'icon'     => 'icon-paper-clip'
        ),
        array(
            'id'       => 'backup',
            'title'    => 'Import/Export',
            'icon'     => 'icon-cog'
        )
   );
   
   $settings = array(
        array(
            'id'          => 'main_layout',
            'label'       => 'Site Layout',
            'default'     => 'wide',
            'type'        => 'select',
            'section'     => 'general',
            'choices'     => array(
              array( 
                'value' => 'wide',
                'label' => 'Wide' 
              ),
              array( 
                'value' => 'boxed',
                'label' => 'Boxed' 
              )
            )
        ),
        array(
            'id'          => 'to_top',
            'label'       => '"Back To Top" button',
            'default'     => 'modern',
            'type'        => 'select',
            'section'     => 'general',
            'choices'     => array(
              array( 
                'value' => 'disable',
                'label' => 'Disable' 
              ),
              array( 
                'value' => 'modern',
                'label' => 'Modern' 
              ),
              array( 
                'value' => 'standart',
                'label' => 'Standard' 
              ),
            )
        ),
        array(
            'id'          => 'fixed_nav',
            'label'       => 'Fixed navigation',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'general',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'nice_scroll',
            'label'       => 'Nice Scroll',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'general',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'copyright',
            'label'       => 'Copyright Text',
            'default'     => 'Wordpress DEMO Store. All Rights Reserved.',
            'type'        => 'text',
            'section'     => 'general'
        ),
        // COLOR SCHEME 
        array(
            'id'          => 'main_color_scheme',
            'label'       => 'Main color scheme',
            'default'     => 'light',
            'type'        => 'select',
            'section'     => 'color_scheme',
            'choices'     => array(
              array( 
                'value' => 'light',
                'label' => 'Light' 
              ),
              array( 
                'value' => 'dark',
                'label' => 'Dark' 
              )
            )
        ),
        array(
            'id'          => 'activecol',
            'label'       => 'Main Color',
            'default'     => '#fc5b5b',
            'type'        => 'colorpicker',
            'section'     => 'color_scheme',
        ),
        array(
            'id'          => 'activehovercol',
            'label'       => 'Active button hover Color',
            'default'     => '#e83636',
            'type'        => 'colorpicker',
            'section'     => 'color_scheme',
        ),
        array(
            'id'          => 'footer_bg',
            'label'       => 'Footer Background Color',
            'default'     => '#222222',
            'type'        => 'colorpicker',
            'section'     => 'color_scheme',
        ),
        array(
            'id'          => 'background_img',
            'label'       => 'Site Background',
            'desc'        => '',
            'default'     => '',
            'type'        => 'background',
            'section'     => 'color_scheme',
        ),
        array(
            'id'          => 'background_cover',
            'label'       => 'Background Image Expanding',
            'default'     => '',
            'type'        => 'select',
            'section'     => 'color_scheme',
            'choices'     => array(
              array( 
                'value' => 'enable',
                'label' => 'enable' 
              ),
              array( 
                'value' => 'disable',
                'label' => 'disable' 
              )
            )
        ),
        // TYPOGRAPHY
        array(
            'id'          => 'sfont',
            'label'       => 'Site Font',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        array(
            'id'          => 'h1',
            'label'       => 'H1',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        array(
            'id'          => 'h2',
            'label'       => 'H2',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        array(
            'id'          => 'h3',
            'label'       => 'H3',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        array(
            'id'          => 'h4',
            'label'       => 'H4',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        array(
            'id'          => 'h5',
            'label'       => 'H5',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        array(
            'id'          => 'h6',
            'label'       => 'H6',
            'default'     => '',
            'type'        => 'typography',
            'section'     => 'typography',
        ),
        // HEADER
        array(
            'id'          => 'header_type',
            'label'       => 'Header Type',
            'default'     => 'variant2',
            'type'        => 'radio-image',
            'section'     => 'header',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'default',
                    'label'   => 'Expanded',
                    'src'     => OT_URL . '/assets/images/header_v1.jpg'
                ),
                array(
                    'value'   => 'variant2',
                    'label'   => 'Compressed',
                    'src'     => OT_URL . '/assets/images/header_v2.jpg'
                ),
                array(
                    'value'   => 'variant3',
                    'label'   => 'Variant 3',
                    'src'     => OT_URL . '/assets/images/header_v3.jpg'
                ),
                array(
                    'value'   => 'variant4',
                    'label'   => 'Variant 4',
                    'src'     => OT_URL . '/assets/images/header_v4.jpg'
                ),
                array(
                    'value'   => 'variant5',
                    'label'   => 'Variant 5',
                    'src'     => OT_URL . '/assets/images/header_v5.jpg'
                ),
                array(
                    'value'   => 'variant6',
                    'label'   => 'Variant 6',
                    'src'     => OT_URL . '/assets/images/header_v6.jpg'
                ),
                /*
                array(
                    'value'   => 'variant7',
                    'label'   => 'Variant 7',
                    'src'     => OT_URL . '/assets/images/header_v7.jpg'
                )*/
            )
        ),
        array(
            'id'          => 'menu_type',
            'label'       => 'Menu Type',
            'default'     => 'default',
            'type'        => 'select',
            'desc'        => 'Works only with expanded header variant',
            'section'     => 'general',
            'choices'     => array(
              array( 
                'value' => 'default',
                'label' => 'Default Menu' 
              ),
              array( 
                'value' => 'mega',
                'label' => 'Mega Menu' 
              )
            )
        ),
        array(
            'id'          => 'logo',
            'label'       => 'Logo image',
            'default'     => '',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'header'
        ),
        array(
            'id'          => 'favicon',
            'label'       => 'Favicon',
            'default'     => '[template_url]/images/favicon.ico',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'header'
        ),
        array(
            'id'          => 'top_links',
            'label'       => 'Enable top links (Register | Sign In)',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'header',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'cart_widget',
            'label'       => 'Enable cart widget',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'header',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'search_form',
            'label'       => 'Enable search form in header',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'header',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'header_phone',
            'label'       => 'Phone number',
            'default'     => 'Call toll free: 099822384',
            'type'        => 'text',
            'section'     => 'header'
        ),
        // CONTACT FORM
        array(
            'id'          => 'contacts_email',
            'label'       => 'Your email for contact form',
            'default'     => 'test@gmail.com',
            'type'        => 'text',
            'section'     => 'contact_form'
        ),
        array(
            'id'          => 'google_map',
            'label'       => 'Longitude and Latitude for google map',
            'desc'        => '<b>Example:</b>  51.507622,-0.1305',
            'default'     => '51.507622,-0.1305',
            'type'        => 'text',
            'section'     => 'contact_form'
        ),
        array(
            'id'          => 'contacts_custom_html',
            'label'       => 'Custom html content',
            'desc'        => 'This content will appear above contacts information',
            'default'     => '',
            'type'        => 'textarea',
            'section'     => 'contact_form'
        ),
        array(
            'id'          => 'contacts_info',
            'label'       => 'Enter your contacts information',
            'desc'        => '<b>NOTE:</b>  You can use any shortcode / HTML code.',
            'default'     => '
<h5>Contact Info</h5>
<p style="font-size:11px;">30 South Park Avenue<br/>
San Francisco, CA 94108<br/>
USA</p> 
<p style="font-size:11px;">Phone: (123) 456-7890<br/>
Fax: +08 (123) 456-7890<br/>
Email: contact@companyname.com<br/>
Web: companyname.com</p>
<p>
<a class="fc-webicon twitter" href="#">Twitter</a>&nbsp;&nbsp;
<a class="fc-webicon googleplus" href="#">Google+</a>&nbsp;&nbsp;
<a class="fc-webicon facebook" href="#">Facebook</a>&nbsp;&nbsp;
<a class="fc-webicon youtube" href="#">YouTube</a>&nbsp;
</p>
<hr style="margin-bottom:15px;">
<h5>Dummy Text</h5>
<p style="font-size:11px;">It is a long established fact that a reader will be 
distracted by the readable content of a page when 
looking at its layout.</p>
            
            ',
            'type'        => 'textarea',
            'section'     => 'contact_form'
        ),
        // SHOP
        array(
            'id'          => 'just_catalog',
            'label'       => 'Just Catalog',
            'desc'        => 'Disable "Add To Cart" button and shopping cart',
            'default'     => 0,
            'type'        => 'checkbox',
            'section'     => 'shop',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'ajax_filter',
            'label'       => 'Enable Ajax Filter',
            'type'        => 'checkbox',
            'section'     => 'shop',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'checkout_accordion',
            'label'       => 'Enable Accordion Checkout',
            'type'        => 'checkbox',
            'section'     => 'shop',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'cats_accordion',
            'label'       => 'Enable Navigation Accordion',
            'type'        => 'checkbox',
            'section'     => 'shop',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'touch_carusels',
            'label'       => 'Enable Touch Navigation for sliders',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'shop',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'new_icon',
            'label'       => 'Enable "NEW" icon',
            'type'        => 'checkbox',
            'section'     => 'shop',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'new_icon_width',
            'label'       => '"NEW" Icon width',
            'desc'        => '<b>Example: </b> 60',
            'type'        => 'text',
            'section'     => 'shop',
            'default'     => 50
        ),
        array(
            'id'          => 'new_icon_height',
            'label'       => '"NEW" Icon height',
            'desc'        => '<b>Example: </b> 20',
            'type'        => 'text',
            'section'     => 'shop',
            'default'     => 50
        ),
        array(
            'id'          => 'new_icon_url',
            'label'       => '"NEW" Icon Image',
            'default'     => '',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'shop'
        ),
        array(
            'id'          => 'sale_icon',
            'label'       => 'Enable "Sale" icon',
            'type'        => 'checkbox',
            'section'     => 'shop',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'sale_icon_width',
            'label'       => '"SALE" Icon width',
            'default'     => '',
            'desc'        => '<b>Example: </b> 60',
            'type'        => 'text',
            'section'     => 'shop',
            'default'     => 50
        ),
        array(
            'id'          => 'sale_icon_height',
            'label'       => '"SALE" Icon height',
            'default'     => '',
            'desc'        => '<b>Example: </b> 20',
            'type'        => 'text',
            'section'     => 'shop',
            'default'     => 50
        ),
        array(
            'id'          => 'sale_icon_url',
            'default'     => '',
            'label'       => '"SALE" Icon Image',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'shop'
        ),
        array(
            'id'          => 'product_bage_banner',
            'label'       => 'Product Page Banner',
            'default'     => 'wp-content/themes/idstore/images/assets/shop-banner.jpg',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'shop'
        ),
        array(
            'id'          => 'empty_cart_content',
            'label'       => 'Text for empty cart',
            'default'     => '
<h2>Your cart is currently empty</h2>
<p>You have not added any items in your shopping cart</p>
            ',
            'type'        => 'textarea',
            'section'     => 'shop'
        ),
        array(
            'id'          => 'empty_category_content',
            'label'       => 'Text for empty category',
            'default'     => '
<h2>There no products where found</h2>
            ',
            'type'        => 'textarea',
            'section'     => 'shop'
        ),
        // Product Grid
        array(
            'id'          => 'view_mode',
            'label'       => 'Products view mode',
            'type'        => 'select',
            'section'     => 'product_grid',
            'default'     => 'grid_list',
            'class'       => 'prodcuts_per_row',
            'choices'     => array(
              array( 
                'value' => 'grid_list',
                'label' => 'Grid/List' 
              ),
              array( 
                'value' => 'list_grid',
                'label' => 'List/Grid' 
              ),
              array( 
                'value' => 'grid',
                'label' => 'Only Grid' 
              ),
              array( 
                'value' => 'list',
                'label' => 'Only List' 
              )
            )
        ),
        array(
            'id'          => 'prodcuts_per_row',
            'label'       => 'Products per row',
            'type'        => 'select',
            'section'     => 'product_grid',
            'default'     => 3,
            'class'       => 'prodcuts_per_row',
            'choices'     => array(
              array( 
                'value' => 3,
                'label' => '3' 
              ),
              array( 
                'value' => 4,
                'label' => '4' 
              ),
              array( 
                'value' => 5,
                'label' => '5' 
              ),
              array( 
                'value' => 6,
                'label' => '6' 
              ),
            )
        ),
        array(
            'id'          => 'product_page_sidebar',
            'label'       => 'Sidebar',
            'type'        => 'checkbox',
            'default'     => array(
            	0 => 1
            ),
            'section'     => 'product_grid',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'grid_sidebar',
            'label'       => 'Layout',
            'desc'        => 'Sidebar position',
            'default'     => 'left',
            'type'        => 'radio-image',
            'section'     => 'product_grid',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'left',
                    'label'   => 'Left Sidebar',
                    'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
                ),
                array(
                    'value'   => 'right',
                    'label'   => 'Right Sidebar',
                    'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
                )
            )
        ),
        array(
            'id'          => 'product_img_hover',
            'label'       => 'Product Image Hover',
            'type'        => 'select',
            'section'     => 'product_grid',
            'default'     => 'swap',
            'choices'     => array(
              array( 
                'value' => 'disable',
                'label' => 'Disable' 
              ),
              array( 
                'value' => 'tooltip',
                'label' => 'Tooltip' 
              ),
              array( 
                'value' => 'swap',
                'label' => 'Swap' 
              ),
            )
        ),
        array(
            'id'          => 'product_page_image_width',
            'label'       => 'Product Images Width',
            'default'     => 270,
            'type'        => 'text',
            'section'     => 'product_grid'
        ),
        array(
            'id'          => 'product_page_image_height',
            'label'       => 'Product Images Height',
            'default'     => 370,
            'type'        => 'text',
            'section'     => 'product_grid'
        ),
        array(
            'id'          => 'product_page_image_cropping',
            'label'       => 'Image Cropping',
            'type'        => 'checkbox',
            'default'     => array(
                0 => 0
            ),
            'section'     => 'product_grid',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'product_page_productname',
            'label'       => 'Show product name',
            'type'        => 'checkbox',
            'section'     => 'product_grid',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'product_page_price',
            'label'       => 'Show Price',
            'type'        => 'checkbox',
            'section'     => 'product_grid',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'product_page_addtocart',
            'label'       => 'Show "Add to cart" button',
            'type'        => 'checkbox',
            'section'     => 'product_grid',
            'default'     => array(
            	0 => 1
            ),
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        // BLOG 
        array(
            'id'          => 'post_img_slider',
            'label'       => 'Create a slider from post photos',
            'type'        => 'checkbox',
            'section'     => 'blog_page',
            'default'     => 0,
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'posts_nav',
            'label'       => 'Show Navigation Above Blog Post',
            'type'        => 'checkbox',
            'section'     => 'blog_page',
            'default'     => 0,
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'blog_layout',
            'label'       => 'Blog page layout',
            'default'     => 'default',
            'type'        => 'radio-image',
            'section'     => 'blog_page',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'default',
                    'label'   => 'Default',
                    'src'     => get_template_directory_uri().'/code/css/images/blog_1.jpg'
                ),
                array(
                    'value'   => 'portrait',
                    'label'   => 'Portrait Images',
                    'src'     => get_template_directory_uri().'/code/css/images/blog_2.jpg'
                ),
                array(
                    'value'   => 'horizontal',
                    'label'   => 'Portrait Images 2',
                    'src'     => get_template_directory_uri().'/code/css/images/blog_3.jpg'
                )
            )
        ),
        array(
            'id'          => 'blog_sidebar',
            'label'       => 'Sidebar position',
            'default'     => 'left',
            'type'        => 'radio-image',
            'section'     => 'blog_page',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'left',
                    'label'   => 'Left Sidebar',
                    'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
                ),
                array(
                    'value'   => 'right',
                    'label'   => 'Right Sidebar',
                    'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
                )
            )
        ),
        array(
            'id'          => 'blog_sidebar_responsive',
            'label'       => 'Sidebar position for responsive layout',
            'default'     => 'bottom',
            'type'        => 'select',
            'section'     => 'blog_page',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'top',
                    'label'   => 'Top'
                ),
                array(
                    'value'   => 'bottom',
                    'label'   => 'Bottom'
                )
            )
        ),
        // Portfolio
        array(
            'id'          => 'portfolio_count',
            'label'       => 'Items per page',
            'default'     => -1,
            'desc'        => 'Use -1 to show all items',
            'type'        => 'text',
            'section'     => 'portfolio'
        ),
        array(
            'id'          => 'portfolio_columns',
            'label'       => 'Columns',
            'type'        => 'select',
            'section'     => 'portfolio',
            'default'     => 3,
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => 1
              ),
              array( 
                'value' => 2,
                'label' => 2
              ),
              array( 
                'value' => 3,
                'label' => 3 
              ),
              array( 
                'value' => 4,
                'label' => 4 
              ),
            )
        ),
        array(
            'id'          => 'port_use_lightbox',
            'label'       => 'Use lightbox',
            'type'        => 'checkbox',
            'section'     => 'portfolio',
            'default'     => 1,
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'slider_nav_type',
            'label'       => 'Slider Navigation Type',
            'type'        => 'select',
            'section'     => 'portfolio',
            'default'     => 'large',
            'choices'     => array(
              array( 
                'value' => 'large',
                'label' => 'Large'
              ),
              array( 
                'value' => 'small',
                'label' => 'Small'
              )
            )
        ),
        array(
            'id'          => 'recent_projects',
            'label'       => 'Show Recent Works',
            'type'        => 'checkbox',
            'section'     => 'portfolio',
            'default'     => 1,
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        array(
            'id'          => 'portfolio_comments',
            'label'       => 'Enable Comments For Projects',
            'type'        => 'checkbox',
            'section'     => 'portfolio',
            'default'     => 1,
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              ),
            )
        ),
        // Single Product Page
        array(
            'id'          => 'single_product_layout',
            'label'       => 'Single Product page layout',
            'default'     => 'default',
            'type'        => 'radio-image',
            'section'     => 'single_product',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'default',
                    'label'   => 'Default',
                    'src'     => get_template_directory_uri().'/option-tree/assets/images/product_1.jpg'
                ),
                array(
                    'value'   => 'variant2',
                    'label'   => 'Portrait Images',
                    'src'     => get_template_directory_uri().'/option-tree/assets/images/product_2.jpg'
                ),
                array(
                    'value'   => 'variant3',
                    'label'   => 'Portrait Images 2',
                    'src'     => get_template_directory_uri().'/option-tree/assets/images/product_3.jpg'
                )
            )
        ),
        array(
            'id'          => 'ajax_addtocart',
            'label'       => 'Ajax "Add To Cart"',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'single_product',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 1,
                    'label'   => ''
                )
            )
        ),        
        array(
            'id'          => 'thumbs_count',
            'label'       => 'Number of thumbnails in slider below main image',
            'default'     => 3,
            'type'        => 'select',
            'section'     => 'single_product',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 3,
                    'label'   => '3'
                ),
                array(
                    'value'   => 4,
                    'label'   => '4'
                ),
            )
        ),
        array(
            'id'          => 'zoom_efect',
            'label'       => 'Zoom effect',
            'default'     => 'dock',
            'type'        => 'select',
            'section'     => 'single_product',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 'disable',
                    'label'   => 'Disable'
                ),
                array(
                    'value'   => 'dock',
                    'label'   => 'Dock'
                ),
                array(
                    'value'   => 'slippy',
                    'label'   => 'Slippy'
                ),
                array(
                    'value'   => 'window',
                    'label'   => 'Window'
                )
            )
        ),
        array(
            'id'          => 'single_product_thumb_width',
            'label'       => 'Product Thumbnails Width',
            'default'     => 75,
            'type'        => 'text',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'single_product_thumb_height',
            'label'       => 'Product Thumbnails Height',
            'default'     => 100,
            'type'        => 'text',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'gallery_lightbox',
            'label'       => 'Enable Lightbox for Product Images',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'single_product',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 1,
                    'label'   => ''
                )
            )
        ),
        array(
            'id'          => 'right_banners',
            'label'       => 'Right Sidebar',
            'desc'        => 'Enter custom content you would like to output to the product right sidebar <br>(If its off - widget from "Single product sidebar" area will be shown) </br><b>NOTE:</b>  You can use any shortcode / HTML code.',
            'default'     => '
<div class="banner banner-transform"><img alt="" src="[template_url]/images/Custom-banner1.jpg">
<div class="mask">
<h2>Nice Demo Banner</h2>
<p>
It is a long established fact that a reader will be
distracted by the readable content of page when
looking at its layout.
</p>
<br/>
<a class="info" href="#">Read More</a>

</div>
</div>
<div class="banner banner-transform"><img alt="" src="[template_url]/images/Custom-banner1.jpg">
<div class="mask">
<h2>Nice Demo Banner</h2>
<p>
It is a long established fact that a reader will be
distracted by the readable content of page when
looking at its layout.
</p>
<br/>
<a class="info" href="#">Read More</a>

</div>
</div>
            ',
            'type'        => 'textarea',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'related_products',
            'label'       => 'Show related products',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'single_product',
            'class'       => '',
            'choices'     => array(
                array(
                    'value'   => 1,
                    'label'   => ''
                )
            )
        ),
        array(
            'id'          => 'size_guide_img',
            'label'       => 'Size Guide img',
            'default'     => 'wp-content/themes/idstore/images/assets/size-guide.jpg',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'size_guide_img_mobile',
            'label'       => 'Size Guide img (mobile)',
            'default'     => 'wp-content/themes/idstore/images/assets/size-guide-mobile.jpg',
            'desc'        => 'Upload image: png, jpg or gif file',
            'type'        => 'upload',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'custom_tab_title',
            'label'       => 'Custom Tab Title',
            'default'     => 'Custom Tab For All Products',
            'type'        => 'text',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'custom_tab',
            'label'       => 'Custom Tab',
            'desc'        => 'Enter custom content you would like to output to the product custom tab (for all products)',
            'default'     => '
<div class="global-custom-tab">
<img class="img-left" src="[template_url]/images/assets/customtab.png" alt="" />
<h3>Custom TEXT/HTML</h3>Ultricies sociis ut vel parturient! Tempor! Nec quis turpis placerat ac hac tincidunt, velit, vel sit mauris a, dolor, natoque enim! Etiam risus? Elit, adipiscing dignissim ut et risus sit placerat, penatibus tincidunt, diam sed dignissim rhoncus mus lectus, penatibus arcu sit in mattis porta placerat. Ultricies velit odio. Vel? Aliquam nunc dolor! Nisi, cras, nunc, et auctor? Augue facilisis! Augue eu dis platea sed, placerat hac pid, lectus dapibus turpis in tincidunt arcu rhoncus auctor. Sit duis nascetur vut! Pulvinar egestas, aenean, sagittis odio enim magna, etiam platea nec lundium, nisi, mauris porttitor elementum a, tempor turpis. Aliquam nunc dolor! Nisi, cras, nunc, et auctor? Augue facilisis! Augue eu dis platea sed, placerat hac pid, lectus dapibus turpis in tincidunt arcu rhoncus auctor. Sit duis nascetur vut! Pulvinar egestas, aenean, sagittis odio enim magna, etiam platea nec lundium, nisi, mauris porttitor elementum a, tempor turpis. Aliquam nunc dolor! Nisi, cras, nunc, et auctor? Augue facilisis! Augue eu dis platea sed, placerat hac pid, lectus dapibus turpis in tincidunt arcu rhoncus auctor. Sit duis nascetur vut! Pulvinar egestas, aenean, sagittis odio enim magna, etiam platea nec lundium, nisi, mauris porttitor elementum a, tempor turpis.
</div>
            ',
            'type'        => 'textarea',
            'section'     => 'single_product'
        ),
        array(
            'id'          => 'import_export',
            'label'       => 'Import or Export your theme configuration',
            'default'     => '',
            'desc'        => '',
            'type'        => 'backup',
            'section'     => 'backup'
        ),
        // Responsive
        array(
            'id'          => 'responsive',
            'label'       => 'Enable Responsive Design',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'responsive',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'responsive_from',
            'label'       => 'Large resolution from',
            'desc'        => 'By default: 1600',
            'default'     => 1600,
            'type'        => 'text',
            'section'     => 'responsive',
        ),
        array(
            'id'          => 'loader',
            'label'       => 'Show loader icon until site loading on mobile devices',
            'default'     => array(
            	0 => 1
            ),
            'type'        => 'checkbox',
            'section'     => 'responsive',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        array(
            'id'          => 'banner_mask',
            'label'       => 'Show banner mask on mobile device',
            'default'     => 'enable',
            'type'        => 'select',
            'section'     => 'responsive',
            'choices'     => array(
              array( 
                'value' => 'enable',
                'label' => 'Enable' 
              ),
              array( 
                'value' => 'disable',
                'label' => 'Disable' 
              ),
            )
        ),
        // Custom CSS
        array(
            'id'          => 'custom_css',
            'label'       => 'Enable Custom CSS file',
            'desc'        => 'Enable this option to load "custom.css" file in which you can override the default styling of the theme. To create "custom.css" you can use the file "default.custom.css" which is located in theme directory.',
            'default'     => 0,
            'type'        => 'checkbox',
            'section'     => 'custom_css',
            'choices'     => array(
              array( 
                'value' => 1,
                'label' => '' 
              )
            )
        ),
        
        
        
   );

  $custom_settings = array(
    'contextual_help' => array(
      'content'       => array( 
        array(
          'id'        => 'general_help',
          'title'     => 'General',
          'content'   => ''
        )
      ),
      'sidebar'       => '',
    ),
    'sections'        => $sections,
    'settings'        => $settings
  );
  
  if(is_array($settings)){
	  foreach($settings as $key => $value){	
		  $defaults[$value['id']] = $value['default'];
	  }
  }
  
  add_option( 'option_tree', $defaults ); // update_option  add_option
	
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
} 

/**
 * Initialize the meta boxes for pages. 
 */
add_action( 'admin_init', 'page_meta_boxes' );


function page_meta_boxes() {
	$page_options = array(
		array(
			'id'          => 'sidebar_state',
			'label'       => 'Sidebar Position',
			'type'        => 'select',
			'choices'     => array(
	              array( 
	                'value' => '',
	                'label' => 'Default' 
	              ),
	              array( 
	                'value' => 'no_sidebar',
	                'label' => 'Without Sidebar' 
	              ),
	              array( 
	                'value' => 'left',
	                'label' => 'Left Sidebar' 
	              ),
	              array( 
	                'value' => 'right',
	                'label' => 'Right Sidebar' 
	              )
	            )
		),
		array(
			'id'          => 'widget_area',
			'label'       => 'Widget Area',
			'type'        => 'sidebar_select'
		)
	);

  $my_meta_box = array(
    'id'        => 'page_layout',
    'title'     => 'Page Layout',
    'desc'      => '',
    'pages'     => array( 'page', 'post' ),
    'context'   => 'side',//side normal
    'priority'  => 'low',
    'fields'    => $page_options
  );
  
  ot_register_meta_box( $my_meta_box );	

}

?>