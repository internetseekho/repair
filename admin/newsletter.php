<?php 
$file_name="newsletter";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM newsletters ORDER BY id DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($newsletter_data=mysqli_fetch_assoc($query)) {
		$newsletter_data['date'] = format_date($newsletter_data['date']).' '.format_time($newsletter_data['date']);
		$data_list[] = $newsletter_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/newsletter.php");

//Footer section
require_once("include/footer.php"); ?>