<?php
//Get location data based on locationID
function get_single_location_data($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM locations WHERE published='1' AND id='".$id."'");
	$response = mysqli_fetch_assoc($query);
	return $response;
}
?>

