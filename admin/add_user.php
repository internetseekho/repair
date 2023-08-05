<?php 
$file_name="users";

//Header section
require_once("include/header.php");

if($prms_customer_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Template file
require_once("views/user/add_user.php");

//Footer section
include("include/footer.php"); ?>
