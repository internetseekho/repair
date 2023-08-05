<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$user_id = $_SESSION['user_id'];
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

if(isset($post['submit_form'])) {

	$valid_csrf_token = verifyFormToken('change_password');
	if($valid_csrf_token!='1') {
		writeHackLog('change_password');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	if($post['password']==$post['password2']) {
		$query=mysqli_query($db,"UPDATE `users` SET `password`='".md5($post['password'])."' WHERE id='".$user_id."'");
		if($query=="1") {
			unset($_SESSION['login_user']);
			unset($_SESSION['user_id']);
			$msg = 'Password has been successfully changed';
			setRedirectWithMsg($return_url,$msg,'success');
			exit();
		} else {
			$msg = 'Something went wrong!';
			setRedirectWithMsg($return_url,$msg,'danger');
			exit();
		}
	} else {
		$msg = 'New password and confirm password not matched.';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>