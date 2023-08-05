<?php 
$file_name="location";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM locations ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($location_data=mysqli_fetch_assoc($query)) {
		$location_data['google_cal_auth_info'] = '';
		$location_data['address'] = base64_encode($location_data['address']);
		$location_data['start_time'] = '';
		$location_data['end_time'] = '';
		$location_data['time_interval'] = '';
		$location_data['is_google_cal_auth'] = '';
		$location_data['google_cal_api'] = '';
		$location_data['allowed_num_of_booking_per_time_slot'] = '';
		$location_data['num_of_booking_per_time_slot'] = '';
		$location_data['status'] = $location_data['published'];
		$data_list[] = $location_data;
	}
}

$json_data_list = json_encode($data_list);

//Template file
require_once("views/location/location.php");

//Footer section
require_once("include/footer.php"); ?>
