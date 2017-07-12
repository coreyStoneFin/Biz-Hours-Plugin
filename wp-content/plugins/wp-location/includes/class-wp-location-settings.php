<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class wp_location_settings
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_options_page(
			'Wordpress Locations Settings',
			'Wp-Location Settings',
			'manage_options',
			'wp-location-setting',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'my_option_name' );
		?>
        <div class="wrap">
            <h1>My Settings</h1>
            <form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'wp_location_options' );
				do_settings_sections( 'wp-location-setting' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init()
	{
		register_setting(
			'wp_location_options', // Option group
			'wp_location_google', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'Google Maps Settings', // Title
			array( $this, 'print_section_info' ), // Callback
			'wp-location-setting' // Page
		);

		add_settings_field(
			'api_key', // ID
			'API Key', // Title
			array( $this, 'api_key_callback' ), // Callback
			'wp-location-setting', // Page
			'setting_section_id' // Section
		);

//		add_settings_field(
//			'title',
//			'Title',
//			array( $this, 'title_callback' ),
//			'wp-location-setting',
//			'setting_section_id'
//		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
	    return $input;
		$new_input = array();
		if( isset( $input['api_key'] ) ) {
			$new_input['api_key'] = preg_replace( "/[0-9a-z\-_]/i","",$input['api_key'] );
		}
//		if( isset( $input['title'] ) )
//			$new_input['title'] = sanitize_text_field( $input['title'] );

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info()
	{
		print 'Enter your settings below:';
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function api_key_callback()
	{
		printf(
			'<input type="text" id="api_key" name="wp_location_google[api_key]" value="%s" />',
			isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''
		);
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function title_callback()
	{
		printf(
			'<input type="text" id="title" name="wp_location_google[title]" value="%s" />',
			isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
		);
	}
}

if( is_admin() )
	$my_settings_page = new wp_location_settings();