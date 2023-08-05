<?php 
$file_name="appointment_status";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM appointments_status ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($status_data=mysqli_fetch_assoc($query)) {
		$data_list[] = $status_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/status/appointment_status.php");

//Footer section
require_once("include/footer.php"); ?>
