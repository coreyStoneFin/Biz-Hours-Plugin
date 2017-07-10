<?php
$states     = array(
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
$labelClass = "";
$inputClass = "";
?>
<div class="wrap">
    <h2>Add Location</h2>
    <form method="post" action="admin-post.php">
        <input type="hidden" name="action" value="wp_locations_save"/>
        <fieldset>
            <table class="form-table">
                <tbody>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="name">Location Name: <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input type="text" name="name" value="" placeholder="Dr. Muffin's Residence"/>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="address1">Address: <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input type="text" name="address1" value="" placeholder="123 Drury Lane"/>
                    </td>
                </tr>
                <tr class="form-field">
                    <th scope="row">
                        <label for="address2">Address2:</label>
                    </th>
                    <td>
                        <input type="text" name="address2" value="" placeholder=""/>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="city">City:</label>
                    </th>
                    <td>
                        <input type="text" name="city" value="" placeholder="Lincoln"/>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="province">State:<span class="description">(required)</span></label>
                    </th>
                    <td>
                        <select name="province">
                            <optgroup label="Please Select"></optgroup>
							<?php
							foreach ( $states as $key => $value ) {
								echo '<option value="' . $value . '">' . $value . '</option>';
							}
							?>
                        </select>
                    </td>
                </tr>
                <tr class="form-field">
                    <th scope="row">
                        <label for="country">Country:</label>
                    </th>
                    <td>
                        <input type="text" name="country" value="United States"/>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="postalCode">Postal Code: <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input type="text" name="postalCode" value="" placeholder="68508"/>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="name">Location Name: <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input type="text" name="name" value="" placeholder="Dr. Muffin's Residence"/>
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row">
                        <label for="name">Location Name: <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input type="text" name="name" value="" placeholder="Dr. Muffin's Residence"/>
                    </td>
                </tr>

                <label for="blah"> </label>
                <span name="blah"><i>Find Place ID at <a href="https://developers.google.com/places/place-id">this</a> location</i></span>
                </br>
                <button value="Save Location" type="submit">Save Location</button>
                </tbody>
            </table>
        </fieldset>
    </form>
</div>