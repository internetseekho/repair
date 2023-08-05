<?php 
$file_name="bulk_order";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM bulk_order_form ORDER BY id DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($bulk_order_data=mysqli_fetch_assoc($query)) {
		$bulk_order_data['date'] = format_date($bulk_order_data['date']).' '.format_time($bulk_order_data['date']);
		$data_list[] = $bulk_order_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/bulk_order.php");

//Footer section
require_once("include/footer.php"); ?>