<?php
require_once("_config/config.php");
require_once("include/functions.php");

if(!isset($post['filter_by_location'])) {
	$post['filter_by_location'] = "";
}
if(!isset($post['status'])) {
	$post['status'] = "";
}
if(!isset($post['contractor_type'])) {
	$post['contractor_type'] = "";
}
if(!isset($post['from_date'])) {
	$post['from_date'] = "";
}
if(!isset($post['to_date'])) {
	$post['to_date'] = "";
}

$mysql_q = "";
if($post['filter_by_location']) {
	$mysql_q .= " AND a.location_id='".$post['filter_by_location']."'";
}

if($post['status']) {
	$mysql_q .= " AND a.status='".$post['status']."'";
}

if($post['contractor_type'] == "contractor") {
	$mysql_q .= " AND ca.contractor_id>0";
} elseif($post['contractor_type'] == "inhouse") {
	$mysql_q .= " AND ca.contractor_id IS NULL";
}

if($post['from_date'] != "" && $post['to_date'] != "") {
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

//Fetch list of appointments submitted form
$query=mysqli_query($db,"SELECT a.*, l.name AS location_name, u.name AS customer_name, ca.contractor_id, ca.amount AS contractor_amount FROM appointments AS a LEFT JOIN locations AS l ON l.id=a.location_id LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN contractor_appt AS ca ON ca.appt_id=a.appt_id WHERE 1 ".$mysql_q." ORDER BY a.id DESC");
?>

<!doctype html>
<html>
<head>
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
	<?php /*?><a class="btn btn-general" href="javascript:void(0);" onClick="printDiv('print_order_data');">Print</a><?php */?>
	
	<div id="print_order_data">
	<?php
	//Template file
	require_once("views/print_order_list.php");
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
		location.reload(true);
	}

	printDiv('print_order_data');
	</script>
</body>
</html>