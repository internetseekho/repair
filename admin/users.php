<?php 
$file_name="users";

//Header section
require_once("include/header.php");

//Filter by users based on username, email, name, first name, last name & phone
$filter_by = "";
if($post['filter_by']) {
	$filter_by = " AND (username LIKE '%".real_escape_string($post['filter_by'])."' OR email LIKE '%".real_escape_string($post['filter_by'])."'  OR name LIKE '%".real_escape_string($post['filter_by'])."' OR first_name LIKE '%".real_escape_string($post['filter_by'])."' OR last_name LIKE '%".real_escape_string($post['filter_by'])."' OR phone LIKE '%".real_escape_string($post['filter_by'])."')";
}

if($post['status']!='') {
	$filter_by .= " AND status='".$post['status']."'";
}

$data_list = array();
$user_query=mysqli_query($db,"SELECT * FROM users WHERE 1 ".$filter_by." ORDER BY id DESC");
$num_rows = mysqli_num_rows($user_query);
if($num_rows>0) {
	while($user_data=mysqli_fetch_assoc($user_query)) {
		
		$appt_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_appointments FROM appointments WHERE email='".$user_data['email']."'");
		$appt_data = mysqli_fetch_assoc($appt_query);
		$num_of_appointments = intval($appt_data['num_of_appointments']);
						
		$date = format_date($user_data['date']);
		$data_list[] = array('id'=>$user_data['id'],'name'=>$user_data['name'],'first_name'=>$user_data['first_name'],'last_name'=>$user_data['last_name'],'email'=>$user_data['email'],'phone'=>$user_data['phone'],'address'=>$user_data['address'],'city'=>$user_data['city'],'state'=>$user_data['state'],'country'=>$user_data['country'],'postcode'=>$user_data['postcode'],'date'=>$date,'status'=>$user_data['status'],'remarks'=>base64_encode($user_data['remarks']),'num_of_appointments'=>$num_of_appointments);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/user/users.php");

//Footer section
include("include/footer.php"); ?>
