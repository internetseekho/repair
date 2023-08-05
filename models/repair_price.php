<?php
//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

$price = 0;
if(!isset($post['brand_id'])) {
	$post['brand_id'] = '';
}
if(!isset($post['device_id'])) {
	$post['device_id'] = '';
}
if(!isset($post['filter_by'])) {
	$post['filter_by'] = '';
}
if(!isset($post['model_id'])) {
	$post['model_id'] = '';
}

//Fetch device list
$devices_q='';
if($post['brand_id']) {
	//$devices_q=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND brand_id='".$post['brand_id']."'");
	$devices_q=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.brand_id='".$post['brand_id']."' AND b.id='".$post['brand_id']."' GROUP BY m.device_id ORDER BY d.ordering ASC");
}

$mobile_q='';
if($post['device_id']) {
	$mobile_q=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url AS d_sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.device_id='".$post['device_id']."' ORDER BY m.id DESC");
}

$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

//Filter by users based on title, device
$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
}
if($post['brand_id']) {
	$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
}
if($post['device_id']) {
	$filter_by .= " AND m.device_id = '".$post['device_id']."'";
}
if($post['model_id']) {
	$filter_by .= " AND m.id = '".$post['model_id']."'";
}

$fault_list = array();
$fq="SELECT fpm.*, m.title, d.title AS device_title, d.sef_url AS d_sef_url, b.title AS brand_title, c.title AS cat_title FROM fault_price_manager AS fpm LEFT JOIN mobile AS m ON m.id=fpm.model_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE 1 ".$filter_by."";
$query=mysqli_query($db,$fq);
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
		
		$fault_list[] = $model_data;
	}
}
?>
