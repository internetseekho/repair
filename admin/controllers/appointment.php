<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['create_shipment'])) {
	$id = $post['id'];
	if($id=="") {
		$msg='Sorry! something wrong!!';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'view_appointment.php?id='.$id);
		exit();
	}

	$query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$id."'");
	$appointment_data = mysqli_fetch_assoc($query);
	if($appointment_data['shipping_address'] == "" || $appointment_data['shipping_city'] == "" || $appointment_data['shipping_state'] == "" || $appointment_data['shipping_zipcode'] == "") {
		$msg='You must need to fillup shipping fields (Ship Your Device) on <a class="btn btn-sm btn-accent" href="'.ADMIN_URL.'addedit_appointment.php?id='.$id.'">edit order</a>';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'view_appointment.php?id='.$id);
		exit();
	}
	
	//START post shipment by easypost API
	if($shipping_api == "easypost" && $shipping_api_key != "") {
		require_once("../../libraries/easypost-php-master/lib/easypost.php");
		\EasyPost\EasyPost::setApiKey($shipping_api_key);

		// create address
		$to_address_params = array(
			"verify"  =>  array("delivery"),
			//'name' => $company_name,
			'company' => $company_name,
			'street1' => $company_address,
			'city' => $company_city,
			'state' => $company_state,
			'zip' => $company_zipcode,
			'country' => $company_country,
			'phone' => substr(preg_replace("/[^\d]/", "", $company_phone), -10),
			'email' => $site_email
		);

		// create address
		$from_address_params = array(
			"verify"  =>  array("delivery"),
			'name' => $appointment_data['name'],
			'street1' => $appointment_data['shipping_address'],
			//'street2' => "",
			'city' => $appointment_data['shipping_city'],
			'state' => $appointment_data['shipping_state'],
			'zip' => $appointment_data['shipping_zipcode'],
			'country' => $company_country,
			'phone' => substr(preg_replace("/[^\d]/", "", $appointment_data['phone']), -10),
			'email' => $appointment_data['email']
		);
	
		$to_address = \EasyPost\Address::create($to_address_params);
		$from_address = \EasyPost\Address::create($from_address_params);

		if($to_address->verifications->delivery->success != '1') {
			$msg='Company address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'view_appointment.php?id='.$id);
			exit();
		}
		
		if($from_address->verifications->delivery->success != '1') {
			$msg='Shipping address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'view_appointment.php?id='.$id);
			exit();
		}
		
		if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
			$shipment = \EasyPost\Shipment::create(array(
			  "to_address" => $to_address,
			  "from_address" => $from_address,
			  "parcel" => array(
				"length" => $shipping_parcel_length,
				"width" => $shipping_parcel_width,
				"height" => $shipping_parcel_height,
				"weight" => $shipping_parcel_weight
			  )
			));
	
			//$shipment->buy(array('rate' => array('id' => $shipment->rates[0]->id)));
			$shipment->buy(array(
			  'rate' => $shipment->lowest_rate()
			));
					
			$shipment->label(array(
			  'file_format' => 'PDF'
			));
			//print_r($shipment);
	
			$shipment_id = $shipment->id;
			$shipment_tracking_code = $shipment->tracker->tracking_code;
			$shipment_label_url = $shipment->postage_label->label_url;
		}
		
		mysqli_query($db,"UPDATE appointments SET shipping_api='".$shipping_api."', shipment_id='".$shipment_id."', shipment_tracking_code='".$shipment_tracking_code."', shipment_label_url='".$shipment_label_url."' WHERE id='".$id."'");
	} //END post shipment by easypost API

	$msg = "Shipment successfully created.";
	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'view_appointment.php?id='.$id);
	exit();
} elseif(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM appointments WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$appt_id = '';
			$f_query = mysqli_query($db,"SELECT * FROM appointments WHERE id='".$id_v."'");
			$appointment_data = mysqli_fetch_assoc($f_query);
			$appt_id = $appointment_data['appt_id'];
			
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM appointments WHERE id="'.$id_v.'"');
			if($query=='1') {
				mysqli_query($db,'DELETE FROM invoice WHERE appt_id="'.$appt_id.'"');
			}
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE appointments SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['update'])) {
	$appt_id=$post['appt_id'];
	$is_send_alert=$post['is_send_alert'];
	$is_send_sms_alert=$post['is_send_sms_alert'];
	$note=real_escape_string($post['note']);
	$status=$post['status'];

	$query = mysqli_query($db,"SELECT * FROM appointments WHERE appt_id='".$appt_id."'");
	$appointment_data = mysqli_fetch_assoc($query);

	if($appt_id) {
		$query=mysqli_query($db,"UPDATE appointments SET status='".$status."' WHERE appt_id='".$appt_id."'");
		if($query=="1") {
			if($is_send_alert=='1' || $is_send_sms_alert=='1') {
				
				$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE id='".$status."'");
				$appt_status_data = mysqli_fetch_assoc($appt_status_query);

				$template_data = get_template_data('admin_reply_from_order');
				$admin_user_data = get_admin_user_data();
				$customer_data = get_user_data($appointment_data['user_id']);

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
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$customer_company_name}',
					'{$appt_id}',
					'{$appt_date}',
					'{$appt_time}',
					'{$appt_status}',
					'{$product_name}',
					'{$amount}',
					'{$current_date_time}');
	
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
					$customer_data['first_name'],
					$customer_data['last_name'],
					$customer_data['name'],
					$customer_data['phone'],
					$customer_data['email'],
					$customer_data['address'],
					$customer_data['address2'],
					$customer_data['city'],
					$customer_data['state'],
					$customer_data['country'],
					$customer_data['postcode'],
					$customer_data['company_name'],
					$appointment_data['appt_id'],
					$appointment_data['appt_date'],
					str_replace("_"," to ",$appointment_data['appt_time']),
					ucwords(str_replace('_',' ',$appt_status_data['name'])),
					$appointment_data['item_name'],
					amount_fomat($appointment_data['item_amount']),
					format_date(date('Y-m-d H:i:s')).' '.format_time(date('Y-m-d H:i:s')));
	
				if(!empty($template_data)) {
					if($is_send_alert=='1') {
						$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
						$email_body_text = str_replace($patterns,$replacements,$post['note']);
						send_email($customer_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
					}
					
					//START sms send to customer
					if($template_data['sms_status']=='1' && $sms_sending_status=='1' && $is_send_sms_alert=='1') {
						$from_number = '+'.$general_setting_data['twilio_long_code'];
						$to_number = '+'.$customer_data['phone'];
						if($from_number && $account_sid && $auth_token) {
							$sms_body_text = str_replace($patterns,$replacements,$post['sms_content']);
							
							try {
								$sms_api->messages->create(
									$to_number,
									array(
										'from' => $from_number,
										'body' => $sms_body_text
									)
								);
							} catch(Exception $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
							
							/*try {
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
							} catch(Exception $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}*/
						}
					} //END sms send to customer
				}
	
				$msg="Successfully send alert to customer & appointment status updated.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg="Appointment status has been successfully updated.";
				$_SESSION['success_msg']=$msg;
			}
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'view_appointment.php?id='.$appointment_data['id']);
		exit();
	}
} elseif(isset($post['addedit_appt'])) {
	$post = $_POST;

	/*echo '<pre>';
	print_r($post);
	exit;*/

	foreach($post as $key=>$val) {
		if($key=="product_id" || $key=="item_amount" || $key=="status" || $key=="quantity" || $key=="device_id" || $key=="payment_amt" || $key=="user_id" || $key=="name" || $key=="email" || $key=="phone"  || $key=="address1" || $key=="address2" || $key=="city" || $key=="state" || $key=="postcode" || $key=="user_other_fields_status" || $key=="shipping_method" || $key=="address" || $key=="instructions" || $key=="floor_no" || $key=="shipping_address" || $key=="shipping_city" || $key=="shipping_state" || $key=="shipping_zipcode" || $key=="location_id" || $key=="date" || $key=="time_slot" || $key=="extra_remarks" || $key=="id" || $key=="published" || $key=="cometoyou_address" || $key=="cometoyou_city" || $key=="cometoyou_state" || $key=="cometoyou_zipcode") {
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
	
	$order_files_array = array();
	if(!empty($_FILES)) {
		if(!file_exists('../../images/orders/'))
			mkdir('../../images/orders/',0777);

		if(!file_exists('../../images/orders/files/'))
			mkdir('../../images/orders/files/',0777);

		foreach($_FILES as $fdk=>$files_data) {
			if($files_data['name']!="") {
				$file_ext = pathinfo($files_data['name'],PATHINFO_EXTENSION);
				$file_tmp_name = $files_data['tmp_name'];
				$file_name=date('YmdHis').'_'.str_replace(':','_',$fdk).'.'.$file_ext;
				$order_files_array[] = $file_name;
				move_uploaded_file($file_tmp_name,'../../images/orders/files/'.$file_name);
			}
		}
	}
	
	$id=$post['id'];
	$product_id=$post['product_id'];
	$item_amount=$post['item_amount'];
	$name=real_escape_string($post['name']);
	$email=$post['email'];
	$phone=$post['phone'];
	$appt_id=$post['appt_id'];
	$user_id=$post['user_id'];
	$status=$post['status'];
	$published=$post['published'];

	$instructions='';

	$shipping_method=$post['shipping_method'];
	if($shipping_method == "come_to_you") {
		$shipping_address=$post['cometoyou_address'];
		$shipping_city=$post['cometoyou_city'];
		$shipping_state=$post['cometoyou_state'];
		$shipping_zipcode=$post['cometoyou_zipcode'];
		$instructions=$post['instructions'];
	} else {
		$shipping_address=$post['shipping_address'];
		$shipping_city=$post['shipping_city'];
		$shipping_state=$post['shipping_state'];
		$shipping_zipcode=$post['shipping_zipcode'];
	}

	$location_id=$post['location_id'];
	$expl_appt_date = explode("/",$post['date']);
	$appt_date = $expl_appt_date[2].'-'.$expl_appt_date[0].'-'.$expl_appt_date[1];
	$appt_time=$post['time_slot'];
	$extra_remarks=$post['extra_remarks'];

	$sql_pro = "SELECT * FROM mobile WHERE id='".$product_id."'";
	$exe_pro = mysqli_query($db,$sql_pro);
	$row_pro = mysqli_fetch_assoc($exe_pro);
	$product_name = $row_pro['title'];

	if($name && $email && $phone && $appt_date && $appt_time) {
		$is_update = false;
		$is_insert = false;
		if($id>0) {
			$f_query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$id."'");
			$appointment_data = mysqli_fetch_assoc($f_query);
			$discount = $appointment_data['discount'];
			if($appointment_data['discount_type']=="flat") {
				$discount_of_amt = $discount;
			} elseif($appointment_data['discount_type']=="percentage") {
				$discount_of_amt = (($item_amount*$discount) / 100);	
			}

			$query=mysqli_query($db,"UPDATE appointments SET user_id='".$user_id."', product_id='".$product_id."', item_name='".real_escape_string($order_items)."', item_amount='".$item_amount."', name='".$name."', email='".$email."', phone='".$phone."', instructions='".$instructions."', shipping_method='".$shipping_method."', location_id='".$location_id."', appt_date='".$appt_date."', appt_time='".$appt_time."', extra_remarks='".$extra_remarks."', status='".$status."', published='".$published."', shipping_address='".$shipping_address."', shipping_city='".$shipping_city."', shipping_state='".$shipping_state."', shipping_zipcode='".$shipping_zipcode."', item_files='".@implode(",",$order_files_array)."', promocode_amt='".$discount_of_amt."' WHERE id='".$id."'");
			$appointment_id = $id;
			$is_update = true;
		} else {
			$appt_id = $order_prefix.date('s').rand(100000,999999);

			$query=mysqli_query($db,"INSERT INTO appointments(appt_id, user_id, product_id, item_name, item_amount, name, email, phone, instructions, shipping_method, location_id, appt_date, appt_time, extra_remarks, added_date, status, published, item_files) VALUES('".$appt_id."','".$user_id."','".$product_id."','".real_escape_string($order_items)."','".$item_amount."','".$name."','".$email."','".$phone."','".$instructions."','".$shipping_method."','".$location_id."','".$appt_date."','".$appt_time."','".$extra_remarks."','".date('Y-m-d H:i:s')."','".$status."','".$published."','".@implode(",",$order_files_array)."')");
			$appointment_id = mysqli_insert_id($db);
			$is_insert = true;
		}
		
		if($query=="1") {
		
			$address1=real_escape_string($post['address1']);
			$address2=real_escape_string($post['address2']);
			$city=real_escape_string($post['city']);
			$state=real_escape_string($post['state']);
			$postcode=real_escape_string($post['postcode']);
			$user_other_fields_status=$post['user_other_fields_status'];
			
			$u_query=mysqli_query($db,"SELECT * FROM users WHERE email='".$email."'");
			$exist_user_data=mysqli_fetch_assoc($u_query);
			if(empty($exist_user_data)) {
				mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, `email`, `address`, `address2`, `city`, `state`, `postcode`, `company_name`, `username`, `date`, `status`) VALUES('".$name."','".$name."','','".$phone."','".$email."','".$address1."','".$address2."','".$city."','".$state."','".$postcode."','','".$email."','".date('Y-m-d H:i:s')."','1')");
				$user_id = mysqli_insert_id($db);
				mysqli_query($db,"UPDATE `appointments` SET `user_id`='".$user_id."' WHERE id='".$appointment_id."'");
			} else {
				mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`phone`='".$phone."',`update_date`='".date('Y-m-d H:i:s')."' WHERE email='".$email."'");
				if($user_other_fields_status == '1') {
					mysqli_query($db,"UPDATE `users` SET `address`='".$address1."',`address2`='".$address2."',`city`='".$city."',`state`='".$state."',`postcode`='".$postcode."' WHERE email='".$email."'");
				}
				mysqli_query($db,"UPDATE `appointments` SET `user_id`='".$exist_user_data['id']."' WHERE id='".$appointment_id."'");
			}
			
			//Get location data based on locationID
			function get_single_location_data($id) {
				global $db;
				$response = array();
				$query=mysqli_query($db,"SELECT * FROM locations WHERE published='1' AND id='".$id."'");
				$response = mysqli_fetch_assoc($query);
				return $response;
			}

			$single_location_data = get_single_location_data($location_id);
			
			if($is_insert == true) {
				//Email send to Admin
				$template_data = get_template_data('appt_form_alert');
				$template_data_to_customer = get_template_data('appt_thank_you_email_to_customer');

				//Get admin user data
				$admin_user_data = get_admin_user_data();

				$logo = '<img src="'.$logo_url.'" width="180">';
				$admin_logo = '<img src="'.SITE_URL.'images/'.$general_setting_data['admin_logo'].'" width="180">';

				if($location_id>0) {
					$company_address = $single_location_data['address'];
					$company_city = $single_location_data['city'];
					$company_state = $single_location_data['state'];
					$company_zipcode = $single_location_data['zipcode'];
					$company_country = $single_location_data['country'];
					$company_name = $company_name.($single_location_data['name']?' - '.$single_location_data['name']:'');
				}

				$item_name_array = $items_array;
				$total_amount = $item_amount;

				$order_files_html = '';
				if(!empty($order_files_array)) {
					$order_files_list = explode(",",$order_files_array);
					foreach($order_files_array as $file_k=>$file_v) {
						if($file_v!="") {
							$file_image_ext = pathinfo($file_v, PATHINFO_EXTENSION);
							$order_files_html .= '<tr>
								<td colspan="2" bgcolor="#ddd" width="100%" style="padding:15px;"><a href="'.SITE_URL.'images/orders/files/'.$file_v.'" '.($file_image_ext!="txt"&&$file_image_ext!="pdf"?'data-lightbox="image"':'target="_blank"').'>'.$file_v.'</a></td>
							</tr>
							<tr><td style="padding:1px;"></td></tr>';
						}
					}
				}

				$item_list_html = '';
				if(!empty($item_name_array)) {
					foreach($item_name_array as $item_name_data) {
						$items_name = '';
						$items_opt_name = '';
			
						$items_opt_price = '';
						$items_opt_price_arr = array();
			
						$items_name = '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).'</strong>';
			
						$item_list_html .= '<tr>
							<td colspan="2" bgcolor="#ddd" width="100%" style="padding:15px;">'.$items_name.'</td>
						</tr>
						<tr><td style="padding:1px;"></td></tr>';
			
						if(!empty($item_name_data['opt_data'])) {
							foreach($item_name_data['opt_data'] as $opt_data) {
								$items_opt_name = $opt_data['opt_name'];

								$item_list_html .= '<tr>
									<td bgcolor="#ddd" width="80%" style="padding:15px;">'.$items_opt_name.'</td>';
									if($online_booking_hide_price != '1') {
									$item_list_html .= '<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.amount_fomat($opt_data['opt_price']).'</td>';
									}
								$item_list_html .= '</tr>
								<tr><td style="padding:1px;"></td></tr>';
							}
						}
					}
				}
			
				if($order_files_html) {
					$item_list_html .= '<tr>
						<td colspan="2" bgcolor="#ddd" width="100%" style="padding:15px;"><b>Files</b></td>
					</tr>
					<tr><td style="padding:1px;"></td></tr>';
					$item_list_html .= $order_files_html;
				}
			
				if($online_booking_hide_price != '1') {
					if($promocode_amt>0) {
						$item_list_html .= '<tr>
							<td bgcolor="#ddd" width="80%" style="padding:15px;"><b>Item Total</b></td>
							<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.amount_fomat($total_amount).'</td>
						</tr>
						<tr><td style="padding:1px;"></td></tr>';
						$item_list_html .= '<tr>
							<td bgcolor="#ddd" width="80%" style="padding:15px;">'.$discount_amt_label.'</td>
							<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">-'.amount_fomat($promocode_amt).'</td>
						</tr>
						<tr><td style="padding:1px;"></td></tr>';
					}
				
					$item_list_html .= '<tr>
						<td bgcolor="#ddd" width="80%" style="padding:15px;"><b>Total</b></td>
						<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.amount_fomat($total_amount-$promocode_amt).'</td>
					</tr>
					<tr><td style="padding:1px;"></td></tr>';
				}

				$items_body_html .= '<table width="650" cellpadding="0" cellspacing="0">';
					$items_body_html .= '
						<tr><td style="padding:10px;"></td></tr>
						<tr>
							<td width="80%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Repair Selected Item</strong></td>';
							if($online_booking_hide_price != '1') {
							$items_body_html .= '<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Price</strong></td>';
							}
						$items_body_html .= '</tr>
						<tr><td style="padding:0px;"></td></tr>';
					$items_body_html .= '<tbody>'.$item_list_html.'</tbody>';
				$items_body_html .= '</table>';

				//echo $items_body_html;
				//exit;

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
					'{$product_name}',
					'{$product_items}',
					'{$shipping_method}',
					'{$shop_location}',
					'{$appt_date}',
					'{$appt_time_slot}',
					'{$extra_remarks}',
					'{$amount}',
					'{$address}',
					'{$city}',
					'{$state}',
					'{$zipcode}',
					'{$floor_no}',
					'{$instructions}');
	
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
					$name,
					$phone,
					$email,
					$product_name,
					$items_body_html,
					$shipping_method,
					str_replace("_"," ",$shipping_method),
					format_date($appt_date),
					format_time(str_replace("_"," to ",$appt_time)),
					$extra_remarks,
					amount_fomat($item_amount),
					$shipping_address,
					$shipping_city,
					$shipping_state,
					$shipping_zipcode,
					'',
					$instructions);
				
				$shop_admin_email = $admin_user_data['email'];

				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				$shop_location_email = "";
				if($location_id>0) {
					send_email($single_location_data['email'], $email_subject, $email_body_text, $name, $email);
					if(trim($single_location_data['cc_email'])) {
						send_email($single_location_data['cc_email'], $email_subject, $email_body_text, $name, $email);
					}
					$shop_location_email = $single_location_data['email'];
				} else {
					send_email($shop_admin_email, $email_subject, $email_body_text, $name, $email);
				}
				
				//Email send to User
				if(!empty($template_data_to_customer)) {
					$email_subject = str_replace($patterns,$replacements,$template_data_to_customer['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data_to_customer['content']);
					
					send_email($email, $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
					
					//START sms send to customer
					if($template_data_to_customer['sms_status']=='1' && $phone!="") {
						$from_number = '+'.$general_setting_data['twilio_long_code'];
						$to_number = '+'.$user_phone_country_code.$phone;
						if($from_number && $account_sid && $auth_token) {
							$sms_body_text = str_replace($patterns,$replacements,$template_data_to_customer['sms_content']);
							
							try {
								$sms_api->messages->create(
									$to_number,
									array(
										'from' => $from_number,
										'body' => $sms_body_text
									)
								);
							} catch(Exception $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
							
							/*try {
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
							} catch(Exception $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}*/
						}
					} //END sms send to customer
				}
			
				/*//START Google Calendar API
				$google_cal_appt_id = array();
				$google_cal_appt_link = array();
				$appt_date = $post['date'];
				require_once("g_calendar_api.php");
				
				$lctn_google_cal_api = $single_location_data['google_cal_api'];
				$lctn_is_google_cal_auth = $single_location_data['is_google_cal_auth'];
				if($shop_location_email!="" && $lctn_google_cal_api=='1' && $lctn_is_google_cal_auth=='1') {
					
					// Get the API client and construct the service object.
					$lctn_client = getClient($location_id);
					$lctn_service = new Google_Service_Calendar($lctn_client);
	
					$lctn_expl_appt_date = explode("/",$appt_date);
					$lctn_appt_date = $lctn_expl_appt_date[2].'-'.$lctn_expl_appt_date[0].'-'.$lctn_expl_appt_date[1];
					$lctn_dateTime = $lctn_appt_date.' '.$lctn_appt_time;
					$lctn_dateTime =  date("Y-m-d\TH:i:sP", strtotime($lctn_dateTime));
	
					$lctn_event = new Google_Service_Calendar_Event(array(
					  'summary' => $post['name'].' ('.$post['phone'].')',
					  'location' => $company_address.', '.$company_city.', '.$company_state.', '.$company_zipcode,
					  'description' => $post['item_name'].'<br>Extra Remarks: '.$post['extra_remarks'],
					  'start' => array(
						'dateTime' => $lctn_dateTime,
						'timeZone' => 'America/Phoenix',
					  ),
					  'end' => array(
						'dateTime' => $lctn_dateTime,
						'timeZone' => 'America/Phoenix',
					  ),
					  'recurrence' => array(
						//'RRULE:FREQ=DAILY;COUNT=2'
					  ),
					  'attendees' => array(
						array('email' => $shop_admin_email),
						array('email' => $shop_location_email),
						array('email' => $email),
					  ),
					  'reminders' => array(
						'useDefault' => FALSE,
						'overrides' => array(
						  array('method' => 'email', 'minutes' => 24 * 60),
						  array('method' => 'popup', 'minutes' => 10),
						),
					  ),
					));
	
					$lctn_calendarId = 'primary';
					$lctn_event = $lctn_service->events->insert($lctn_calendarId, $lctn_event);
	
					if($lctn_event->id!="") {
						$google_cal_appt_id[$location_id] = $lctn_event->id;
						$google_cal_appt_link[$location_id] = $lctn_event->htmlLink;
					}
				} elseif($google_cal_api=='1' && $is_google_cal_auth=='1') {
					$location_id = 0;
					//require_once("g_calendar_api.php");
					
					// Get the API client and construct the service object.
					$client = getClient($location_id);
					$service = new Google_Service_Calendar($client);
	
					$expl_appt_date = explode("/",$appt_date);
					$appt_date = $expl_appt_date[2].'-'.$expl_appt_date[0].'-'.$expl_appt_date[1];
					$dateTime = $appt_date.' '.$appt_time;
					$dateTime =  date("Y-m-d\TH:i:sP", strtotime($dateTime));
	
					$event = new Google_Service_Calendar_Event(array(
					  'summary' => $post['name'].' ('.$post['phone'].')',
					  'location' => $company_address.', '.$company_city.', '.$company_state.', '.$company_zipcode,
					  'description' => $post['item_name'].'<br>Extra Remarks: '.$post['extra_remarks'],
					  'start' => array(
						'dateTime' => $dateTime,
						'timeZone' => 'America/Phoenix',
					  ),
					  'end' => array(
						'dateTime' => $dateTime,
						'timeZone' => 'America/Phoenix',
					  ),
					  'recurrence' => array(
						//'RRULE:FREQ=DAILY;COUNT=2'
					  ),
					  'attendees' => array(
						array('email' => $shop_admin_email),
						array('email' => $shop_location_email),
						array('email' => $email),
					  ),
					  'reminders' => array(
						'useDefault' => FALSE,
						'overrides' => array(
						  array('method' => 'email', 'minutes' => 24 * 60),
						  array('method' => 'popup', 'minutes' => 10),
						),
					  ),
					));
	
					$calendarId = 'primary';
					$event = $service->events->insert($calendarId, $event);
					if($event->id!="") {
						$google_cal_appt_id['corporate'] = $event->id;
						$google_cal_appt_link['corporate'] = $event->htmlLink;
					}
				} //END Google Calendar API
	
				if(!empty($google_cal_appt_id) && !empty($google_cal_appt_link)) {
					mysqli_query($db,"UPDATE appointments SET google_cal_appt_id='".json_encode($google_cal_appt_id)."', google_cal_appt_link='".json_encode($google_cal_appt_link)."' WHERE id='".$appointment_id."'");
				}*/
				
				$msg="Appointment has been successfully added";
			} else {
				
				$msg="Appointment has been successfully updated";
			}
		}

		$_SESSION['success_msg']=$msg;
	} else {
		$msg="Something went wrong!";
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'addedit_appointment.php?id='.$appointment_id);
	exit();
} elseif(isset($post['assign_to_contractor'])) {
	$appt_auto_inc_id=$post['appt_auto_inc_id'];
	$appt_id=$post['appt_id'];
	$contractor_id=$post['contractor_id'];
	$amount=$post['amount'];
	if($appt_id) {
		$ca_query=mysqli_query($db,"SELECT * FROM contractor_appt WHERE appt_id='".$appt_id."'");
		$contractor_appt_data = mysqli_fetch_assoc($ca_query);
		if(!empty($contractor_appt_data)) {
			$query=mysqli_query($db,"UPDATE contractor_appt SET contractor_id='".$contractor_id."', amount='".$amount."' WHERE appt_id='".$appt_id."'");
		} else {
			$query=mysqli_query($db,"INSERT INTO contractor_appt(contractor_id, amount, date, appt_id) VALUES('".$contractor_id."','".$amount."','".date('Y-m-d H:i:s')."','".$appt_id."')");
		}
		if($query=="1") {
			$msg="This Order successfully assigned to contractor.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation/add failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'view_appointment.php?id='.$appt_auto_inc_id);
		exit();
	}
} elseif(isset($post['invoice'])) {
	//echo '<pre>';
	//print_r($post);
	
	$invoice_id = rand(11111111,99999999);
	$date = date('Y-m-d H:i:s');
	$appt_id=$post['appt_id'];
	$appt_auto_inc_id=$post['appt_auto_inc_id'];
	
	$product_array=$post['product'];
	$qty_array=$post['qty'];
	$price_array=$post['price'];
	$discount_array=$post['discount'];
	$tax_array=$post['tax'];
	$total_array=$post['total'];
	
	$invoice_details_array = array();
	foreach($product_array as $product_item_k => $product_item_v) {
		if(trim($product_item_v)!="" && $price_array[$product_item_k]>0) {
			$invoice_details_array[] = array('item_name'=>$product_item_v, 'qty'=>$qty_array[$product_item_k], 'price'=>$price_array[$product_item_k], 'discount'=>$discount_array[$product_item_k], 'tax'=>$tax_array[$product_item_k], 'total'=>$total_array[$product_item_k]);
		}
	}
	
	$discount_type=$post['discount_type'];
	$tax_type=$post['tax_type'];
	$payment_method=$post['payment_method'];
	$payment_status=$post['payment_status'];
	
	$invoice_details = json_encode($invoice_details_array);
	if($appt_id) {
		$ca_query=mysqli_query($db,"SELECT * FROM invoice WHERE appt_id='".$appt_id."'");
		$invoice_appt_data = mysqli_fetch_assoc($ca_query);
		if(!empty($invoice_appt_data)) {
			$query=mysqli_query($db,"UPDATE invoice SET invoice_date='".$date."', invoice_details='".$invoice_details."', discount_type='".$discount_type."', tax_type='".$tax_type."', payment_method='".$payment_method."', payment_status='".$payment_status."' WHERE appt_id='".$appt_id."'");
		} else {
			$query=mysqli_query($db,"INSERT INTO invoice(invoice_id, appt_id, invoice_date, invoice_details, discount_type, tax_type, type, payment_method, payment_status) VALUES('".$invoice_id."','".$appt_id."','".$date."','".$invoice_details."','".$discount_type."','".$tax_type."','order','".$payment_method."','".$payment_status."')");
		}
		if($query=="1") {
			$msg="Invoice has been successfully generated/updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong generated/updated failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'order_invoice.php?id='.$appt_auto_inc_id);
		exit();
	}
} elseif(isset($post['clock_inout'])) {
	$appt_auto_inc_id=$post['appt_auto_inc_id'];
	$staff_id=$post['staff_id'];
	$order_id=$post['order_id'];
	$mode=$post['mode'];
	$time_sheet_id=$post['time_sheet_id'];
	$datetime=date("Y-m-d H:i:s");

	if($order_id && $staff_id) {
		if($mode == "check_in") {
			$query=mysqli_query($db,"INSERT INTO time_sheet(staff_id, order_id, clock_in_datetime) VALUES('".$staff_id."','".$order_id."','".$datetime."')");
		} else {
			$query=mysqli_query($db,"UPDATE time_sheet SET clock_out_datetime='".$datetime."' WHERE id='".$time_sheet_id."'");
		}
		if($query=="1") {
			//$msg="This Order successfully assigned to contractor.";
			//$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation/add failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'view_appointment.php?id='.$appt_auto_inc_id);
		exit();
	}
}

setRedirect(ADMIN_URL.'appointment.php');
exit();
?>
