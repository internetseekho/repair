<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

if(isset($post['missing_product'])) {
	
	$valid_csrf_token = verifyFormToken('missing_product');
	if($valid_csrf_token!='1') {
		writeHackLog('missing_product');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$email=real_escape_string($post['email']);
	$item_name=real_escape_string($post['item_name']);
	$subject='';
	$message=real_escape_string($post['message']);
	
	if($missing_product_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	if($name && $phone && $email && $item_name) {
		$query=mysqli_query($db,"INSERT INTO contact(name, phone, email, item_name, subject, message, date, type) values('".$name."','".$phone."','".$email."','".$item_name."','".$subject."','".$message."','".date('Y-m-d H:i:s')."', 'quote')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('quote_request_form_alert');

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
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$current_date_time}',
				'{$form_subject}',
				'{$form_message}',
				'{$item_name}');

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
				$post['name'],
				$phone,
				$post['email'],
				format_date(date('Y-m-d H:i:s')).' '.format_time(date('Y-m-d H:i:s')),
				$post['subject'],
				$post['message'],
				$post['item_name']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			$msg="Thank you for quote request. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry! something wrong updation failed.';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} elseif(isset($post['sell_this_device'])) {

	$valid_csrf_token = verifyFormToken('model_details');
	if($valid_csrf_token!='1') {
		writeHackLog('model_details');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	$post = $_POST;
	$location_id = $post['location_id'];

	foreach($post as $key=>$val) {
		if($key=="payment_method" || $key=="quantity" || $key=="sell_this_device" || $key=="device_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="req_storage" || $key=="id" || $key=="PHPSESSID" || $key=="base_price"  || $key=="promo_code" || $key=="promocode_id" || $key=="promocode_value" || $key=="csrf_token" || $key=="order_items" || $key=="ga" || $key=="gid" || $key=="cng_device_id" || $key=="cng_model_id") {
			continue;
		}

		$exp_key = explode(":",$key);
		$exp_val = explode("::",$val);

		$pf_q = "SELECT * FROM product_fields WHERE id = '".$exp_key[1]."'";
		$exe_pro_fld = mysqli_query($db,$pf_q);
		$product_fields_data = mysqli_fetch_assoc($exe_pro_fld);

		if(is_array($val) && $key!="files") {
			$radio_items_array = array();
			foreach($val as $val_k => $val_d) {
				$exp_val_d = explode("::",$val_d);
				$po_qry = mysqli_query($db,"SELECT * FROM product_options WHERE id='".$exp_val_d[1]."'");
				$product_options_data = mysqli_fetch_assoc($po_qry);
				$radio_items_array[] = array('opt_id'=>$exp_val_d[1],'opt_name'=>$exp_val_d[0],'opt_price'=>$product_options_data['price']);
			}
			if(!empty($radio_items_array)) {
				$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>$radio_items_array);
			}
		} else {
			if($exp_val[0]) {
				$po_qry = mysqli_query($db,"SELECT * FROM product_options WHERE id='".$exp_val[1]."'");
				$product_options_data = mysqli_fetch_assoc($po_qry);
				
				$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>array(array('opt_id'=>$exp_val[1],'opt_name'=>$exp_val[0],'opt_price'=>$product_options_data['price'])));
			}
		}
	}
	$order_items = json_encode($items_array);
	
	$order_files_array = array();
	if(!empty($_FILES)) {
		if(!file_exists('../images/orders/'))
			mkdir('../images/orders/',0777);

		if(!file_exists('../images/orders/files/'))
			mkdir('../images/orders/files/',0777);

		foreach($_FILES as $fdk=>$files_data) {
			if($files_data['name']!="") {
				$file_ext = pathinfo($files_data['name'],PATHINFO_EXTENSION);
				$file_tmp_name = $files_data['tmp_name'];
				$file_name=date('YmdHis').'_'.str_replace(':','_',$fdk).'.'.$file_ext;
				$order_files_array[] = $file_name;
				move_uploaded_file($file_tmp_name,'../images/orders/files/'.$file_name);
			}
		}
	}

	//START logic for promocode
	$date = date('Y-m-d');
	$amt = $post['payment_amt'];
	$promocode_id = $post['promocode_id'];
	$promo_code = $post['promo_code'];
	//if($promocode_id!='' && $promo_code!="" && $amt>0) {
	if($promocode_id!='' && $promo_code!="") {
		$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."'))");
		$promo_code_data = mysqli_fetch_assoc($query);

		$is_allow_code_from_same_cust = true;
		if($promo_code_data['multiple_act_by_same_cust']=='1' && $promo_code_data['multi_act_by_same_cust_qty']>0 && $user_id>0) {
			$query=mysqli_query($db,"SELECT COUNT(*) AS multiple_act_by_same_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."' AND user_id='".$user_id."'");
			$act_by_same_cust_data = mysqli_fetch_assoc($query);
			if($act_by_same_cust_data['multiple_act_by_same_cust']>$promo_code_data['multi_act_by_same_cust_qty']) {
				$is_allow_code_from_same_cust = false;
			}
		}

		$is_allow_code_from_cust = true;
		if($promo_code_data['act_by_cust']>0) {
			$query=mysqli_query($db,"SELECT COUNT(*) AS act_by_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."'");
			$act_by_cust_data = mysqli_fetch_assoc($query);
			if($act_by_cust_data['act_by_cust']>$promo_code_data['act_by_cust']) {
				$is_allow_code_from_cust = false;
			}
		}

		$is_promocode_exist = false;
		if(!empty($promo_code_data) && $is_allow_code_from_same_cust && $is_allow_code_from_cust) {
			$discount = $promo_code_data['discount'];
			if($promo_code_data['discount_type']=="flat") {
				$discount_of_amt = $discount;
				//$total = ($amt+$discount);
				//$discount_amt_with_format = amount_fomat($discount_of_amt);
				//$discount_amt_label = "Surcharge: ";
			} elseif($promo_code_data['discount_type']=="percentage") {
				$discount_of_amt = (($amt*$discount) / 100);
				//$total = ($amt+$discount_of_amt);
				//$discount_amt_with_format = amount_fomat($discount_of_amt);
				//$discount_amt_label = "Surcharge (".$discount."%): ";
			}
			$is_promocode_exist = true;
		} else {
			$msg = "This promo code has expired or not allowed so please try again.";
			setRedirectWithMsg(SITE_URL.'revieworder',$msg,'info');
			exit();
		}
	} //END logic for promocode

	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];
	$req_storage = $post['req_storage'];

	$order_id = $order_prefix.date('s').rand(100000,999999);
	mysqli_query($db,"INSERT INTO `orders`(`order_id`, `date`, `status`, promocode_id, promocode, promocode_amt, discount_type, discount) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial', '".$promocode_id."', '".$promo_code."', '".$discount_of_amt."', '".$promo_code_data['discount_type']."', '".$discount."')");

	$quantity_price = $post['payment_amt'];
	$item_price = ($quantity_price/* * $quantity*/);

	$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `files`, `price`, `quantity`, `quantity_price`) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".@implode(",",$order_files_array)."','".$item_price."','".$quantity."','".$quantity_price."')");
	$last_insert_id = mysqli_insert_id($db);
	if($query=="1") {
		$_SESSION['order_id']=$order_id;
		$_SESSION['location_id']=$location_id;
		setRedirect(SITE_URL.'repair/'.$order_id);
		exit();
	} else {
		$msg='Something went wrong! so please try again.';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}
}  elseif(isset($post['sell_my_device_new'])) {

	/*$valid_csrf_token = verifyFormToken('model_details');
	if($valid_csrf_token!='1') {
		writeHackLog('model_details');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}*/

	$post = $_POST;
	$location_id = $post['location_id'];

	foreach($post as $key=>$val) {
		if($key=="payment_method" || $key=="quantity" || $key=="sell_this_device" || $key=="sell_my_device_new" || $key=="device_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="req_storage" || $key=="id" || $key=="PHPSESSID" || $key=="base_price"  || $key=="promo_code" || $key=="promocode_id" || $key=="promocode_value" || $key=="csrf_token" || $key=="order_items" || $key=="ga" || $key=="gid" || $key=="cng_device_id" || $key=="cng_model_id" || $key=="model_id" || $key=="brand_id" || $key=="device_id" || $key=="device_category_id") {
			continue;
		}

		$exp_key = explode(":",$key);
		$exp_val = explode(":",$val);

		$pf_q = "SELECT * FROM product_fields WHERE id = '".$exp_key[1]."'";
		$exe_pro_fld = mysqli_query($db,$pf_q);
		$product_fields_data = mysqli_fetch_assoc($exe_pro_fld);

		if(is_array($val) && $key!="files") {
			$radio_items_array = array();
			foreach($val as $val_k => $val_d) {
				$exp_val_d = explode(":",$val_d);
				$po_qry = mysqli_query($db,"SELECT * FROM product_options WHERE id='".$exp_val_d[1]."'");
				$product_options_data = mysqli_fetch_assoc($po_qry);
				$radio_items_array[] = array('opt_id'=>$exp_val_d[1],'opt_name'=>$exp_val_d[0],'opt_price'=>$product_options_data['price']);
			}
			if(!empty($radio_items_array)) {
				$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>$radio_items_array);
			}
		} else {
			if($exp_val[0]) {
				$po_qry = mysqli_query($db,"SELECT * FROM product_options WHERE id='".$exp_val[1]."'");
				$product_options_data = mysqli_fetch_assoc($po_qry);
				
				$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>array(array('opt_id'=>$exp_val[1],'opt_name'=>$exp_val[0],'opt_price'=>$product_options_data['price'])));
			}
		}
	}
	$order_items = json_encode($items_array);
	/*echo '<pre>';
	print_r($post);
	print_r($items_array);
	exit;*/
	
	$order_files_array = array();
	if(!empty($_FILES)) {
		if(!file_exists('../images/orders/'))
			mkdir('../images/orders/',0777);

		if(!file_exists('../images/orders/files/'))
			mkdir('../images/orders/files/',0777);

		foreach($_FILES as $fdk=>$files_data) {
			if($files_data['name']!="") {
				$file_ext = pathinfo($files_data['name'],PATHINFO_EXTENSION);
				$file_tmp_name = $files_data['tmp_name'];
				$file_name=date('YmdHis').'_'.str_replace(':','_',$fdk).'.'.$file_ext;
				$order_files_array[] = $file_name;
				move_uploaded_file($file_tmp_name,'../images/orders/files/'.$file_name);
			}
		}
	}

	//START logic for promocode
	$date = date('Y-m-d');
	$amt = $post['payment_amt'];
	$promocode_id = $post['promocode_id'];
	$promo_code = $post['promo_code'];
	//if($promocode_id!='' && $promo_code!="" && $amt>0) {
	if($promocode_id!='' && $promo_code!="") {
		$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."'))");
		$promo_code_data = mysqli_fetch_assoc($query);

		$is_allow_code_from_same_cust = true;
		if($promo_code_data['multiple_act_by_same_cust']=='1' && $promo_code_data['multi_act_by_same_cust_qty']>0 && $user_id>0) {
			$query=mysqli_query($db,"SELECT COUNT(*) AS multiple_act_by_same_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."' AND user_id='".$user_id."'");
			$act_by_same_cust_data = mysqli_fetch_assoc($query);
			if($act_by_same_cust_data['multiple_act_by_same_cust']>$promo_code_data['multi_act_by_same_cust_qty']) {
				$is_allow_code_from_same_cust = false;
			}
		}

		$is_allow_code_from_cust = true;
		if($promo_code_data['act_by_cust']>0) {
			$query=mysqli_query($db,"SELECT COUNT(*) AS act_by_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."'");
			$act_by_cust_data = mysqli_fetch_assoc($query);
			if($act_by_cust_data['act_by_cust']>$promo_code_data['act_by_cust']) {
				$is_allow_code_from_cust = false;
			}
		}

		$is_promocode_exist = false;
		if(!empty($promo_code_data) && $is_allow_code_from_same_cust && $is_allow_code_from_cust) {
			$discount = $promo_code_data['discount'];
			if($promo_code_data['discount_type']=="flat") {
				$discount_of_amt = $discount;
				//$total = ($amt+$discount);
				//$discount_amt_with_format = amount_fomat($discount_of_amt);
				//$discount_amt_label = "Surcharge: ";
			} elseif($promo_code_data['discount_type']=="percentage") {
				$discount_of_amt = (($amt*$discount) / 100);
				//$total = ($amt+$discount_of_amt);
				//$discount_amt_with_format = amount_fomat($discount_of_amt);
				//$discount_amt_label = "Surcharge (".$discount."%): ";
			}
			$is_promocode_exist = true;
		} else {
			$msg = "This promo code has expired or not allowed so please try again.";
			setRedirectWithMsg(SITE_URL.'revieworder',$msg,'info');
			exit();
		}
	} //END logic for promocode

	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];
	$req_storage = $post['req_storage'];

	$order_id = $order_prefix.date('s').rand(100000,999999);
	mysqli_query($db,"INSERT INTO `orders`(`order_id`, `date`, `status`, promocode_id, promocode, promocode_amt, discount_type, discount) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial', '".$promocode_id."', '".$promo_code."', '".$discount_of_amt."', '".$promo_code_data['discount_type']."', '".$discount."')");

	$quantity_price = $post['payment_amt'];
	$item_price = ($quantity_price/* * $quantity*/);

	$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `files`, `price`, `quantity`, `quantity_price`) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".@implode(",",$order_files_array)."','".$item_price."','".$quantity."','".$quantity_price."')");
	$last_insert_id = mysqli_insert_id($db);
	if($query=="1") {
		$_SESSION['order_id']=$order_id;
		$_SESSION['location_id']=$location_id;
		setRedirect(SITE_URL.'repair/'.$order_id);
		exit();
	} else {
		$msg='Something went wrong! so please try again.';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>