<?php 
$file_name="contact";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM contact ORDER BY id DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($contact_data=mysqli_fetch_assoc($query)) {
		$contact_data['type'] = ucfirst($contact_data['type']);
		$contact_data['date'] = format_date($contact_data['date']).' '.format_time($contact_data['date']);
		$contact_data['message'] = base64_encode($contact_data['message']);
		$data_list[] = $contact_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/contact.php");

//Footer section
require_once("include/footer.php"); ?>