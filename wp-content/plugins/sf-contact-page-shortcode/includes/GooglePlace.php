<?php
/**
 * Created by PhpStorm.
 * User: jwesely
 * Date: 1/4/2017
 * Time: 12:13 PM
 */

class GooglePlace {
    public $place_id;
    public $alt_ids;
    public $name;
    public $geometry;
    public $address1;
    public $address2;
    // City
    public $city;
    // State
    public $province;
    // Country
    public $country="US";
    // Zip
    public $postalCode;
    public $opening_hours;
	public $permanently_closed;
}
