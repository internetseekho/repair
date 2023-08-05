<?php 
$file_name="contractors";

//Header section
require_once("include/header.php");

if($prms_contractor_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Template file
require_once("views/contractor/add_contractor.php");

//Footer section
include("include/footer.php"); ?>
