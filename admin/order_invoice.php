<?php 
$file_name="appointments";

//Header section
require_once("include/header.php");
$id = $post['id'];

if($id<=0 && $prms_invoice_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && ($prms_invoice_edit!='1' && $prms_order_invoice!='1')) {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch details of appointment submitted form
$query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$id."'");
$appointment_data = mysqli_fetch_assoc($query);

$ac_query=mysqli_query($db,"SELECT c.*, ca.contractor_id, ca.appt_id, ca.amount FROM contractors AS c LEFT JOIN contractor_appt AS ca ON ca.contractor_id=c.id WHERE ca.appt_id='".$appointment_data['appt_id']."'");
$assigned_contractor_data = mysqli_fetch_assoc($ac_query);

$i_query=mysqli_query($db,"SELECT * FROM invoice WHERE appt_id='".$appointment_data['appt_id']."' AND appt_id!=''");
$invoice_data = mysqli_fetch_assoc($i_query);

$invoice_id = $invoice_data['invoice_id'];
$invoice_date = $invoice_data['invoice_date'];
$tax_type = $invoice_data['tax_type'];
$discount_type = $invoice_data['discount_type'];
$payment_method = $invoice_data['payment_method'];
$payment_status = $invoice_data['payment_status'];
$invoice_details = json_decode($invoice_data['invoice_details'],true);

$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");

$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
$exe_pro = mysqli_query($db,$sql_pro);
$row_pro = mysqli_fetch_assoc($exe_pro);
$product_name = $row_pro['title'];

$promocode_amt = 0;
$discount_amt_label = "";
if($appointment_data['promocode_id']>0 && $appointment_data['promocode_amt']>0) {
	$promocode_amt = $appointment_data['promocode_amt'];
	$discount_amt_label = "<strong>Promocode Discount:</strong> -";
	if($appointment_data['discount_type']=="percentage")
		$discount_amt_label = "<strong>Promocode Discount (".$appointment_data['discount']."% of Initial Quote):</strong> -";

	$f_promocode_info = $discount_amt_label.amount_fomat($promocode_amt);
}

//Template file
require_once("views/order_invoice.php");

//Footer section
require_once("include/footer.php"); ?>