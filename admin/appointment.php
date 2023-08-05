<?php 
$file_name="appointments";

//Header section
require_once("include/header.php");

$lcn_query=mysqli_query($db,"SELECT * FROM locations ORDER BY id ASC");

$mysql_q = "";
$browser_params = "?export=yes";
if($post['filter_by_location']) {
	$browser_params .= "&location_id=".$post['filter_by_location'];
	$mysql_q .= " AND a.location_id='".$post['filter_by_location']."'";
}

if(isset($_GET['user_id']) && $_GET['user_id']) {
	$mysql_q .= " AND a.user_id='".$_GET['user_id']."'";
}

if($post['status']) {
	$browser_params .= "&status=".$post['status'];
	$mysql_q .= " AND a.status='".$post['status']."'";
}

if($post['contractor_type'] == "contractor") {
	$browser_params .= "&contractor_type=".$post['contractor_type'];
	$mysql_q .= " AND ca.contractor_id>0";
} elseif($post['contractor_type'] == "inhouse") {
	$browser_params .= "&contractor_type=".$post['contractor_type'];
	$mysql_q .= " AND ca.contractor_id IS NULL";
}

if($post['from_date'] != "" && $post['to_date'] != "") {
	$browser_params .= "&from_date=".$post['from_date'];
	$browser_params .= "&to_date=".$post['to_date'];
	
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	
	$mysql_q .= " AND (a.appt_date>='".$from_date."' AND a.appt_date<='".$to_date."')";
} elseif($post['from_date'] != "") {
	$browser_params .= "&from_date=".$post['from_date'];
	
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	$mysql_q .= " AND a.appt_date='".$from_date."'";
} elseif($post['to_date'] != "") {
	$browser_params .= "&to_date=".$post['to_date'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	$mysql_q .= " AND a.appt_date='".$to_date."'";
}

if(isset($_REQUEST['export'])) {
	setRedirect(ADMIN_URL.'download_order_export.php'.$browser_params);
	exit;
}

if(isset($_REQUEST['print'])) {
	setRedirect(ADMIN_URL.'print_order_list.php'.$browser_params);
	exit;
}

//Search by Appt. ID, Name, Email, Phone
if($post['filter_by']) {
	$mysql_q = " AND (a.appt_id LIKE '%".real_escape_string($post['filter_by'])."%' OR a.email LIKE '%".real_escape_string($post['filter_by'])."%'  OR a.name LIKE '%".real_escape_string($post['filter_by'])."%' OR a.phone LIKE '%".real_escape_string($post['filter_by'])."%')";
}

$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");

$data_list = array();
$query=mysqli_query($db,"SELECT a.*, ast.name AS status_name, l.name AS location_name, u.name AS customer_name, ca.contractor_id, ca.amount AS contractor_amount, c.name AS contractor_name FROM appointments AS a LEFT JOIN locations AS l ON l.id=a.location_id LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN contractor_appt AS ca ON ca.appt_id=a.appt_id LEFT JOIN contractors AS c ON c.id=ca.contractor_id LEFT JOIN appointments_status AS ast ON ast.id=a.status WHERE 1 ".$mysql_q." ORDER BY a.id DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($appointment_details=mysqli_fetch_assoc($query)) {

		$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_details['product_id']."'";
		$exe_pro = mysqli_query($db,$sql_pro);
		$row_pro = mysqli_fetch_assoc($exe_pro);
		$product_name = $row_pro['title'];

		$items_name = "";
		$item_name_array = json_decode($appointment_details['item_name'],true);
		if(!empty($item_name_array)) {
			foreach($item_name_array as $item_name_data) {
				$items_name .= '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).':</strong> ';
				$items_opt_name = "";
				foreach($item_name_data['opt_data'] as $opt_data) {
					$items_opt_name .= $opt_data['opt_name'].', ';
				}
				$items_name .= rtrim($items_opt_name,', ');
				$items_name .= '<br>';		
			}
		}

		$appointment_data = array('id'=>$appointment_details['id'],
								'user_id'=>$appointment_details['user_id'],
								'appt_id'=>$appointment_details['appt_id'],
								'product_id'=>$appointment_details['product_id'],
								'product_name'=>base64_encode(substr($items_name,0,50)),
								'item_name'=>base64_encode($items_name),
								'item_amount'=>$appointment_details['item_amount'],
								'name'=>$appointment_details['name'],
								'email'=>$appointment_details['email'],
								'phone'=>$appointment_details['phone'],
								'location_id'=>$appointment_details['location_id'],
								'appt_date'=>$appointment_details['appt_date'],
								'appt_time'=>$appointment_details['appt_time'],
								'added_date'=>$appointment_details['added_date'],
								'status'=>$appointment_details['status'],
								'published'=>$appointment_details['published'],
								'promocode_id'=>$appointment_details['promocode_id'],
								'promocode'=>$appointment_details['promocode'],
								'promocode_amt'=>$appointment_details['promocode_amt'],
								'discount_type'=>$appointment_details['discount_type'],
								'discount'=>$appointment_details['discount'],
								'status_name'=>($appointment_details['status_name']?$appointment_details['status_name']:""),
								'location_name'=>($appointment_details['location_name']?$appointment_details['location_name']:""),
								'customer_name'=>$appointment_details['customer_name'],
								'contractor_id'=>$appointment_details['contractor_id'],
								'contractor_amount'=>$appointment_details['contractor_amount'],
								'contractor_name'=>$appointment_details['contractor_name']);

		$actual_cost_total = '';
		$f_row_total = '';
		$invoice_total_array = array();
		$f_discount_total = '';
		$discount_sum_array = array();
		$f_tax_total = '';
		$tax_sum_array = array();
		
		$i_q = mysqli_query($db,"SELECT * FROM invoice WHERE appt_id='".$appointment_data['appt_id']."' AND appt_id!=''");
		$invoice_data = mysqli_fetch_assoc($i_q);
		$invoice_id = $invoice_data['invoice_id'];
		$invoice_date = $invoice_data['invoice_date'];
		$tax_type = $invoice_data['tax_type'];
		$discount_type = $invoice_data['discount_type'];
		$payment_method = $invoice_data['payment_method'];
		$payment_status = $invoice_data['payment_status'];
		$invoice_details = json_decode($invoice_data['invoice_details'],true);
		if(!empty($invoice_details) && $invoice_details!="") {
		  foreach($invoice_details as $product_item_k => $product_item_data) {
			$qty = $product_item_data['qty'];
			$price = $product_item_data['price'];
			$discount = $product_item_data['discount'];
			$tax = $product_item_data['tax'];
			
			$invoice_total = ($qty*$price);
			$f_discount = (1*$discount);
			$f_tax = (1*$tax);
			
			if($discount_type == '%') {
				$discount_sum=$invoice_total/100*$f_discount;
			} else {
				$discount_sum=$f_discount;
			}
			
			if($tax_type == '%') {
				$tax_sum=$invoice_total/100*$f_tax;
			} else {
				$tax_sum=$f_tax;
			}
			
			$invoice_total_array[] = $invoice_total;
			$discount_sum_array[] = $discount_sum;
			$tax_sum_array[] = $tax_sum;
		  }

		  $f_row_total = array_sum($invoice_total_array);
		  $f_discount_total = array_sum($discount_sum_array);
		  $f_tax_total = array_sum($tax_sum_array);

		  $actual_cost_total = ($f_tax_total+($f_row_total-$f_discount_total));
		}
		
		$estimate_cost = '';
		$contractor_cost = '';
		$commision = '';
		$f_promocode_info = '';
		
		if($appointment_data['promocode_id']>0 && $appointment_data['promocode_amt']>0) {
			$promocode_amt = amount_fomat($appointment_data['promocode_amt']);
			$discount_amt_label = "Promocode Discount: -";
			if($appointment_data['discount_type']=="percentage")
				$discount_amt_label = "Promocode Discount (".$appointment_data['discount']."% of Initial Quote): -";

			$f_promocode_info = '<br>'.$discount_amt_label.$promocode_amt;
			
			//$estimate_cost = ($appointment_data['item_amount']-$appointment_data['promocode_amt']);
		} else {
			//$estimate_cost = $appointment_data['item_amount'];
		}
		if($appointment_data['promocode_amt']>0) {
			$estimate_cost = ($appointment_data['item_amount']-$appointment_data['promocode_amt']);
		} else {
			$estimate_cost = $appointment_data['item_amount'];
		}
		
		$contractor_cost = $appointment_data['contractor_amount'];
		$commision = ($appointment_data['contractor_amount']>0?($appointment_data['item_amount']-$appointment_data['contractor_amount']):'');
		
		$estimate_cost_array[] = $estimate_cost;
		$contractor_cost_array[] = $contractor_cost;
		$commision_array[] = $commision;
		
		$appointment_data['estimate_cost'] = amount_format_without_sign($estimate_cost);
		$appointment_data['contractor_cost'] = amount_format_without_sign($contractor_cost);
		$appointment_data['commision'] = amount_format_without_sign($commision);
		$appointment_data['f_promocode_info'] = '';//base64_encode($f_promocode_info);
		$appointment_data['actual_cost_total'] = amount_format_without_sign($actual_cost_total);

		$contr_type = "";
		if($appointment_data['contractor_id'] && $appointment_data['contractor_name']) {
			$contr_type = $appointment_data['contractor_name'];
		} elseif($appointment_data['contractor_id']) {
			$contr_type = ""; //removal contractor
		} else {
			$contr_type = "In House";
		}
		$appointment_data['contr_type'] = $contr_type;
		
		if($appointment_data['user_id']>0 && $appointment_data['customer_name']) {
			$customer_name_w_link = '<br><a href="edit_user.php?id='.$appointment_data['user_id'].'">'.$appointment_data['customer_name'].'</a>';
		} else {
			$customer_name_w_link = '<br>Guest';
		}
		$appointment_data['customer_name_w_link'] = base64_encode($customer_name_w_link);
		if($appointment_data['appt_date']!="" && $appointment_data['appt_date']!="0000-00-00") {
			$appointment_data['appt_datetime'] = format_date($appointment_data['appt_date']).' '.format_time($appointment_data['appt_time']);
		} else {
			$appointment_data['appt_datetime'] = "";
		}
		$appointment_data['added_date'] = format_date($appointment_data['added_date']).' '.format_time($appointment_data['added_date']);
		$appointment_data['customer_name'] = ($appointment_data['customer_name']?$appointment_data['customer_name']:' ');
		if($appointment_data['contractor_id'] > 0) {
			$appointment_data['contractor_type'] = 'contractor';
		} else {
			$appointment_data['contractor_type'] = 'inhouse';
		}
		
		$data_list[] = $appointment_data;
	}
}

$json_data_list = json_encode($data_list);

//Template file
require_once("views/appointment.php");

//Footer section
require_once("include/footer.php"); ?>