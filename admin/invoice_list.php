<?php 
$file_name="invoice_list";

//Header section
require_once("include/header.php");

$lcn_query=mysqli_query($db,"SELECT * FROM locations ORDER BY id ASC");

$mysql_q = "";
$browser_params = "?export=yes";

if($post['from_date'] != "" && $post['to_date'] != "") {
	$browser_params .= "&from_date=".$post['from_date'];
	$browser_params .= "&to_date=".$post['to_date'];
	
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	
	$mysql_q .= " AND (DATE_FORMAT(i.invoice_date,'%Y-%m-%d')>='".$from_date."' AND DATE_FORMAT(i.invoice_date,'%Y-%m-%d')<='".$to_date."')";
} elseif($post['from_date'] != "") {
	$browser_params .= "&from_date=".$post['from_date'];
	
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	$mysql_q .= " AND DATE_FORMAT(i.invoice_date,'%Y-%m-%d')='".$from_date."'";
} elseif($post['to_date'] != "") {
	$browser_params .= "&to_date=".$post['to_date'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	$mysql_q .= " AND DATE_FORMAT(i.invoice_date,'%Y-%m-%d')='".$to_date."'";
}

$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");
$users_query=mysqli_query($db,"SELECT * FROM users WHERE status = '1' ORDER BY id ASC");

$data_list = array();
$i_q = mysqli_query($db,"SELECT i.*, a.id AS appt_auto_inc_id, a.email AS appt_email, u.email AS user_email, u.name AS customer_name FROM invoice AS i LEFT JOIN appointments AS a ON a.appt_id=i.appt_id LEFT JOIN users AS u ON u.id=a.user_id WHERE 1 AND i.appt_id!='' ".$mysql_q." GROUP BY i.appt_id ORDER BY i.id DESC");
$num_rows = mysqli_num_rows($i_q);
if($num_rows>0) {
	while($invoice_data=mysqli_fetch_assoc($i_q)) {
	
		$actual_cost_total = '';
		$f_row_total = '';
		$invoice_total_array = array();
		$f_discount_total = '';
		$discount_sum_array = array();
		$f_tax_total = '';
		$tax_sum_array = array();
		
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
			$discount = (float)$product_item_data['discount'];
			$tax = (float)$product_item_data['tax'];
			
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
		
		$estimate_cost = isset($invoice_data['item_amount'])?$invoice_data['item_amount']:0;
		$contractor_cost = isset($invoice_data['contractor_amount'])?$invoice_data['contractor_amount']:0;
		$commision = ($contractor_cost>0?($invoice_data['item_amount']-$contractor_cost):'');
		
		$estimate_cost_array[] = $estimate_cost;
		$contractor_cost_array[] = $contractor_cost;
		$commision_array[] = $commision;
		
		$customer_email = ($invoice_data['user_email']!=""?$invoice_data['user_email']:'');
				
		$contr_type = "";
		if(isset($invoice_data['contractor_id']) && $invoice_data['contractor_id']) {
			$contr_type = $invoice_data['contractor_name'];
		} else {
			$contr_type = "In House";
		}
		$invoice_data['contr_type'] = $contr_type;
		$invoice_data['invoice_date'] = format_date($invoice_data['invoice_date']).' '.format_time($invoice_data['invoice_date']);
		$invoice_data['actual_cost_total'] = $actual_cost_total;
		$invoice_data['customer_email'] = trim($customer_email);
		if($actual_cost_total>0) {
			$invoice_data['actual_cost_total_with_format'] = amount_format_without_sign($actual_cost_total);
		}
		$invoice_data['invoice_details'] = '';
		$invoice_data['customer_name'] = ($invoice_data['customer_name']?$invoice_data['customer_name']:' ');
		$data_list[] = $invoice_data;
	}
}

$json_data_list = json_encode($data_list);

//Template file
require_once("views/invoice_list.php");

//Footer section
require_once("include/footer.php"); ?>