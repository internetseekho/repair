<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

if(isset($post['submit_quote'])) {

	$valid_csrf_token = verifyFormToken('get_quote');
	if($valid_csrf_token!='1') {
		writeHackLog('get_quote');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	if(($home_instant_repair_quote == "b_d_m" && $post['quote_make']!="" && $post['quote_device']!="" && $post['quote_model']!="") || ($home_instant_repair_quote == "d_m" && $post['quote_device']!="" && $post['quote_model']!="")) {
		setRedirect($post['quote_model']);
	} else {
		$msg='Something went wrong! Please try again';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}
?>
