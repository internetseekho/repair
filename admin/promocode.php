<?php 
$file_name="promocode";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM promocode ORDER BY to_date ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($promocode_data=mysqli_fetch_assoc($query)) {
		$promocode_data['from_date'] = format_date($promocode_data['from_date']);//date("m/d/Y",strtotime($promocode_data['from_date']));
		$promocode_data['to_date'] = format_date($promocode_data['to_date']);//date("m/d/Y",strtotime($promocode_data['to_date']));
		$promocode_data['discount'] = ($promocode_data['discount_type']=="percentage"?$promocode_data['discount'].'%':amount_fomat($promocode_data['discount']));
		$promocode_data['description'] = '';
		$data_list[] = $promocode_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/promocode/promocode.php");

//Footer section
include("include/footer.php"); ?>
