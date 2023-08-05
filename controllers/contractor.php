<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

if(isset($post['submit_form'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zip_code=real_escape_string($post['zip_code']);
	$company_name=real_escape_string($post['company_name']);
	$password=real_escape_string($post['password']);
	
	$valid_csrf_token = verifyFormToken('contractor');
	if($valid_csrf_token!='1') {
		writeHackLog('contractor');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	if($contractor_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	//if($name && $state && $email && $city && $zip_code && $company_name) {
	if($name && $email && $phone && $company_name) {
	
		$contractor_q=mysqli_query($db,"SELECT * FROM contractors WHERE email='".$email."'");
		$contractor_data=mysqli_fetch_assoc($contractor_q);
		if(!empty($contractor_data)) {
			$msg='Email address already used. Sign-in to contractor panel or try another email.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
		
		$contractor_q=mysqli_query($db,"SELECT * FROM contractors WHERE phone='".$phone."'");
		$contractor_data=mysqli_fetch_assoc($contractor_q);
		if(!empty($contractor_data)) {
			$msg='Phone already used. Sign-in to contractor panel or try another phone.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
		
		$query=mysqli_query($db,"INSERT INTO contractors(name, email, phone, country, state, city, zip_code, company_name, password, date) VALUES('".$name."','".$email."','".$phone."','".$country."','".$state."','".$city."','".$zip_code."','".$company_name."','".md5($password)."','".date('Y-m-d H:i:s')."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('contractor_form_alert');
			$template_data_to_customer = get_template_data('contractor_thank_you_email_to_customer');

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
				'{$customer_email}',
				'{$customer_phone}',
				'{$country}',
				'{$state}',
				'{$city}',
				'{$zip_code}',
				'{$company_name}',
				'{$devices}',
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
				$post['email'],
				$post['phone'],
				$post['country'],
				$post['state'],
				$post['city'],
				$post['zip_code'],
				$post['company_name'],
				$imp_devices,
				$post['content']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			//START email send to customer
			if(!empty($template_data_to_customer)) {
				$email_subject = str_replace($patterns,$replacements,$template_data_to_customer['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data_to_customer['content']);
				send_email($post['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			} //END email send to customer

			//$msg="Thank you contacting us for contractor. We'll contact you shortly.";
			$url = SITE_URL.'contractor-form-thank-you';
			setRedirect($url);
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