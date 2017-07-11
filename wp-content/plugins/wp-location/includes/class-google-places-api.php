<?php

/**
 * Created by PhpStorm.
 * User: jwesely
 * Date: 1/4/2017
 * Time: 12:13 PM
 */
class google_places_api {
	private static $apiKey = "AIzaSyDuHcLe6WbcD1qVmBfZ6OXT85XOT3oiscs";
	// private $key     = "AIzaSyCckc-IRS8AKZK-Hq_qwiq1O02nqLce0-c";
	public static $place_endpoint = "https://maps.googleapis.com/maps/api/place/details/json?";
	public static $map_endpoint = "https://maps.googleapis.com/maps/api/place/details/json?";
	protected static $version = "3.exp";


	public static function include_js_script() {
		wp_enqueue_script( 'google-maps-api', "https://maps.googleapis.com/maps/api/js?key=" . google_places_api::apiKey . "&v=" . google_places_api::version );
	}

	public static function geocode( $address ) {
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
			$place_id          = $resp['results'][0]['place_id'];
			$formatted_address = $resp['results'][0]['formatted_address'];

			// verify if data is complete
			if ( $lati && $longi && $formatted_address ) {

				// put the data in the array
				$data_arr              = array();
				$data_arr['latitude']  = $lati;
				$data_arr['longitude'] = $longi;
				$data_arr['formatted'] = $formatted_address;
				$data_arr['place_id']  = $place_id;

				return $data_arr;
			}
		}

		return null;
	}

	public static function get_place_hours( $place_id ) {
		$current_time = new DateTime( "now" );
		$current_time->setTimezone( new DateTimeZone( 'America/Chicago' ) );
		$json = wp_remote_get( google_places_api::place_endpoint . 'placeid=' . $place_id . '&key=' . google_places_api::apiKey );

		try {
			$place_object = json_decode( $json['body'] );

			return $place_object->result->opening_hours;
		} catch ( Exception $e ) {
			return null;
		}
	}
}
