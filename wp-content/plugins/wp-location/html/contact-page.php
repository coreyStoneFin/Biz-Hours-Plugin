<?php
/**
 * Created by PhpStorm.
 * User: jwesely
 * Date: 3/3/2016
 * Time: 10:07 AM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$store_locations = array();
foreach(query_posts('post_type=sf-store-locations') as $store_id => $store_location){
    $store_locations[$store_location->post_title] = array(
        'store_name' => $store_location->post_title,
        'store_address' => array(
            'address_line' => get_post_meta($store_location->ID, '_address', true),
            'city' => get_post_meta($store_location->ID, '_city', true),
            'state' => get_post_meta($store_location->ID, '_state', true),
            'zip' => get_post_meta($store_location->ID, '_zip', true),

        ),
        'store_phone' => get_post_meta($store_location->ID, '_phone', true),
        'store_email' => get_post_meta($store_location->ID, '_email', true),
        );
}
echo '<h5>Contact Info</h5>';
foreach($store_locations as $name => $details){
    echo '<div>
            <h5>'.$details['store_name'].'</h5>
            <p>'.$details['store_address']['address_line'].',<br>'.$details['store_address']['city'].',<br>'.$details['store_address']['state'].' '.$details['store_address']['zip'].'.</p>
            <p><a href="tel:'.$details['store_phone'].'">'.$details['store_phone'].'</a></p>
</div>
<p>&nbsp;</p>
    ';
}
