<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM invoice WHERE id="'.$post['d_id'].'" ');
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
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM invoice WHERE id="'.$id_v.'"');
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
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
							} catch(Services_Twilio_RestException $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
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
} elseif(isset($post['i_order_id'])) {
$id=$post['i_order_id'];
	
//Fetch details of appointment submitted form
$query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$id."'");
$appointment_data = mysqli_fetch_assoc($query);

if($appointment_data['promocode_id']>0 && $appointment_data['promocode_amt']>0) {
	$promocode_amt = $appointment_data['promocode_amt'];
	$discount_amt_label = "<strong>Promocode Discount:</strong>";
	if($appointment_data['discount_type']=="percentage")
		$discount_amt_label = "<strong>Promocode Discount (".$appointment_data['discount']."% of Initial Quote):</strong>";

	$f_promocode_info = $discount_amt_label.amount_fomat($promocode_amt);
}

$ac_query=mysqli_query($db,"SELECT c.*, ca.contractor_id, ca.appt_id, ca.amount FROM contractors AS c LEFT JOIN contractor_appt AS ca ON ca.contractor_id=c.id WHERE ca.appt_id='".$appointment_data['appt_id']."'");
$assigned_contractor_data = mysqli_fetch_assoc($ac_query);

$i_query=mysqli_query($db,"SELECT * FROM invoice WHERE appt_id='".$appointment_data['appt_id']."'");
$invoice_data = mysqli_fetch_assoc($i_query);

$invoice_id = $invoice_data['invoice_id'];
$invoice_date = $invoice_data['invoice_date'];
$tax_type = $invoice_data['tax_type'];
$discount_type = $invoice_data['discount_type'];
$invoice_details = json_decode($invoice_data['invoice_details'],true);

$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");

$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
$exe_pro = mysqli_query($db,$sql_pro);
$row_pro = mysqli_fetch_assoc($exe_pro);
$product_name = $row_pro['title'];

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:20px;
  font-weight:bold;
}
</style>
EOF;

//<h2>Invoice #'.($invoice_id!=''?$invoice_id:'xxxxxxxx').'</h2>

$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;">
	<tbody>
	  <tr>
		<td style="padding-bottom:20px;">'.($general_setting_data['invoice_logo']!=""?$invoice_logo:"").'</td>
		<td><h2 style="font-size:18px;">Invoice #'.($invoice_id!=''?$invoice_id:'xxxxxxxx').'</h2></td>
		<td style="padding-bottom:20px;"><strong>Date:</strong> '.($invoice_date!=""?date("m-d-Y h:i",strtotime($invoice_date)):"xx-xx-xxxx xx:xx").'</td>
	  </tr>
	  <tr>
		<td>
			<dl>
				<dt>'.$company_address.'</dt>
				<dt>'.$company_city.', '.$company_state.' '.$company_zipcode.'</dt>
				<dt>'.$company_country.'</dt>
			</dl>
		</td>
		<td>&nbsp;</td>
		<td>
			<dl>
				<dt><strong>Name:</strong> '.$appointment_data['name'].'</dt>
				<dt><strong>Email:</strong> '.$appointment_data['email'].'</dt>
				<dt><strong>Phone:</strong> '.$appointment_data['phone'].'</dt>
			</dl>
		</td>
	  </tr>
	</tbody>
</table>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;border-bottom:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;">';

	  $product_item_k = 0;
	  if(!empty($invoice_details) && $invoice_details!="") {
	  	  $f_invoice_details = array();
		  foreach($invoice_details as $product_item_k => $product_item_data) {

			$qty = $product_item_data['qty'];
			$price = $product_item_data['price'];
			$discount = $product_item_data['discount'];
			$tax = $product_item_data['tax'];
			
			$row_total = ($qty*$price);
		
			$f_discount = (1*$discount);
			$f_tax = (1*$tax);
			
			if($discount_type == '%') {
				$discount_sum=$row_total/100*$f_discount;
			} else {
				$discount_sum=$f_discount;
			}
			
			if($tax_type == '%') {
				$tax_sum=$row_total/100*$f_tax;
			} else {
				$tax_sum=$f_tax;
			}
			
			$row_total_array[] = $row_total;
			$discount_sum_array[] = $discount_sum;
			$tax_sum_array[] = $tax_sum;
			
			$f_invoice_details[] = array(
									'item_name'=>$product_item_data['item_name'],
									'qty'=>$product_item_data['qty'],
									'price'=>$product_item_data['price'],
									'discount_sum'=>$discount_sum,
									'tax_sum'=>$tax_sum,
									'row_total'=>$row_total,
								);
			
			/*$html.='<tr>
				<td>'.$product_item_data['item_name'].'</td>
				<td>'.$product_item_data['qty'].'</td>
				<td>'.amount_fomat($product_item_data['price']).'</td>
				<td>'.amount_fomat($discount_sum).($discount_type == '%'?' ('.$f_discount.'%)':'').'</td>
				<td>'.amount_fomat($tax_sum).($tax_type == '%'?' ('.$f_tax.'%)':'').'</td>
				<td>'.amount_fomat($row_total).'</td>
			 </tr>';*/
		  }
		  	
			$f_row_total = array_sum($row_total_array);
		    $f_discount_total = array_sum($discount_sum_array);
		    $f_tax_total = array_sum($tax_sum_array);
	  		
			$colspan = '3';
			$t_col = '6';
			if($f_discount_total>0 && $f_tax_total>0) {
				$colspan = '3';
				$t_col = '6';
			} elseif($f_discount_total<=0 && $f_tax_total<=0) {
				$colspan = '1';
				$t_col = '4';
			} elseif($f_discount_total>0 || $f_tax_total>0) {
				$colspan = '2';
				$t_col = '5';
			}

			$html.='<tr>
				<td colspan="'.$t_col.'" align="center">
					<b style="font-size:18px;">Order Info:</b>
				</td>
			</tr>
			<tr>
				<td colspan="'.$t_col.'">
					<span><strong>Order ID:</strong> '.$appointment_data['appt_id'].', <strong>Model:</strong> '.$product_name.', <strong>Estimate Amount:</strong> '.amount_fomat($appointment_data['item_amount']).'</span>
				</td>
			</tr>
			<tr>
				<td colspan="'.$t_col.'" align="center">
					<b style="font-size:18px;">Invoice Details</b>
				</td>
			</tr>';
  
			$html.='<thead>
				<tr>
					<th>Item Name</th>
					<th>Qty</th>
					<th>Price</th>';
					if($f_discount_total>0) {
						$html.='<th>Discount</th>';
					}
					if($f_tax_total>0) {
						$html.='<th>Tax</th>';
					}
					$html.='<th>Price Total</th>
				</tr>
			</thead>
			<tbody>';
			
			foreach($f_invoice_details as $f_product_item_k => $f_product_item_data) {
				$html.='<tr>
					<td>'.$f_product_item_data['item_name'].'</td>
					<td>'.$f_product_item_data['qty'].'</td>
					<td>'.amount_fomat($f_product_item_data['price']).'</td>';
					if($f_discount_total>0) {
						$html.='<td>'.amount_fomat($f_product_item_data['discount_sum']).($discount_type == '%'?' ('.$f_discount.'%)':'').'</td>';
					}
					if($f_tax_total>0) {
						$html.='<td>'.amount_fomat($f_product_item_data['tax_sum']).($tax_type == '%'?' ('.$f_tax.'%)':'').'</td>';
					}
					$html.='<td>'.amount_fomat($f_product_item_data['row_total']).'</td>
				 </tr>';
			}
			
			if($f_row_total>0) {
				 $html.='<tr>
					<td colspan="'.$colspan.'">&nbsp;</td>
					<td colspan="2" align="right"><strong>Price Sub Total:</strong></td>
					<td><strong>'.amount_fomat($f_row_total).'</strong></td>
				  </tr>';
			  }
			  
			  if($f_discount_total>0) {
				  $html.='<tr>
					<td colspan="'.$colspan.'">&nbsp;</td>
					<td colspan="2" align="right"><strong>Discount Total:</strong></td>
					<td><strong>-'.amount_fomat($f_discount_total).'</strong></td>
				  </tr>';
			  }
			  
			  if($promocode_amt>0) {
				  $html.='<tr>
					<td colspan="'.$colspan.'">&nbsp;</td>
					<td colspan="2" align="right"><strong>'.$discount_amt_label.'</strong></td>
					<td><strong>-'.amount_fomat($promocode_amt).'</strong></td>
				  </tr>';
			  }
			  
			  if($f_tax_total>0) {
				  $html.='<tr>
					<td colspan="'.$colspan.'">&nbsp;</td>
					<td colspan="2" align="right"><strong>Tax Total:</strong></td>
					<td><strong>'.amount_fomat($f_tax_total).'</strong></td>
				  </tr>';
			  }
			  
			  if($f_row_total>0) {
				  $html.='<tr>
					<td colspan="'.$colspan.'">&nbsp;</td>
					<td colspan="2" align="right"><strong>Grand Total:</strong></td>
					<td><strong>'.amount_fomat(($f_tax_total+($f_row_total-($f_discount_total+$promocode_amt)))).'</strong></td>
				  </tr>';
			  }

			  $html.='<tr>
					<td colspan="'.$t_col.'" align="center">
						<b>Payment Status:</b> '.ucwords($invoice_data['payment_status']).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Payment Method:</b> '.ucwords($invoice_data['payment_method']).'
					</td>
				</tr>';
			
	  } else {
	  	//$html.='<tr><td colspan="6" align="center">Item Not Available</td></tr>';
	  }
	  
	$html.='</tbody>
</table>';

require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information
$pdf->SetCreator($general_setting_data['from_name']);
$pdf->SetAuthor($general_setting_data['from_name']);
$pdf->SetTitle($general_setting_data['from_name']);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// add a page
$pdf->AddPage();

$pdf->SetFont('dejavusans');

$pdf->writeHtml($html);

ob_end_clean();

//$pdf->Output('pdf/order-'.date('Y-m-d-H-i-s').'.pdf', 'I');

$file_folder='pdf';
$file_folder_path = CP_ROOT_PATH.'/admin/'.$file_folder;
if(!file_exists($file_folder_path))
	mkdir($file_folder_path, 0777);

$pdf_name='invoice-'.$invoice_id.'.pdf';
$pdf->Output($file_folder_path.'/'.$pdf_name, 'F');

	$template_data = get_template_data('invoice_send_email_to_customer');
	$admin_user_data = get_admin_user_data();
	$customer_data = get_user_data($appointment_data['user_id']);
	
	$customer_email = ($customer_data['email']!=""?$customer_data['email']:$appointment_data['email']);
	
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
		date('Y-m-d H:i'));
	
	if(!empty($template_data)) {
		$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
		$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
		
		$attachment_data['basename'] = $pdf_name;
		$attachment_data['folder'] = 'admin/pdf';	
		$ok = send_email($customer_email, $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
		if($ok == '1') {
			$msg="Successfully send invoice to customer.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg="Something went wrong!";
			$_SESSION['error_msg']=$msg;
		}
		
		unlink($file_folder_path.'/'.$pdf_name);
	}
}

setRedirect(ADMIN_URL.'invoice_list.php');
exit();
?>
