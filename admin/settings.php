<?php 
$file_name="general_settings";

//Header section
require_once("include/header.php");

$unique_id = get_unique_id_on_load();

$m_portlet_body_padding_top = "";
$m_portlet_body_padding_bottom = "";
	
$heading_title = "Settings";
$type = $post['type'];
if($type == "general") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Settings";
} elseif($type == "appointment") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Appointment Settings";
} elseif($type == "company") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Company Settings";
} elseif($type == "email") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	$m_portlet_body_padding_bottom = " m--padding-bottom-10";
	
	$heading_title = "Email Settings";
} elseif($type == "socials") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Socials Settings";
} elseif($type == "sms") {
	$m_portlet_body_padding_top = " m--padding-top-10";

	$heading_title = "SMS Settings";
} elseif($type == "blog") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Blog Settings";
} elseif($type == "captcha") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Captcha Settings";
} elseif($type == "homepage") {
	$m_portlet_body_padding_top = " m--padding-top-10";

	$heading_title = "Home Page Settings";
} elseif($type == "sitemap") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Sitemap Settings";
} elseif($type == "ticket") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Ticket Settings";
} elseif($type == "menutype") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	
	$heading_title = "Menu Type Settings";
} elseif($type == "payment_method") {
	$heading_title = "Payment Method Settings";
} elseif($type == "payment_status") {
	$heading_title = "Payment Status Settings";
} elseif($type == "testimonial") {
	$m_portlet_body_padding_top = " m--padding-top-10";

	$heading_title = "Testimonial Settings";
} elseif($type == "recently_ordered") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	$m_portlet_body_padding_bottom = " m--padding-bottom-20";
	
	$heading_title = "Recently Ordered Settings";
} elseif($type == "shipping_api") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	$m_portlet_body_padding_bottom = " m--padding-bottom-20";
	
	$heading_title = "Shipping API Settings";
} elseif($type == "model_fields") {
	$m_portlet_body_padding_top = " m--padding-top-10";
	$m_portlet_body_padding_bottom = " m--padding-bottom-20";
	
	$heading_title = "Model Fields Settings";
}

//Fetch general settings data
$query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($query);
$display_terms = json_decode($general_setting_data['display_terms'],true);
$currency = @explode(",",$general_setting_data['currency']);
$payment_option = json_decode($general_setting_data['payment_option'],true); 
$sales_pack = json_decode($general_setting_data['sales_pack'],true); 
$shipping_option = json_decode($general_setting_data['shipping_option'],true);
$page_list_limit = $general_setting_data['page_list_limit'];
$ticket_settings = json_decode($general_setting_data['ticket_settings'],true);
$payment_method_array = json_decode($general_setting_data['payment_method'],true);
$payment_status_array = json_decode($general_setting_data['payment_status'],true);
$testimonial_settings = json_decode($general_setting_data['testimonial_settings'],true);
$recently_ordered_settings = json_decode($general_setting_data['recently_ordered_settings'],true);
$captcha_settings = json_decode($general_setting_data['captcha_settings'],true);
$other_settings = json_decode($general_setting_data['other_settings'],true);

if(!isset($recently_ordered_settings['display_recently_ordered'])) {
	$recently_ordered_settings['display_recently_ordered'] = 0;
}
if(!isset($testimonial_settings['display_on_model_detail'])) {
	$testimonial_settings['display_on_model_detail'] = 0;
}
if(!isset($testimonial_settings['display_on_device_page'])) {
	$testimonial_settings['display_on_device_page'] = 0;
}
if(!isset($testimonial_settings['display_on_model_page'])) {
	$testimonial_settings['display_on_model_page'] = 0;
}

if(!isset($appt_week_days_block['day_0'])) {
	$appt_week_days_block['day_0'] = 0;
}
if(!isset($appt_week_days_block['day_1'])) {
	$appt_week_days_block['day_1'] = 0;
}
if(!isset($appt_week_days_block['day_2'])) {
	$appt_week_days_block['day_2'] = 0;
}
if(!isset($appt_week_days_block['day_3'])) {
	$appt_week_days_block['day_3'] = 0;
}
if(!isset($appt_week_days_block['day_4'])) {
	$appt_week_days_block['day_4'] = 0;
}
if(!isset($appt_week_days_block['day_5'])) {
	$appt_week_days_block['day_5'] = 0;
}
if(!isset($appt_week_days_block['day_6'])) {
	$appt_week_days_block['day_6'] = 0;
}

if(empty($captcha_settings['contact_form'])) {
	$captcha_settings['contact_form'] = '';
}
if(empty($captcha_settings['write_review_form'])) {
	$captcha_settings['write_review_form'] = '';
}
if(empty($captcha_settings['bulk_order_form'])) {
	$captcha_settings['bulk_order_form'] = '';
}
if(empty($captcha_settings['affiliate_form'])) {
	$captcha_settings['affiliate_form'] = '';
}
if(empty($captcha_settings['appt_form'])) {
	$captcha_settings['appt_form'] = '';
}
if(empty($captcha_settings['login_form'])) {
	$captcha_settings['login_form'] = '';
}

if(empty($captcha_settings['signup_form'])) {
	$captcha_settings['signup_form'] = '';
}
if(empty($captcha_settings['contractor_form'])) {
	$captcha_settings['contractor_form'] = '';
}
if(empty($captcha_settings['order_track_form'])) {
	$captcha_settings['order_track_form'] = '';
}
if(empty($captcha_settings['newsletter_form'])) {
	$captcha_settings['newsletter_form'] = '';
}
if(empty($captcha_settings['missing_product_form'])) {
	$captcha_settings['missing_product_form'] = '';
}
if(empty($captcha_settings['imei_number_based_search_form'])) {
	$captcha_settings['imei_number_based_search_form'] = '';
}

if(empty($other_settings['cust_payment_option'])) {
$other_settings['cust_payment_option'] = '';
}
if(empty($other_settings['cust_payment_type'])) {
$other_settings['cust_payment_type'] = '';
}
if(empty($other_settings['cust_payment_per_val'])) {
$other_settings['cust_payment_per_val'] = '';
}
if(empty($other_settings['payment_mode'])) {
$other_settings['payment_mode'] = '';
}
if(empty($other_settings['cust_payment_per_val'])) {
$other_settings['cust_payment_per_val'] = '';
}
if(empty($other_settings['stripe_test_publishable_key'])) {
$other_settings['stripe_test_publishable_key'] = '';
}
if(empty($other_settings['stripe_test_secret_key'])) {
$other_settings['stripe_test_secret_key'] = '';
}
if(empty($other_settings['stripe_live_publishable_key'])) {
$other_settings['stripe_live_publishable_key'] = '';
}
if(empty($other_settings['stripe_live_secret_key'])) {
$other_settings['stripe_live_secret_key'] = '';
}

//Template file
require_once("views/general_settings.php");

//Footer section
require_once("include/footer.php"); ?>
