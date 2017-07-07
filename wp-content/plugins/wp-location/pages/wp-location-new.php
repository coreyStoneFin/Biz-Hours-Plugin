<?php
$states   = array(
	"Alabama",
	"Alaska",
	"Arizona",
	"Arkansas",
	"California",
	"Colorado",
	"Connecticut",
	"Delaware",
	"Florida",
	"Georgia",
	"Hawaii",
	"Idaho",
	"Illinois",
	"Indiana",
	"Iowa",
	"Kansas",
	"Kentucky",
	"Louisiana",
	"Maine",
	"Maryland",
	"Massachusetts",
	"Michigan",
	"Minnesota",
	"Mississippi",
	"Missouri",
	"Montana",
	"Nebraska",
	"Nevada",
	"New Hampshire",
	"New Jersey",
	"New Mexico",
	"New York",
	"North Carolina",
	"North Dakota",
	"Ohio",
	"Oklahoma",
	"Oregon",
	"Pennsylvania",
	"Rhode Island",
	"South Carolina",
	"South Dakota",
	"Tennessee",
	"Texas",
	"Utah",
	"Vermont",
	"Virginia",
	"Washington",
	"West Virginia",
	"Wisconsin",
	"Wyoming"
);
$style="style=''";
?>
<div class="wrap">
    <h2>Add Location</h2>
    <form method="post" action="admin-post.php">
        <input type="hidden" name="action" value="wp_locations_save" />
        <fieldset>
            <legend>Address</legend>
            <label for="name" <?php echo $style; ?>> Address Name:</label>
            <input type="text" name="name" value="" />
            </br>
            <legend>Address</legend>
            <label for="address1" <?php echo $style; ?>> Address Line:</label>
            <input type="text" name="address1" value="" />
            </br>

            <label for="address2" <?php echo $style; ?>> Address Line 2:</label>
            <input type="text" name="address2" value="" />
           </br>

            <label for="city" <?php echo $style; ?>>City:</label>
            <input type="text" name="city" value="" />
            </br>

            <label for="province" <?php echo $style; ?>>State:</label>
            <select name="province">
                <optgroup label="Please Select"></optgroup >
                <?php
                foreach ( $states as $key => $value ) {
                    echo '<option value="' . $value . '">' . $value . '</option>';
                }
                ?>
                </select>
            </br>

            <label for="country" <?php echo $style; ?>>Country:</label>
            <input type="text" name="country" value="United States" />
            </br>

            <label for="postalCode" <?php echo $style; ?>>Postal Code:</label>
            <input type="number" name="postalCode" value="" />
            </br>
            <label for="geometry" <?php echo $style; ?>>Longitude and Latitude for google map:</label>
            <input type="text" name="geometry" value="" placeholder="Example: 51.507622,-0.1305"/>
            </br>
            <label for="place_id" <?php echo $style; ?>>Google Place ID:</label>
            <input type="text" name="place_id" value="" title="Google Place ID"/>
            </br>
            <label for="blah" >  </label>
            <span name="blah"><i>Find Place ID at <a href="https://developers.google.com/places/place-id">this</a> location</i></span>
            </br>
        </fieldset>
    </form>
</div>