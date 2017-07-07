<?php
/**
 * Created by PhpStorm.
 * User: cwesely
 * Date: 6/7/2017
 * Time: 3:01 PM
 */
?>
<script>function initMap() {
    var map = new google.maps.Map(document.getElementById(\'map\'), {
        center: {lat: -33.866, lng: 151.196},
        zoom: 15
    });

    var infowindow = new google.maps.InfoWindow();
    var service = new google.maps.places.PlacesService(map);

    service.getDetails({
        placeId: \'ChIJN1t_tDeuEmsRUsoyG83frY4\'
    }, function(place, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });
            google.maps.event.addListener(marker, \'click\', function() {
                infowindow.setContent(\'<div><strong>\' + place.name + \'</strong><br>\' +
                    \'Place ID: \' + place.place_id + \'<br>\' +
                    place.formatted_address + \'</div>\');
                infowindow.open(map, this);
            });
        }
    });
}
    var customLabel = {
        restaurant: {
            label: 'R'
        },
        bar: {
            label: 'B'
        }
    }



    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}</script>
<div id="map" style="height:auto;width:auto"></div>
<!-- Replace the value of the key parameter with your own API key. -->
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD04tdJ0qehxqOzXsKp_Z8j7GUarzi5--0cs&libraries=places&callback=initMap">
</script>