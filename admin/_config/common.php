<?php
$admin_query=mysqli_query($db,"SELECT username, email FROM admin WHERE type='super_admin' ORDER BY id DESC");
$admin_detail=mysqli_fetch_assoc($admin_query);

$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($gs_query);

$model_details_page_slug = "product/";
//$model_details_page_slug = "";

$category_details_page_slug = "product-category/";
//$category_details_page_slug = "";

$country_small_nm = "in";
$custom_js_code = $general_setting_data['custom_js_code'];
$after_body_js_code = $general_setting_data['after_body_js_code'];
$before_body_js_code = $general_setting_data['before_body_js_code'];
$company_name = $general_setting_data['company_name'];
$company_address = $general_setting_data['company_address'];
$company_city = $general_setting_data['company_city'];
$company_state = $general_setting_data['company_state'];
$company_country = $general_setting_data['company_country'];
$company_zipcode = $general_setting_data['company_zipcode'];
$company_phone = $general_setting_data['company_phone'];
$header_service_hours_text = $general_setting_data['header_service_hours_text'];
$map_key = $general_setting_data['map_key'];
$company_lat = $general_setting_data['company_lat'];
$company_lng = $general_setting_data['company_lng'];
$promocode_section = $general_setting_data['promocode_section'];
define('TIMEZONE',$general_setting_data['timezone']);

$allow_sms_verify_of_admin_staff_login = $general_setting_data['allow_sms_verify_of_admin_staff_login'];

$amount_sign = '&#163;';
$top_seller_limit = ($general_setting_data['top_seller_limit']>0?$general_setting_data['top_seller_limit']:0);
$fb_page_url = trim($general_setting_data['fb_page_url']);

$social_login = trim($general_setting_data['social_login']);
$social_login_option = trim($general_setting_data['social_login_option']);
$google_client_id = trim($general_setting_data['google_client_id']);
$google_client_secret = trim($general_setting_data['google_client_secret']);
$google_cal_api = trim($general_setting_data['google_cal_api']);
$is_google_cal_auth = trim($general_setting_data['is_google_cal_auth']);
$fb_app_id = trim($general_setting_data['fb_app_id']);
$fb_app_secret = trim($general_setting_data['fb_app_secret']);
$sms_sending_status = trim($general_setting_data['sms_sending_status']);
$google_calendar_client_id = trim($general_setting_data['google_calendar_client_id']);
$google_calendar_client_secret = trim($general_setting_data['google_calendar_client_secret']);

$amount_sign_with_prefix = '';
$amount_sign_with_postfix = '';

$disp_currency = $general_setting_data['disp_currency'];
$currency = @explode(",",$general_setting_data['currency']);
$currency_symbol = $currency[1];
$currency_nm = $currency[0];
if($general_setting_data['disp_currency']=="prefix")
	$amount_sign_with_prefix = $currency_symbol;
elseif($general_setting_data['disp_currency']=="postfix")
	$amount_sign_with_postfix = $currency_symbol;

$is_space_between_currency_symbol = $general_setting_data['is_space_between_currency_symbol'];
$thousand_separator = $general_setting_data['thousand_separator'];
$decimal_separator = $general_setting_data['decimal_separator'];
$decimal_number = $general_setting_data['decimal_number'];

//$choosed_payment_option = json_decode($general_setting_data['payment_option'],true);
//$default_payment_option = $general_setting_data['default_payment_option'];
$order_prefix = trim($general_setting_data['order_prefix']);
$order_completed_prefix = trim($general_setting_data['order_completed_prefix']);
$display_terms_array = json_decode($general_setting_data['display_terms'],true);
//$choosed_sales_pack_array = json_decode($general_setting_data['sales_pack'],true);
$payment_method_list_array = json_decode($general_setting_data['payment_method'],true);
$payment_status_list_array = json_decode($general_setting_data['payment_status'],true);

$page_list_limit = ($general_setting_data['page_list_limit']>5?$general_setting_data['page_list_limit']:5);
$blog_recent_posts = trim($general_setting_data['blog_recent_posts']);
$blog_categories = trim($general_setting_data['blog_categories']);
$blog_rm_words_limit = trim($general_setting_data['blog_rm_words_limit']);
$user_phone_country_code = trim($general_setting_data['user_phone_country_code']);

define('ADMIN_PANEL_NAME',$general_setting_data['admin_panel_name']);
define('SITE_NAME',$general_setting_data['site_name']);
define('FROM_EMAIL',$general_setting_data['from_email']);
define('FROM_NAME',$general_setting_data['from_name']);

$logo_url = SITE_URL.'images/'.$general_setting_data['logo'];
$invoice_logo_url = SITE_URL.'images/'.$general_setting_data['invoice_logo'];
$app_logo_url = SITE_URL.'images/'.$general_setting_data['app_logo'];

$site_phone = $general_setting_data['phone'];
$site_email = $general_setting_data['email'];
$website = $general_setting_data['website'];
$copyright = $general_setting_data['copyright'];
$copyright = str_replace('{$year}',date("Y"),$copyright);
$theme_color_type = "green"; //$general_setting_data['theme_option'];

$appt_start_time = trim($general_setting_data['appt_start_time']);
$appt_end_time = trim($general_setting_data['appt_end_time']);
$appt_time_interval = trim($general_setting_data['appt_time_interval']);

$block_days = '';
$block_days_array = array();
$appt_week_days_block = array();
$appt_week_days_block = json_decode($general_setting_data['appt_week_days_block'],true);
if(isset($appt_week_days_block['day_0']) && $appt_week_days_block['day_0']=='1') {
	$block_days .= '0,';
	$block_days_array[] = '0';
}
if(isset($appt_week_days_block['day_1']) && $appt_week_days_block['day_1']=='1') {
	$block_days .= '1,';
	$block_days_array[] = '1';
}
if(isset($appt_week_days_block['day_2']) && $appt_week_days_block['day_2']=='1') {
	$block_days .= '2,';
	$block_days_array[] = '2';
}
if(isset($appt_week_days_block['day_3']) && $appt_week_days_block['day_3']=='1') {
	$block_days .= '3,';
	$block_days_array[] = '3';
}
if(isset($appt_week_days_block['day_4']) && $appt_week_days_block['day_4']=='1') {
	$block_days .= '4,';
	$block_days_array[] = '4';
}
if(isset($appt_week_days_block['day_5']) && $appt_week_days_block['day_5']=='1') {
	$block_days .= '5,';
	$block_days_array[] = '5';
}
if(isset($appt_week_days_block['day_6']) && $appt_week_days_block['day_6']=='1') {
	$block_days .= '6,';
	$block_days_array[] = '6';
}
$appt_block_days = rtrim($block_days,',');

$appt_special_dates_block_array = array();
$appt_special_dates_block_list = '';
$appt_special_dates_block = trim($general_setting_data['appt_special_dates_block']);
if($appt_special_dates_block!="") {
	foreach(explode(",",$appt_special_dates_block) as $appt_special_dates_block_k => $appt_special_dates_block_v) {
		$appt_special_dates_block_array[] = date("Y-m-d",strtotime($appt_special_dates_block_v));
	}
	//$appt_special_dates_block_list = implode("','",$appt_special_dates_block_array);
}

$logo = '<img src="'.$logo_url.'" width="200">';
$invoice_logo = '<img src="'.$invoice_logo_url.'" width="200">';
$admin_logo = '<img src="'.SITE_URL.'images/'.$general_setting_data['admin_logo'].'" width="200">';
if($general_setting_data['admin_logo']!="") {
	$admin_logo_url = SITE_URL.'images/'.$general_setting_data['admin_logo'];
} else {
	$admin_logo_url = ADMIN_URL.'img/logo-placeholder.jpeg';
}

$display_on_model_detail = '';
$display_on_device_page = '';
$display_on_model_page = '';

$testimonial_settings = json_decode($general_setting_data['testimonial_settings'],true);
if(isset($testimonial_settings['display_on_model_detail'])) {
	$display_on_model_detail = $testimonial_settings['display_on_model_detail'];
}
if(isset($testimonial_settings['display_on_device_page'])) {
	$display_on_device_page = $testimonial_settings['display_on_device_page'];
}
if(isset($testimonial_settings['display_on_model_page'])) {
	$display_on_model_page = $testimonial_settings['display_on_model_page'];
}

$captcha_settings = json_decode($general_setting_data['captcha_settings'],true);
$contact_form_captcha = '0';
$write_review_form_captcha = '0';
$bulk_order_form_captcha = '0';
$affiliate_form_captcha = '0';
$appt_form_captcha = '0';
$login_form_captcha = '0';
$signup_form_captcha = '0';
$contractor_form_captcha = '0';
$order_track_form_captcha = '0';
$newsletter_form_captcha = '0';
$missing_product_form_captcha = '0';
$captcha_key = $captcha_settings['captcha_key'];
$captcha_secret = $captcha_settings['captcha_secret'];
if($captcha_key!="" && $captcha_secret!="") {
	$contact_form_captcha = isset($captcha_settings['contact_form'])?$captcha_settings['contact_form']:0;
	$write_review_form_captcha = isset($captcha_settings['write_review_form'])?$captcha_settings['write_review_form']:0;
	$bulk_order_form_captcha = isset($captcha_settings['bulk_order_form'])?$captcha_settings['bulk_order_form']:0;
	$affiliate_form_captcha = isset($captcha_settings['affiliate_form'])?$captcha_settings['affiliate_form']:0;
	$appt_form_captcha = isset($captcha_settings['appt_form'])?$captcha_settings['appt_form']:0;
	$login_form_captcha = isset($captcha_settings['login_form'])?$captcha_settings['login_form']:0;
	$signup_form_captcha = isset($captcha_settings['signup_form'])?$captcha_settings['signup_form']:0;
	$contractor_form_captcha = isset($captcha_settings['contractor_form'])?$captcha_settings['contractor_form']:0;
	$order_track_form_captcha = isset($captcha_settings['order_track_form'])?$captcha_settings['order_track_form']:0;
	$newsletter_form_captcha = isset($captcha_settings['newsletter_form'])?$captcha_settings['newsletter_form']:0;
	$missing_product_form_captcha = isset($captcha_settings['missing_product_form'])?$captcha_settings['missing_product_form']:0;
}

$display_recently_ordered = '';
$recently_ordered_limit = '';

$recently_ordered_settings = json_decode($general_setting_data['recently_ordered_settings'],true);
if(isset($recently_ordered_settings['display_recently_ordered'])) {
	$display_recently_ordered = $recently_ordered_settings['display_recently_ordered'];
}
if(isset($recently_ordered_settings['recently_ordered_limit'])) {
	$recently_ordered_limit = $recently_ordered_settings['recently_ordered_limit'];
}

$other_settings = json_decode($general_setting_data['other_settings'],true);

$signup_activation_by_admin = '';
if(isset($other_settings['signup_activation_by_admin'])) {
	$signup_activation_by_admin = $other_settings['signup_activation_by_admin'];
}

$newslettter_section = '';
if(isset($other_settings['newslettter_section'])) {
	$newslettter_section = $other_settings['newslettter_section'];
}

$show_missing_model_section = '';
if(isset($other_settings['show_missing_model_section'])) {
	$show_missing_model_section = $other_settings['show_missing_model_section'];
}

$show_missing_device_section = '';
if(isset($other_settings['show_missing_device_section'])) {
	$show_missing_device_section = $other_settings['show_missing_device_section'];
}

$show_missing_brand_section = '';
if(isset($other_settings['show_missing_brand_section'])) {
	$show_missing_brand_section = $other_settings['show_missing_brand_section'];
}

$show_missing_category_section = '';
if(isset($other_settings['show_missing_category_section'])) {
	$show_missing_category_section = $other_settings['show_missing_category_section'];
}

$online_booking_hide_price = '';
if(isset($other_settings['online_booking_hide_price'])) {
	$online_booking_hide_price = $other_settings['online_booking_hide_price'];
}

$full_review_or_number_of_words = '';
if(isset($other_settings['full_review_or_number_of_words'])) {
	$full_review_or_number_of_words = $other_settings['full_review_or_number_of_words'];
}

$review_limited_words = ($other_settings['review_limited_words']>0?$other_settings['review_limited_words']:0);

$home_instant_repair_quote = '';
if(isset($other_settings['home_instant_repair_quote'])) {
	$home_instant_repair_quote = $other_settings['home_instant_repair_quote'];
}

$contractor_concept = '';
if(isset($other_settings['contractor_concept'])) {
	$contractor_concept = $other_settings['contractor_concept'];
}

$text_field_of_model_fields = '';
if(isset($other_settings['text_field_of_model_fields'])) {
	$text_field_of_model_fields = $other_settings['text_field_of_model_fields'];
}

$text_area_of_model_fields = '';
if(isset($other_settings['text_area_of_model_fields'])) {
	$text_area_of_model_fields = $other_settings['text_area_of_model_fields'];
}

$calendar_of_model_fields = '';
if(isset($other_settings['calendar_of_model_fields'])) {
	$calendar_of_model_fields = $other_settings['calendar_of_model_fields'];
}

$file_upload_of_model_fields = '';
if(isset($other_settings['file_upload_of_model_fields'])) {
	$file_upload_of_model_fields = $other_settings['file_upload_of_model_fields'];
}

$tooltips_of_model_fields = '';
if(isset($other_settings['tooltips_of_model_fields'])) {
	$tooltips_of_model_fields = $other_settings['tooltips_of_model_fields'];
}

$icons_of_model_fields = '';
if(isset($other_settings['icons_of_model_fields'])) {
	$icons_of_model_fields = $other_settings['icons_of_model_fields'];
}

$repair_questions_expanded_or_expand_collapse = '';
if(isset($other_settings['repair_questions_expanded_or_expand_collapse'])) {
	$repair_questions_expanded_or_expand_collapse = $other_settings['repair_questions_expanded_or_expand_collapse'];
}

$select_fields_as_box_or_add_remove_button = '';
if(isset($other_settings['select_fields_as_box_or_add_remove_button'])) {
	$select_fields_as_box_or_add_remove_button = $other_settings['select_fields_as_box_or_add_remove_button'];
}

$show_repair_item_price = '';
if(isset($other_settings['show_repair_item_price'])) {
	$show_repair_item_price = $other_settings['show_repair_item_price'];
}

$maintainance_mode = '';
if(isset($other_settings['maintainance_mode'])) {
	$maintainance_mode = $other_settings['maintainance_mode'];
}

$show_fault_prices = '';
if(isset($other_settings['show_fault_prices'])) {
	$show_fault_prices = $other_settings['show_fault_prices'];
}

$show_breadcrumbs = '';
if(isset($other_settings['show_breadcrumbs'])) {
	$show_breadcrumbs = $other_settings['show_breadcrumbs'];
}

$show_missing_category_section = '';
if(isset($other_settings['show_missing_category_section'])) {
	$show_missing_category_section = $other_settings['show_missing_category_section'];
}

$cust_payment_option = '';
if(isset($other_settings['cust_payment_option'])) {
	$cust_payment_option = $other_settings['cust_payment_option'];
}
$cust_payment_type = '';
if(isset($other_settings['cust_payment_type'])) {
	$cust_payment_type = $other_settings['cust_payment_type'];
}
$cust_payment_per_val = 0;
if(isset($other_settings['cust_payment_per_val'])) {
	$cust_payment_per_val = $other_settings['cust_payment_per_val'];
}
$payment_mode = '';
if(isset($other_settings['payment_mode'])) {
	$payment_mode = $other_settings['payment_mode'];
}
$stripe_test_publishable_key = '';
if(isset($other_settings['stripe_test_publishable_key'])) {
	$stripe_test_publishable_key = $other_settings['stripe_test_publishable_key'];
}
$stripe_test_secret_key = '';
if(isset($other_settings['stripe_test_secret_key'])) {
	$stripe_test_secret_key = $other_settings['stripe_test_secret_key'];
}
$stripe_live_publishable_key = '';
if(isset($other_settings['stripe_live_publishable_key'])) {
	$stripe_live_publishable_key = $other_settings['stripe_live_publishable_key'];
}
$stripe_live_secret_key = '';
if(isset($other_settings['stripe_live_secret_key'])) {
	$stripe_live_secret_key = $other_settings['stripe_live_secret_key'];
}

$stripe_publishable_key = $stripe_test_publishable_key;
$stripe_secret_key = $stripe_test_secret_key;
if($payment_mode == "live") {
	$stripe_publishable_key = $stripe_live_publishable_key;
	$stripe_secret_key = $stripe_live_secret_key;
}

//START for footer social
$socials_link = '';
$social_list_array = array('facebook','twitter','linkedin','foursquare','pinterest','flickr','youtube','google_plus','vimeo','instagram','yelp');
foreach($social_list_array as $social_key => $social_val) {
	$social_link = $other_settings[$social_val.'_social_link'];
	$social_link_icon = $other_settings[$social_val.'_social_link_icon'];
	$social_link_status = $other_settings[$social_val.'_social_link_status'];
	if($social_link_status == '1' && $social_link!="") {
		//$socials_link .= '<li><a href="'.$social_link.'" title="'.$social_link.'"><i class="'.$social_link_icon.'" aria-hidden="true"></i></a></li>';
		$socials_link .= '<a class="social-icon si-small si-borderless si-colored si-rounded si-'.str_replace('google_plus','google',$social_val).'" href="'.$social_link.'" title="'.$social_link.'"><i class="icon-'.$social_link_icon.'"></i><i class="icon-'.$social_link_icon.'"></i></a>';
	}
} //END for footer social

$allowed_num_of_booking_per_time_slot = trim($general_setting_data['allowed_num_of_booking_per_time_slot']);
$num_of_booking_per_time_slot = trim($general_setting_data['num_of_booking_per_time_slot']);

$is_act_top_right_menu = '';
if(isset($other_settings['top_right_menu'])) {
	$is_act_top_right_menu = $other_settings['top_right_menu'];
}

$is_act_header_menu = '';
if(isset($other_settings['header_menu'])) {
	$is_act_header_menu = $other_settings['header_menu'];
}

$is_act_footer_menu_column1 = '';
if(isset($other_settings['footer_menu_column1'])) {
	$is_act_footer_menu_column1 = $other_settings['footer_menu_column1'];
}

$is_act_footer_menu_column2 = '';
if(isset($other_settings['footer_menu_column2'])) {
	$is_act_footer_menu_column2 = $other_settings['footer_menu_column2'];
}

$is_act_footer_menu_column3 = '';
if(isset($other_settings['footer_menu_column3'])) {
	$is_act_footer_menu_column3 = $other_settings['footer_menu_column3'];
}

$is_act_copyright_menu = '';
if(isset($other_settings['copyright_menu'])) {
	$is_act_copyright_menu = $other_settings['copyright_menu'];
}

$footer_menu_column1_title = '';
if(isset($other_settings['footer_menu_column1_title'])) {
	$footer_menu_column1_title = $other_settings['footer_menu_column1_title'];
}

$footer_menu_column2_title = '';
if(isset($other_settings['footer_menu_column2_title'])) {
	$footer_menu_column2_title = $other_settings['footer_menu_column2_title'];
}

$footer_menu_column3_title = '';
if(isset($other_settings['footer_menu_column3_title'])) {
	$footer_menu_column3_title = $other_settings['footer_menu_column3_title'];
}

$location_option_bring_to_shop = '0';
if(isset($other_settings['location_option_bring_to_shop'])) {
	$location_option_bring_to_shop = $other_settings['location_option_bring_to_shop'];
}

$location_option_come_for_you = '0';
if(isset($other_settings['location_option_come_for_you'])) {
	$location_option_come_for_you = $other_settings['location_option_come_for_you'];
}

$location_option_ship_device = '0';
if(isset($other_settings['location_option_ship_device'])) {
	$location_option_ship_device = $other_settings['location_option_ship_device'];
}

$location_option_default = array();
$location_option_default['bring_to_shop'] = 0;
$location_option_default['come_for_you'] = 0;
$location_option_default['ship_device'] = 0;
if($location_option_bring_to_shop == '1') {
	$location_option_default['bring_to_shop'] = 1;
} elseif($location_option_come_for_you == '1') {
	$location_option_default['come_for_you'] = 1;
} elseif($location_option_ship_device == '1') {
	$location_option_default['ship_device'] = 1;
}

$shipping_api = trim($general_setting_data['shipping_api']);
$shipment_generated_by_cust = trim($general_setting_data['shipment_generated_by_cust']);
$shipping_api_key = trim($general_setting_data['shipping_api_key']);
$shipping_api_secret = trim($general_setting_data['shipping_api_secret']);
$default_carrier_account = trim($general_setting_data['default_carrier_account']);
$carrier_account_id = trim($general_setting_data['carrier_account_id']);

$shipping_predefined_package = "";
if($carrier_account_id!="") {
	if($default_carrier_account == "usps") {
		$shipping_predefined_package = "SmallFlatRateBox";  //SmallFlatRateBox, MediumFlatRateBox, LargeFlatRateBox ...
	} elseif($default_carrier_account == "ups") {
		$shipping_predefined_package = "SmallExpressBox";  //SmallExpressBox, MediumExpressBox, LargeExpressBox ...
	} elseif($default_carrier_account == "fedex") {
		$shipping_predefined_package = "FedExSmallBox";  //FedExSmallBox, FedExMediumBox, FedExLargeBox, FedExExtraLargeBox ...
	} elseif($default_carrier_account == "dhl") {
		$shipping_predefined_package = "JumboBox";  //JumboBox, JuniorJumboBox ...
	}
}

$shipping_parcel_lg = trim($general_setting_data['shipping_parcel_length']);
$shipping_parcel_wd = trim($general_setting_data['shipping_parcel_width']);
$shipping_parcel_hg = trim($general_setting_data['shipping_parcel_height']);
$shipping_parcel_wg = trim($general_setting_data['shipping_parcel_weight']);

$shipping_parcel_length = ($shipping_parcel_lg?$shipping_parcel_lg:'20.2');
$shipping_parcel_width = ($shipping_parcel_wd?$shipping_parcel_wd:'10.9');
$shipping_parcel_height = ($shipping_parcel_hg?$shipping_parcel_hg:'5');
$shipping_parcel_weight = ($shipping_parcel_wg?$shipping_parcel_wg:'65.9');

$countries_list = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

//Library of SMTP method based send email
require(CP_ROOT_PATH."/libraries/PHPMailer/class.phpmailer.php");
//require(CP_ROOT_PATH."/libraries/twilio/Services/Twilio.php");
require(CP_ROOT_PATH."/libraries/twilio/new/src/Twilio/autoload.php");
require(CP_ROOT_PATH."/libraries/sendgrid-php/vendor/autoload.php");

$account_sid = $general_setting_data['twilio_ac_sid'];
$auth_token = $general_setting_data['twilio_ac_token'];
//$sms_api = new Services_Twilio($account_sid, $auth_token);

use Twilio\Rest\Client;
$sms_api = new Client($account_sid, $auth_token);
?>