<?php 
$file_name="device";

//Header section
require_once("include/header.php");

$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (d.title LIKE '%".real_escape_string($post['filter_by'])."%')";
}

$data_list = array();
$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE 1 ".$filter_by." ORDER BY d.id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($device_data=mysqli_fetch_assoc($query)) {
		$data_list[] = array('id'=>$device_data['id'],'title'=>$device_data['title'],'image'=>$device_data['device_img'],'ordering'=>$device_data['ordering'],'status'=>$device_data['published']);
	}
}
$json_data_list = json_encode($data_list);

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Template file
require_once("views/device/device.php");

//Footer section
include("include/footer.php"); ?>
