<?php
/**
 * Load option tree plugin
 */

add_filter('ot_show_pages', '__return_false');
add_filter('ot_show_new_layout', '__return_false');
add_filter('ot_theme_mode', '__return_true');
load_template(trailingslashit(get_template_directory()) . 'option-tree/ot-loader.php');


global $etheme_responsive;

add_theme_support('woocommerce');

register_nav_menu('top', 'Top Navigation');

$just_catalog = etheme_get_option('just_catalog');
$etheme_responsive = etheme_get_option('responsive');

$etheme_color_version = etheme_get_option('main_color_scheme');

if (isset($_COOKIE['responsive'])) {
    $etheme_responsive = false;
}

function remove_loop_button()
{
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
    remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
    remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
    remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
}

if ($just_catalog) {
    add_action('init', 'remove_loop_button');
}

if (!isset($content_width)) $content_width = 920;

function etheme_enqueue_styles()
{
    global $etheme_responsive, $etheme_color_version;

    $custom_css = etheme_get_option('custom_css');
    if (!is_admin()) {  //NOT AN ADMIN SCREEN this isn't talking about the USER
        wp_enqueue_style("bootstrap", get_template_directory_uri() . '/css/bootstrap.css');
        wp_enqueue_style("style", get_stylesheet_directory_uri() . '/style.css');
        wp_enqueue_style("eatfitstyle", get_template_directory_uri() . '/css/eatfit_custom.css?version=2.2');
        if ($etheme_responsive) {
            wp_enqueue_style("bootstrap-responsive", get_template_directory_uri() . '/css/bootstrap-responsive.css');
            wp_enqueue_style("responsive", get_template_directory_uri() . '/css/responsive.css');
        }
        wp_enqueue_style("slider", get_template_directory_uri() . '/css/slider.css');
        wp_enqueue_style("font-awesome", get_template_directory_uri() . '/css/font-awesome.min.css');
        wp_enqueue_style("cbpQTRotator", get_template_directory_uri() . '/code/testimonials/assets/css/component.css');
        if ($custom_css) {
            wp_enqueue_style("custom", get_template_directory_uri() . '/custom.css');
        }
        if ($etheme_color_version == 'dark') {
            wp_enqueue_style("dark", get_template_directory_uri() . '/css/dark.css');
        }

        wp_enqueue_style("open-sans", "//fonts.googleapis.com/css?family=Open+Sans");
        wp_enqueue_style("lato", "//fonts.googleapis.com/css?family=Lato:100,400");

        $script_depends = array();

        if (class_exists('WooCommerce')) {
            $script_depends = array('wc-add-to-cart-variation');
        }

        wp_enqueue_script('jquery.easing', get_template_directory_uri() . '/js/jquery.easing.1.3.min.js', array(), false, true);
        wp_enqueue_script('cookie', get_template_directory_uri() . '/js/cookie.js', array());
        if (is_front_page() OR is_admin()) {
            wp_enqueue_script('jquery.nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array(), false, true);
        }
        wp_enqueue_script('hoverIntent', get_template_directory_uri() . '/js/hoverIntent.js', array(), false, true);
        //wp_enqueue_script('jquery.slider', get_template_directory_uri().'/js/jquery.slider.js',array(),false,true);
        wp_enqueue_script('modernizr.custom', get_template_directory_uri() . '/js/modernizr.custom.js');
        wp_enqueue_script('cbpQTRotator', get_template_directory_uri() . '/js/jquery.cbpQTRotator.min.js', array(), false, true);
        wp_enqueue_script('jquery.inview', get_template_directory_uri() . '/js/jquery.inview.js', array(), false, true);
        wp_enqueue_script('modals', get_template_directory_uri() . '/js/modals.js', array(), false, true);
        wp_enqueue_script('tooltip', get_template_directory_uri() . '/js/tooltip.js');
        wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js');
        wp_enqueue_script('et_masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array(), false, true);
        wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), false, true);
        wp_enqueue_script('etheme', get_template_directory_uri() . '/js/script.js', $script_depends);
        // jeff add localization for empty product
        wp_register_script('eatfit_custom', get_template_directory_uri() . '/js/eatfit_custom.js?version=2.1', array(), false, true);
        $eatfit_custom_data = array(
            'empty_product_id' => get_page_by_title('None', OBJECT, 'product')->ID,
            'ajaxurl' => admin_url('admin-ajax.php')
        );
        wp_localize_script('eatfit_custom', 'eatfit_custom_params', $eatfit_custom_data);
        wp_enqueue_script('eatfit_custom');
//		wp_enqueue_script('eatfit_custom', get_template_directory_uri().'/js/eatfit_custom.js',array(),false,true);
        wp_enqueue_script('eatfit-wc-varjax', get_template_directory_uri() . '/js/ajax_add_to_cart_script.js?version=2.0', array(), false, true);
        if (is_page('checkout')) {
            wp_enqueue_script('eatfit_wc_wootax_policy', get_template_directory_uri() . '/js/sales_tax_policy_script.js?version=2.0', array('jquery-ui-dialog'), false, true);
        }
    }

    wp_dequeue_style('woocommerce_prettyPhoto_css');
    wp_enqueue_style('woocommerce_prettyPhoto_css', get_template_directory_uri() . '/css/prettyPhoto.css');

}

/** Remove white space around shrtcodes */

//remove_filter( 'the_content', 'wpautop' );
//add_filter( 'the_content', 'wpautop' , 12);

add_action('wp_enqueue_scripts', 'etheme_enqueue_styles');
function jsString($str = '')
{
    return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
}

function etheme_get_the_category_list($separator = '', $parents = '', $post_id = false)
{
    global $wp_rewrite;
    $categories = get_the_category($post_id);
    if (!is_object_in_taxonomy(get_post_type($post_id), 'category'))
        return apply_filters('the_category', '', $separator, $parents);

    if (empty($categories))
        return apply_filters('the_category', __('Uncategorized'), $separator, $parents);

    $rel = "";

    $thelist = '';
    if ('' == $separator) {
        $thelist .= '<ul class="post-categories">';
        foreach ($categories as $category) {
            $thelist .= "\n\t<li>";
            switch (strtolower($parents)) {
                case 'multiple':
                    if ($category->parent)
                        $thelist .= get_category_parents($category->parent, true, $separator);
                    $thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '" ' . $rel . '>' . $category->name . '</a></li>';
                    break;
                case 'single':
                    $thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '" ' . $rel . '>';
                    if ($category->parent)
                        $thelist .= get_category_parents($category->parent, false, $separator);
                    $thelist .= $category->name . '</a></li>';
                    break;
                case '':
                default:
                    $thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '" ' . $rel . '>' . $category->name . '</a></li>';
            }
        }
        $thelist .= '</ul>';
    } else {
        $i = 0;
        foreach ($categories as $category) {
            if (0 < $i)
                $thelist .= $separator;
            switch (strtolower($parents)) {
                case 'multiple':
                    if ($category->parent)
                        $thelist .= get_category_parents($category->parent, true, $separator);
                    $thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '" ' . $rel . '>' . $category->name . '</a>';
                    break;
                case 'single':
                    $thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '" ' . $rel . '>';
                    if ($category->parent)
                        $thelist .= get_category_parents($category->parent, false, $separator);
                    $thelist .= "$category->name</a>";
                    break;
                case '':
                default:
                    $thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '" ' . $rel . '>' . $category->name . '</a>';
            }
            ++$i;
        }
    }
    return apply_filters('the_category', $thelist, $separator, $parents);
}

function etheme_get_contents($url)
{
    if (function_exists('curl_init')) {
        $output = file_get_contents($url); //$output = file_get_contents_curl( $url );
    } elseif (function_exists('file_get_contents')) {
        $output = file_get_contents($url);
    } else {
        return false;
    }
    return $output;
}

function etheme_demo_alerts()
{
    do_action('etheme_demo_alerts');
}

function get_header_type()
{
    return etheme_get_option('header_type');
}

add_filter('custom_header_filter', 'get_header_type', 10);

//add_filter('add_to_cart_fragments', 'get_pickup_time_selector',9,1);

function get_pickup_time_selector($fragments)
{
    $fragments ['#local_pickup_time_select'] = pickup_time_list_fragment();
    return $fragments;
}


function pickup_time_list_fragment()
{
    $hourOptions = create_hour_options_for_pickup_times();
    //so now we have an array of arrays - first array is the one we care about
    if ($hourOptions . count() > 0) {
        $theOptions = '';
        $theTimes = $hourOptions[0];
        foreach ($theTimes as $key => $value) {
            $theOptions = $theOptions . '<option value="' . $key . '">".$value."</option>"';
        }
        $theReturn = "<select name='local_pickup_time_select' id='local_pickup_time_select' class='select'>";

        return $theReturn . theOptions;
    }
}


/**
 * Create an array of times starting with an hour past the current time
 * returns array($availableOptions[],$closedDateStrings[])
 * @since    1.0.0
 * copied from \plugins\woocommerce-local-pickup-time\public\class-local-pickup-time.php and improved upon.
 */
function create_hour_options_for_pickup_times()
{

    // Make sure we have a time zone set
    $offset = get_option('gmt_offset');
    $timezone_setting = get_option('timezone_string');
    $optionPrefix = "";

    if ($timezone_setting) {
        date_default_timezone_set(get_option('timezone_string', 'America/New_York'));
    } else {
        $timezone = timezone_name_from_abbr(null, $offset * 3600, true);
        if ($timezone === false) $timezone = timezone_name_from_abbr(null, $offset * 3600, false);
        date_default_timezone_set($timezone);
    }


    global $woocommerce;
    $daysNotice = 2;
    $timeDueInSeconds = 61200;  //61200 = 5PM
    $specialCoupons = [
        "licor" => "monday",
        "nelnet" => "monday",
    ];


    foreach ($specialCoupons as $key => $value) {
        if ($woocommerce->cart->has_discount($key)) {
            $nextDate = strtotime('next ' . $value);
            $weekNo = date('W');
            $weekNoNextDate = date('W', $nextDate);
            $dif = $nextDate - time();

            $dueDate = $nextDate + $timeDueInSeconds;//this is in seconds yet

            if (strtotime("-" . $daysNotice . " day", $dueDate) < time()) {
                //its not in time - so they have a week plus some days...
                $nextDate = strtotime("7 day", $nextDate);
            }

            $pickup_options[] = array(strtoupper($key) . ' ' . date('m-d-Y', $nextDate) => "Delivery for " . strtoupper($key) . " on " . ucwords($value) . " - " . date('m-d-Y', $nextDate));
            return $pickup_options;
        }
    }

    
    $isCustomMeal = false;

    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
        if ($values['composite_children']) {
            $isCustomMeal = true;
        }
    }

    $closing_days_raw = trim(get_option('local_pickup_hours_closings'));
    $closing_days = explode("\n		$nextDate+$timeDueInSeconds	1423177200	Integer", $closing_days_raw);
    $closing_days = array_filter($closing_days, 'trim');

    // Get delay, interval, and number of days ahead settings
    $delay_minutes = get_option('local_pickup_delay_minutes', 60);
    $interval = get_option('local_pickup_hours_interval', 30);
    $delay_days = get_option('local_pickup_delay_days', 0);
    $num_days_allowed = get_option('local_pickup_days_ahead', 1);
    //todo another option - let the customer choose asap, like jimmyjohns.
    $asap_text = get_option('local_pickup_asap', false);
    if (trim($asap_text) == '')
        $asap_text = false;

    //sanity check
    $delay_days = $delay_days >= $num_days_allowed ? 0 : $delay_days;
    //i can foresee a request to support "business days" instead of just $delay_minutes = $delay_days*24*60+$delay_minutes;
    //If you're changing this make sure you finish implementing the rest of the business day logic kthx :)
    $delay_days_business_days = false;
    $delay_minutes = 1440;
    $custom_delay_minutes = 0;
    if($isCustomMeal ){
        //$delay_days = 2;
        $optionPrefix = "Custom Meal--";
        $asap_text = false;
        $custom_delay_minutes =2880;
    }

    // Create an empty array for our dates
    $pickup_options = array();
    if ($asap_text != false)
        $pickup_options[] = array($asap_text => $asap_text);
    $current_time = time();


    // Loop through all days ahead and add the pickup time options to the array
    //delay_days defaults to 0
    for ($i = 1.0 * $delay_days; $i <= 1.0 * $num_days_allowed; $i++) {

        //first get the current date - throw it into a human readable string			
        //$current_date_string = date('m-d-Y', strtotime("+$i days", $current_time));
        $current_date_string = date('m-d-Y', strtotime("+" . $custom_delay_minutes + ($i * $delay_minutes)." minutes", $current_time));
        //$current_date_convertable_string = date('Y-m-d', strtotime("+$i days", $current_time));
        $current_date_convertable_string = date('Y-m-d', strtotime("+" . $custom_delay_minutes + ($i * $delay_minutes)." minutes", $current_time));
        // now we get the full name of the current day
        //$current_day_name = date('l', strtotime("+$i days", $current_time));
        $current_day_name = date('l', strtotime("+" . $custom_delay_minutes + ($i * $delay_minutes)." minutes", $current_time));
        // now we convert it to lowercase so we can use it to get the option data from the theme
        $current_day_name_lower = strtolower($current_day_name);


        // Get the day's opening and closing times
        // first the string for the open time.
        $open_time = get_option('local_pickup_hours_' . $current_day_name_lower . '_start', '10:00');
        //then the string for the close time
        $close_time = get_option('local_pickup_hours_' . $current_day_name_lower . '_end', '19:00');
        // now we cast the open time into a time variable.
        $tStart = strtotime($open_time);
        // now we cast the close time into a time variable.
        $tEnd = strtotime($current_date_convertable_string . ' ' . $close_time);

        //check to see if we're closed due to being a holiday or just after close for the day.  If it's before open - they may still be able to pick up first thing.
        if (in_array($current_date_string, $closing_days) || ($i == 0 && $current_time >= $tEnd) || ($open_time == $close_time && ($open_time == 0 || $open_time == ''))) {
            // Set drop down text to let user know store is closed
            if ($i == 0) {
                $reason = 'We\'re already closed for today';
            } else if ($open_time == $close_time && ($open_time == 0 || $open_time == '')) {
                $reason = 'Sorry we don\'t offer pick-up on ' . $current_date_string;
            } else {
                $reason = 'Sorry, we\'re closed on ' . $current_date_string;
            }
            $pickup_options[] = array('' => __($reason, 'PickupTimePlugin_Custom'));
            continue;
        }

        //if $i isn't today, then we won't care about the next available opening time, just set it to opening time.
        /*		if ($current_date_string == date( 'm-d-Y', time()))
			{
			$start_time = $open_time;
			}*/

        // Setup start and end times for pickup options
        if ($delay_days_business_days && $delay_days > 0) {
            //todo fancy rounding logic...not sure how this should be implemented. Do we do $tNow + $nextClosestStartTime + $delay_days?
            //I think we need one more option for this to be fleshed out - orders received after hours are treated as received at the open of next business day? Maybe have a customizable time per day?,
            //orders received during open hours are treated as if they were recieved at end of day? Or beginning of day? I think for this to work we'll need a better interface for setting up order hours.
            //especially in places where orders are processed at night..they'd probably want to accept orders for the next business day up to midnight, even though the storefront closes at 6pm.
            throw new Exception('Business Day Delays aren\'t implemented yet! How did you get here?');
            $start_time = $open_time;
        } else {
            //not business days
            // go set the start time to be a minimum delay from now OR the open time, whichever comes later
            if ($i == 0) {
                $now_plus_delay_seconds = time() + $delay_minutes * 60;   ////TODO - this might be why we see 3am
                $pickup_time_begin_seconds = ceil($now_plus_delay_seconds / ($interval * 60)) * ($interval * 60) + ($interval * 60);
                //start_time is either the opening time or the next available pickup time
                $start_time = ($pickup_time_begin_seconds < strtotime($open_time)) ? $open_time : date('g:i a', $pickup_time_begin_seconds);
            } else {
                // set start_time to opentime
                $start_time = $open_time;
            }
        }
        //if ($start_time<time() )
        //{
        //	$start_time=time();
        //}
        // get the start time string into a time variable to increment.
        $tNow = strtotime($current_date_convertable_string . ' ' . $start_time);
        // Create array of time options to return to woocommerce_form_field
        while ($tNow <= $tEnd) {
            $day_name = ($i == '0' && !$isCustomMeal) ? 'Today' : $current_day_name;
            //get the (American) human readable date
            $date_time = $current_date_convertable_string . ' ' . date("h:i a T", $tNow);
            //get the date that will cast gracefully into a dateTime value in MS SQL server and most other DBs
            $option_key = date('Y-m-d h:i a T', strtotime($date_time));
            //get the date with the name out front for the peeps to read
            $option_value = $optionPrefix . $day_name . '  ' . date('F d, Y \a\t g:i a', strtotime($date_time));
            $pickup_options[] = array($option_key => $option_value);
            $tNow = strtotime("+$interval minutes", $tNow);
        }

    } // end for loop

    //if they're closed for all of the options, disable
    $flattened_pickup_options = array();
    $allClosed = true;
    $closedDays = array();
    foreach ($pickup_options as $opt) {
        list($key, $val) = each($opt);
        if ($key != '') {
            $allClosed = false;
            $flattened_pickup_options[$key] = $val;
        } else {
            $closedDays[] = $val;
        }
    }
    if ($allClosed) {
        $flattened_pickup_options[''] = "No available pickup times";
        // Hide Order Review so user doesn't order anything today
        remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
    }
    return array($flattened_pickup_options, $closedDays);
}
//login redirect for timeclock/customers....
add_filter('woocommerce_login_redirect', 'custom_login_redirect', 10, 2);
function custom_login_redirect($redirect_to, $user)
{
    if ($user->exists()) {
        if (!empty($user->roles) && is_array($user->roles))
            $role = $user->roles[0];
        if (in_array($role, array('administrator', 'manager', 'shop_manager', 'employee'), false)) {
            $redirect_to = get_site_url() . '/time-clock';
        } else {
            //$redirect_to=get_site_url()."/shop";
            ////allow the default through???
        }
    }
    return $redirect_to;
}

/* Header Template Parts */

function etheme_header_menu()
{

    $menuClass = 'menu ' . etheme_get_option('menu_type') . '-menu';
    if (!etheme_get_option('menu_type')) {
        $menuClass = 'menu default-menu';
    }
    ?>
    <div class="row">
        <div id="main-nav" class="span12">
            <?php wp_nav_menu(array('theme_location' => 'top', 'name' => 'top', 'container' => 'div', 'container_class' => $menuClass, 'menu_id' => 'top')); ?>
        </div>
    </div>
    <?php
}

function etheme_header_wp_navigation()
{
    wp_nav_menu(array('theme_location' => 'top', 'name' => 'top', 'container' => 'div', 'container_class' => 'menu default-menu', 'menu_id' => 'top'));
}

function etheme_logo()
{
    $logoimg = etheme_get_option('logo'); ?>
    <?php if ($logoimg): ?>
    <a href="<?php echo home_url(); ?>"><img src="<?php echo $logoimg ?>" alt="<?php bloginfo('description'); ?>"/></a>
<?php else: ?>
    <a href="<?php echo home_url(); ?>"><span class="logo-text-red">ID</span>Store</a>
<?php endif;
}


add_action('after_setup_theme', 'et_promo_remove', 11);
if (!function_exists('et_promo_remove')) {
    function et_promo_remove()
    {
        //update_option('et_close_promo_etag', 'ETag: "bca6c0-b9-500bba1239ca80"');
    }
}


if (!function_exists('et_show_promo_text')) {
    function et_show_promo_text()
    {
        $versionsUrl = '//8theme.com/import/';
        $ver = 'promo';
        $folder = $versionsUrl . '' . $ver;

        $txtFile = $folder . '/idstore.txt';
        $file_headers = @get_headers($txtFile);

        $etag = $file_headers[4];

        $cached = false;
        $promo_text = false;

        $storedEtag = get_option('et_last_promo_etag');
        $closedEtag = get_option('et_close_promo_etag');

        if ($etag == $storedEtag && $closedEtag != $etag) {
            $storedEtag = get_option('et_last_promo_etag');
            $promo_text = get_option('et_promo_text');
        } else if ($closedEtag == $etag) {
            return;
        } else {
            $fileContent = file_get_contents($txtFile);
            update_option('et_last_promo_etag', $etag);
            update_option('et_promo_text', $fileContent);
        }

        if ($file_headers[0] == 'HTTP/1.1 200 OK') {
            echo '<div class="promo-text-wrapper">';
            if (!$promo_text && isset($fileContent)) {
                echo $fileContent;
            } else {
                echo $promo_text;
            }
            echo '<div class="close-btn" title="Hide promo text">x</div>';
            echo '</div>';
        }
    }
}

add_action("wp_ajax_et_close_promo", "et_close_promo");
add_action("wp_ajax_nopriv_et_close_promo", "et_close_promo");
if (!function_exists('et_close_promo')) {
    function et_close_promo()
    {
        $versionsUrl = '//8theme.com/import/';
        $ver = 'promo';
        $folder = $versionsUrl . '' . $ver;

        $txtFile = $folder . '/idstore.txt';
        $file_headers = @get_headers($txtFile);

        $etag = $file_headers[4];
        $res = update_option('et_close_promo_etag', $etag);
        die();
    }
}

/**
 * Function for disabling Responsive layout
 *
 */

function etheme_set_responsive()
{
    if (isset($_GET['responsive']) && $_GET['responsive'] == 'off') {
        if (!isset($_COOKIE['responsive'])) {
            setcookie('responsive', 1, time() + 1209600, COOKIEPATH, COOKIE_DOMAIN, false);
        }
        $redirect_to = $_SERVER['HTTP_REFERER'];
        wp_redirect($redirect_to);
        exit();
    } elseif (isset($_GET['responsive']) && $_GET['responsive'] == 'on') {
        if (isset($_COOKIE['responsive'])) {
            setcookie('responsive', 1, time() - 1209600, COOKIEPATH, COOKIE_DOMAIN, false);
        }
        $redirect_to = $_SERVER['HTTP_REFERER'];
        wp_redirect($redirect_to);
        exit();
    }
}

if (etheme_get_option('responsive'))
    add_action('init', 'etheme_set_responsive');


function etheme_page_menu_args($args)
{
    $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'etheme_page_menu_args');

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @return int
 */
function etheme_excerpt_length($length)
{
    return 40;
}

add_filter('excerpt_length', 'etheme_excerpt_length');

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @return string "Continue Reading" link
 */
function etheme_continue_reading_link()
{
    return ' <a href="' . get_permalink() . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', ETHEME_DOMAIN) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and etheme_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @return string An ellipsis
 */
function etheme_auto_excerpt_more($more)
{
    return ' &hellip;' . etheme_continue_reading_link();
}

add_filter('excerpt_more', 'etheme_auto_excerpt_more');

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function etheme_custom_excerpt_more($output)
{
    if (has_excerpt() && !is_attachment()) {
        $output .= etheme_continue_reading_link();
    }
    return $output;
}

add_filter('get_the_excerpt', 'etheme_custom_excerpt_more');

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 */
add_filter('use_default_gallery_style', '__return_false');

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function etheme_remove_gallery_css($css)
{
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}

// Backwards compatibility with WordPress 3.0.
if (version_compare($GLOBALS['wp_version'], '3.1', '<'))
    add_filter('gallery_style', 'etheme_remove_gallery_css');

if (!function_exists('etheme_comment')) :
    function etheme_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case '' :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>">
                    <?php echo get_avatar($comment, 55); ?>
                    <div class="comment-meta">
                        <h5 class="author"><?php echo get_comment_author_link() ?>
                            / <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></h5>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', ETHEME_DOMAIN); ?></em>
                        <?php endif; ?>
                        <p class="date">
                            <?php
                            /* translators: 1: date, 2: time */
                            printf(__('%1$s at %2$s', ETHEME_DOMAIN), get_comment_date(), get_comment_time()); ?></a><?php edit_comment_link(__('(Edit)', ETHEME_DOMAIN), ' ');
                            ?>
                        </p>
                    </div>
                    <div class="comment-body"><?php comment_text(); ?></div>
                    <div class="clear"></div>
                    <!-- .reply -->
                </div><!-- #comment-##  -->

                <?php
                break;
            case 'pingback'  :
            case 'trackback' :
                ?>
                <li class="post pingback">
                <p><?php _e('Pingback:', ETHEME_DOMAIN); ?><?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', ETHEME_DOMAIN), ' '); ?></p>
                <?php
                break;
        endswitch;
    }
endif;

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 */
function etheme_remove_recent_comments_style()
{
    add_filter('show_recent_comments_widget_style', '__return_false');
}

add_action('widgets_init', 'etheme_remove_recent_comments_style');

if (!function_exists('etheme_posted_on')) :
    function etheme_posted_on()
    {
        printf(__('<span class="%1$s"></span> %2$s', ETHEME_DOMAIN),
            'meta-prep meta-prep-author',
            sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                get_permalink(),
                esc_attr(get_the_time()),
                get_the_date()
            )
        );
    }
endif;
if (!function_exists('etheme_posted_by')) :
    function etheme_posted_by()
    {
        printf(__('<span class="%1$s">Posted by</span> %2$s', ETHEME_DOMAIN),
            'meta-author',
            sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                get_author_posts_url(get_the_author_meta('ID')),
                esc_attr(sprintf(__('View all posts by %s', ETHEME_DOMAIN), get_the_author())),
                get_the_author()
            )
        );
    }
endif;

if (!function_exists('etheme_posted_in')) :
    /**
     * Prints HTML with meta information for the current post (category, tags and permalink).
     *
     * @since Twenty Ten 1.0
     */
    function etheme_posted_in()
    {
        // Retrieves tag list of current post, separated by commas.
        $tag_list = get_the_tag_list('', ', ');
        if ($tag_list) {
            $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ETHEME_DOMAIN);
        } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
            $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ETHEME_DOMAIN);
        } else {
            $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ETHEME_DOMAIN);
        }
        // Prints the string, replacing the placeholders.
        printf(
            $posted_in,
            etheme_get_the_category_list(', '),
            $tag_list,
            get_permalink(),
            the_title_attribute('echo=0')
        );
    }
endif;

function etheme_excerpt_more($more)
{
    global $post;
    return '<br><a class="button fl-r" style="margin-bottom:10px;" href="' . get_permalink($post->ID) . '"><span>' . __('Read More', ETHEME_DOMAIN) . '</span></a><div class="clear"></div>';
}

add_filter('excerpt_more', 'etheme_excerpt_more');

function etheme_get_image($attachment_id = 0, $width = null, $height = null, $crop = true, $post_id = null)
{
    global $post;
    if (!$attachment_id) {
        if (!$post_id) {
            $post_id = $post->ID;
        }
        if (has_post_thumbnail($post_id)) {
            $attachment_id = get_post_thumbnail_id($post_id);
        } else {
            $attached_images = (array)get_posts(array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'post_status' => null,
                'post_parent' => $post_id,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            if (!empty($attached_images))
                $attachment_id = $attached_images[0]->ID;
        }
    }

    if (!$attachment_id)
        return;

    $image_url = etheme_get_resized_url($attachment_id, $width, $height, $crop);

    return apply_filters('blanco_product_image', $image_url);
}


// **********************************************************************//
// ! Registration
// **********************************************************************//
add_action('wp_ajax_et_register_action', 'et_register_action');
add_action('wp_ajax_nopriv_et_register_action', 'et_register_action');
if (!function_exists('et_register_action')) {
    function et_register_action()
    {
        global $wpdb, $user_ID;
        $captcha_instance = new ReallySimpleCaptcha();
        if (!$captcha_instance->check($_REQUEST['captcha-prefix'], $_REQUEST['captcha-word'])) {
            $return['status'] = 'error';
            $return['msg'] = __('The security code you entered did not match. Please try again.', ETHEME_DOMAIN);
            echo json_encode($return);
            die();
        }
        if (!empty($_REQUEST)) {
            //We shall SQL escape all inputs
            $username = esc_sql($_REQUEST['username']);
            if (empty($username)) {
                $return['status'] = 'error';
                $return['msg'] = __("User name should not be empty.", ETHEME_DOMAIN);
                echo json_encode($return);
                die();
            }
            $email = esc_sql($_REQUEST['email']);
            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
                $return['status'] = 'error';
                $return['msg'] = __("Please enter a valid email.", ETHEME_DOMAIN);
                echo json_encode($return);
                die();
            }
            $pass = esc_sql($_REQUEST['pass']);
            $pass2 = esc_sql($_REQUEST['pass2']);
            if (empty($pass) || strlen($pass) < 5) {
                $return['status'] = 'error';
                $return['msg'] = __("Password should have more than 5 symbols", ETHEME_DOMAIN);
                echo json_encode($return);
                die();
            }
            if ($pass != $pass2) {
                $return['status'] = 'error';
                $return['msg'] = __("The passwords do not match", ETHEME_DOMAIN);
                echo json_encode($return);
                die();
            }

            $status = wp_create_user($username, $pass, $email);
            if (is_wp_error($status)) {
                $return['status'] = 'error';
                $return['msg'] = __("Username already exists. Please try another one.", ETHEME_DOMAIN);
                echo json_encode($return);
            } else {
                $from = get_bloginfo('name');
                $from_email = get_bloginfo('admin_email');
                $headers = 'From: ' . $from . " <" . $from_email . ">\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $subject = __("Registration successful", ETHEME_DOMAIN);
                $message = et_registration_email($username);
                wp_mail($email, $subject, $message, $headers);
                $return['status'] = 'success';
                $return['msg'] = __("Please check your email for login details.", ETHEME_DOMAIN);
                echo json_encode($return);
            }
            die();
        }
    }
}

if (!function_exists('et_registration_email')) {
    function et_registration_email($username = '')
    {
        global $woocommerce;
        $logoimg = etheme_get_option('logo');
        $logoimg = apply_filters('etheme_logo_src', $logoimg);
        ob_start(); ?>
        <div
            style="background-color: #f5f5f5;width: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 70px 0 70px 0;">
            <div
                style="-webkit-box-shadow: 0 0 0 3px rgba(0,0,0,0.025) ;box-shadow: 0 0 0 3px rgba(0,0,0,0.025);-webkit-border-radius: 6px;border-radius: 6px ;background-color: #fdfdfd;border: 1px solid #dcdcdc; padding:20px; margin:0 auto; width:500px; max-width:100%; color: #737373; font-family:Arial; font-size:14px; line-height:150%; text-align:left;">
                <?php if ($logoimg): ?>
                    <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img
                            style="max-width:100%;" src="<?php echo $logoimg ?>"
                            alt="<?php bloginfo('description'); ?>"/></a>
                <?php else: ?>
                    <a href="<?php echo home_url(); ?>" style="display:block; text-align:center;"><img
                            style="max-width:100%;" src="<?php echo PARENT_URL . '/images/logo.png'; ?>"
                            alt="<?php bloginfo('name'); ?>"></a>
                <?php endif; ?>
                <p><?php printf(__('Thanks for creating an account on %s. Your username is %s.', ETHEME_DOMAIN), get_bloginfo('name'), $username); ?></p>
                <?php if (class_exists('Woocommerce')): ?>

                    <p><?php printf(__('You can access your account area to view your orders and change your password here: <a href="%s">%s</a>.', ETHEME_DOMAIN), get_permalink(get_option('woocommerce_myaccount_page_id')), get_permalink(get_option('woocommerce_myaccount_page_id'))); ?></p>

                <?php endif; ?>

            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}


function etheme_get_images($width = null, $height = null, $crop = true, $post_id = null)
{
    global $post;

    if (!$post_id) {
        $post_id = $post->ID;
    }

    if (has_post_thumbnail($post_id)) {
        $attachment_id = get_post_thumbnail_id($post_id);
    }

    $args = array(
        'post_type' => 'attachment',
        'post_status' => null,
        'post_parent' => $post_id,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'exclude' => get_post_thumbnail_id($post_id)
    );

    $attachments = get_posts($args);

    if (empty($attachments) && empty($attachment_id))
        return;

    $image_urls = array();

    $image_urls[] = etheme_get_resized_url($attachment_id, $width, $height, $crop);

    foreach ($attachments as $one) {
        $image_urls[] = etheme_get_resized_url($one->ID, $width, $height, $crop);
    }

    return apply_filters('blanco_attachment_image', $image_urls);
}

function etheme_get_resized_url($id, $width, $height, $crop)
{
    if (function_exists("gd_info") && (($width >= 10) && ($height >= 10)) && (($width <= 1024) && ($height <= 1024))) {
        $vt_image = vt_resize($id, '', $width, $height, $crop);
        if ($vt_image)
            $image_url = $vt_image['url'];
        else
            $image_url = false;
    } else {
        $full_image = wp_get_attachment_image_src($id, 'full');
        if (!empty($full_image[0]))
            $image_url = $full_image[0];
        else
            $image_url = false;
    }

    if (is_ssl() && !strstr($image_url, 'https')) str_replace('http', 'https', $image_url);

    return $image_url;
}

if (!function_exists('vt_resize')) {
    function vt_resize($attach_id = null, $img_url = null, $width, $height, $crop = false)
    {

        // this is an attachment, so we have the ID
        if ($attach_id) {

            $image_src = wp_get_attachment_image_src($attach_id, 'full');
            $file_path = get_attached_file($attach_id);

            // this is not an attachment, let's use the image url
        } else if ($img_url) {

            $file_path = parse_url($img_url);
            $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

            //$file_path = ltrim( $file_path['path'], '/' );
            //$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];

            $orig_size = getimagesize($file_path);

            $image_src[0] = $img_url;
            $image_src[1] = $orig_size[0];
            $image_src[2] = $orig_size[1];
        }

        $file_info = pathinfo($file_path);

        // check if file exists
        $base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];
        if (!file_exists($base_file))
            return;

        $extension = '.' . $file_info['extension'];

        // the image path without the extension
        $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

        // checking if the file size is larger than the target size
        // if it is smaller or the same size, stop right here and return
        if ($image_src[1] > $width || $image_src[2] > $height) {

            if ($crop == true) {

                $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

                // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
                if (file_exists($cropped_img_path)) {

                    $cropped_img_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);

                    $vt_image = array(
                        'url' => $cropped_img_url,
                        'width' => $width,
                        'height' => $height
                    );

                    return $vt_image;
                }
            } elseif ($crop == false) {

                // calculate the size proportionaly
                $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
                $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

                // checking if the file already exists
                if (file_exists($resized_img_path)) {

                    $resized_img_url = str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);

                    $vt_image = array(
                        'url' => $resized_img_url,
                        'width' => $proportional_size[0],
                        'height' => $proportional_size[1]
                    );

                    return $vt_image;
                }
            }

            // check if image width is smaller than set width
            $img_size = getimagesize($file_path);
            if ($img_size[0] <= $width) $width = $img_size[0];

            // no cache files - let's finally resize it
            $new_img_path = image_resize($file_path, $width, $height, $crop);
            $new_img_size = getimagesize($new_img_path);
            $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

            // resized output
            $vt_image = array(
                'url' => $new_img,
                'width' => $new_img_size[0],
                'height' => $new_img_size[1]
            );

            return $vt_image;
        }

        // default output - without resizing
        $vt_image = array(
            'url' => $image_src[0],
            'width' => $image_src[1],
            'height' => $image_src[2]
        );

        return $vt_image;
    }
}

if (!function_exists('vt_resize2')) {
    function vt_resize2($img_name, $dir_url, $dir_path, $width, $height, $crop = false)
    {

        $file_path = trailingslashit($dir_path) . $img_name;

        $orig_size = getimagesize($file_path);

        $image_src[0] = trailingslashit($dir_url) . $img_name;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];

        $file_info = pathinfo($file_path);

        // check if file exists
        $base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];
        if (!file_exists($base_file))
            return;

        $extension = '.' . $file_info['extension'];

        // the image path without the extension
        $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

        // checking if the file size is larger than the target size
        // if it is smaller or the same size, stop right here and return
        if ($image_src[1] > $width || $image_src[2] > $height) {

            if ($crop == true) {

                $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

                // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
                if (file_exists($cropped_img_path)) {

                    $cropped_img_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);

                    $vt_image = array(
                        'url' => $cropped_img_url,
                        'width' => $width,
                        'height' => $height
                    );

                    return $vt_image;
                }
            } elseif ($crop == false) {

                // calculate the size proportionaly
                $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
                $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

                // checking if the file already exists
                if (file_exists($resized_img_path)) {

                    $resized_img_url = str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);

                    $vt_image = array(
                        'url' => $resized_img_url,
                        'width' => $proportional_size[0],
                        'height' => $proportional_size[1]
                    );

                    return $vt_image;
                }
            }

            // check if image width is smaller than set width
            $img_size = getimagesize($file_path);
            if ($img_size[0] <= $width) $width = $img_size[0];

            // no cache files - let's finally resize it
            $new_img_path = image_resize($file_path, $width, $height, $crop);
            $new_img_size = getimagesize($new_img_path);
            $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

            // resized output
            $vt_image = array(
                'url' => $new_img,
                'width' => $new_img_size[0],
                'height' => $new_img_size[1]
            );

            return $vt_image;
        }

        // default output - without resizing
        $vt_image = array(
            'url' => $image_src[0],
            'width' => $image_src[1],
            'height' => $image_src[2]
        );

        return $vt_image;
    }
}

function etheme_product_page_banner()
{
    global $post;
    $etheme_productspage_id = etheme_shortcode2id('[productspage]');
    if ($post->ID == $etheme_productspage_id && etheme_get_option('product_bage_banner') && etheme_get_option('product_bage_banner') != ''):
        ?>
        <div class="wpsc_category_details">
            <img src="<?php etheme_option('product_bage_banner') ?>"/>
        </div>
    <?php endif;
}

function blog_breadcrumbs()
{

    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter = '<span class="delimeter">/</span>'; // delimiter between crumbs
    $home = __('Home', ETHEME_DOMAIN); // text for the 'Home' link
    $blogPage = 'Blog';
    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb

    global $post;
    $homeLink = home_url();

    if (is_front_page()) {

        if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';

    } else {

        echo '<div class="span12 breadcrumbs">';
        echo '<div id="breadcrumb">';
        echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
            echo $before . __('Archive by category', ETHEME_DOMAIN) . ' "' . single_cat_title('', false) . '"' . $after;

        } elseif (is_search()) {
            echo $before . __('Search results for', ETHEME_DOMAIN) . ' "' . get_search_query() . '"' . $after;

        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;

        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;

        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;

        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() == 'etheme_portfolio') {
                $portfolioId = etheme_tpl2id('portfolio.php');
                $portfolioLink = get_permalink($portfolioId);
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $portfolioLink . '/">' . $post_type->labels->name . '</a>';
                if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            } elseif (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1) echo ' ' . $delimiter . ' ';
            }
            if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Articles posted by ' . $userdata->display_name . $after;

        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        } else {

            echo $blogPage;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
            echo ' (' . __('Page') . ' ' . get_query_var('paged') . ')';
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
        }

        echo '</div>';
        echo '<a class="back-to" href="javascript: history.go(-1)"><span>‹</span>' . __('Return to Previous Page', ETHEME_DOMAIN) . '</a></div>';

    }
}

// Add GOOGLE fonts
function etheme_recognized_google_font_families($array, $field_id = false)
{
    $array = array(
        'Open+Sans' => '"Open Sans", sans-serif',
        'Droid+Sans' => '"Droid Sans", sans-serif',
        'Lato' => '"Lato"',
        'Cardo' => '"Cardo"',
        'Fauna+One' => '"Fauna One"',
        'Oswald' => '"Oswald"',
        'Yanone+Kaffeesatz' => '"Yanone Kaffeesatz"',
        'Muli' => '"Muli"'
    );

    return $array;

}

function etheme_get_chosen_google_font()
{
    $chosenFonts = array();
    $fontOptions = array();
    $fontOptions[] = etheme_get_option('h1');
    $fontOptions[] = etheme_get_option('h2');
    $fontOptions[] = etheme_get_option('h3');
    $fontOptions[] = etheme_get_option('h4');
    $fontOptions[] = etheme_get_option('h5');
    $fontOptions[] = etheme_get_option('h6');
    $fontOptions[] = etheme_get_option('sfont');

    foreach ($fontOptions as $value) {
        if ($value['google-font'] != '')
            $chosenFonts[] = $value['google-font'];
    }

    return $chosenFonts;

}

// Footer Demo Blocks
function etheme_footer_demo($block)
{
    switch ($block) {
        case 1:
            ?>
            <span class="footer_title">Our Contacts</span>
            <p class="footer-home">
                <i class="icon-home"></i>
                United Kingdom, London
                <br>
                Simple Street 15A
            </p>
            <p class="footer-phone">
                <i class="icon-phone"></i>
                (123) 123.456.7890
                <br>
                (123) 123.456.7890
            </p>
            <p class="footer-mail">
                <i class="icon-envelope-alt"></i>
                megashop@info.com
                <br>
                megashop@holding.com
            </p>
            <?php
            break;
        case 2:
            ?>
            <span class="footer_title">About Our Shop</span>
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting
                industry. Lorem Ipsum has been the industry's standard dummy text
                ever since the 1500s, when an unknown printer took a galley of type
                and scrambled it to make a type specimen book. It has survived not
                only five centuries, but also the leap into electronic typesetting,
                remaining.
            </p>
            <?php
            break;
        case 3:
            ?>
            <span class="footer_title">Flickr</span>
            <div class="footer_thumbs">
                <ul class="img-list">
                    <li class="flickr-photo ">
                        <a href="//www.flickr.com/photos/we-are-envato/8954733698" target="_blank">
                            <img src="//farm4.static.flickr.com/3820/8954733698_a2646a7642_s.jpg"
                                 alt="Author Guilherme Salum (DD Studios) at work in his studio" width="60" height="60">
                        </a>
                    </li>
                    <li class="flickr-photo ">
                        <a href="//www.flickr.com/photos/we-are-envato/8953389435" target="_blank">
                            <img src="//farm4.static.flickr.com/3685/8953389435_e5caf8d988_s.jpg"
                                 alt="Checking out the outdoor space" width="60" height="60">
                        </a>
                    </li>
                    <li class="flickr-photo footer_thumbs_last-child">
                        <a href="//www.flickr.com/photos/we-are-envato/8954585074" target="_blank">
                            <img src="//farm4.static.flickr.com/3795/8954585074_a38ff86602_s.jpg"
                                 alt="The team listening to what the next few months holds for the company" width="60"
                                 height="60">
                        </a>
                    </li>
                    <li class="flickr-photo ">
                        <a href="//www.flickr.com/photos/we-are-envato/8954585316" target="_blank">
                            <img src="//farm3.static.flickr.com/2879/8954585316_60966c9a23_s.jpg"
                                 alt="Selina and Collis" width="60" height="60">
                        </a>
                    </li>
                    <li class="flickr-photo ">
                        <a href="//www.flickr.com/photos/we-are-envato/8954584978" target="_blank">
                            <img src="//farm8.static.flickr.com/7346/8954584978_00d1041821_s.jpg"
                                 alt="Collis speaking to the team" width="60" height="60">
                        </a>
                    </li>
                    <li class="flickr-photo footer_thumbs_last-child">
                        <a href="//www.flickr.com/photos/we-are-envato/8953388295" target="_blank">
                            <img src="//farm8.static.flickr.com/7301/8953388295_b5ef30267f_s.jpg"
                                 alt="Cyan finds Collis" presentation="" pretty="" width="60" height="60">
                        </a>
                    </li>
                </ul>
            </div>
            <?php
            break;
        case 4:
            ?>
            <span class="footer_title">STORES</span>
            <ul class="footer_menu">
                <li><a href="#">New York</a></li>
                <li><a href="#">Paris</a></li>
                <li><a href="#">London</a></li>
                <li><a href="#">Madrid</a></li>
                <li><a href="#">Tokio</a></li>
                <li><a href="#">Milan</a></li>
                <li><a href="#">Hong Kong</a></li>
            </ul>
            <?php
            break;
        case 5:
            ?>
            <span class="footer_title">Our Offers</span>
            <ul class="footer_menu">
                <li><a href="#">New products</a></li>
                <li><a href="#">Top sellers</a></li>
                <li><a href="#">Specials</a></li>
                <li><a href="#">Manufacturers</a></li>
                <li><a href="#">Suppliers</a></li>
                <li><a href="#">Specials</a></li>
                <li><a href="#">Customer Service</a></li>
            </ul>
            <?php
            break;
        case 6:
            ?>
            <span class="footer_title">Our Services</span>
            <ul class="footer_menu">
                <li><a href="#">Order tracking</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Gift Cards</a></li>
                <li><a href="#">Shipping Information</a></li>
                <li><a href="#">Returns & refunds</a></li>
                <li><a href="#">Personalised Cards</a></li>
                <li><a href="#">Delivery information</a></li>
            </ul>
            <?php
            break;
        case 7:
            ?>
            <span class="footer_title">Our Offers</span>
            <img src="<?php echo get_template_directory_uri(); ?>/images/label_2-1.png" class="footer-logo" alt=""/>
            <br>
            <img src="<?php echo get_template_directory_uri(); ?>/images/label_3-1.png" class="footer-logo2" alt=""/>
            <img src="<?php echo get_template_directory_uri(); ?>/images/label_1-1.png" class="footer-logo3" alt=""/>
            <?php
            break;
        case 8:
            ?>
            <ul class="footer_copyright_menu">
                <li><a href="#">Site Map</a> /</li>
                <li><a href="#">Advanced Search</a> /</li>
                <li><a href="#">Orders and Returns</a> /</li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <?php
            break;
        case 9:
            ?>
            <ul class="footer_copyright_payments hidden-phone">
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/1363982755_paypal.png"
                                     alt=""/></a></li>
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/1363982759_mastercard.png"
                                     alt=""/></a></li>
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/1363984018_visa.png"
                                     alt=""/></a></li>
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/1363982767_discover.png"
                                     alt=""/></a></li>
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/1363982770_maestro.png"
                                     alt=""/></a></li>
                <li><a href="#"><img
                            src="<?php echo get_template_directory_uri(); ?>/images/1363982772_google_checkout.png"
                            alt=""/></a></li>
                <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/1363982777_cirrus.png"
                                     alt=""/></a></li>
            </ul>
            <?php
            break;
        case 7:
            ?>
            <span class="footer_title">Our Offers</span>
            <img src="<?php echo get_template_directory_uri(); ?>/images/mcafee_antivirus_logo_images-1.png"
                 class="footer-logo" alt=""/>
            <br>
            <img src="<?php echo get_template_directory_uri(); ?>/images/ab-seal-horizontal-large.png"
                 class="footer-logo2" alt=""/>
            <?php
            break;
        case 7:
            ?>
            <span class="footer_title">Our Offers</span>
            <img src="<?php echo get_template_directory_uri(); ?>/images/mcafee_antivirus_logo_images-1.png"
                 class="footer-logo" alt=""/>
            <br>
            <img src="<?php echo get_template_directory_uri(); ?>/images/ab-seal-horizontal-large.png"
                 class="footer-logo2" alt=""/>
            <?php
            break;
    }
}

function prar($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function display_price_in_variation_option_name($term)
{
    global $wpdb, $product;

    $result = $wpdb->get_col("SELECT slug FROM {$wpdb->prefix}terms WHERE name = '$term'");

    $term_slug = (!empty($result)) ? $result[0] : $term;


    $query = "SELECT postmeta.post_id AS product_id
                FROM {$wpdb->prefix}postmeta AS postmeta
                    LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id )
                WHERE postmeta.meta_key LIKE 'attribute_%'
                    AND postmeta.meta_value = '$term_slug'                    
					AND products.post_parent = '$product->id' ";

    $variation_id = $wpdb->get_col($query);

    $parent = wp_get_post_parent_id($variation_id[0]);

    if ($parent > 0) {
        $_product = new WC_Product_Variation($variation_id[0]);
        return $term . ' (' . woocommerce_price($_product->get_price()) . ')';
    }
    return $term;

}


add_filter('woocommerce_checkout_customer_userdata', 'save_shipping_to_new_customer', 10, 2);
function save_shipping_to_new_customer($userdata, $something)
{
    foreach ($something->posted as $key => $value) {
        if ((strpos($key, 'billing') !== false) || (strpos($key, 'shipping') !== false)) {
            $userdata[$key] = $value;
        }
    }
    return $userdata;
}

add_filter('woocommerce_get_price_excluding_tax', 'round_price_product', 10, 1);
add_filter('woocommerce_get_price_including_tax', 'round_price_product', 10, 1);
add_filter('woocommerce_tax_round', 'round_price_product', 10, 1);
add_filter('woocommerce_get_price', 'round_price_product', 10, 1);

function round_price_product($price)
{
    // Return rounded price
    return round($price, 2);
}

add_action('init', 'woocommerce_clear_cart_url');
function woocommerce_clear_cart_url()
{
    global $woocommerce;

    if (isset($_GET['empty-cart'])) {
        $woocommerce->cart->empty_cart();
    }
}

add_action('woocommerce_after_cart', 'add_cart_clear_button');
function add_cart_clear_button()
{
    global $woocommerce;
    echo '<a class="button" href="' . $woocommerce->cart->get_cart_url() . '?empty-cart">Empty Cart</a>';
}

add_filter('woocommerce_package_rates', 'hide_flate_rate_when_nonGC_present', 10, 2);
function hide_flate_rate_when_nonGC_present($rates, $package)
{
    //all hail woocommerce 2.6 where all the sudden local_pickup has 1s and 2s in the id name wooo
    if (isset ($rates['flat_rate'])) {
        unset($rates['flat_rate']);
    }

    return $rates;
}

add_filter('woocommerce_package_rates', 'local_delivery_mod', 10, 2);
function local_delivery_mod($rates, $package)
{
    global $woocommerce;
    $free_shipping_coupon_exists = false;
//    $couponfree = "";
    foreach($woocommerce->cart->coupons as $index => $coupon){
        if($coupon->enable_free_shipping()){
            $free_shipping_coupon_exists = true;
//            $couponfree = $coupon;
        }
    }
//
    foreach($rates as $key => $value){
        if ($value->label == "Local Delivery"){
//            $rates[$key]->id .= ":local_delivery";
            if($free_shipping_coupon_exists){
                $rates[$key]->cost = "0.00";
            }
        }

    }

    return $rates;
}

add_action('woocommerce_flat_rate_shipping_add_rate', 'gc_custom_rate', 10, 2);

function gc_custom_rate($method, $rate)
{

    $new_rate = $rate;
    $new_rate['id'] .= ':' . 'usps'; // Append a custom ID
    $new_rate['label'] = 'USPS'; // Rename to 'Rushed Shipping'
    $extra = ceil(WC()->cart->cart_contents_count / 5) * 1;
    $new_rate['cost'] = $extra;
    $nonGC = false;
    foreach (WC()->cart->cart_contents as $key => $item) {
        if ($item['data']->get_shipping_class() !== "small-container-fits-150") {
            $nonGC = true;
            break;
        }
    }
    // Add it to WC
    if(!$nonGC){
        $method->add_rate($new_rate);
    }

}

add_action('woocommerce_pre_payment_complete', 'order_packing_lists', 10, 1);
function order_packing_lists($order_id)
{

    $order = new WC_Order($order_id);
    $items = $order->get_items();
    $ship_method = $order->get_shipping_method();
    $shipping_class_counters = array(
        'Standard' => 0,
        'Dessert' => 0,
        'Gift_Card' => 0
    );
    if ($ship_method == "USPS") {
        $html = $order->get_formatted_shipping_address();
        if (!add_post_meta($order_id, '_USPS_mailing_address', $html, true)) {
            update_post_meta($order_id, '_USPS_mailing_address', $html);
        }
    } elseif ($ship_method == "Local Pickup") {

        $details = array();
        foreach ($items as $key => $item) {
            $item_shipping_class = $order->get_product_from_item($item)->get_shipping_class();
            $product_meta = get_post_meta($item['variation_id']);
            if (isset($item['composite_data'])) {
                if (isset($item['composite_children'])) {
                    array_push($details, array('size' => "REG", 'name' => $item['name'], 'qty' => $item['qty'], 'isComposite' => true, 'compositeKey' => $item['composite_cart_key']));
                    if ($item_shipping_class == "gift_card") {
                        $shipping_class_counters['Gift_Card'] += 1 * $item['qty'];
                    } elseif ($item_shipping_class == "shipping_dessert") {
                        $shipping_class_counters['Dessert'] += 1 * $item['qty'];
                    } else {
                        $shipping_class_counters['Standard'] += 1 * $item['qty'];
                    }
                }
                if (isset($item['composite_parent'])) {
                    foreach ($details as $key2 => $deet) {
                        if ($deet['compositeKey'] == $item['composite_parent']) {
                            $details[$key2]['children'][$key] = $item['name'];

                        }
                    }
                }
            } else {
                array_push($details, array('size' => strtoupper(substr($product_meta['attribute_pa_size'][0], 0, 3)), 'name' => $item['name'], 'qty' => $item['qty'], 'isComposite' => false));
                if ($item_shipping_class == "gift_card") {
                    $shipping_class_counters['Gift_Card'] += 1 * $item['qty'];
                } elseif ($item_shipping_class == "shipping_dessert") {
                    $shipping_class_counters['Dessert'] += 1 * $item['qty'];
                } else {
                    $shipping_class_counters['Standard'] += 1 * $item['qty'];
                }
            }
        }
        if (!add_post_meta($order_id, '_pl_meal_details', $details, true)) {
            update_post_meta($order_id, '_pl_meal_details', $details);
        }
        if (!add_post_meta($order_id, '_pl_meal_total_items', $shipping_class_counters, true)) {
            update_post_meta($order_id, '_pl_meal_total_items', $shipping_class_counters);
        }
    }
    //if shipping is flat_rate:usps address
}

add_action('wp_ajax_create_LP_USPS_package_lists', 'create_LP_USPS_package_lists');
function create_LP_USPS_package_lists()
{

    $order_id = $_POST['order_id'];


    $details = get_post_meta($order_id, '_pl_meal_details', true);
    $address = get_post_meta($order_id, '_USPS_mailing_address', false);
    $total_items = get_post_meta($order_id, '_pl_meal_total_items', true);

    //TODO: foreach shipping label make label printer version of packing image and include a page for packing list
    $html = '<html><head><link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . ('/css/print.css') . '"/></head><body style=""><p>Ctrl-P to open print preview</p>';
//        $html = '<link rel="stylesheet" type="text/css" href="'.plugins_url('sf-woocommerce-ups-integration-plugin/Assets/CSS/print.css', dirname(__FILE__)).'"/>';
    if (isset($details) && $details != "") {
        $html .= get_printable_order_contents($details);
    }
    if (isset($address) && $address != "") {
        $img_url = "";
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->prefix}posts WHERE post_name LIKE 'source-icon-06' AND post_type LIKE 'attachment'";
        $thumb_id = $wpdb->get_var($query);
        if (!is_null($thumb_id)) {
            $attachment = wp_get_attachment_image_src($thumb_id, 'full');
            $img_url = $attachment[0];
        }
        $html .= '<table style="margin: 0in;"><tr><td><img style="width: 1in;height: 1in;" src="' . $img_url . '"/></td><td>';
        $html .= $address[0] . '</td></tr></table>';
    }
    if ($total_items != "") {
        foreach ($total_items as $key => $value) {
            $html .= '<span>' . $key . ' : ' . $value . '</span><br>';
        }
        $html .= '<span>Total Items : ' . array_sum($total_items) . '</span>';
    }

    $html .= '</body></html>';


    wp_die($html);
    return;
//        return $actions;
}

function get_printable_order_contents($packing_list)
{
    $html = '<div class="sf_ups_shipping_packing_list_label"><table><thead><tr>Local Pickup</tr><tr><th class="sf_ups_shipping_prod_size">Size</th><th class="sf_ups_shipping_prod_name">Product</th><th class="sf_ups_shipping_prod_qty">Quantity</th></tr></thead><tbody>';
    foreach ($packing_list as $key => $value) {
        if ($value['isComposite']) {
            $html = $html . '<tr><td class="sf_ups_shipping_prod_size">' . $value['size'] . '</td><td class="sf_ups_shipping_prod_name">' . $value['name'] . '</td><td class="sf_ups_shipping_prod_qty">' . $value['qty'] . '</td></tr><tr><td class="sf_ups_shipping_prod_component" colspan="3"><ul class="" style="list-style-type:none;">';

            foreach ($value['children'] as $component_id => $component_value) {
                if ($component_value != "None") {
                    $html = $html . '<li style="width:100%;">' . $component_value . '</li>';
                }

            }
            $html = $html . '</ul></td></tr>';
        } else {
            $html = $html . '<tr><td class="sf_ups_shipping_prod_size">' . $value['size'] . '</td><td class="sf_ups_shipping_prod_name">' . $value['name'] . '</td><td class="sf_ups_shipping_prod_qty">' . $value['qty'] . "</td></tr>";
        }

    }
    $html = $html . "</tbody></table></div>";
    return $html;
}

add_filter('woocommerce_admin_order_actions', 'USPS_LocalPickup_packaging_links', 10, 2);
function USPS_LocalPickup_packaging_links($actions, $the_order)
{
    if (strpos($the_order->get_shipping_method(), 'USPS') !== false && $the_order->post_status == "wc-completed") {
        //enqueue js?
        $actions['print_labels'] = array('url' => '#z', 'name' => 'Shipping', 'action' => 'other_shipping');
    }
    if (strpos($the_order->get_shipping_method(), 'Local Pickup') !== false && $the_order->post_status == "wc-completed") {
        //enqueue js?
        $actions['print_labels'] = array('url' => '#z', 'name' => 'Shipping', 'action' => 'other_shipping');
    }
    return $actions;
}

//add_filter( 'woocommerce_email_order_items_table', 'qty_totals_insert', 100, 2);
function qty_totals_insert($table, $order)
{
//	<tr class="compositeRow"><td style="text-align:left; vertical-align:middle; border: 1px solid #eee; word-wrap:break-word;">
//		Custom Meals<br/><small></small></td>
//
//			<td style="text-align:left; vertical-align:middle; border: 1px solid #eee;">1</td>
//			<td style="text-align:left; vertical-align:middle; border: 1px solid #eee;"><span class="amount">&#36;6.00</span></td>
//			</tr>
    //$class_totals_html =
    $total_items = get_post_meta($order->id, '_pl_meal_total_items', true);

    if ($total_items != "") {
        $html = "";
        foreach ($total_items as $key => $value) {
            $html .= '<tr>';
            $html .= '<th class="td" scope="col" colspan="2" style=" text-align:left;">' . str_replace('_', ' ', $key) . ' Items</th>';
            $html .= '<td class="td" scope="col" style=" text-align:left;" >' . $value . '</td>';
            $html .= '</tr>';
        }
        $html .= '<tr>';
        $html .= '<th class="td" scope="col" colspan="2" style=" text-align:left;">Total Items</th>';
        $html .= '<td class="td" scope="col" style=" text-align:left;" >' . array_sum($total_items) . '</td>';
        $html .= '</tr>';

    }

    return $table . $html;
}


//return list of valid dates for product
add_action('woocommerce_before_checkout_shipping', 'datePicker');
function datePicker()
{
    // only echo if shipping is enabled
    if (WC()->shipping()->enabled) {
        echo '<ul class="nav add-menu-item-tabs nav-tabs" id="checkout_method_field">';
        echo '<li role="presentation" class="tabs active" id="local_pickup" data-value="local_pickup"><a href="#z">Local Pickup</a></li>';
        echo '<li role="presentation" class="tabs" id="local_delivery" data-value="local_delivery"><a href="#z">Local Delivery</a></li>';
        echo '<li role="presentation" class="tabs" id="ups_rate" data-value="ups_rate"><a href="#z">Ship It To Me</a></li>';
        echo '</ul>';
    }
}

add_action('wp_ajax_get_available_Dates', 'dateMaker');
add_action('wp_ajax_nopriv_get_available_Dates', 'dateMaker');
//ajax call to create dates
function dateMaker()
{
    //local delivery only allow times between 8-11 am and 2-7 pm
    //business as usual
    $arrival_dates = array();
    //shipittome no sat/sun/mon, no ground for friday delivery
    //only 1 day etas for tuesday
    $one_day_allowed = 1;
    $two_day_allowed = 1;

    $current_date = new DateTime(date('Y-m-d H:m:s'));

    if ($_POST['preferred_method'] == "ups_rate") {
        $current_date->modify('+60 hours');

        switch ($current_date->format('D')) {
            case 'Sat':
                //tues through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Tuesday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
            case 'Sun':
                //tues through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Tuesday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
            case 'Mon':
                //wed through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Wednesday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
            case 'Tue':
                //thu through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Thursday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
            case 'Wed':
                //this friday 1 day through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Friday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
            case 'Thu':
                //tues through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Tuesday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
            case 'Fri':
                //tues through next friday
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Tuesday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;

            default:
                $start_date = new DateTime(date('Y-m-d', strtotime('+1 Tuesday', $current_date->getTimestamp())));
                $end_date = new DateTime(date('Y-m-d', strtotime('+2 Friday', $current_date->getTimestamp())));
                break;
        }
        $end_date->modify('+1 day');
        $interval = new DateInterval('P1D');
        $date_range = new DatePeriod($start_date, $interval, $end_date);
        $arrival_dates['As Soon As Possible'] = 'As Soon As Possible';
        foreach ($date_range as $date) {
            if (in_array($date->format('D'), array('Sat', 'Sun', 'Mon'))) {
                continue;
            }
            $arrival_dates[$date->format('l Y-m-d')] = $date->format('l F d, Y');
        }
    } else if ($_POST['preferred_method'] == 'local_delivery') {
        $arrival_dates['As Soon As Possible'] = 'As Soon As Possible';
        $the_date = new DateTime(date('Y-m-d H:m:s', strtotime('+44 hours')));
        if ($the_date->format('D') == 'Thu') {
            $pickup_date1 = new DateTime(date('Y-m-d', strtotime('+1 Monday', $the_date->getTimestamp())));
            $pickup_date2 = new DateTime(date('Y-m-d', strtotime('+2 Monday', $the_date->getTimestamp())));
        } else {
            $pickup_date1 = new DateTime(date('Y-m-d', strtotime('Next Monday', $the_date->getTimestamp())));
            $pickup_date2 = new DateTime(date('Y-m-d', strtotime('+1 Monday', $the_date->getTimestamp())));
        }
        $arrival_dates[($pickup_date1->format('l Y-m-d') . ' 10am to 12pm')] = ($pickup_date1->format('l F d, Y') . ' 10am to 12pm');
        //$arrival_dates[($pickup_date1->format('l Y-m-d') . ' 2pm to 7pm')] = ($pickup_date1->format('l F d, Y') . ' 2pm to 7pm');
        $arrival_dates[($pickup_date2->format('l Y-m-d') . ' 10am to 12pm')] = ($pickup_date2->format('l F d, Y') . ' 10am to 12pm');
        //$arrival_dates[($pickup_date2->format('l Y-m-d') . ' 2pm to 7pm')] = ($pickup_date2->format('l F d, Y') . ' 2pm to 7pm');
    } else {
        $arrival_dates = create_hour_options_for_pickup_times()[0];
    }
    $options = array();
    //tuesdays need to use 1day shipping methods
    //friday deliveries, guaranteed only
    foreach ($arrival_dates as $key => $value) {
        $string = '<option value="' . $key . '">' . $value . '</option>';
        array_push($options, $string);
    }

    wp_die(implode('', $options));
    return;
}

add_filter('woocommerce_order_shipping_method', 'label_cleaner_mk2', 10, 2);
function label_cleaner_mk2($labels, $something)
{

    return explode('||', $labels)[0];
}

add_action('woocommerce_after_cart_contents', 'disclaimer_box_size', 10, 0);
add_action('woocommerce_review_order_after_cart_contents', 'disclaimer_box_size', 10, 0);
function disclaimer_box_size()
{
    $shop_page_url = get_permalink(wc_get_page_id('shop'));
    if (WC()->shipping()->enabled) :
        ?>
        <div id="disclaimer_box" class="warningBlock">

            <p>
                <strong>Note:</strong> When selecting the Shipping option, you will get the best value by ordering 25 meals. The shipping costs stay the same when ordering 1 or 25 meals. <a
                    href="<?php echo $shop_page_url; ?>" style="text-decoration: underline;">Continue shopping</a>
            </p>

        </div>
        <?php
    endif;

    echo '<a href="'.$shop_page_url.'" class="button" style="margin: 10px 0px; float: right;" >Continue Shopping</a>';
}

//add checkboxes for lactose free, gluten free, and unshippable

function woo_prod_add_status_icons_fields_save($post_id)
{
    $woocommerce_checkbox2 = isset($_POST['lFree_checkbox']) ? 'yes' : 'no';
    update_post_meta($post_id, 'lFree_checkbox', $woocommerce_checkbox2);

    $woocommerce_checkbox = isset($_POST['gFree_checkbox']) ? 'yes' : 'no';
    update_post_meta($post_id, 'gFree_checkbox', $woocommerce_checkbox);

    $woocommerce_checkbox4 = isset($_POST['sFree_checkbox']) ? 'yes' : 'no';
    update_post_meta($post_id, 'sFree_checkbox', $woocommerce_checkbox4);

    $woocommerce_checkbox3 = isset($_POST['unshippable_checkbox']) ? 'yes' : 'no';
    update_post_meta($post_id, 'unshippable_checkbox', $woocommerce_checkbox3);

}

function woo_prod_add_status_icons_fields()
{
    global $woocommerce, $post;
    echo '<div class="options_group">';
    //custom fields here
    woocommerce_wp_checkbox(
        array(
            'id' => 'lFree_checkbox',
            'wrapper_class' => '',
            'label' => __('Lactose Free', 'woocommerce'),
            'description' => __('Product is Lactose Free', 'woocommerce')
        )
    );
    woocommerce_wp_checkbox(
        array(
            'id' => 'gFree_checkbox',
            'wrapper_class' => '',
            'label' => __('Gluten Free', 'woocommerce'),
            'description' => __('Product is Gluten Free', 'woocommerce')
        )
    );
    woocommerce_wp_checkbox(
        array(
            'id' => 'sFree_checkbox',
            'wrapper_class' => '',
            'label' => __('Soy Free', 'woocommerce'),
            'description' => __('Product is Soy Free', 'woocommerce')
        )
    );
    woocommerce_wp_checkbox(
        array(
            'id' => 'unshippable_checkbox',
            'wrapper_class' => '',
            'label' => __('Unshippable', 'woocommerce'),
            'description' => __('Product is Unshippable', 'woocommerce')
        )
    );
    echo '</div>';
}

add_action('woocommerce_product_options_general_product_data', 'woo_prod_add_status_icons_fields');
//add_action( 'woocommerce_product_options_shipping', 'woo_prod_add_status_icons_fields' );
add_action('woocommerce_process_product_meta', 'woo_prod_add_status_icons_fields_save');

add_action('woocommerce_cart_calculate_fees', 'local_pickup_lincoln_occupation_tax', 1);
function local_pickup_lincoln_occupation_tax()
{

    global $woocommerce;
    if (is_admin() && !defined('DOING_AJAX'))
        return;
    $hasTaxables = false;
    foreach ($woocommerce->cart->cart_contents as $key => $value) {
        if ($value['data']->tax_status != "none") {
            $hasTaxables = true;
        }
    }
    if ($woocommerce->session->get('chosen_shipping_methods')[0] == "local_pickup" && $hasTaxables) {
        $percentage = 0.02;
        $taxable_subtotal = 0.0;
        foreach ($woocommerce->cart->cart_contents as $key => $value) {
            if ($value['data']->tax_status != "none") {
                $taxable_subtotal += $value['line_subtotal'];
            }
//				echo "<strong>".$value['data']->tax_status."</strong><br>";
        }
        $surcharge = ($taxable_subtotal + $woocommerce->cart->shipping_total) * $percentage;
        if($surcharge > 0){
            $woocommerce->cart->add_fee('Occupation Tax', $surcharge, true, '');
        }
    }
}
add_action('woocommerce_cart_calculate_fees', 'local_delivery_lincoln_occupation_tax', 1);
function local_delivery_lincoln_occupation_tax()
{
    //zipcodes last checked 2016-1-26
    $zipcodes = array(68336, 68402, 68430, 68502, 68503, 68504, 68505, 68506, 68507, 68508, 68510, 68512, 68514, 68516, 68517, 68520, 68521, 68522, 68523, 68524, 68526, 68527, 68528, 68531);
    $tax_percentage = 0.02;
    global $woocommerce;
    if (is_admin() && !defined('DOING_AJAX'))
        return;
    $hasTaxables = false;
    foreach ($woocommerce->cart->cart_contents as $key => $value) {
        if ($value['data']->tax_status != "none") {
            $hasTaxables = true;
        }
    }
    if ($woocommerce->session->get('chosen_shipping_methods')[0] != "local_pickup" && $hasTaxables) {
        $tax_based_on = get_option('woocommerce_tax_based_on');

        // Attempt to fetch correct address
        if ($tax_based_on == 'billing') {
            $customer_zip5 = $woocommerce->customer->get_postcode();

        } else {

            $customer_zip5 = $woocommerce->customer->get_shipping_postcode();
        }
        if (array_search($customer_zip5, $zipcodes)) {
            $taxable_subtotal = 0.0;
            foreach ($woocommerce->cart->cart_contents as $key => $value) {
                if ($value['data']->tax_status != "none") {
                    $taxable_subtotal += $value['line_subtotal'];
                }
//				echo "<strong>".$value['data']->tax_status."</strong><br>";
            }
            $surcharge = ($taxable_subtotal + $woocommerce->cart->shipping_total) * $tax_percentage;

            if($surcharge > 0){
                $woocommerce->cart->add_fee('Occupation Tax', $surcharge, true, '');
            }

        }
    }
    $shipping_methods = $woocommerce->shipping->load_shipping_methods();

}

add_filter('etheme_add_custom_product_labels', 'add_our_labels', 10, 2);
function add_our_labels($output, $post_id)
{
    $meta = get_post_meta($post_id);
    $isLactoseFree = $meta['lFree_checkbox'];
    $isGlutenFree = $meta['gFree_checkbox'];
    $isSoyFree = $meta['sFree_checkbox'];
    $isShippable = $meta['unshippable_checkbox'];
    $output .= '<span class="statusBar">';
    // 10384611_1429552360662653_3225121260700510051_n
    if (isset($isLactoseFree)) {
        if ($isLactoseFree[0] == "yes") {
            //get lactose free image somehow
            $url_lactoseFree = get_attachment_url_by_slug('lactose_free');
            $output .= '<img src="' . $url_lactoseFree . '" title="Lactose Free"/>';
//			$output .= '<span class='
        }
    }
    if (isset($isGlutenFree)) {
        if ($isGlutenFree[0] == "yes") {
            //get gluten free image somehow
            $url_glutenFree = get_attachment_url_by_slug('gluten_free');
//            $output .= '<img src="' . $url_glutenFree . '" title="Gluten Free"/>';
        }
    }
    if (isset($isSoyFree)) {
        if ($isSoyFree[0] == "yes") {
            $url_soyFree = get_attachment_url_by_slug('soy_free');
//            $output .= '<img src="' . $url_soyFree . '" title="Soy Free"/>';
        }
    }

    $output .= '</span>';
    $output .= '<span class="shipping-icon">';
    if (isset($isShippable)) {
        if ($isShippable[0] == "no") {
            //get unshippable image
            $url_unshippable = get_attachment_url_by_slug('unshippable');
//			$output .= '<img src="'.$url_unshippable.'" title="Shippable"/>';
        }
    } else {
        //get unshippable image
        $url_unshippable = get_attachment_url_by_slug('unshippable');
//        $output .= '<img src="' . $url_unshippable . '" />';
    }
    $output .= '</span>';
    return $output;
}

function get_attachment_url_by_slug($slug)
{
    $args = array(
        'post_type' => 'attachment',
        'name' => sanitize_title($slug),
        'posts_per_page' => 1,
        'post_status' => 'inherit',
    );
    $_header = get_posts($args);
    $header = $_header ? array_pop($_header) : null;
    return $header ? wp_get_attachment_url($header->ID) : '';
}
add_filter( 'woocommerce_composite_sale_price_html', 'useOldPriceStyle', 10, 1);
function useOldPriceStyle ($price){
    $var = preg_replace('#<(/?)ins>#', '', $price);
    return preg_replace('#<del>(.*?)</del>#', '', $var);
}

//lets remove the payment Methods because no one wants to be teased by stuff that isn't available to them
add_filter( 'woocommerce_account_menu_items', 'noPaymentMethods', 10, 1);
function noPaymentMethods ($items){
    unset($items['payment-methods']);
return $items;
}

function hide_shipping_when_free_is_available( $rates ) {
    $free = array();

    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $free[ $rate_id ] = $rate;
            break;
        }
    }
    return ! empty( $free ) ? $free : $rates;
}
//add_filter( 'woocommerce_package_rates', 'hide_shipping_when_free_is_available', 100 );

add_filter('woocommerce_available_payment_gateways','filter_gateways',1);
function filter_gateways($gateways){
    global $woocommerce;

        if(in_array('lunchonmonolith', $woocommerce->cart->applied_coupons,false)){
            if(key_exists('stripe', $gateways)){
                unset($gateways['stripe']);
            }

            if(key_exists('mercury_woocommerce_gateway', $gateways)){
                unset($gateways['mercury_woocommerce_gateway']);
            }


        }else{
            unset($gateways['cheque']);
        }

    //Remove a specific payment option
    return $gateways;
}

add_filter('woocommerce_shipping_chosen_method', 'set_default_method', 1);
function set_default_method($chosen_method){
//    wc_print_notice($chosen_method);
    return $chosen_method;
}
/////add class info to cart
//global $woocommerce;
//// add filter here - - apply_filters('woocommerce_cart_table_item_class', 'cart_table_item'...
//add_filter( 'woocommerce_cart_table_item_class', array( $this, 'sourceCompositeClass' ), 10, 3 );
//
//
//	/**
//	 * Changes the tr class of composited items in all templates to allow their styling.
//	 *
//	 * @param  string   $classname
//	 * @param  array    $values
//	 * @param  string   $cart_item_key
//	 * @return string
//	 */
//	function sourceCompositeClass( $classname, $values, $cart_item_key ) {
//
//		if ( isset( $values[ 'composite_data' ] ) && isset( $values[ 'composite_parent' ] ) && ! empty( $values[ 'composite_parent' ] ) )
//			return $classname . ' component_table_item';
//		elseif ( isset( $values[ 'composite_data' ] ) && isset( $values[ 'composite_children' ] ) && ! empty( $values[ 'composite_children' ] ) )
//			return $classname . ' component_container_table_item';
//
//		return $classname;
//	}
//	
