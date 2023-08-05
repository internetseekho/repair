<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("../models/repair.php");
require_once("common.php");

if(isset($post['request_repair'])) {

	//echo '<pre>';
	//print_r($post);
	//exit;

	$valid_csrf_token = verifyFormToken('repair');
	if($valid_csrf_token!='1') {
		writeHackLog('repair');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	if($appt_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}

	$product_id=$post['product_id'];
	$item_id=$post['item_id'];
	$item_name=real_escape_string($post['item_name']);
	$item_amount=$post['item_amount'];
	$name=real_escape_string($post['name']);
	$email=$post['email'];
	$phone=$post['phone'];
	$appt_id=$post['appt_id'];
	$user_id=$post['user_id'];

	$instructions='';

	$shipping_method=$post['shipping_method'];
	if($shipping_method == "come_to_you") {
		$shipping_address=$post['address'];
		$shipping_city=$post['city'];
		$shipping_state=$post['state'];
		$shipping_zipcode=$post['zipcode'];
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
	
	$stripe_token = $post['stripeToken'];
	$stripe_email = $post['stripeEmail'];
	$payable_amount = $post['payable_amount'];
		
	$sql_pro = "SELECT * FROM mobile WHERE id='".$product_id."'";
	$exe_pro = mysqli_query($db,$sql_pro);
	$row_pro = mysqli_fetch_assoc($exe_pro);
	$product_name = $row_pro['title'];
	
	$order_query=mysqli_query($db,"SELECT oi.*, d.title AS device_title, m.title AS model_title, m.models FROM order_items AS oi LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oi.id='".$item_id."'");
	$item_data = mysqli_fetch_assoc($order_query);
	$item_name_array = json_decode($item_data['item_name'],true);
	$item_name = json_encode($item_name_array);
	$total_amount = $item_data['price'];
	
	$p_order_data = get_order_data($item_data['order_id']);
	if($p_order_data['promocode_id']>0 && $p_order_data['promocode_amt']>0) {
		$promocode_amt = $p_order_data['promocode_amt'];
		$discount_amt_label = "<strong>Promocode Discount</strong>";
		if($p_order_data['discount_type']=="percentage") {
			$discount_amt_label = "<strong>Promocode Discount (".$p_order_data['discount']."% of Initial Quote)</strong>";
		}
	}
	
	$order_files_html = '';
	if($item_data['files']!="") {
		$order_files_list = explode(",",$item_data['files']);
		foreach($order_files_list as $file_k=>$file_v) {
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
		
		if($payable_amount>0) {
			$item_list_html .= '<tr>
				<td bgcolor="#ddd" width="80%" style="padding:15px;"><b>Paid Amount</b></td>
				<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.amount_fomat($payable_amount).'</td>
			</tr>
			<tr><td style="padding:1px;"></td></tr>';
		}
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

	if($name && $email && $phone && $appt_date && $appt_time) {

		//START for check booking available
		$appt_mysql_params = "";
		if($location_id>0) {
			$cba_query=mysqli_query($db,"SELECT * FROM locations WHERE published=1 AND id='".$location_id."'");
			$cba_location_data=mysqli_fetch_assoc($cba_query);
			$lctn_allowed_num_of_booking_per_time_slot = trim($cba_location_data['allowed_num_of_booking_per_time_slot']);
			$lctn_num_of_booking_per_time_slot = trim($cba_location_data['num_of_booking_per_time_slot']);
			if(count($cba_location_data)>0 && $lctn_allowed_num_of_booking_per_time_slot == '1' && $lctn_num_of_booking_per_time_slot>0) {
				$allowed_num_of_booking_per_time_slot = $lctn_allowed_num_of_booking_per_time_slot;
				$num_of_booking_per_time_slot = $lctn_num_of_booking_per_time_slot;
				$appt_mysql_params .= " AND a.location_id='".$location_id."'";
			}
		}
	
		$response = array();
		$q = mysqli_query($db,"SELECT a.* FROM appointments AS a WHERE a.appt_date='".$appt_date."' AND a.appt_time='".$appt_time."'".$appt_mysql_params."");
		$num_of_appointments = mysqli_num_rows($q);
		if($num_of_appointments>0 
			&& $allowed_num_of_booking_per_time_slot == '1' 
			&& $num_of_booking_per_time_slot>0 
			&& ($num_of_booking_per_time_slot<=$num_of_appointments)) 
		{
			$msg="You are not able to booking in this time. so you can please try different time.";
			setRedirectWithMsg($return_url,$msg,'error');
			exit();
		} //END for check booking available
	
		if($user_id<=0) {
			$user_type = 'guest';
		
			$eu_query=mysqli_query($db,"SELECT * FROM users WHERE email='".$email."'");
			$exist_user_data=mysqli_fetch_assoc($eu_query);
			if(empty($exist_user_data)) {
				mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `phone`, `email`, `date`, `status`, `type`) VALUES('".$name."','".$name."','".$phone."','".$email."','".date('Y-m-d H:i:s')."','1','".$user_type."')");
				$user_id = mysqli_insert_id($db);
			} else {
				$user_id = $exist_user_data['id'];
			}
		}
		
		$partial_order_q = mysqli_query($db,"SELECT * FROM orders WHERE order_id='".$appt_id."'");
		$partial_order_data = mysqli_fetch_assoc($partial_order_q);
		
		$item_files = "";
		$order_item_list = get_order_item_list($appt_id);
		foreach($order_item_list as $order_item_list_data) {
			$item_files = $order_item_list_data['files'];
		}
		
		$query=mysqli_query($db,"INSERT INTO appointments(appt_id, user_id, product_id, item_name, item_amount, name, email, phone, instructions, shipping_method, location_id, appt_date, appt_time, extra_remarks, added_date, status, promocode_id, promocode, promocode_amt, discount_type, discount, item_files) VALUES('".$appt_id."','".$user_id."','".$product_id."','".$item_name."','".$item_amount."','".$name."','".$email."','".$phone."','".$instructions."','".$shipping_method."','".$location_id."','".$appt_date."','".$appt_time."','".$extra_remarks."','".date('Y-m-d H:i:s')."','1', '".$partial_order_data['promocode_id']."', '".$partial_order_data['promocode']."', '".$partial_order_data['promocode_amt']."', '".$partial_order_data['discount_type']."', '".$partial_order_data['discount']."','".$item_files."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			
			$pmt_last_insert_id = 0;
			if($stripe_secret_key && $stripe_token && $cust_payment_option == '1') {
				require('../libraries/stripe/init.php');
				\Stripe\Stripe::setApiKey($stripe_secret_key);
		
				try {
					$customer = \Stripe\Customer::create(array(
						'email'  => $stripe_email,
						'source' => $stripe_token
					));
					$stripe_customer_id = $customer->id;
					//$stripe_card_data = $customer->sources->data['0'];
				} catch(Exception $e) {
					$msg = $e->getMessage();
					setRedirectWithMsg($return_url,$msg,'warning');
					exit();
				}
		
				try {
					$charge_return_data = \Stripe\Charge::create([
						'amount' => ($payable_amount * 100),
						'currency' => $currency_nm,
						'description' => '',
						//'source' => $stripeToken,
						"customer" => $customer->id,
						"metadata"    => array(
							"appt_id" => $appt_id
						)
					]);
					$stripe_response = json_encode($charge_return_data);
				} catch(Exception $e) {
					$msg = $e->getMessage();
					setRedirectWithMsg($return_url,$msg,'warning');
					exit();
				}
		
				//mysqli_query($db,"UPDATE appointments SET stripe_customer_id='".$stripe_customer_id."', stripe_email='".$stripe_email."', stripe_amount='".$payable_amount."', stripe_response='".$stripe_response."' WHERE id='".$last_insert_id."'");
				mysqli_query($db,"INSERT INTO payment_history(appt_id, stripe_customer_id, stripe_email, paid_amount, stripe_response, date) VALUES('".$appt_id."','".$stripe_customer_id."','".$stripe_email."','".$payable_amount."','".$stripe_response."','".date('Y-m-d H:i:s')."')");
				$pmt_last_insert_id = mysqli_insert_id($db);
			}

			$paid_transaction_id = '';
			$pmt_h_q = mysqli_query($db,"SELECT * FROM payment_history WHERE id='".$pmt_last_insert_id."'");
			$payment_history_data = mysqli_fetch_assoc($pmt_h_q);
			$stripe_response_dt = json_decode($payment_history_data['stripe_response'],true);
			if(!empty($stripe_response_dt)) {
				$paid_transaction_id = $stripe_response_dt['id'];
			}

			$single_location_data = get_single_location_data($location_id);

			//START post shipment by easypost API
			if($shipping_method == "ship_device" && $shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {
				try {
					require_once("../libraries/easypost-php-master/lib/easypost.php");
					\EasyPost\EasyPost::setApiKey($shipping_api_key);
			
					//create To address
					$to_address_params = array(
						"verify"  =>  array("delivery"),
						//'name' => $company_name,
						'company' => $company_name,
						'street1' => $company_address,
						'city' => $company_city,
						'state' => $company_state,
						'zip' => $company_zipcode,
						'country' => $company_country,
						'phone' => $company_phone,
						'email' => $site_email
					);

					//create From address
					$from_address_params = array(
						"verify"  =>  array("delivery"),
						'name' => $name,
						'street1' => $shipping_address,
						//'street2' => "",
						'city' => $shipping_city,
						'state' => $shipping_state,
						'zip' => $shipping_zipcode,
						'country' => $company_country,
						'phone' => substr($phone, -10),
						'email' => $email
					);
					
					$to_address = \EasyPost\Address::create($to_address_params);
					$from_address = \EasyPost\Address::create($from_address_params);
					
					$parcel_param_array = array(
					  "length" => $shipping_parcel_length,
					  "width" => $shipping_parcel_width,
					  "height" => $shipping_parcel_height,
					  "weight" => $shipping_parcel_weight
					);
					
					if($shipping_predefined_package!="") {
						$parcel_param_array['predefined_package'] = $shipping_predefined_package;
					}
					
					$parcel_info = \EasyPost\Parcel::create($parcel_param_array);
					
					if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
						$shipment = \EasyPost\Shipment::create(array(
						  "to_address" => $to_address,
						  "from_address" => $from_address,
						  "parcel" => $parcel_info,
						  "carrier_accounts" => array($carrier_account_id),
						  "options" => array(
							  "label_size" => '4x6',
							  //"label_size" => '8.5x11',
							  //"print_custom_1" => "Instructions, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
							  //"print_custom_2" => "test 2",
							  //"print_custom_3" => "test 3",
						  )
						));
						
						/*$shipment_rate_id = '';
						if(!empty($shipment->rates)) {
							foreach($shipment->rates as $rate_data) {
								if($rate_data->service == "Ground") {
									$shipment_rate_id = $rate_data->id;
								}
							}
						}
						if($shipment_rate_id!="") {
							$shipment->buy(array('rate' => array('id' => $shipment_rate_id)));
						} else {
							$shipment->buy(array(
							  'rate' => $shipment->lowest_rate(),
							));
						}*/
			
						//$shipment->buy(array('rate' => array('id' => $shipment_rate_id)));
						$shipment->buy(array(
						  'rate' => $shipment->lowest_rate(),
						));
			
						$shipment->label(array(
						  'file_format' => 'PDF'
						));
			
						$shipment_id = $shipment->id;
						$shipment_tracking_code = $shipment->tracker->tracking_code;
						$shipment_label_url = $shipment->postage_label->label_url;
					} else {
						//$msg='Unable to create shipment, one or more parameters were invalid.';
						//setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
						//exit();
					}
				} catch(\EasyPost\Error $e) {
					$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
					error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());
	
					//$msg='Unable to create shipment, one or more parameters were invalid.';
					//setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
					//exit();
				}
				
				mysqli_query($db,"UPDATE appointments SET shipping_address='".$shipping_address."', shipping_city='".$shipping_city."', shipping_state='".$shipping_state."', shipping_zipcode='".$shipping_zipcode."', shipping_api='".$shipping_api."', shipment_id='".$shipment_id."', shipment_tracking_code='".$shipment_tracking_code."', shipment_label_url='".$shipment_label_url."' WHERE id='".$last_insert_id."'");
			} else {
				$shipment_id = '';
				$shipment_tracking_code = '';
				$shipment_label_url = '';
			} //END post shipment by easypost API

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
				'{$paid_amount}',
				'{$paid_transaction_id}',
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
				$appt_date,
				str_replace("_"," to ",$appt_time),
				$extra_remarks,
				amount_fomat($item_amount),
				amount_fomat($payable_amount),
				$paid_transaction_id,
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

				$attachment_data = array();
				if($shipment_label_url!="") {
					$shipment_basename_label_url = basename($shipment_label_url);
					$label_copy_to_our_srvr = copy($shipment_label_url,'../shipment_labels/'.$shipment_basename_label_url);

					$attachment_data['basename'] = $shipment_basename_label_url;
					$attachment_data['folder'] = 'shipment_labels';
				}
				send_email($email, $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);

				//START sms send to customer
				if($template_data_to_customer['sms_status']=='1' && $phone!="" && $sms_sending_status=='1') {
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

			//START Google Calendar API
			$google_cal_appt_id = array();
			$google_cal_appt_link = array();
			$appt_date = $post['date'];
			require_once("g_calendar_api.php");
			
			$attendees_array = array();
			if($shop_admin_email) {
				$attendees_array['email'] = $shop_admin_email;
			}
			if($shop_location_email) {
				$attendees_array['email'] = $shop_location_email;
			}
			if($email) {
				$attendees_array['email'] = $email;
			}
			
			if(!empty($attendees_array)) {
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
						$attendees_array
						//array('email' => $shop_admin_email),
						//array('email' => $shop_location_email),
						//array('email' => $email),
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
						$attendees_array
						//array('email' => $shop_admin_email),
						//array('email' => $shop_location_email),
						//array('email' => $email),
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
				}

				if(!empty($google_cal_appt_id) && !empty($google_cal_appt_link)) {
					mysqli_query($db,"UPDATE appointments SET google_cal_appt_id='".json_encode($google_cal_appt_id)."', google_cal_appt_link='".json_encode($google_cal_appt_link)."' WHERE id='".$last_insert_id."'");
				}
			} //END Google Calendar API
		}

		unset($_SESSION['order_id']);
		unset($_SESSION['location_id']);

		$msg="Thank you for request. We'll contact you shortly.";
		$order_completed_prefix_id = $last_insert_id;
		if($order_completed_prefix) {
			$order_completed_prefix_id = $order_completed_prefix.'-'.$last_insert_id;
		}
		setRedirectWithMsg($return_url.'/'.$order_completed_prefix_id,$msg,'success');
	} else {
		$msg="Something went wrong!";
		setRedirectWithMsg($return_url,$msg,'error');
	}
	exit();
} elseif(isset($post['pay_now_request'])) {

	//echo '<pre>';
	//print_r($post);
	//exit;

	$appt_id=$post['appt_id'];
	$stripe_token = $post['stripeToken'];
	$stripe_email = $post['stripeEmail'];
	$payable_amount = $post['payable_amount'];
			
	$pmt_last_insert_id = 0;
	if($stripe_secret_key && $stripe_token && $cust_payment_option == '1') {
		require('../libraries/stripe/init.php');
		\Stripe\Stripe::setApiKey($stripe_secret_key);

		try {
			$customer = \Stripe\Customer::create(array(
				'email'  => $stripe_email,
				'source' => $stripe_token
			));
			$stripe_customer_id = $customer->id;
			//$stripe_card_data = $customer->sources->data['0'];
		} catch(Exception $e) {
			$msg = $e->getMessage();
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}

		try {
			$charge_return_data = \Stripe\Charge::create([
				'amount' => ($payable_amount * 100),
				'currency' => $currency_nm,
				'description' => '',
				//'source' => $stripeToken,
				"customer" => $customer->id,
				"metadata"    => array(
					"appt_id" => $appt_id
				)
			]);
			$stripe_response = json_encode($charge_return_data);
		} catch(Exception $e) {
			$msg = $e->getMessage();
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}

		mysqli_query($db,"INSERT INTO payment_history(appt_id, stripe_customer_id, stripe_email, paid_amount, stripe_response, date) VALUES('".$appt_id."','".$stripe_customer_id."','".$stripe_email."','".$payable_amount."','".$stripe_response."','".date('Y-m-d H:i:s')."')");
		$pmt_last_insert_id = mysqli_insert_id($db);
	}

	$msg="Payment sucessfully completed.";
	setRedirectWithMsg($return_url,$msg,'success');
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>