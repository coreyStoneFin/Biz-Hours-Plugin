<?php

/**
 * Created by PhpStorm.
 * User: jwesely
 * Date: 1/4/2017
 * Time: 12:13 PM
 */

class GooglePlacesAPI {
	public $apiKey = "AIzaSyDuHcLe6WbcD1qVmBfZ6OXT85XOT3oiscs";
	public $base_endpoint = "https://maps.googleapis.com/maps/api/place/details/json?";
    /**
     * Test Stuff
     */
	public $places = array('ChIJ25W8z6SVlocR-FL6WmKVcsk', 'ChIJQ6XGdyqWlocRWz36iSuQkgY');
	function Fetch_Place(){
		$json = wp_remote_get($this->base_endpoint . 'placeid='. $this->places[0] . '&key='. $this->apiKey);
		$place_object = json_decode($json['body']);
		$this->pickup_time_select_for_place($this->places[1]);
		$this->local_delivery_time_select_for_place();
		$this->show_store_status($this->places[1]);
		$this->show_store_status_all($this->places[1]);
		$this->get_condensed_store_hours($this->places[1]);
	}
    /**
     * End Test Stuff
     */
	function get_place_hours($place){
		$json = wp_remote_get($this->base_endpoint . 'placeid='. $place . '&key='. $this->apiKey);
		$place_object = json_decode($json['body']);
		if(isset($place_object->result->opening_hours)){
			$hours = $place_object->result->opening_hours;
		}

		//generate a business status (open now/ open in x time/ open on tuesday...
		//generate a list of the next few days hours
		//generate a selection list that has sutosearch? typable time?
		return false;
	}
	// Generate a select list of local pickup times
	function pickup_time_select_for_place($place){
		$available_dates = $this->generate_pickup_times_for_place($place);
//		echo '<select>';
		foreach ($available_dates as $key=> $value){
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
//		echo '</select>';
	}
	// Generate a select list of local delivery times
	function local_delivery_time_select_for_place(){
		$available_dates = $this->generate_local_delivery_times_for_place();
//		echo '<select>';
		foreach ($available_dates as $key=> $value){
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
//		echo '</select>';
	}

	//Get local delivery times
	//@param $offset is in hours
	function generate_local_delivery_times_for_place($offset = 4){
		$the_date = new DateTime(date('Y-m-d H:m:s', strtotime('+'.$offset.' hours')));
		$available_dates = array();

		foreach(range(1,3) as $cnt){
			$date = date('l F d, Y', strtotime('+'.$cnt.' Monday', $the_date->getTimestamp())) . ' 10 am to 12 pm';
			$key = date('l Y-m-d', strtotime('+'.$cnt.' Monday', $the_date->getTimestamp())) . ' 10am to 12pm';
			$available_dates[$key] = $date;
		}
		return $available_dates;
	}
	function generate_pickup_times_for_place($place){
		$json = wp_remote_get($this->base_endpoint . 'placeid='. $place . '&key='. $this->apiKey);
		$place_object = json_decode($json['body']);

		//array for converting google day to letter day
		$days = array(
			'Sun' => 0 ,
			'Mon' => 1 ,
			'Tue' => 2 ,
			'Wed' => 3 ,
			'Thu' => 4 ,
			'Fri' => 5 ,
			'Sat' => 6
		);
		$date_list = array();
		foreach(range (0,6)as $cnt){
			$a_day = new DateTime(date('Y-m-d', strtotime( "today +".$cnt." day")), new DateTimeZone('America/Chicago'));
			$date_list[] = clone $a_day;

		}
		$current_time = new DateTime("now");
		$current_time->setTimezone(new DateTimeZone('America/Chicago'));
		$available_dates = array();
		$available_dates['asap'] = "As Soon As Possible";
		if(isset($place_object->result->opening_hours)){
			//generate a list of pickup times based on place hours

			$hours = $place_object->result->opening_hours;
			foreach( $date_list as $key => $date){
				$start_time = clone $date;
				$start_time->setTimezone(new DateTimeZone('America/Chicago'));
				$s_time_in_hhmm = $hours->periods[$days[date('D')]]->open->time;
				$start_time->setTime(substr($s_time_in_hhmm, 0, 2),substr($s_time_in_hhmm, 2, 2));

				$end_time = clone $date;
				$end_time->setTimezone(new DateTimeZone('America/Chicago'));
				$e_time_in_hhmm = $hours->periods[$days[date('D')]]->close->time;
				$end_time->setTime(substr($e_time_in_hhmm, 0, 2),substr($e_time_in_hhmm, 2, 2));
				if(($start_time < $current_time) && ($current_time < $end_time)){
					$start_time = clone $current_time;
					$start_time = $this->roundupMinutesFromDatetime($start_time, 15);
				}

				$available_dates = array_merge($available_dates, $this->generate_pickup_times_for_range($start_time, $end_time, $current_time));
//				$start_time = new DateTime('');
//				array_merge($available_dates, $this->generate_pickup_times_for_range());
			}

		}
		return $available_dates;
	}

	function generate_pickup_times_for_range($start_time, $end_time, $current_time){

		//format times dd/mm/yy:0000
		$pickup_times = array();
		$interval = new DateInterval('PT15M');
		$dateRange = new DatePeriod($start_time, $interval, $end_time);
		foreach ($dateRange as $date){
//			echo (date('Y-m-d', $date->getTimestamp()) === date('Y-m-d', $current_time->getTimestamp())) ?  $date->format('\T\o\d\a\y F d, Y \a\t G:i a T') . "<br>" : $date->format('l F d, Y \a\t G:i a T'). "<br>";
			$pickup_times[$date->format("Y-m-d h:i a T")] = ($date->format('Y-m-d') === $current_time->format('Y-m-d')) ?  $date->format('\T\o\d\a\y F d, Y \a\t h:i a') : $date->format('l F d, Y \a\t h:i a');
		}
		return $pickup_times;
	}

	public function roundupMinutesFromDatetime(\Datetime $date, $minuteOff = 10)
	{
		$string = sprintf(
			"%d minutes %d seconds",
			$date->format("i") % $minuteOff,
			$date->format("s")
		);

		$date->sub(\DateInterval::createFromDateString($string));
		return $date->add(new DateInterval('PT'.$minuteOff.'M'));
	}

	//given a place id return a nice little div with todays hours and possibly the open now
	function show_store_status($place){
		$day_conversion_table = array(
			0 => 5,
			1 => 0,
			2 => 1,
			3 => 2,
			4 => 3,
			5 => 4,
			6 => 6
		); // because googlePlaces API doesn't understand how to make things the same...
		$current_time = new DateTime("now");
		$current_time->setTimezone(new DateTimeZone('America/Chicago'));
		$json = wp_remote_get($this->base_endpoint . 'placeid='. $place . '&key='. $this->apiKey);
		$place_object = json_decode($json['body']);
		$hours = $place_object->result->opening_hours;
		echo "<p>Store Status: " . ($hours->open_now ? "Open" : "Closed") . "</p><p>". $hours->weekday_text[$day_conversion_table[date('w', $current_time->getTimestamp())]] ."</p>";
	}
	function show_store_status_all($place){
		$current_time = new DateTime("now");
		$current_time->setTimezone(new DateTimeZone('America/Chicago'));
		$json = wp_remote_get($this->base_endpoint . 'placeid='. $place . '&key='. $this->apiKey);
		$place_object = json_decode($json['body']);
		$hours = $place_object->result->opening_hours;
		echo "<div class='sf-google-place-hours-container'>";
		echo "<p>Store Status: " . ($hours->open_now ? "Open" : "Closed") . "</p>";
		echo "<table class='sf-google-place-hours-table'>";
		foreach ($hours->weekday_text as $key => $value){
			echo "<tr><td>". $value ."</td></tr>";
		}
		echo "</table>";
		echo "</div>";
	}

	function get_condensed_store_hours($place)
	{

		$day_conversion_table = array(
			0 => "Sun",
			1 => "Mon",
			2 => "Tue",
			3 => "Wed",
			4 => "Thu",
			5 => "Fri",
			6 => "Sat"
		);

		// Get the current time and make it this timezone
		$current_time = new DateTime("now");
		$current_time->setTimezone(new DateTimeZone('America/Chicago'));

		// Fetch business hours from Google Places API using given $place id
		$json = wp_remote_get($this->base_endpoint . 'placeid='. $place . '&key='. $this->apiKey);
		$place_object = json_decode($json['body']);
		$hours = $place_object->result->opening_hours;


		$days_to_hours = array();

		foreach ($hours->periods as $day => $business_hours)
		{
			foreach ($business_hours as $type => $info)
			{
				$days_to_hours[$info->day][$type] = $info->time;
			}
		}

		$timespans_to_days = array();

		foreach ($days_to_hours as $day => $times)
		{
			$matched = false;

			foreach ($timespans_to_days as $groupID => $grouping)
			{
				if($this->sameSpan($grouping, $times))
				{
					$timespans_to_days[$groupID]['days'][] = $day;
					$matched = true;

					break;
				}
			}

			if(!$matched){
				$new = $times;
				$new['days'][] = $day;
				$timespans_to_days[] = $new;

			}
		}

		$day_to_group = array();

		foreach ( $timespans_to_days as $groupingID => $group )
		{
			foreach ( $group['days'] as $key => $day)
			{
				$day_to_group[$day] = $groupingID;
			}
		}

		echo "<table>";
		$start_day = false;
		$end_day = false;
		$groupingID = false;
		$arraySize = sizeof($day_to_group);
		$separate_sunday = false;
		for ( $i = 1 ; $i < $arraySize; $i++)
		{
			if(!$start_day)
			{
				$start_day = $i;
				$groupingID = $day_to_group[$start_day];
			}

			if($i+1 != $arraySize)
			{
				if($day_to_group[$i+1] != $groupingID){
					$end_day = $i;
				}
			}
			else
			{
				if($day_to_group[0] != $groupingID)
				{
					$end_day = $i;
					$separate_sunday = true;
				}
				else
				{
					$end_day = 0;
				}
			}

			if($end_day)
			{
				// Print the sections
				$time_string = date("g:i A", strtotime($timespans_to_days[$groupingID]['open'])) . " - " .date("g:i A", strtotime($timespans_to_days[$groupingID]['close']));
				if($start_day == $end_day)
				{
					$date_string = $day_conversion_table[$start_day] . ": " . $time_string;
				}
				else
				{
					$date_string = $day_conversion_table[$start_day] . "-" . $day_conversion_table[$end_day] . ": " .$time_string;
				}

				echo "<tr><td>$date_string</td></tr>";

				if($separate_sunday)
				{
					$sundayGroupID = $day_to_group[0];
					$sunday_time_string = date("g:i A", strtotime($timespans_to_days[$sundayGroupID]['open'])) . " - " .date("g:i A", strtotime($timespans_to_days[$sundayGroupID]['close']));
					$date_string = $day_conversion_table[0] . ": " . $sunday_time_string;
					echo "<tr><td>$date_string</td></tr>";
				}

				// Reset variables
				$start_day = false;
				$end_day = false;
				$groupingID = false;
			}
		}

		echo "</table>";

		return false;
	}

	function sameSpan($span1, $span2){
		return (($span1['close'] === $span2['close']) && ($span1['open'] === $span2['open']));
	}

}

