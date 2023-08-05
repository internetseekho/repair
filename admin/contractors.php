<?php 
$file_name="contractors";

//Header section
require_once("include/header.php");

//Filter by contractors based on email, name & phone
$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (email LIKE '%".real_escape_string($post['filter_by'])."%'  OR name LIKE '%".real_escape_string($post['filter_by'])."%' OR phone LIKE '%".real_escape_string($post['filter_by'])."%')";
}

if($post['status']!='') {
	$filter_by .= " AND status='".$post['status']."'";
}

$data_list = array();
$user_query=mysqli_query($db,"SELECT * FROM contractors WHERE 1 ".$filter_by." ORDER BY id DESC");
$num_rows = mysqli_num_rows($user_query);
if($num_rows>0) {
	while($contractor_data=mysqli_fetch_assoc($user_query)) {
		$date = format_date($contractor_data['date']);
		$data_list[] = array('id'=>$contractor_data['id'],'name'=>$contractor_data['name'],'email'=>$contractor_data['email'],'phone'=>$contractor_data['phone'],'company_name'=>$contractor_data['company_name'],'date'=>$date,'status'=>$contractor_data['status']);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/contractor/contractors.php");

//Footer section
include("include/footer.php"); ?>
