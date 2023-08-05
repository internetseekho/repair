<?php 
$file_name="mobile";

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
$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title, c.title AS cat_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE 1 ".$filter_by."");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($model_data=mysqli_fetch_assoc($query)) {
		$prev_url = SITE_URL.$model_data['sef_url'].'/'.createSlug($model_data['title']).'/'.$model_data['id'];
		$price = amount_fomat($model_data['price']);
		$data_list[] = array('id'=>$model_data['id'],'title'=>$model_data['title'],'price'=>$price,'sef_url'=>$model_data['sef_url'],'cat_title'=>$model_data['cat_title'],'brand_title'=>$model_data['brand_title'],'device_title'=>$model_data['device_title'],'image'=>$model_data['model_img'],'ordering'=>$model_data['ordering'],'status'=>$model_data['published'],'prev_url'=>$prev_url);
	}
}
$json_data_list = json_encode($data_list);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

//Template file
require_once("views/mobile/mobile.php");

//Footer section
include("include/footer.php"); ?>
