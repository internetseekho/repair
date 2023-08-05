<?php 
$file_name="faqs_groups";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM faqs_groups ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($faq_group_data=mysqli_fetch_assoc($query)) {
		$data_list[] = $faq_group_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/faq/faqs_groups.php");

//Footer section
require_once("include/footer.php"); ?>
