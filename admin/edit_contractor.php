<?php 
$file_name="contractors";

//Header section
require_once("include/header.php");

$contractor_id = $post['id'];

if($contractor_id>0 && $prms_contractor_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single user data based user id
$contractor_data = get_contractor_data($contractor_id);
if(empty($contractor_data)) {
	setRedirect(ADMIN_URL.'contractors.php');
	exit();
}

//Template file
require_once("views/contractor/edit_contractor.php");

//Footer section
include("include/footer.php"); ?>
