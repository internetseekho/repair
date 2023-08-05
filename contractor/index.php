<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_contractor']) && $_SESSION['contractor_username']!="") {
	setRedirect(CONTRACTOR_URL.'profile.php');
	exit();
}

//Template file
require_once("views/admin_user/login.php");

//Footer section
require_once("include/login/footer.php"); ?>
