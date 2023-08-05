<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once('../models/model.php');
require_once("common.php");

$field_ids = array();

$req_data = $_POST;
//print_r($req_data);
if(!empty($req_data)) {
	$req_model_id = $req_data['req_model_id'];
	
	$order_items_name = '';
	foreach($req_data as $key=>$val) {
		if($key=="payment_method" || $key=="quantity" || $key=="sell_this_device" || $key=="device_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="req_storage" || $key=="id" || $key=="PHPSESSID" || $key=="base_price"  || $key=="promo_code" || $key=="promocode_id" || $key=="promocode_value" || $key=="csrf_token" || $key=="order_items" || $key=="ga" || $key=="gid" || $key=="cng_device_id" || $key=="cng_model_id") {
			continue;
		}
		
		$exp_key_rd = explode(":",$key);
		//print_r($exp_key_rd);
		$key = $exp_key_rd[0];
		
		$pf_q = "SELECT * FROM product_fields WHERE id = '".$exp_key_rd[1]."'";
		$exe_pro_fld = mysqli_query($db,$pf_q);
		$product_fields_data = mysqli_fetch_assoc($exe_pro_fld);
		$input_type = $product_fields_data['input_type'];
		
		$val_lbl = '';
		if(is_array($val)) {
			foreach($val as $val_k => $val_l) {
				$val_dt = explode("::",$val_l);
				if($val_dt[1]>0) {
					$val_lbl .= $val_dt[0].', ';
					$field_ids[] = $val_dt[1];
				}
			}
		}
		
		if($val_lbl!="") {
			$order_items_array[] = str_replace("_"," ",$key).": ".rtrim($val_lbl,', ');
			if($input_type!="text" && $input_type!="textarea" && $input_type!="file" && $val_lbl!="") {
				$order_items_name .= '<li><strong>'.str_replace("_"," ",$key).":</strong><br />".rtrim($val_lbl,', ').'</li>';
			}
		} else {

			$val_dt = explode("::",$val);
			if($val_dt[1]>0) {
				$val = $val_dt[0].', ';
				$field_ids[] = $val_dt[1];
			}

			$order_items_array[] = str_replace("_"," ",$key).": ".$val;
			if($input_type!="text" && $input_type!="textarea" && $input_type!="file" && $val!="") {
				$order_items_name .= '<li><strong>'.str_replace("_"," ",$key).":</strong><br />".rtrim($val,', ').'</li>';
			}
		}
	}
	$order_items = implode("::",$order_items_array);
	//$order_items_name = implode("::",$order_items_name_array);
	$order_items_name = ($order_items_name?'<ul>'.$order_items_name.'</ul>':'');

	$query = mysqli_query($db,"SELECT m.* FROM mobile AS m WHERE m.id='".$req_model_id."'");
	$model_data = mysqli_fetch_assoc($query);
	$f_model_price = 0;//$model_data['price'];

	if(!empty($field_ids)) {
		foreach($field_ids as $field_id) {
			$po_qry = mysqli_query($db,"SELECT * FROM product_options WHERE id='".$field_id."'");
			$product_options_data = mysqli_fetch_assoc($po_qry);
			if($product_options_data['price'] > 0) {
				$f_model_price = ($f_model_price+$product_options_data['price']);
			}	
		}
	}
}

$response_array = array();
if($f_model_price>0) {
	$response_array['payment_amt'] = $f_model_price;
	//$response_array['order_items'] = $order_items;
	$response_array['order_items_name'] = $order_items_name;
} else {
	$response_array['payment_amt'] = '0';
	//$response_array['order_items'] = $order_items;
	$response_array['order_items_name'] = $order_items_name;
}

echo json_encode($response_array);
exit;