<?php
require_once("_config/config.php");
require_once("include/functions.php");

$mysql_q = "";
if($post['location_id']) {
	$mysql_q .= " AND a.location_id='".$post['location_id']."'";
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

$html.='<h2>Order List</h2>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;border:1px solid #333">
	<thead>
	  <tr>
		<th>Order ID</th>
		<th>Repair Item(s)</th>
		<th>Name</th>
		<th>Phone</th>
		<th>Appt. Date/Time</th>
		<th>Order Date</th>
		<th>Estimate Cost('.$currency_symbol.')</th>
		<th>Contractor Cost('.$currency_symbol.')</th>
		<th>Commision('.$currency_symbol.')</th>
	  </tr>
	</thead>
	<tbody>';

	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		while($appointment_data=mysqli_fetch_assoc($query)) {
			$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
			$exe_pro = mysqli_query($db,$sql_pro);
			$row_pro = mysqli_fetch_assoc($exe_pro);
			$product_name = $row_pro['title'];
			
			$estimate_cost = '';
			$contractor_cost = '';
			$commision = '';
			
			$estimate_cost = $appointment_data['item_amount'];
			$contractor_cost = $appointment_data['contractor_amount'];
			$commision = ($appointment_data['contractor_amount']>0?($appointment_data['item_amount']-$appointment_data['contractor_amount']):'');
				
			$html.='<tr>
				<td>'.$appointment_data['appt_id'].'</td>
				<td>'.$appointment_data['item_name'].'</td>
				<td>'.$appointment_data['name'];
				
				if($appointment_data['user_id']>0 && $appointment_data['customer_name']) {
					//$html.='<br><a href="edit_user.php?id='.$appointment_data['user_id'].'">'.$appointment_data['customer_name'].'</a>';
					$html.='<br>'.$appointment_data['customer_name'];
				} else {
					$html.='<br>Guest';
				}
				
				$html.='</td>
				<td>'.$appointment_data['phone'].'</td>
				<td>'.date('m/d/Y',strtotime($appointment_data['appt_date'])).' '.str_replace("_"," to ",$appointment_data['appt_time']).'</td>
				<td>'.date('m/d/Y h:i A',strtotime($appointment_data['added_date'])).'</td>
				<td>'.$estimate_cost.'</td>
				<td>'.$contractor_cost.'</td>
				<td>'.($commision!=''?$commision:'').'</td>
			</tr>';
		}
	}
	
	$html.='</tbody>
</table>';

//echo $html;
//exit;

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

$pdf->writeHtml($html);

ob_end_clean();

$pdf->Output('pdf/order-'.date('Y-m-d-H-i-s').'.pdf', 'D');
//$pdf->Output('pdf/order-'.date('Y-m-d-H-i-s').'.pdf', 'I');
?>
