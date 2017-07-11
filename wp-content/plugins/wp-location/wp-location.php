<?php
/*
Plugin Name: StoneFin Location Support
Plugin URI: http://www.reallyeffective.co.uk/knowledge-base
Description: StoneFin Location Support
Version: 0.1 BETA
Author: Jeff Wesely, Corey Wesely, Joe Echtenkamp
Author URI: https://www.stonefin.com
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! defined( "wpLocationTable" ) ) {
	include_once "includes/Constants.php";
}

add_action( 'wp_enqueue_scripts', 'locations_enqueue_styles' );
function locations_enqueue_styles() {
	if ( is_page( 'checkout' ) ) {
		wp_register_script( 'locations_script', plugin_dir_url( __FILE__ ) . 'pickup_location_blues.js?version=0.3', array(), false, true );
		wp_enqueue_script( 'locations_script' );
	}
}

//tell wordpress to register the demolistposts shortcode
add_shortcode( "contact-page-shortcode", "contactpage_handler" );
function SFCP_getLocations() {
	$store_locations = array();
	$query           = get_posts(
		array(
			'meta_value' => '',
			'post_type'  => 'sf-store-locations'
		)
	);

	foreach ( $query as $store_id => $store_location ) {
		$store_locations[ $store_location->post_title ] = get_post_meta( $store_location->ID, '_location', true );

	}
}

function wp_locations_view() {
	try {
		require_once( "pages/wp-locations-view.php" );
	} catch ( Exception $e ) {
		var_dump( $e );
	}
}

function wp_locations_add() {
	try {
		require_once( "pages/wp-location-new.php" );
	} catch ( Exception $e ) {
		var_dump( $e );
	}
}

function wp_locations_edit( $location_id ) {
	try {
        if ( ! defined( "wpLocationTable" ) ) {
			include_once "includes/Constants.php";
		}
		require_once( "pages/wp-location-edit.php" );
	} catch ( Exception $e ) {
		var_dump( $e );
	}
}

function wp_locations_save() {
	global $wpdb;
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You are not allowed to be on this page.' );
	}

	// Check that nonce field
	check_admin_referer( 'wp_location_verify' );
	$location = $_POST['location'];
	if ( ! empty( $location ) ) {
		// disabling alt_id for now
		try {
			// Check for NULL Values, and set as such
			if ( empty( $location['geometry'] ) ) {
				$location['geometry'] = null;
			}
			if ( empty( $location['place_id'] ) ) {
				$location['place_id'] = null;
			}
			if ( empty( $location['alt_ids'] ) ) {
				$location['alt_ids'] = null;
			}
			if ( empty( $location['address2'] ) ) {
				$location['address2'] = null;
			}

			// make sure that the ID key Exists so that the format array is aligned
			if ( ! array_key_exists( "id", $location ) ) {
				$location['id'] = null;
			}

			// sort the array by Key, so that our format lines up, otherwise dont use a format at all
			$format = null;
			if ( ksort( $location ) ) {
				$format                = array();
				$format['address1']    = "%s";
				$format['address2']    = "%s";
				$format['alt_ids']     = "%s";
				$format['city']        = "%s";
				$format['country']     = "%s";
				$format['geometry']    = "%s";
				$format['id']          = "%d";
				$format['name']        = "%s";
				$format['province']    = "%s";
				$format['place_id']    = "%s";
				$format['postal_code'] = "%s";

				// just in case i f*ck up something above
				ksort($format);
			}

			$wpdb->replace( $wpdb->prefix . WP_LOCATION_TABLE, $location, $format );
			add_action( 'admin_notices', 'wp_locations_save_success' );
			wp_redirect( "/wp-admin/admin.php?page=wp-location" );
		} catch ( Exception $e ) {
			// something Failed
			// add error to Admin Page
			add_action( 'admin_notices', 'wp_locations_save_failure' );
			var_dump( $e );
			//wp_redirect("/wp-admin/admin.php?page=wp-location-add");
		}

	}
	// now that we've saved redirect back to the List

}

function wp_locations_save_success() {
	?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Successfully Saved Location!', 'wp-locations-textarea' ); ?></p>
    </div>
	<?php
}

function wp_locations_save_failure() {
	?>
    <div class="notice notice-error">
        <p><?php _e( 'Failed to Save Location!', 'wp-locations-textarea' ); ?></p>
    </div>
	<?php
}

add_action( 'admin_post_wp_locations_save', 'wp_locations_save' );

function contactpage_handler( $atts ) {
	/**
	 * Creates Content for the page used to create a store location.
	 */
	//run function that actually does the work of the plugin
	$a = shortcode_atts( array(
		'gmap' => 1
	), $atts );

	if ( isset( $_GET['contactSubmit'] ) ) {
		$emailFrom = strip_tags( $_GET['contactEmail'] );
		$emailTo   = etheme_get_option( 'contacts_email' );
		$subject   = strip_tags( $_GET['contactSubject'] );

		$name    = strip_tags( $_GET['contactName'] );
		$email   = strip_tags( $_GET['contactEmail'] );
		$message = strip_tags( stripslashes( $_GET['contactMessage'] ) );

		$body = "Name: " . $name . "\n";
		$body .= "Email: " . $email . "\n";
		$body .= "Message: " . $message . "\n";
		$body .= $name . ", <b>" . $emailFrom . "</b>\n";

		$headers = "From $emailFrom " . PHP_EOL;
		$headers .= "Reply-To: $emailFrom" . PHP_EOL;
		$headers .= "MIME-Version: 1.0" . PHP_EOL;
		$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
		$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

		if ( isset( $_GET['contactSubmit'] ) ) {
			$success = wp_mail( $emailTo, $subject, $body, $headers );
			if ( $success ) {
				echo '<p class="yay">All is well, your e&ndash;mail has been sent.</p>';
			}
		} else {
			echo '<p class="oops">Something went wrong</p>';
		}
	} else {
		?>

        <div class="span9 blog1_post contacts-page" id="blog_full_content">
			<?php
			if ( $a['gmap'] == 1 ):
				$store_locations = array();
				$query           = get_posts(
					array(
						'meta_value' => '',
						'post_type'  => 'sf-store-locations'
					)
				);

				foreach ( $query as $store_id => $store_location ) {
					$store_locations[ $store_location->post_title ] = get_post_meta( $store_location->ID, '_location', true );

				} ?>
                <div class="span9 blog1_post_image" id="map-image">
                    <div id="map">
                        <p>Enable your JavaScript!</p>
                    </div>
                </div>
                <div class="clear"></div>

                <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
                <script type="text/javascript">

                    function etheme_google_map() {
                        var styles = {
                            '8theme': [{
                                "featureType": "administrative",
                                "stylers": [
                                    {"visibility": "on"}
                                ]
                            },
                                {
                                    "featureType": "road",
                                    "stylers": [
                                        {"visibility": "on"},
                                        {"hue": "#e78b8b"}
                                    ]
                                },
                                {
                                    "stylers": [
                                        {"visibility": "on"},
                                        {"hue": "#e78b8b"},
                                        {"saturation": -50}
                                    ]
                                }
                            ]
                        };

                        var myLatlngSrc = new Array(<?php echo '"' . implode( '","', $store_locations ) . '"';?>);
                        var myLatlngArray = new Array();
                        myLatlngSrc.forEach(function (element, index, array) {

                            var latlng = element.split(',');
                            latlng.forEach(function (item, index) {
                                latlng[index] = parseFloat(item);
                            });

                            myLatlngArray.push(new google.maps.LatLng(latlng[0], latlng[1]));
                        });


                        var myOptions = {
                            zoom: 17,
                            center: myLatlngArray[0],
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            disableDefaultUI: true,
                            mapTypeId: '8theme',
                            draggable: true,
                            zoomControl: true,
                            panControl: false,
                            mapTypeControl: true,
                            scaleControl: true,
                            streetViewControl: true,
                            overviewMapControl: true,
                            scrollwheel: false,
                            disableDoubleClickZoom: false
                        }
                        var map = new google.maps.Map(document.getElementById("map"), myOptions);
                        var styledMapType = new google.maps.StyledMapType(styles['8theme'], {name: '8theme'});
                        map.mapTypes.set('8theme', styledMapType);
                        var bounds = new google.maps.LatLngBounds();
                        var marker;

                        myLatlngArray.forEach(function (element, index, array) {

                            bounds.extend(element);
                            marker = new google.maps.Marker({
                                position: element,
                                map: map,
                                title: ""
                            });

                        });
                        map.fitBounds(bounds);


                    }

                    jQuery(document).ready(function () {
                        etheme_google_map();
                    });

                    jQuery(document).resize(function () {
                        etheme_google_map();
                    });

                </script>


			<?php endif; ?>
        </div>

        <div class="contact-form">
            <h1><?php the_title(); ?></h1>
            <div id="contactsMsgs" class="clear"></div>
            <div class="span4 contact_info">
				<?php include( 'html/contact-page.php' ) ?>
            </div>
            <div class="span5 blog_full_review_container" id="contact_container">
                <h2><?php _e( 'Contact Form', ETHEME_DOMAIN ); ?></h2>

                <form action="<?php the_permalink(); ?>" method="POST" class="form" id="ethemeContactForm">
                    <label for="contactName"><?php _e( 'Name', ETHEME_DOMAIN ); ?> <span
                                class="required">*</span></label>
                    <input type="text" class="contact_input required-field" name="contactName"/>
                    <label for="contactEmail"><?php _e( 'Email', ETHEME_DOMAIN ); ?> <span
                                class="required">*</span></label>
                    <input type="text" class="contact_input required-field" name="contactEmail"/>
                    <label for="contactSubject"><?php _e( 'Subject', ETHEME_DOMAIN ); ?> <span
                                class="required">*</span></label>
                    <input type="text" class="contact_input" name="contactSubject"/>
                    <label for="contactMessage"><?php _e( 'Message', ETHEME_DOMAIN ); ?> <span
                                class="required">*</span></label>
                    <textarea class="contact_textarea required-field" rows="10" cols="45"
                              name="contactMessage"></textarea>

                    <div id="contact_button">
                        <button class="button fl-r" name="contactSubmit" type="submit">
                            <span><?php _e( 'Send Request', ETHEME_DOMAIN ); ?></span></button>
                        <div class="contactSpinner"></div>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
        </div>
		<?php
	}
	$contactph_output = contactpage_function();

	//send back text to replace shortcode in post
	return $contactph_output;
}

function contactpage_function() {
	//process plugin
	$contactp_output = "";

	//send back text to calling function
	return $contactp_output;
}

register_activation_hook( __FILE__, 'giar_activate' );
function giar_activate() {
	flush_rewrite_rules();
}


add_action( 'rest_api_init', 'dt_register_api_hooks' );
function dt_register_api_hooks() {
	$namespace = 'give-it-a-rest/v1';

	register_rest_route( $namespace, '/list-posts/', array(
		'methods'  => 'GET',
		'callback' => 'giar_get_posts',
	) );

}

function giar_get_posts() {
	if ( 0 || false === ( $return = get_transient( 'dt_all_posts' ) ) ) {
		$query     = apply_filters( 'giar_get_posts_query', array(
			'numberposts' => - 1,
			'post_type'   => 'sf-store-locations',
			'post_status' => 'publish',
		) );
		$all_posts = get_posts( $query );
		$return    = array();

		foreach ( $all_posts as $post ) {
			$return[] = array(
				'ID'        => $post->ID,
				'title'     => $post->post_title,
				'permalink' => get_permalink( $post->ID ),
			);
		}
		$data['stores'] = $return;
		// cache for 10 minutes
		set_transient( 'giar_all_posts', $return, apply_filters( 'giar_posts_ttl', 60 * 10 ) );
	}
	$response = new WP_REST_Response( $data );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'giar_access_control_allow_origin', '*' ) );

	return $response;
}


//Store location custom post type
//function store_location_init()
//{
//    $args = array(
//        'label' => 'Store Locations',
//        'public' => false,
//        'show_ui' => true,
////        'capability_type' => 'post',
////        'hierarchical' => false,
////        'rewrite' => array('slug' => 'store-locations'),
////        'query_var' => true,
//        'menu_icon' => 'dashicons-video-alt',
//        'supports' => array(
//            'title',
//            'custom-fields',)
//    );
//    register_post_type('sf-store-locations', $args);
//}

// add_action('init', 'store_location_init');
/**
 * Something to do with creating a store location
 */

// Add Admin Menu Tab
function wpLocationMenuItem() {
	// add Store Location Main Menu
    add_menu_page( 'Store Locations', 'Store Locations', 'manage_options', 'wp-location', 'wp_locations_view' );

    // Add "Add Location" SubMenu
	add_submenu_page(
		"wp-location",
		"Add New Location",
		"Add Location",
		"manage_options",
		"wp-location-add",
		"wp_locations_add"
	);
	// add "Edit Location" page, WITHOUT menu Item
	add_submenu_page(
		null,
		"Edit Location",
		"Edit Location",
		"manage_options",
		"wp-location-edit",
		"wp_locations_edit"
	);
}

add_action( 'admin_menu', 'wpLocationMenuItem' );

//add_action( 'add_meta_boxes', 'add_events_metaboxes' );

//function add_events_metaboxes() {
//	add_meta_box( 'wpt_events_location', 'Location Address', 'wpt_events_location', 'sf-store-locations', 'normal', 'default' );
//}

//add_action( 'save_post', 'wpt_save_events_meta', 1, 2 ); // save the custom fields

// function to geocode address, it will return false if unable to geocode address
function geocode( $address ) {

	// url encode the address
	$address = urlencode( $address );

	// google map geocode api url
	$url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

	// get the json response
	$resp_json = file_get_contents( $url );

	// decode the json
	$resp = json_decode( $resp_json, true );

	// response status will be 'OK', if able to geocode given address
	if ( $resp['status'] == 'OK' ) {

		// get the important data
		$lati              = $resp['results'][0]['geometry']['location']['lat'];
		$longi             = $resp['results'][0]['geometry']['location']['lng'];
		$formatted_address = $resp['results'][0]['formatted_address'];

		// verify if data is complete
		if ( $lati && $longi && $formatted_address ) {

			// put the data in the array
			$data_arr = array();

			array_push(
				$data_arr,
				$lati,
				$longi,
				$formatted_address
			);

			return $data_arr;

		} else {
			return false;
		}

	} else {
		return false;
	}
}

//return apply_filters( 'woocommerce_order_shipping_method', implode( ', ', $labels ), $this )
//add_filter( 'woocommerce_order_shipping_method', 'add_store_to_via',10 , 2);
//function add_store_to_via ($lables, $this){
//
//}

function google_place_shortcode( $atts = [] ) {
	include_once 'includes/GooglePlacesAPI.php';
	$GpApi = new GooglePlacesAPI();
	$GpApi->Fetch_Place();
}

add_shortcode( 'googleplace', 'google_place_shortcode' );

function google_place_pickup_time_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'place_key' => '',
	), $atts );

	include_once 'includes/GooglePlacesAPI.php';
	$dummy = new GooglePlacesAPI();

	return $dummy->pickup_time_select_for_place( $a['place_key'] );
}

add_shortcode( 'googleplace_pickup', 'google_place_pickup_time_shortcode' );
function me_map() {
	//require_once 'includes/Map.js';
	include_once 'html/mymap.html';
	//return $dummy->local_delivery_time_select_for_place();
}

add_shortcode( 'me_map', 'me_map' );
function google_place_delivery_time_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'place_key' => '',
	), $atts );

	include_once 'includes/GooglePlacesAPI.php';
	$dummy = new GooglePlacesAPI();

	return $dummy->local_delivery_time_select_for_place();
}

add_shortcode( 'googleplace_delivery', 'google_place_delivery_time_shortcode' );

function google_place_business_hours_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'place_key' => '',
	), $atts );

	include_once 'includes/GooglePlacesAPI.php';
	$dummy = new GooglePlacesAPI();

	return $dummy->get_condensed_store_hours( $a['place_key'] );
}

add_shortcode( 'googleplace_business_hours', 'google_place_business_hours_shortcode' );
/**
 * to use these shortcodes, must enter it like this
 * [tag attribute="the value"]some text[/tag]
 */
function google_place_business_status_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'place_key' => '',
	), $atts );

	include_once 'includes/GooglePlacesAPI.php';
	$dummy = new GooglePlacesAPI();

	return $dummy->show_store_status( $a['place_key'] );
}

add_shortcode( 'googleplace_business_status', 'google_place_business_status_shortcode' );

function wpLocationInstall() {
	global $wpdb;
	global $wp_location_db_version;

	$table_name      = $wpdb->prefix . WP_LOCATION_TABLE;
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	id INT(10) NOT NULL AUTO_INCREMENT,
	place_id TEXT NULL,
	alt_ids TEXT NULL,
	name VARCHAR(255) NOT NULL,
	geometry GEOMETRY NULL,
	address1 VARCHAR(255) NOT NULL,
	address2 VARCHAR(255) NULL DEFAULT NULL,
	city VARCHAR(255) NOT NULL,
	province VARCHAR(255) NOT NULL,
	country VARCHAR(255) NOT NULL DEFAULT 'United States',
	postal_code VARCHAR(255) NOT NULL,
	created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY  (id)
) $charset_collate;
";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'wp_location_db_version', $wp_location_db_version );
}

// Install or Update the Table
register_activation_hook( __FILE__, 'wpLocationInstall' );
?>