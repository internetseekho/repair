<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

$type=real_escape_string($post['req_type']);
if(isset($post['general_setting'])) {
	$q=mysqli_query($db,"SELECT * FROM general_setting ORDER BY id DESC");
	$general_setting_data=mysqli_fetch_assoc($q);
	$saved_other_settings = json_decode($general_setting_data['other_settings'],true);

	$req_other_settings = $post['other_settings'];
	if($type == "general") {
		$robots_txt=$post['robots_txt'];
		if($robots_txt!="") {
			$myfile = fopen("../../robots.txt", "w") or die("Unable to open file!");
			fwrite($myfile, $robots_txt);
			fclose($myfile);
		}
		
		$admin_panel_name=real_escape_string($post['admin_panel_name']);
		$site_name = real_escape_string($post['site_name']);
		$slogan=real_escape_string($post['slogan']);
		$website=real_escape_string($post['website']);
		$phone=real_escape_string($post['phone']);
		$email=real_escape_string($post['email']);
		$copyright=real_escape_string($post['copyright']);
		$map_key = $post['map_key'];
		$top_seller_limit=$post['top_seller_limit'];
		$promocode_section=$post['promocode_section'];
		$page_list_limit = real_escape_string($post['page_list_limit']);
		$currency=$post['currency'];
		$disp_currency=$post['disp_currency'];
		$is_space_between_currency_symbol = $post['is_space_between_currency_symbol'];
		$thousand_separator = real_escape_string($post['thousand_separator']);
		$decimal_separator = real_escape_string($post['decimal_separator']);
		$decimal_number = $post['decimal_number'];
		$is_ip_restriction = $post['is_ip_restriction'];
		$allowed_ip = $post['allowed_ip'];
		$header_service_hours_text = $post['header_service_hours_text'];
		$custom_js_code = real_escape_string($post['custom_js_code']);
		$after_body_js_code = real_escape_string($post['after_body_js_code']);
		$before_body_js_code = real_escape_string($post['before_body_js_code']);
		$time_format = $post['time_format'];
		$date_format = $post['date_format'];
		$timezone = real_escape_string($post['timezone']);
		$order_receipt_terms = real_escape_string($post['order_receipt_terms']);
		$allow_sms_verify_of_admin_staff_login = $post['allow_sms_verify_of_admin_staff_login'];

		$saved_other_settings['full_review_or_number_of_words'] = $req_other_settings['full_review_or_number_of_words'];
		$saved_other_settings['review_limited_words'] = $req_other_settings['review_limited_words'];
		$saved_other_settings['home_instant_repair_quote'] = $req_other_settings['home_instant_repair_quote'];
		$saved_other_settings['show_breadcrumbs'] = $req_other_settings['show_breadcrumbs'];

		if($req_other_settings['maintainance_mode'] == '1') {
			$saved_other_settings['maintainance_mode'] = '1';
		} else {
			$saved_other_settings['maintainance_mode'] = '0';
		}
		if($req_other_settings['contractor_concept'] == '1') {
			$saved_other_settings['contractor_concept'] = '1';
		} else {
			$saved_other_settings['contractor_concept'] = '0';
		}
		if($req_other_settings['show_missing_model_section'] == '1') {
			$saved_other_settings['show_missing_model_section'] = '1';
		} else {
			$saved_other_settings['show_missing_model_section'] = '0';
		}
		if($req_other_settings['show_missing_device_section'] == '1') {
			$saved_other_settings['show_missing_device_section'] = '1';
		} else {
			$saved_other_settings['show_missing_device_section'] = '0';
		}
		if($req_other_settings['show_missing_brand_section'] == '1') {
			$saved_other_settings['show_missing_brand_section'] = '1';
		} else {
			$saved_other_settings['show_missing_brand_section'] = '0';
		}
		if($req_other_settings['show_missing_category_section'] == '1') {
			$saved_other_settings['show_missing_category_section'] = '1';
		} else {
			$saved_other_settings['show_missing_category_section'] = '0';
		}
		
		if($req_other_settings['signup_activation_by_admin'] == '1') {
			$saved_other_settings['signup_activation_by_admin'] = '1';
		} else {
			$saved_other_settings['signup_activation_by_admin'] = '0';
		}
		if($req_other_settings['newslettter_section'] == '1') {
			$saved_other_settings['newslettter_section'] = '1';
		} else {
			$saved_other_settings['newslettter_section'] = '0';
		}
		
		if($_FILES['logo']['name']) {
			$logo_ext = pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION);
			if($logo_ext=="png" || $logo_ext=="jpg" || $logo_ext=="jpeg" || $logo_ext=="gif") {
				$logo_tmp_name=$_FILES['logo']['tmp_name'];
				$logo_name='logo.'.$logo_ext;
				$logo_update=', logo="'.$logo_name.'"';
				move_uploaded_file($logo_tmp_name,'../../images/'.$logo_name);
			} else {
				$msg="Logo type must be png, jpg, jpeg, gif";
				$_SESSION['error_msg']=$msg;
				setRedirect(ADMIN_URL."settings.php?type=".$type);
				exit();
			}
		}
		
		if($_FILES['app_logo']['name']) {
			$app_logo_ext = pathinfo($_FILES['app_logo']['name'],PATHINFO_EXTENSION);
			if($app_logo_ext=="png" || $app_logo_ext=="jpg" || $app_logo_ext=="jpeg" || $app_logo_ext=="gif") {
				$app_logo_tmp_name=$_FILES['app_logo']['tmp_name'];
				$app_logo_name='app_logo.'.$app_logo_ext;
				$app_logo_update=', app_logo="'.$app_logo_name.'"';
				move_uploaded_file($app_logo_tmp_name,'../../images/'.$app_logo_name);
			} else {
				$msg="App logo type must be png, jpg, jpeg, gif";
				$_SESSION['error_msg']=$msg;
				setRedirect(ADMIN_URL."settings.php?type=".$type);
				exit();
			}
		}
		
		if($_FILES['invoice_logo']['name']) {
			$invoice_logo_ext = pathinfo($_FILES['invoice_logo']['name'],PATHINFO_EXTENSION);
			if($invoice_logo_ext=="png" || $invoice_logo_ext=="jpg" || $invoice_logo_ext=="jpeg" || $invoice_logo_ext=="gif") {
				$invoice_logo_tmp_name=$_FILES['invoice_logo']['tmp_name'];
				$invoice_logo_name='invoice_logo.'.$invoice_logo_ext;
				$invoice_logo_update=', invoice_logo="'.$invoice_logo_name.'"';
				move_uploaded_file($invoice_logo_tmp_name,'../../images/'.$invoice_logo_name);
			} else {
				$msg="Invoice logo type must be png, jpg, jpeg, gif";
				$_SESSION['error_msg']=$msg;
				setRedirect(ADMIN_URL."settings.php?type=".$type);
				exit();
			}
		}
		
		if($_FILES['favicon_icon']['name']) {
			$favicon_icon_ext = pathinfo($_FILES['favicon_icon']['name'],PATHINFO_EXTENSION);
			if($favicon_icon_ext=="ico") {
				$favicon_icon_tmp_name=$_FILES['favicon_icon']['tmp_name'];
				$favicon_icon_name='favicon.ico';
				$favicon_icon_update=', favicon_icon="'.$favicon_icon_name.'"';
				move_uploaded_file($favicon_icon_tmp_name,'../../images/'.$favicon_icon_name);
			} else {
				$msg="Favicon type must be ico";
				$_SESSION['error_msg']=$msg;
				setRedirect(ADMIN_URL."settings.php?type=".$type);
				exit();
			}
		}
		
		if($_FILES['admin_logo']['name']) {
			$admin_logo_ext = pathinfo($_FILES['admin_logo']['name'],PATHINFO_EXTENSION);
			if($admin_logo_ext=="png" || $admin_logo_ext=="jpg" || $admin_logo_ext=="jpeg" || $admin_logo_ext=="gif") {
				$admin_logo_tmp_name=$_FILES['admin_logo']['tmp_name'];
				$admin_logo_name='admin_logo.'.$admin_logo_ext;
				$admin_logo_update=', admin_logo="'.$admin_logo_name.'"';
				move_uploaded_file($admin_logo_tmp_name,'../../images/'.$admin_logo_name);
			} else {
				$msg="Admin logo type must be png, jpg, jpeg, gif";
				$_SESSION['error_msg']=$msg;
				setRedirect(ADMIN_URL."settings.php?type=".$type);
				exit();
			}
		}

		$query=mysqli_query($db,"UPDATE general_setting SET admin_panel_name='".$admin_panel_name."' ".$logo_update." ".$app_logo_update." ".$invoice_logo_update." ".$favicon_icon_update." ".$admin_logo_update.", slogan='".$slogan."', phone='".$phone."', email='".$email."', copyright='".$copyright."', website='".$website."', currency='".$currency."', disp_currency='".$disp_currency."', payment_option='".$payment_option."', default_payment_option='".$default_payment_option."', sales_pack='".$sales_pack."', shipping_option='".$shipping_option."', terms='".$terms."', terms_status='".$terms_status."', display_terms='".$display_terms."', promocode_section='".$promocode_section."', top_seller_limit='".$top_seller_limit."', verification='".$verification."', site_name='".$site_name."', missing_product_section='".$missing_product_section."', page_list_limit='".$page_list_limit."', custom_js_code='".$custom_js_code."', after_body_js_code='".$after_body_js_code."', before_body_js_code='".$before_body_js_code."', header_service_hours_text='".$header_service_hours_text."', map_key='".$map_key."', is_space_between_currency_symbol='".$is_space_between_currency_symbol."', thousand_separator='".$thousand_separator."', decimal_separator='".$decimal_separator."', decimal_number='".$decimal_number."', is_ip_restriction='".$is_ip_restriction."', allowed_ip='".$allowed_ip."', time_format='".$time_format."', date_format='".$date_format."', timezone='".$timezone."', order_receipt_terms='".$order_receipt_terms."', allow_sms_verify_of_admin_staff_login='".$allow_sms_verify_of_admin_staff_login."'");
	} elseif($type == "appointment") {
		$order_prefix=$post['order_prefix'];
		$order_completed_prefix=$post['order_completed_prefix'];
		$appt_start_time=real_escape_string($post['appt_start_time']);
		$appt_end_time=real_escape_string($post['appt_end_time']);
		$appt_time_interval=real_escape_string($post['appt_time_interval']);
		$allowed_num_of_booking_per_time_slot=$post['allowed_num_of_booking_per_time_slot'];
		$num_of_booking_per_time_slot=$post['num_of_booking_per_time_slot'];
		$appt_week_days_block=json_encode($post['appt_week_days_block']);
		$appt_special_dates_block=$post['appt_special_dates_block'];
		$google_cal_api = $post['google_cal_api'];
		$google_calendar_client_id=$post['google_calendar_client_id'];
		$google_calendar_client_secret=$post['google_calendar_client_secret'];
		
		$saved_other_settings['location_option_bring_to_shop'] = $req_other_settings['location_option_bring_to_shop'];
		$saved_other_settings['location_option_come_for_you'] = $req_other_settings['location_option_come_for_you'];
		$saved_other_settings['location_option_ship_device'] = $req_other_settings['location_option_ship_device'];
		
		if($req_other_settings['online_booking_hide_price'] == '1') {
			$saved_other_settings['online_booking_hide_price'] = '1';
		} else {
			$saved_other_settings['online_booking_hide_price'] = '0';
		}

		$h_start_time = date("H",strtotime($appt_start_time));
		$h_end_time = date("H",strtotime($appt_end_time));
		if($appt_start_time!="" && $appt_end_time!="" && ($h_start_time>=$h_end_time)) {
			$msg="Appt. end time must me greater than Appt. start time";
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL."settings.php?type=".$type);
			exit();
		}
		
		$query=mysqli_query($db,"UPDATE general_setting SET order_prefix='".$order_prefix."', order_completed_prefix='".$order_completed_prefix."', appt_start_time='".$appt_start_time."', appt_end_time='".$appt_end_time."', appt_time_interval='".$appt_time_interval."', appt_week_days_block='".$appt_week_days_block."', appt_special_dates_block='".$appt_special_dates_block."', google_cal_api='".$google_cal_api."', allowed_num_of_booking_per_time_slot='".$allowed_num_of_booking_per_time_slot."', num_of_booking_per_time_slot='".$num_of_booking_per_time_slot."', google_calendar_client_id='".$google_calendar_client_id."', google_calendar_client_secret='".$google_calendar_client_secret."'");
	} elseif($type == "company") {
		$company_name=real_escape_string($post['company_name']);
		$company_phone=real_escape_string($post['company_phone']);
		$company_address=real_escape_string($post['company_address']);
		$company_city=real_escape_string($post['company_city']);
		$company_state=real_escape_string($post['company_state']);
		$company_country=real_escape_string($post['company_country']);
		$company_zipcode=real_escape_string($post['company_zipcode']);

		$customer_address=$company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode;
		$customer_address = str_replace(" ", "+", $customer_address);
		//$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$customer_address&sensor=false&key=".$map_key);
		$json = get_curl_data("https://maps.google.com/maps/api/geocode/json?address=$customer_address&sensor=false&key=".$map_key);
		$json = json_decode($json);
		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

		$company_lat='';
		$company_lng='';
		if(!empty($long))
			$company_lng=$long;
			
		if(!empty($lat))
			$company_lat=$lat;

		$query=mysqli_query($db,"UPDATE general_setting SET company_name='".$company_name."', company_address='".$company_address."', company_city='".$company_city."', company_state='".$company_state."', company_country='".$company_country."', company_zipcode='".$company_zipcode."', company_phone='".$company_phone."', company_lat='".$company_lat."', company_lng='".$company_lng."'");
	} elseif($type == "email") {
		$from_name=real_escape_string($post['from_name']);
		$from_email=real_escape_string($post['from_email']);
		$mailer_type=$post['mailer_type'];
		$smtp_host=real_escape_string($post['smtp_host']);
		$smtp_port=real_escape_string($post['smtp_port']);
		$smtp_security=$post['smtp_security'];
		$smtp_username=real_escape_string($post['smtp_username']);
		$smtp_password=real_escape_string($post['smtp_password']);
		$email_api_key=real_escape_string($post['email_api_key']);
		$query=mysqli_query($db,"UPDATE general_setting SET from_name='".$from_name."', from_email='".$from_email."', mailer_type='".$mailer_type."', smtp_host='".$smtp_host."', smtp_port='".$smtp_port."', smtp_security='".$smtp_security."', smtp_username='".$smtp_username."', smtp_password='".$smtp_password."', email_api_key='".$email_api_key."'");
	} elseif($type == "socials") {
		$social_login=$post['social_login'];
		$social_login_option=$post['social_login_option'];
		$google_client_id=$post['google_client_id'];
		$google_client_secret=$post['google_client_secret'];
		$fb_app_id=$post['fb_app_id'];
		$fb_app_secret=$post['fb_app_secret'];

		$saved_other_settings['facebook_social_link'] = $req_other_settings['facebook_social_link'];
		$saved_other_settings['facebook_social_link_icon'] = $req_other_settings['facebook_social_link_icon'];
		$saved_other_settings['twitter_social_link'] = $req_other_settings['twitter_social_link'];
		$saved_other_settings['twitter_social_link_icon'] = $req_other_settings['twitter_social_link_icon'];
		$saved_other_settings['linkedin_social_link'] = $req_other_settings['linkedin_social_link'];
		$saved_other_settings['linkedin_social_link_icon'] = $req_other_settings['linkedin_social_link_icon'];
		$saved_other_settings['foursquare_social_link'] = $req_other_settings['foursquare_social_link'];
		$saved_other_settings['foursquare_social_link_icon'] = $req_other_settings['foursquare_social_link_icon'];
		$saved_other_settings['pinterest_social_link'] = $req_other_settings['pinterest_social_link'];
		$saved_other_settings['pinterest_social_link_icon'] = $req_other_settings['pinterest_social_link_icon'];
		$saved_other_settings['flickr_social_link'] = $req_other_settings['flickr_social_link'];
		$saved_other_settings['flickr_social_link_icon'] = $req_other_settings['flickr_social_link_icon'];
		$saved_other_settings['youtube_social_link'] = $req_other_settings['youtube_social_link'];
		$saved_other_settings['youtube_social_link_icon'] = $req_other_settings['youtube_social_link_icon'];
		$saved_other_settings['google_plus_social_link'] = $req_other_settings['google_plus_social_link'];
		$saved_other_settings['google_plus_social_link_icon'] = $req_other_settings['google_plus_social_link_icon'];
		$saved_other_settings['vimeo_social_link'] = $req_other_settings['vimeo_social_link'];
		$saved_other_settings['vimeo_social_link_icon'] = $req_other_settings['vimeo_social_link_icon'];
		$saved_other_settings['instagram_social_link'] = $req_other_settings['instagram_social_link'];
		$saved_other_settings['instagram_social_link_icon'] = $req_other_settings['instagram_social_link_icon'];
		$saved_other_settings['yelp_social_link'] = $req_other_settings['yelp_social_link'];
		$saved_other_settings['yelp_social_link_icon'] = $req_other_settings['yelp_social_link_icon'];

		if($req_other_settings['facebook_social_link_status'] == '1') {
			$saved_other_settings['facebook_social_link_status'] = '1';
		} else {
			$saved_other_settings['facebook_social_link_status'] = '0';
		}
		if($req_other_settings['twitter_social_link_status'] == '1') {
			$saved_other_settings['twitter_social_link_status'] = '1';
		} else {
			$saved_other_settings['twitter_social_link_status'] = '0';
		}
		if($req_other_settings['linkedin_social_link_status'] == '1') {
			$saved_other_settings['linkedin_social_link_status'] = '1';
		} else {
			$saved_other_settings['linkedin_social_link_status'] = '0';
		}
		if($req_other_settings['foursquare_social_link_status'] == '1') {
			$saved_other_settings['foursquare_social_link_status'] = '1';
		} else {
			$saved_other_settings['foursquare_social_link_status'] = '0';
		}
		if($req_other_settings['pinterest_social_link_status'] == '1') {
			$saved_other_settings['pinterest_social_link_status'] = '1';
		} else {
			$saved_other_settings['pinterest_social_link_status'] = '0';
		}
		if($req_other_settings['flickr_social_link_status'] == '1') {
			$saved_other_settings['flickr_social_link_status'] = '1';
		} else {
			$saved_other_settings['flickr_social_link_status'] = '0';
		}
		if($req_other_settings['youtube_social_link_status'] == '1') {
			$saved_other_settings['youtube_social_link_status'] = '1';
		} else {
			$saved_other_settings['youtube_social_link_status'] = '0';
		}
		if($req_other_settings['google_plus_social_link_status'] == '1') {
			$saved_other_settings['google_plus_social_link_status'] = '1';
		} else {
			$saved_other_settings['google_plus_social_link_status'] = '0';
		}
		if($req_other_settings['vimeo_social_link_status'] == '1') {
			$saved_other_settings['vimeo_social_link_status'] = '1';
		} else {
			$saved_other_settings['vimeo_social_link_status'] = '0';
		}
		if($req_other_settings['instagram_social_link_status'] == '1') {
			$saved_other_settings['instagram_social_link_status'] = '1';
		} else {
			$saved_other_settings['instagram_social_link_status'] = '0';
		}
		if($req_other_settings['yelp_social_link_status'] == '1') {
			$saved_other_settings['yelp_social_link_status'] = '1';
		} else {
			$saved_other_settings['yelp_social_link_status'] = '0';
		}
		
		$query=mysqli_query($db,"UPDATE general_setting SET social_login='".$social_login."', social_login_option='".$social_login_option."', google_client_id='".$google_client_id."', google_client_secret='".$google_client_secret."', fb_app_id='".$fb_app_id."', fb_app_secret='".$fb_app_secret."'");
	} elseif($type == "sms") {
		$sms_sending_status = real_escape_string($post['sms_sending_status']);
		$twilio_ac_sid = real_escape_string($post['twilio_ac_sid']);
		$twilio_ac_token = real_escape_string($post['twilio_ac_token']);
		$twilio_long_code = real_escape_string($post['twilio_long_code']);
		$twilio_ipm_service_sid = $post['twilio_ipm_service_sid'];
		$twilio_api_key = $post['twilio_api_key'];
		$twilio_api_secret = $post['twilio_api_secret'];
		$user_phone_country_code = $post['user_phone_country_code'];
		$query=mysqli_query($db,"UPDATE general_setting SET sms_sending_status='".$sms_sending_status."', twilio_ac_sid='".$twilio_ac_sid."', twilio_ac_token='".$twilio_ac_token."', twilio_long_code='".$twilio_long_code."', twilio_ipm_service_sid='".$twilio_ipm_service_sid."', twilio_api_key='".$twilio_api_key."', twilio_api_secret='".$twilio_api_secret."', user_phone_country_code='".$user_phone_country_code."'");
	} elseif($type == "blog") {
		$blog_recent_posts = real_escape_string($post['blog_recent_posts']);
		$blog_categories = real_escape_string($post['blog_categories']);
		$blog_rm_words_limit = real_escape_string($post['blog_rm_words_limit']);
		$query=mysqli_query($db,"UPDATE general_setting SET blog_recent_posts='".$blog_recent_posts."', blog_categories='".$blog_categories."', blog_rm_words_limit='".$blog_rm_words_limit."'");
	} elseif($type == "captcha") {
		$captcha_settings=json_encode($post['captcha_settings']);
		$query=mysqli_query($db,"UPDATE general_setting SET captcha_settings='".$captcha_settings."'");
	} elseif($type == "homepage") {
		//$saved_other_settings['home_instant_repair_quote'] = $req_other_settings['home_instant_repair_quote'];
		
		$home_slider = real_escape_string($post['home_slider']);
		$query=mysqli_query($db,"UPDATE general_setting SET home_slider='".$home_slider."'");
	} elseif($type == "sitemap") {
		if($_FILES['xml_file']['name']) {
			$xml_file_ext = pathinfo($_FILES['xml_file']['name'],PATHINFO_EXTENSION);
			if($xml_file_ext=="xml") {
				$xml_file_tmp_name=$_FILES['xml_file']['tmp_name'];
				$sitemap_name='sitemap.'.$xml_file_ext;
				move_uploaded_file($xml_file_tmp_name,'../../'.$sitemap_name);

				$msg="Sitemap settings has been successfully saved.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg="File type must be xml";
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Sitemap (XML) file must be choose.";
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL."settings.php?type=".$type);
		exit();
	} elseif($type == "ticket") {
		$ticket_settings=json_encode($post['ticket_settings']);
		$query=mysqli_query($db,"UPDATE general_setting SET ticket_settings='".$ticket_settings."'");
	} elseif($type == "menutype") {
		if($req_other_settings['top_right_menu'] == '1') {
			$saved_other_settings['top_right_menu'] = '1';
		} else {
			$saved_other_settings['top_right_menu'] = '0';
		}

		if($req_other_settings['header_menu'] == '1') {
			$saved_other_settings['header_menu'] = '1';
		} else {
			$saved_other_settings['header_menu'] = '0';
		}

		if($req_other_settings['footer_menu_column1'] == '1') {
			$saved_other_settings['footer_menu_column1'] = '1';
		} else {
			$saved_other_settings['footer_menu_column1'] = '0';
		}

		if($req_other_settings['footer_menu_column2'] == '1') {
			$saved_other_settings['footer_menu_column2'] = '1';
		} else {
			$saved_other_settings['footer_menu_column2'] = '0';
		}

		if($req_other_settings['footer_menu_column3'] == '1') {
			$saved_other_settings['footer_menu_column3'] = '1';
		} else {
			$saved_other_settings['footer_menu_column3'] = '0';
		}

		if($req_other_settings['copyright_menu'] == '1') {
			$saved_other_settings['copyright_menu'] = '1';
		} else {
			$saved_other_settings['copyright_menu'] = '0';
		}
		$saved_other_settings['footer_menu_column1_title'] = $req_other_settings['footer_menu_column1_title'];
		$saved_other_settings['footer_menu_column2_title'] = $req_other_settings['footer_menu_column2_title'];
		$saved_other_settings['footer_menu_column3_title'] = $req_other_settings['footer_menu_column3_title'];
	} elseif($type == "payment_method") {
		$payment_method="";
		if(!empty($post['payment_method'])) {
			$payment_method=json_encode(array_filter($post['payment_method']));
		}
		$query=mysqli_query($db,"UPDATE general_setting SET payment_method='".$payment_method."'");
	} elseif($type == "payment_status") {
		$payment_status="";
		if(!empty($post['payment_status'])) {
			$payment_status=json_encode(array_filter($post['payment_status']));
		}
		$query=mysqli_query($db,"UPDATE general_setting SET payment_status='".$payment_status."'");
	} elseif($type == "testimonial") {
		$testimonial_settings=json_encode($post['testimonial_settings']);
		$query=mysqli_query($db,"UPDATE general_setting SET testimonial_settings='".$testimonial_settings."'");
	} elseif($type == "recently_ordered") {
		$recently_ordered_settings=json_encode($post['recently_ordered_settings']);
		$query=mysqli_query($db,"UPDATE general_setting SET recently_ordered_settings='".$recently_ordered_settings."'");
	} elseif($type == "shipping_api") {
		$shipping_api = $post['shipping_api'];
		$shipment_generated_by_cust = ($post['shipment_generated_by_cust']?'1':'0');
		$shipping_api_key = real_escape_string($post['shipping_api_key']);
		$shipping_api_secret = real_escape_string($post['shipping_api_secret']);
		$shipping_parcel_length = $post['shipping_parcel_length'];
		$shipping_parcel_width = $post['shipping_parcel_width'];
		$shipping_parcel_height = $post['shipping_parcel_height'];
		$shipping_parcel_weight = $post['shipping_parcel_weight'];
		$default_carrier_account = $post['default_carrier_account'];
		$carrier_account_id = $post['carrier_account_id'];
		$query=mysqli_query($db,"UPDATE general_setting SET shipping_api='".$shipping_api."', shipment_generated_by_cust='".$shipment_generated_by_cust."', shipping_api_key='".$shipping_api_key."', shipping_api_secret='".$shipping_api_secret."'   , shipping_parcel_length='".$shipping_parcel_length."', shipping_parcel_width='".$shipping_parcel_width."', shipping_parcel_height='".$shipping_parcel_height."', shipping_parcel_weight='".$shipping_parcel_weight."', default_carrier_account='".$default_carrier_account."', carrier_account_id='".$carrier_account_id."'");
	} elseif($type == "model_fields") {
		$saved_other_settings['repair_questions_expanded_or_expand_collapse'] = $req_other_settings['repair_questions_expanded_or_expand_collapse'];
		$saved_other_settings['select_fields_as_box_or_add_remove_button'] = $req_other_settings['select_fields_as_box_or_add_remove_button'];

		if($req_other_settings['show_fault_prices'] == '1') {
			$saved_other_settings['show_fault_prices'] = '1';
		} else {
			$saved_other_settings['show_fault_prices'] = '0';
		}
		
		if($req_other_settings['show_repair_item_price'] == '1') {
			$saved_other_settings['show_repair_item_price'] = '1';
		} else {
			$saved_other_settings['show_repair_item_price'] = '0';
		}
		
		if($req_other_settings['text_field_of_model_fields'] == '1') {
			$saved_other_settings['text_field_of_model_fields'] = '1';
		} else {
			$saved_other_settings['text_field_of_model_fields'] = '0';
		}
		if($req_other_settings['text_area_of_model_fields'] == '1') {
			$saved_other_settings['text_area_of_model_fields'] = '1';
		} else {
			$saved_other_settings['text_area_of_model_fields'] = '0';
		}
		if($req_other_settings['calendar_of_model_fields'] == '1') {
			$saved_other_settings['calendar_of_model_fields'] = '1';
		} else {
			$saved_other_settings['calendar_of_model_fields'] = '0';
		}
		if($req_other_settings['file_upload_of_model_fields'] == '1') {
			$saved_other_settings['file_upload_of_model_fields'] = '1';
		} else {
			$saved_other_settings['file_upload_of_model_fields'] = '0';
		}
		if($req_other_settings['tooltips_of_model_fields'] == '1') {
			$saved_other_settings['tooltips_of_model_fields'] = '1';
		} else {
			$saved_other_settings['tooltips_of_model_fields'] = '0';
		}
		if($req_other_settings['icons_of_model_fields'] == '1') {
			$saved_other_settings['icons_of_model_fields'] = '1';
		} else {
			$saved_other_settings['icons_of_model_fields'] = '0';
		}
	} elseif($type == "payment") {
		$saved_other_settings['cust_payment_option'] = ($req_other_settings['cust_payment_option']=='1'?1:0);
		$saved_other_settings['cust_payment_type'] = $req_other_settings['cust_payment_type'];
		$saved_other_settings['cust_payment_per_val'] = $req_other_settings['cust_payment_per_val'];
		$saved_other_settings['payment_mode'] = $req_other_settings['payment_mode'];
		$saved_other_settings['stripe_test_publishable_key'] = $req_other_settings['stripe_test_publishable_key'];
		$saved_other_settings['stripe_test_secret_key'] = $req_other_settings['stripe_test_secret_key'];
		$saved_other_settings['stripe_live_publishable_key'] = $req_other_settings['stripe_live_publishable_key'];
		$saved_other_settings['stripe_live_secret_key'] = $req_other_settings['stripe_live_secret_key'];
	}

	if(!empty($post['other_settings'])) {
		$other_settings=json_encode($saved_other_settings);
		$query=mysqli_query($db,"UPDATE general_setting SET other_settings='".$other_settings."'");
	}
	if($query=="1") {
		$msg="Settings has been successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif($post['r_logo_id']) {
	$q=mysqli_query($db,'SELECT logo FROM general_setting WHERE id="'.$post['r_logo_id'].'"');
	$get_logodata_row=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE general_setting SET logo="" WHERE id='.$post['r_logo_id']);
	if($get_logodata_row['logo']!="")
		unlink('../../images/'.$get_logodata_row['logo']);

	$msg="Logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_f_icon_id']) {
	$q=mysqli_query($db,'SELECT favicon_icon FROM general_setting WHERE id="'.$post['r_f_icon_id'].'"');
	$general_setting_data=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE general_setting SET favicon_icon="" WHERE id='.$post['r_f_icon_id']);
	if($general_setting_data['favicon_icon']!="")
		unlink('../../images/'.$general_setting_data['favicon_icon']);

	$msg="Favicon icon successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_app_logo_id']) {
	$q=mysqli_query($db,'SELECT app_logo FROM general_setting WHERE id="'.$post['r_app_logo_id'].'"');
	$get_logodata_row=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE general_setting SET app_logo="" WHERE id='.$post['r_app_logo_id']);
	if($get_logodata_row['app_logo']!="")
		unlink('../../images/'.$get_logodata_row['app_logo']);

	$msg="Mobile app logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_admin_logo_id']) {
	$q=mysqli_query($db,'SELECT admin_logo FROM general_setting WHERE id="'.$post['r_admin_logo_id'].'"');
	$get_logodata_row=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE general_setting SET admin_logo="" WHERE id='.$post['r_admin_logo_id']);
	if($get_logodata_row['admin_logo']!="")
		unlink('../../images/'.$get_logodata_row['admin_logo']);

	$msg="Admin logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_i_logo_id']) {
	$q=mysqli_query($db,'SELECT invoice_logo FROM general_setting WHERE id="'.$post['r_i_logo_id'].'"');
	$get_logodata_row=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE general_setting SET invoice_logo="" WHERE id='.$post['r_i_logo_id']);
	if($get_logodata_row['invoice_logo']!="")
		unlink('../../images/'.$get_logodata_row['invoice_logo']);

	$msg="Invoice logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_sitemap']) {
	unlink('../../sitemap.xml');

	$msg="Sitemap successfully removed.";
	$_SESSION['success_msg']=$msg;
}
setRedirect(ADMIN_URL."settings.php?type=".$type);
exit();
?>