<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

if(isset($post['submit_form'])) {
	$mode=real_escape_string($post['mode']);
	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$email=real_escape_string($post['email']);
	$order_id=real_escape_string($post['order_id']);
	$subject=real_escape_string($post['subject']);
	$message=real_escape_string($post['message']);

	$valid_csrf_token = verifyFormToken($mode);
	if($valid_csrf_token!='1') {
		writeHackLog($mode);
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	if($contact_form_captcha == '1' && $mode!="home_page") {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}

	if($name && $phone && $email && (($mode!="home_page" && $subject) || $mode=="home_page")) {
		if($order_id) {
			$order_data = get_order_data($order_id);
			if(empty($order_data)) {
				$msg='This order number is not exist in our system so please enter correct order number.';
				setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			}
		}

		$query=mysqli_query($db,"INSERT INTO contact(name, phone, email, order_id, subject, message, date, type) VALUES('".$name."','".$phone."','".$email."','".$order_id."','".$subject."','".$message."','".date('Y-m-d H:i:s')."', 'contact')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('contact_form_alert');
			
			//Get admin user data
			$admin_user_data = get_admin_user_data();
			
			$patterns = array(
				'{$logo}',
				'{$admin_logo}',
				'{$admin_email}',
				'{$admin_username}',
				'{$admin_site_url}',
				'{$admin_panel_name}',
				'{$from_name}',
				'{$from_email}',
				'{$site_name}',
				'{$site_url}',
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$order_id}',
				'{$form_subject}',
				'{$form_message}');

			$replacements = array(
				$logo,
				$admin_logo,
				$admin_user_data['email'],
				$admin_user_data['username'],
				ADMIN_URL,
				$general_setting_data['admin_panel_name'],
				$general_setting_data['from_name'],
				$general_setting_data['from_email'],
				$general_setting_data['site_name'],
				SITE_URL,
				$post['name'],
				$phone,
				$post['email'],
				($order_data['order_id']?$order_data['order_id']:'No Data'),
				$post['subject'],
				$post['message']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			$msg="Thank you for contacting us. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='Please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>