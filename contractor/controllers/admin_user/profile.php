<?php 
require_once("../../_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
require_once("../common.php");

if(isset($post['update'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zip_code=real_escape_string($post['zip_code']);
	$company_name=real_escape_string($post['company_name']);
	$password=real_escape_string($post['password']);
	if($password!=""){
		$update_password = ",password = '".md5($password)."'";
	}
	
	$contractor_q=mysqli_query($db,"SELECT * FROM contractors WHERE email='".$email."' AND id!='".$post['id']."'");
	$contractor_data=mysqli_fetch_assoc($contractor_q);
	if(!empty($contractor_data)) {
		$msg='This email address already used so please use different email address.';
		$_SESSION['error_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'profile.php');
		exit();
	}
	
	$contractor_q=mysqli_query($db,"SELECT * FROM contractors WHERE phone='".$phone."' AND id!='".$post['id']."'");
	$contractor_data=mysqli_fetch_assoc($contractor_q);
	if(!empty($contractor_data)) {
		$msg='This phone already used so please use different phone.';
		$_SESSION['error_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'profile.php');
		exit();
	}
		
	$query=mysqli_query($db,"UPDATE contractors SET name='".$name."',email='".$email."',phone='".$phone."',country='".$country."',state='".$state."',city='".$city."',zip_code='".$zip_code."',company_name='".$company_name."'".$update_password." WHERE id='".$post['id']."'");
	if($query=="1"){
		$msg="Your profile has been successfully updated.";
		$_SESSION['contractor_username']=$name;
		$_SESSION['success_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'profile.php');
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'profile.php');
	}
} else {
	setRedirect(CONTRACTOR_URL.'profile.php');
}
exit(); ?>