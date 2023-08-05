<?php 
$file_name="affiliate";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM affiliate ORDER BY id DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($affiliate_data=mysqli_fetch_assoc($query)) {
		$affiliate_data['date'] = format_date($affiliate_data['date']).' '.format_time($affiliate_data['date']);
		$data_list[] = $affiliate_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/affiliate.php");

//Footer section
require_once("include/footer.php"); ?>