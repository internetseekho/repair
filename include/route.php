<?php
$devices_id = 0;
$device_id = 0;
$brand_id = 0;
$cat_id = 0;
$category_id = 0;

//START get url params
$path_info = parse_path();

$url_first_param = '';
if(isset($path_info['call_parts'][0])) {
	$url_first_param = $path_info['call_parts'][0];
}

$url_second_param = '';
if(isset($path_info['call_parts'][1])) {
	$url_second_param = $path_info['call_parts'][1];
}

$url_third_param = '';
if(isset($path_info['call_parts'][2])) {
	$url_third_param = $path_info['call_parts'][2];
}

$url_four_param = '';
if(isset($path_info['call_parts'][3])) {
	$url_four_param = $path_info['call_parts'][3];
} //END get url params

//START for get custom/inbuild page menu list
$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.parent AS parent_menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.url='".$url_first_param."' ORDER BY p.id, m.id ASC");
if($url_first_param=="") {
	$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.parent AS parent_menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.slug='home' ORDER BY p.id, m.id ASC");
}

$active_page_data=mysqli_fetch_assoc($p_query);
if($active_page_data['menu_id']<=0) {
	$active_page_data['menu_name'] = $active_page_data['title'];
}

$is_custom_or_inbuild_page = mysqli_num_rows($p_query);
if($is_custom_or_inbuild_page>0) {
	$page_url = $active_page_data['url'];
	$meta_title = $active_page_data['meta_title'];
	$meta_desc = $active_page_data['meta_desc'];
	$meta_keywords = $active_page_data['meta_keywords'];
	
	include("include/header.php");
	
	$inbuild_page_array = array('home','affiliates','contact','reviews','repair-my-mobile','signup','login','terms-and-conditions','review-form','bulk-order-form','get-quote','contractor-form','order-track','offers','branches','missing-product-form','repair-price','services', 'instant-repair-model');
	if(in_array($active_page_data['slug'],$inbuild_page_array)) {
		include 'views/'.str_replace('-','_',$active_page_data['slug']).'.php';
	} elseif(trim($active_page_data['cat_id'])>0) {
		$cat_id = $active_page_data['cat_id'];
		include 'views/models.php';
	} elseif(trim($active_page_data['device_id'])!='') {
		$devices_id = $active_page_data['device_id'];
		include 'views/models.php';
	} elseif(trim($active_page_data['brand_id'])>0) {
		$brand_id = $active_page_data['brand_id'];
		include 'views/devices.php';
	} elseif($active_page_data['slug']=="blog") {
		$blog_url = trim($url_second_param);
		if($blog_url) {
			include 'views/blog/blog_view.php';
		} else {
			include 'views/blog/blog.php';
		}
	} else {
		include 'views/page.php';
	}
} //END for get custom/inbuild page menu list
else
{
	$other_single_page_array = array('revieworder','enterdetails','lost_password','reset_password','profile','account','change-password','search','order_offer','verify_step3','verify_account','repair','view_appointment','contractor-form-thank-you','brands','recently-ordered');

	//START for mobile models, mobile model detail page
	$device_single_data_resp=get_device_single_data($url_first_param);
	
	if(trim($category_details_page_slug) && $url_first_param==basename($category_details_page_slug)) {
	$category_single_data_resp=get_category_single_data_by_sef_url($url_second_param);
	} else {
	$category_single_data_resp=get_category_single_data_by_sef_url($url_first_param);
	}
	
	$brand_single_data_resp=get_brand_single_data_by_sef_url($url_first_param);
	
	if(trim($model_details_page_slug)) {
	$mobile_single_data_resp = get_mobile_single_data_by_url_id($url_second_param, $url_third_param);
	} else {
	$mobile_single_data_resp = get_mobile_single_data_by_url_id($url_first_param, $url_second_param);
	}
	
	if($category_single_data_resp['num_of_category']>0) {
		$category_id = $category_single_data_resp['category_single_data']['id'];
		$brand_single_data_resp = get_brand_single_data_by_sef_url($url_second_param);
		if($brand_single_data_resp['num_of_brand']>0) {
			$brand_id=$brand_single_data_resp['brand_single_data']['id'];
			$device_id=0; //$url_four_param;
			include 'views/device_brand_models.php';
		} else {
			include 'views/category_brands.php';
		}
	} elseif($brand_single_data_resp['num_of_brand']>0) {
		$brand_id = isset($brand_single_data_resp['brand_single_data']['id'])?$brand_single_data_resp['brand_single_data']['id']:0;
		$device_single_data_resp = get_device_single_data($url_second_param);
		$device_id = $device_single_data_resp['device_single_data']['device_id'];
		include 'views/device_brand_models.php';
	} elseif($device_single_data_resp['num_of_device']>0 && $mobile_single_data_resp['num_of_model']<=0) {
		include 'views/models.php';
	} elseif($mobile_single_data_resp['num_of_model']>0) {
		include 'views/model_details.php';
	} //END for mobile models, mobile model detail page

	//START for other menu
	elseif(in_array($url_first_param,$other_single_page_array)) {
		include 'views/'.str_replace('-','_',$url_first_param).'.php';
	} elseif($url_first_param=="category") {
		include 'views/blog/cat_view.php';
	} elseif($url_first_param=="offer-status") {
		include 'controllers/offer_status.php';
	} else {
		setRedirect(SITE_URL);
		exit();
	} //END for other menu
} ?>