<?php
require_once("_config/config.php");
require_once("include/functions.php");

$id=$_GET['id']; 

//Fetch details of appointment submitted form
$query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$post['id']."'");
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
?>

<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<style type="text/css" media="print">
	@page {
		size: auto;
		margin: 0mm;
	}
	
	body {
		background-color:#FFFFFF; 
		margin: 20px;
	}
</style>
</head>
<body style="margin-left:200px;margin-right:200px;">

<div id="print_order_data">
<?php
//Template file
require_once("views/print_order.php");
?>
</div>

<script language="javascript" type="text/javascript">
function printDiv(divID) {
	var divElements = document.getElementById(divID).innerHTML;
	var oldPage = document.body.innerHTML;

	document.body.innerHTML = divElements;

	//Print Page
	window.print();

	//Restore orignal HTML
	document.body.innerHTML = oldPage;
	return true;
}

window.addEventListener("afterprint", myFunction);
function myFunction() {
    //location.reload(true);
	window.close();
}

printDiv('print_order_data');
</script>

</body>
</html>