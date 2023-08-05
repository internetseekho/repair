<?php 
$file_name="fault_list";

//Header section
require_once("include/header.php");

//Filter by users based on title, device
$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
}

if($post['cat_id']) {
	$filter_by .= " AND m.cat_id = '".$post['cat_id']."'";
}

if($post['brand_id']) {
	$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
}

if($post['device_id']) {
	$filter_by .= " AND m.device_id = '".$post['device_id']."'";
}

$data_list = array();
$query=mysqli_query($db,"SELECT fpm.*, m.title, d.title AS device_title, d.sef_url, b.title AS brand_title, c.title AS cat_title FROM fault_price_manager AS fpm LEFT JOIN  mobile AS m ON m.id=fpm.model_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE 1 ".$filter_by."");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($model_data=mysqli_fetch_assoc($query)) {
		//$prev_url = SITE_URL.$model_data['sef_url'].'/'.createSlug($model_data['title']).'/'.$model_data['id'];
		//$price = amount_fomat($model_data['price']);
		$_offer_start_date=$model_data['offer_start_date']!=''?date('m/d/Y',strtotime($model_data['offer_start_date'])):'';
		$model_data['_offer_start_date']=$_offer_start_date;

		$_offer_end_date=$model_data['offer_end_date']!=''?date('m/d/Y',strtotime($model_data['offer_end_date'])):'';
		$model_data['_offer_end_date']=$_offer_end_date;

		$regular_price_display = amount_fomat($model_data['regular_price']);
		$model_data['regular_price_display']=$regular_price_display;

		$sale_price_display = ($model_data['sale_price'] && $model_data['sale_price']!='')?amount_fomat($model_data['sale_price']):'';
		$model_data['sale_price_display']=$sale_price_display;

		$data_list[] = $model_data;
	}
}

$json_data_list = json_encode($data_list);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

//Template file
require_once("views/fault_list.php");

//Footer section
include("include/footer.php"); ?>
