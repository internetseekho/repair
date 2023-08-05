<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$login_link = SITE_URL.get_inbuild_page_url('login');
if(isset($post['submit_form'])) {
	if($post['first_name'] && $post['email'] && $post['phone']) {
		$email = real_escape_string($post['email']);
		$phone = preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
		$password = md5($post['password']);
		$name = real_escape_string($post['first_name']).' '.real_escape_string($post['last_name']);
		
		$valid_csrf_token = verifyFormToken('signup');
		if($valid_csrf_token!='1') {
			writeHackLog('signup');
			$msg = "Invalid Token";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	
		if($signup_form_captcha == '1') {
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
			$response = json_decode($response, true);
			if($response["success"] !== true) {
				$msg = "Invalid captcha";
				setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			}
		}

		$user_email_q=mysqli_query($db,'SELECT * FROM users WHERE email="'.$post['email'].'"');
		$user_email_data=mysqli_fetch_assoc($user_email_q);
		
		$user_phone_q=mysqli_query($db,'SELECT * FROM users WHERE phone="'.$phone.'"');
		$user_phone_data=mysqli_fetch_assoc($user_phone_q);
		
		//$user_id = $user_email_data['id'];
		//if(!empty($user_email_data) && $user_email_data['status']=='1') {
		if(!empty($user_email_data)) {
			$msg='Email address already used. Sign-in or try another email.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
		if(!empty($user_phone_data)) {
			$msg='Phone already used. Sign-in or try another phone.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}

		$random_number = mt_rand(100000, 999999);
		$verification_type = "none";
		$verification_code = "";
		$is_verification = false;
		$status = 1;
		/*if($general_setting_data['verification']=="email" || $general_setting_data['verification']=="sms") {
			$verification_type = $general_setting_data['verification'];
			$verification_code = $random_number;
			$is_verification = true;
			$status = 0;
		}*/
		
		if($signup_activation_by_admin == '1') {
			$status = 0;
		}

		//if(!empty($get_userdata_row) && $get_userdata_row['status']=='0') {
		/*if(!empty($user_email_data)) {
			$query=mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".real_escape_string($post['first_name'])."',`last_name`='".real_escape_string($post['last_name'])."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',`postcode`='".real_escape_string($post['postcode'])."',`username`='".$email."',password='".$password."',status='".$status."',`update_date`='".date('Y-m-d H:i:s')."',`verification_type`='".$verification_type."',`verification_code`='".$verification_code."' WHERE id='".$user_id."'");
			if($is_verification) {				
				$user_data = get_user_data($user_id);

				$template_data_for_email = get_template_data('signup_verification_for_email');
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
					'{$customer_fname}',
					'{$customer_lname}',
					'{$customer_fullname}',
					'{$customer_phone}',
					'{$customer_email}',
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$current_date_time}',
					'{$verification_code}',
					'{$verification_link}',
					'{$admin_phone}');

				$verification_link = SITE_URL.'verify_account/'.md5($user_id);
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
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					date('Y-m-d H:i'),
					$verification_code,
					$verification_link,
					$admin_user_data['phone']);

				//START email send to customer
				if(!empty($template_data_for_email) && $verification_type=="email") {
					$email_subject = str_replace($patterns,$replacements,$template_data_for_email['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data_for_email['content']);

					send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				} //END email send to customer

				//START sms send to customer
				if(!empty($template_data_for_email) && $verification_type=="sms" && $sms_sending_status=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$phone;
					if($from_number && $account_sid && $auth_token) {
						$sms_body_text = str_replace($patterns,$replacements,$template_data_for_email['sms_content']);
						
						try {
							$sms_api->messages->create(
								$to_number,
								array(
									'from' => $from_number,
									'body' => $sms_body_text
								)
							);
						} catch(Services_Twilio_RestException $e) {
							$sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}
					}
				} //END sms send to customer

				setRedirect(SITE_URL.'verify_account/'.md5($user_id));
			} else {
				setRedirect($login_link);
			}
			exit();
		} else {*/
			$query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, `email`, `address`, `address2`, `city`, `state`, `postcode`, `username`, `password`, `status`, `date`, verification_type, verification_code) VALUES('".$name."', '".real_escape_string($post['first_name'])."','".real_escape_string($post['last_name'])."','".$phone."','".$email."','".real_escape_string($post['address'])."','".real_escape_string($post['address2'])."','".real_escape_string($post['city'])."','".real_escape_string($post['state'])."','".real_escape_string($post['postcode'])."','".$email."','".$password."','".$status."','".date('Y-m-d H:i:s')."','".$verification_type."','".$verification_code."')");
			if($query=="1") {
				$user_id = mysqli_insert_id($db);
				$user_data = get_user_data($user_id);

				$template_data = get_template_data('signup_form_alert');
				$template_data_to_customer = get_template_data('signup_thank_you_email_to_customer');
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
						'{$customer_fname}',
						'{$customer_lname}',
						'{$customer_fullname}',
						'{$customer_phone}',
						'{$customer_email}',
						'{$customer_address_line1}',
						'{$customer_address_line2}',
						'{$customer_city}',
						'{$customer_state}',
						'{$customer_country}',
						'{$customer_postcode}',
						'{$current_date_time}',
						'{$verification_code}',
						'{$verification_link}',
						'{$admin_phone}');

				$verification_link = '';
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
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					format_date(date('Y-m-d H:i:s')).' '.format_time(date('Y-m-d H:i:s')),
					$verification_code,
					$verification_link,
					$admin_user_data['phone']);

				//START email send to admin
				if(!empty($template_data)) {
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
					send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['first_name'], $post['email']);
				} //END email send to admin

				//START email send to customer
				if(!empty($template_data_to_customer)) {
					$email_subject = str_replace($patterns,$replacements,$template_data_to_customer['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data_to_customer['content']);
					send_email($post['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				} //END email send to customer
				
				if($signup_activation_by_admin == '1') {
					$msg = 'Your account successfully created, Please wait approve from administractor.';
					setRedirectWithMsg($login_link,$msg,'success');
				} else {
					$_SESSION['login_user'] = $user_data['username'];
					$_SESSION['user_id']=$user_data['id'];
					$msg = 'YOU HAVE SUCCESSFULLY LOGGED IN';
					setRedirectWithMsg(SITE_URL.'account',$msg,'success');
				}

				/*if($is_verification) {
					$user_id = mysqli_insert_id($db);
					$user_data = get_user_data($user_id);

					$template_data_for_email = get_template_data('signup_verification_for_email');

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
						'{$customer_fname}',
						'{$customer_lname}',
						'{$customer_fullname}',
						'{$customer_phone}',
						'{$customer_email}',
						'{$customer_address_line1}',
						'{$customer_address_line2}',
						'{$customer_city}',
						'{$customer_state}',
						'{$customer_country}',
						'{$customer_postcode}',
						'{$current_date_time}',
						'{$verification_code}',
						'{$verification_link}',
						'{$admin_phone}');

					$verification_link = SITE_URL.'verify_account/'.md5($user_id);
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
						$user_data['first_name'],
						$user_data['last_name'],
						$user_data['name'],
						$user_data['phone'],
						$user_data['email'],
						$user_data['address'],
						$user_data['address2'],
						$user_data['city'],
						$user_data['state'],
						$user_data['country'],
						$user_data['postcode'],
						date('Y-m-d H:i'),
						$verification_code,
						$verification_link,
						$admin_user_data['phone']);

					//START email send to customer
					if(!empty($template_data_for_email) && $verification_type=="email") {
						$email_subject = str_replace($patterns,$replacements,$template_data_for_email['subject']);
						$email_body_text = str_replace($patterns,$replacements,$template_data_for_email['content']);

						send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
					} //END email send to customer

					//START sms send to customer
					if(!empty($template_data_for_email) && $verification_type=="sms" && $sms_sending_status=='1') {
						$from_number = '+'.$general_setting_data['twilio_long_code'];
						$to_number = '+'.$phone;
						if($from_number && $account_sid && $auth_token) {
							$sms_body_text = str_replace($patterns,$replacements,$template_data_for_email['sms_content']);
							
							try {
								$sms_api->messages->create(
									$to_number,
									array(
										'from' => $from_number,
										'body' => $sms_body_text
									)
								);
							} catch(Services_Twilio_RestException $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
						}
					} //END sms send to customer

					setRedirect(SITE_URL.'verify_account/'.md5($user_id));
				} else {
					setRedirect($login_link);
				}*/
				exit();
			}
		//}
	} else {
		$msg='Please fill mandatory fields';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>
