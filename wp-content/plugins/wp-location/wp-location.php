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
	require_once "includes/constants.php";
}

if ( ! class_exists( "wp_location" ) ) {
	require_once "includes/class-wp-location.php";
}

if ( ! class_exists( "google_places_api" ) ) {
	require_once( "includes/class-google-places-api.php" );
}

if ( ! class_exists( "wp_location_settings" ) ) {
	require_once( "includes/class-wp-location-settings.php" );
}

function wp_locations_view() {
	try {
		require_once( "pages/wp-locations-view.php" );
	} catch ( Exception $e ) {
		var_dump( $e );
	}
}

function get_wp_location_by_id( $id ) {
	global $wpdb;
	$locationRow           = $wpdb->get_row( "Select * from " . $wpdb->prefix . WP_LOCATION_TABLE . " where id = " . $id . " LIMIT 1", ARRAY_A );
	$location              = new wp_location();
	$location->id          = $locationRow["id"];
	$location->place_id    = $locationRow["place_id"];
	$location->alt_ids     = $locationRow["alt_ids"];
	$location->name        = $locationRow["name"];
	$location->latitude    = $locationRow["latitude"];
	$location->longitude   = $locationRow["longitude"];
	$location->address1    = $locationRow["address1"];
	$location->address2    = $locationRow["address2"];
	$location->city        = $locationRow["city"];
	$location->province    = $locationRow["province"];
	$location->country     = $locationRow["country"];
	$location->postal_code = $locationRow["postal_code"];

	return $location;
}

function get_wp_location_by_name( $name ) {
	global $wpdb;
	$sql                   = $wpdb->prepare( "Select * from " . $wpdb->prefix . WP_LOCATION_TABLE . " where name = %s LIMIT 1", $name );
	$locationRow           = $wpdb->get_row( $sql, ARRAY_A );
	$location              = new wp_location();
	$location->id          = $locationRow["id"];
	$location->place_id    = $locationRow["place_id"];
	$location->alt_ids     = $locationRow["alt_ids"];
	$location->name        = $locationRow["name"];
	$location->latitude    = $locationRow["latitude"];
	$location->longitude   = $locationRow["longitude"];
	$location->address1    = $locationRow["address1"];
	$location->address2    = $locationRow["address2"];
	$location->city        = $locationRow["city"];
	$location->province    = $locationRow["province"];
	$location->country     = $locationRow["country"];
	$location->postal_code = $locationRow["postal_code"];

	return $location;
}

function wp_locations_add() {
	try {
		// dont use once,just incase this method gets called twice
		require( "pages/wp-location-new.php" );
	} catch ( Exception $e ) {
		var_dump( $e );
	}
}

function wp_locations_edit( $location_id ) {
	try {
		if ( ! defined( "wpLocationTable" ) ) {
			include_once "includes/constants.php";
		}

		require( "pages/wp-location-edit.php" );
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
			$temp = null;
			// Check for NULL Values, to see if we even need to run the Query
			if ( empty( $location['longitude'] ) || empty( $location['latitude'] ) || empty( $location['place_id'] ) ) {
				// try and get the Geometry from Google
				$formatted = wp_location_format_address( $location );
				$temp      = wp_location_geocode( $formatted );
			}

			// if we ran the query
			if ( $temp != null ) {
				// are our coordinates empty
				if ( ( empty( $location['latitude'] ) || empty( $location['longitude'] ) ) ) {
					$location['latitude']  = floatval( $temp['latitude'] );
					$location['longitude'] = floatval( $temp['longitude'] );
				}

				// dont overwrite manually entered place_id
				if ( empty( $location['place_id'] ) ) {
					$location['place_id'] = ! empty( $temp['place_id'] ) ? $temp['place_id'] : null;
				}
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
				$format['id']          = "%d";
				$format['latitude']    = "%f";
				$format['longitude']   = "%f";
				$format['name']        = "%s";
				$format['province']    = "%s";
				$format['place_id']    = "%s";
				$format['postal_code'] = "%s";

				// just in case i f*ck up something above
				ksort( $format );
			}

			$wpdb->replace( $wpdb->prefix . WP_LOCATION_TABLE, $location, $format );
			// now that we've saved redirect back to the List
			wp_redirect( "/wp-admin/admin.php?page=wp-location" );
			add_action( 'admin_notices', 'wp_locations_save_success' );
		} catch ( Exception $e ) {
			// something Failed
			// add error to Admin Page
			add_action( 'admin_notices', 'wp_locations_save_failure' );
			wp_redirect( "/wp-admin/admin.php?page=wp-location-add" );
		}
	}
}

function wp_location_format_address( $location ) {
	$formatted = "";
	if ( is_array( $location ) ) {
		$formatted = $location['address1'] . " " . $location['address2'] . ", " . $location['city'] . " " . $location['province'] . " " . $location['postal_code'];
		if ( ! empty( $location['country'] ) ) {
			$formatted .= ", " . $location['country'];
		}
	} elseif ( is_object( $location ) ) {
		$formatted = $location->address1 . " " . $location->address2 . ", " . $location->city . " " . $location->province . " " . $location->postal_code;
		if ( ! empty( $location->country ) ) {
			$formatted .= ", " . $location->country;
		}
	}

	return $formatted;
}

function wp_location_settings(){
    if(is_admin()){
        require_once "includes/class-wp-location-settings.php";
        $settings = new wp_location_settings();
        $settings->create_admin_page();
    }
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

//	// Add "Settings" SubMenu
//	add_submenu_page(
//		"wp-location",
//		"Wp-Location Settings",
//		"Settings",
//		"manage_options",
//		"wp-location-settings",
//		"wp_location_settings"
//	);

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

// function to geocode address, it will return NULL if unable to geocode address
function wp_location_geocode( $address ) {
	return google_places_api::geocode( $address );
}

function wp_location_map_shortcode( $atts = [] ) {
	if ( empty( $atts ) ) {
		return;
	}
	// include the google js script with apiKey
	google_places_api::include_js_script();

	// include the styling for this plugin
	wp_enqueue_style( "wp-location-css", plugins_url( "wp-location/css/wp_location.css" ) );

	$location = null;
	if ( array_key_exists( "name", $atts ) ) {
		// Load location by Name
		$location = get_wp_location_by_name( $atts["name"] );
	} elseif ( array_key_exists( "id", $atts ) ) {
		// load location by Id
		$location = get_wp_location_by_id( $atts['id'] );
	} else {
		// throw exception
		return;
	}

	if ( empty( $location ) ) {
		return;
	}

	$style = array_key_exists( "style", $atts ) ? $atts["style"] . ";" : "";
	$class = array_key_exists( "class", $atts ) ? $atts["class"] . ";" : "";
	ob_start();
	try {
		?>
        <h3><?php echo $location->name; ?></h3>
        <span><?php echo wp_location_format_address( $location ); ?></span>
        <div id="wp-location-map-<?php echo $location->id; ?>" class="wp-location-map <?php echo $class; ?>"
             style="<?php echo $style; ?>"></div>
        <script>
            jQuery(document).ready(function () {
                var loc = new google.maps.LatLng(<?php echo $location->latitude; ?>, <?php echo $location->longitude; ?>);
                var map = new google.maps.Map(document.getElementById('wp-location-map-<?php echo $location->id; ?>'), {
                    zoom: 10,
                    center: loc
                });
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        map.setCenter(initialLocation);
                    });
                }
                var marker = new google.maps.Marker({
                    position: loc,
                    map: map
                });
            });
        </script>
		<?php
		return ob_get_contents();
	} finally {
		// Make sure to end the output buffer that we started, reguardless of success or failure
		ob_end_clean();
	}
}

function wp_location_hours_shortcode( $atts = [] ) {
	if ( empty( $atts ) ) {
		// should throw exception
		return;
	}

	// include the styling for this plugin
	wp_enqueue_style( "wp-location-css", plugins_url( "wp-location/css/wp_location.css" ) );

	$location = null;
	if ( array_key_exists( "name", $atts ) ) {
		// Load location by Name
		$location = get_wp_location_by_name( $atts["name"] );
	} elseif ( array_key_exists( "id", $atts ) ) {
		// load location by Id
		$location = get_wp_location_by_id( $atts['id'] );
	} else {
		// throw exception
		return;
	}

	if ( empty( $location ) || empty( $location->place_id ) ) {
		return;
	}

	$defaulted_atts = shortcode_atts( array(
		"type"  => "long",
		"style" => "",
		"class" => ""
	), $atts );

	$style = $defaulted_atts["style"];
	$class = $defaulted_atts["class"];


	$hours = google_places_api::get_place_hours( $location->place_id );
	if ( empty( $hours ) ) {
		ob_start();
		try {
			?>
            <div class="wp-location-hours-container">
                <div class="wp-location-hours-status">
                    <p>Failed to Load Open Hours for Location</p>
                </div>
            </div>
			<?php
			return ob_get_contents();
		} finally {
			ob_end_clean();
		}
	}

	$html = "";
	switch ( $defaulted_atts['type'] ) {
		case 'long':
			$html = wp_location_hours_display_long( $hours, $class, $style );
			break;
		case 'short':
			$html = wp_location_hours_display_short( $hours, $class, $style );
			break;
		case 'today':
			$html = wp_location_hours_display_today( $hours, $class, $style );
			break;
	}

	return $html;
}

function wp_location_hours_short_shortcode( $atts = [] ) {
	if ( array_key_exists( "name", $atts ) || array_key_exists( "id", $atts ) ) {
		$atts["type"] = "short";

		return wp_location_hours_shortcode( $atts );
	}
}

function wp_location_hours_long_shortcode( $atts = [] ) {
	if ( array_key_exists( "name", $atts ) || array_key_exists( "id", $atts ) ) {
		$atts["type"] = "long";

		return wp_location_hours_shortcode( $atts );
	}
}

function wp_location_hours_today_shortcode( $atts = [] ) {
	if ( array_key_exists( "name", $atts ) || array_key_exists( "id", $atts ) ) {
		$atts["type"] = "today";

		return wp_location_hours_shortcode( $atts );
	}
}

function wp_location_hours_display_long( $hours, $class = "", $style = "" ) {
	if ( empty( $hours ) ) {
		return;
	}

	ob_start();
	try {
		?>
        <div class="wp-location-hours-container <?php echo $class; ?>" style="<?php echo $style; ?>">
            <div class="wp-location-hours-status">
                <p>Doors are: <?php echo( $hours->open_now ? "Open" : "Closed" ); ?></p>
            </div>
            <div class='wp-location-hours-table'>
				<?php
				foreach ( $hours->weekday_text as $key => $value ) {
					?>
                    <div class="wp-location-hours-table-row">
                        <span class="wp-location-hours-table-column"><?php echo $value; ?></span>
                    </div>
					<?php
				}
				?>
            </div>
        </div>
		<?php
		return ob_get_contents();
	} finally {
		// no matter what, make sure to kill the output buffering that we started
		ob_end_clean();
	}
}

function wp_location_hours_display_short( $hours, $class = "", $style = "" ) {
	if ( empty( $hours ) ) {
		return;
	}

	// group days by consistent hours
	$condensed_text = google_places_api::condense_weekday_text( $hours );
	ob_start();
	try {
		?>
        <div class="wp-location-hours-container <?php echo $class; ?>" style="<?php echo $style; ?>">
            <div class="wp-location-hours-status">
                <p>Doors are: <?php echo( $hours->open_now ? "Open" : "Closed" ); ?></p>
            </div>
            <div class='wp-location-hours-table'>
				<?php
				foreach ( $condensed_text as $value ) {
					?>
                    <div class="wp-location-hours-table-row">
                        <span class="wp-location-hours-table-column"><?php echo $value; ?></span>
                    </div>
					<?php
				}
				?>
            </div>
        </div>
		<?php
		return ob_get_contents();
	} finally {
		ob_end_clean();
	}
}

function wp_location_hours_display_today( $hours, $class = "", $style = "" ) {
	if ( empty( $hours ) ) {
		return;
	}
	// because googlePlaces API doesn't understand how to make things the same...
	$day_conversion_table = array( 0 => 5, 1 => 0, 2 => 1, 3 => 2, 4 => 3, 5 => 4, 6 => 6 );
	ob_start();
	try {
		?>
        <div class="wp-location-hours-container <?php echo $class; ?>" style="<?php echo $style; ?>">
            <div class="wp-location-hours-status">
                <p>Doors are: <?php echo( $hours->open_now ? "Open" : "Closed" ); ?></p>
            </div>
            <div class='wp-location-hours-table'>
                <div class="wp-location-hours-table-row">
                    <span class="wp-location-hours-table-column"><?php echo $hours->weekday_text[ $day_conversion_table[ date( 'w' ) ] ] ?></span>
                </div>
            </div>
        </div>
		<?php
		return ob_get_contents();
	} finally {
		ob_end_clean();
	}
}

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
	latitude DECIMAL(20,10) NULL,
	longitude DECIMAL(20,10) NULL,
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
	flush_rewrite_rules();
}


// do all the registration, AFTER ALL the functions have been registered so we dont run into a race Condition problem

// Add Menu Item for Stroe locations
add_action( 'admin_menu', 'wpLocationMenuItem' );
add_action( 'admin_post_wp_locations_save', 'wp_locations_save' );

// add_action( 'admin_post_wp_location_settings_save', 'wp_location_settings_save' );

add_shortcode( 'wp_location_map', 'wp_location_map_shortcode' );
add_shortcode( 'wp_location_hours', 'wp_location_hours_shortcode' );
add_shortcode( 'wp_location_hours_long', 'wp_location_hours_long_shortcode' );
add_shortcode( 'wp_location_hours_short', 'wp_location_hours_short_shortcode' );
add_shortcode( 'wp_location_hours_today', 'wp_location_hours_today_shortcode' );

// Install or Update the Table
register_activation_hook( __FILE__, 'wpLocationInstall' );

?>