<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM contractors WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		$msg="User successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'contractors.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM contractors WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." User(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "User successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'contractors.php');
	exit();
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE contractors SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['status']==1) {
			$msg="Successfully approved.";
			
			$contractor_data = get_contractor_data($post['p_id']);
			if($contractor_data['status'] == '1') {
				$template_data = get_template_data('contractor_approve_email_to_customer');
				$general_setting_data = get_general_setting_data();
				$admin_user_data = get_admin_user_data();

				$contractor_link = SITE_URL.'contractor';
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
					'{$customer_password}',
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$customer_status}',
					'{$current_date_time}',
					'{$contractor_link}');
		
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
					$contractor_data['first_name'],
					$contractor_data['last_name'],
					$contractor_data['name'],
					$contractor_data['phone'],
					$contractor_data['email'],
					($post['password']?$post['password']:'Not Updated'),
					$contractor_data['address'],
					$contractor_data['address2'],
					$contractor_data['city'],
					$contractor_data['state'],
					$contractor_data['country'],
					$contractor_data['postcode'],
					($post['status']=='1'?'Active':'Inactive'),
					format_date(date('Y-m-d H:i:s')).' '.format_time(date('Y-m-d H:i:s')),
					$contractor_link);
				
				if(!empty($template_data)) {
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
					send_email($contractor_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
					
					$msg="Successfully approved and email alert send to contractor";
				}
			}
		} elseif($post['status']==0) {
			$msg="Successfully Unpublished.";
		}
		
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'contractors.php');
} elseif(isset($post['update'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['phone']);
	$password=real_escape_string($post['password']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zip_code=real_escape_string($post['zip_code']);
	$company_name=real_escape_string($post['company_name']);
	if($password) {
		$password = ",`password`='".md5($password)."'";
	}
	
	if($post['id']) {
		$contractor_q=mysqli_query($db,'SELECT * FROM contractors WHERE email="'.$email.'" AND id!="'.$post['id'].'"');
		$exist_contractor_data=mysqli_fetch_assoc($contractor_q);
		if(!empty($exist_contractor_data)) {
			$msg='This email address already used so please use different email address.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_contractor.php?id='.$post['id']);
			exit();
		}
		
		$contractor_q=mysqli_query($db,'SELECT * FROM contractors WHERE phone="'.$phone.'" AND id!="'.$post['id'].'"');
		$exist_contractor_data=mysqli_fetch_assoc($contractor_q);
		if(!empty($exist_contractor_data)) {
			$msg='This phone already used so please use different phone.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_contractor.php?id='.$post['id']);
			exit();
		}
		
		$contractor_q=mysqli_query($db,'SELECT * FROM contractors WHERE id="'.$post['id'].'"');
		$contractor_data=mysqli_fetch_assoc($contractor_q);

		$query=mysqli_query($db,"UPDATE `contractors` SET `name`='".$name."',`phone`='".$phone."',`email`='".$post['email']."',`country`='".$country."',`city`='".$post['city']."',`state`='".$post['state']."',`zip_code`='".$post['zip_code']."',`company_name`='".$post['company_name']."',`update_date`='".date('Y-m-d H:i:s')."',`status`='".$post['status']."'".$password." WHERE id='".$post['id']."'");
		if($query=="1") {
			if($contractor_data['status'] != '1' && $post['status'] == '1') {
				$template_data = get_template_data('contractor_approve_email_to_customer');
				$general_setting_data = get_general_setting_data();
				$admin_user_data = get_admin_user_data();
				$contractor_data = get_contractor_data($post['id']);
	
				$contractor_link = SITE_URL.'contractor';
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
					'{$customer_password}',
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$customer_status}',
					'{$current_date_time}',
					'{$contractor_link}');
		
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
					$contractor_data['first_name'],
					$contractor_data['last_name'],
					$contractor_data['name'],
					$contractor_data['phone'],
					$contractor_data['email'],
					($post['password']?$post['password']:'Not Updated'),
					$contractor_data['address'],
					$contractor_data['address2'],
					$contractor_data['city'],
					$contractor_data['state'],
					$contractor_data['country'],
					$contractor_data['postcode'],
					($post['status']=='1'?'Active':'Inactive'),
					format_date(date('Y-m-d H:i:s')).' '.format_time(date('Y-m-d H:i:s')),
					$contractor_link);
				
				if(!empty($template_data)) {
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
					send_email($contractor_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				}
			}
			
			$msg="Contractor details has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_contractor.php?id='.$post['id']);
	}
} elseif(isset($post['add'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['phone']);
	$password=real_escape_string($post['password']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zip_code=real_escape_string($post['zip_code']);
	$company_name=real_escape_string($post['company_name']);
	$password = md5($password);

	$contractor_q=mysqli_query($db,'SELECT * FROM contractors WHERE email="'.$email.'"');
	$exist_contractor_data=mysqli_fetch_assoc($contractor_q);
	if(!empty($exist_contractor_data)) {
		$msg='This email address already used so please use different email address.';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'add_contractor.php');
		exit();
	}
	
	$contractor_q=mysqli_query($db,'SELECT * FROM contractors WHERE phone="'.$phone.'"');
	$exist_contractor_data=mysqli_fetch_assoc($contractor_q);
	if(!empty($exist_contractor_data)) {
		$msg='This phone already used so please use different phone.';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'add_contractor.php');
		exit();
	}
	
	$query=mysqli_query($db,"INSERT INTO `contractors`(`name`,`phone`,`email`,`country`,`city`,`state`,`zip_code`,`company_name`,`password`,`date`,`status`) VALUES('".$name."','".$phone."','".$post['email']."','".$country."','".$city."','".$state."','".$zip_code."','".$company_name."','".$password."','".date('Y-m-d H:i:s')."','".$post['status']."')");
	if($query=="1") {
		$last_id = mysqli_insert_id($db);
		if($post['status'] == '1') {
			$template_data = get_template_data('contractor_approve_email_to_customer');
			$general_setting_data = get_general_setting_data();
			$admin_user_data = get_admin_user_data();
			$contractor_data = get_contractor_data($last_id);

			$contractor_link = SITE_URL.'contractor';
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
				'{$customer_password}',
				'{$customer_address_line1}',
				'{$customer_address_line2}',
				'{$customer_city}',
				'{$customer_state}',
				'{$customer_country}',
				'{$customer_postcode}',
				'{$customer_status}',
				'{$current_date_time}',
				'{$contractor_link}');
	
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
				$contractor_data['first_name'],
				$contractor_data['last_name'],
				$contractor_data['name'],
				$contractor_data['phone'],
				$contractor_data['email'],
				($post['password']?$post['password']:'Not Updated'),
				$contractor_data['address'],
				$contractor_data['address2'],
				$contractor_data['city'],
				$contractor_data['state'],
				$contractor_data['country'],
				$contractor_data['postcode'],
				($post['status']=='1'?'Active':'Inactive'),
				format_date(date('Y-m-d H:i:s')).' '.format_time(date('Y-m-d H:i:s')),
				$contractor_link);
			
			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($contractor_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			}
		}
		
		$msg="Contractor details has been successfully added.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong add failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'contractors.php');
} else {
	setRedirect(ADMIN_URL.'contractors.php');
}
exit(); ?>