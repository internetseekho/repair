<?php 
$file_name="appointments";

//Header section
require_once("include/header.php");

//$lcn_query=mysqli_query($db,"SELECT * FROM locations ORDER BY id ASC");

$mysql_q = "";

/*
if($post['filter_by_location']) {
	$mysql_q = " AND location_id='".$post['filter_by_location']."'";
}*/

/*if($_REQUEST['user_id']) {
	$mysql_q = " AND user_id='".$_REQUEST['user_id']."'";
}*/

//Search by Appt. ID, Name, Email, Phone
if($post['filter_by']) {
	$mysql_q = " AND (a.appt_id LIKE '%".real_escape_string($post['filter_by'])."%' OR a.email LIKE '%".real_escape_string($post['filter_by'])."%'  OR a.name LIKE '%".real_escape_string($post['filter_by'])."%' OR a.phone LIKE '%".real_escape_string($post['filter_by'])."%')";
}

$appt_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_appointments, ca.contractor_id, ca.appt_id, ca.amount as c_amount, a.id, l.name AS location_name, u.name AS customer_name FROM contractor_appt AS ca LEFT JOIN appointments AS a ON a.appt_id=ca.appt_id LEFT JOIN locations AS l ON l.id=a.location_id LEFT JOIN users AS u ON u.id=a.user_id WHERE ca.contractor_id='".$admin_l_id."' AND ca.contractor_id>0 ".$mysql_q."");
$appt_p_data = mysqli_fetch_assoc($appt_p_query);
$pages->set_total($appt_p_data['num_of_appointments']);

//Fetch list of appointments submitted form
$query=mysqli_query($db,"SELECT ca.contractor_id, ca.appt_id, ca.amount as c_amount, a.*, l.name AS location_name, u.name AS customer_name FROM contractor_appt AS ca LEFT JOIN appointments AS a ON a.appt_id=ca.appt_id LEFT JOIN locations AS l ON l.id=a.location_id LEFT JOIN users AS u ON u.id=a.user_id WHERE ca.contractor_id='".$admin_l_id."' AND ca.contractor_id>0 ".$mysql_q." ORDER BY a.id DESC ".$pages->get_limit()."");

//Template file
require_once("views/appointment.php");

//Footer section
require_once("include/footer.php"); ?>