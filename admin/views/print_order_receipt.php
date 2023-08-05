<?php
$html='';
$html.='<h2>Receipt #'.($appointment_data['appt_id']!=''?$appointment_data['appt_id']:'xxxxxxxx').'</h2>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;border:1px solid #333;">
<tbody>
  <tr>
	<td>
		<h3>From: </h3>
		<dl>
			<dt><strong>Address:</strong></dt>
			<dd>'.$company_address.'</dd>
			<dd>'.$company_city.', '.$company_state.' '.$company_zipcode.'</dd>
			<dd>'.$company_country.'</dd>
			<dt><strong>Contact:</strong></dt>
			<dd>'.$site_email.'</dd>
			<dd>'.$site_phone.'</dd>
		</dl>
	</td>
 
	<td style="vertical-align:top;">
		<h3>To:</h3>
		<dl>
			<dt><strong>Name:</strong> '.$appointment_data['name'].'</dt>
			<dt><strong>Email:</strong> '.$appointment_data['email'].'</dt>
			<dt><strong>Phone:</strong> '.$appointment_data['phone'].'</dt>
		</dl>
	</td>
  </tr>
  <tr>
    <td colspan="2">
		<h3 style="margin-bottom:0px;">Order Info:</h3>
		<dl style="margin-top:5px;">
			<dt><strong>Order ID:</strong>  '.$appointment_data['appt_id'].',  <strong>Product Name:</strong> '.$product_name.',  <strong>Estimate Amount:</strong> '.amount_fomat($appointment_data['item_amount']).',  <strong>Appt. Date:</strong> '.format_date($appointment_data['appt_date']).',  <strong>Appt. Time:</strong> '.str_replace("_"," to ",format_time($appointment_data['appt_time'])).',  <strong>Status:</strong> '.ucwords(str_replace('_',' ',$appointment_data['status_name'])).',  <strong>Submitted Date:</strong> '.format_date($appointment_data['added_date']).' '.format_time($appointment_data['added_date']).'
			</dt>
		</dl>
		<h3 style="margin-bottom:0px;">Terms & Conditions:</h3>
		<dl style="margin-top:-5px;">
			'.$general_setting_data['order_receipt_terms'].'
		</dl>
	</td>
  </tr>
</tbody>
</table>';
	
$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;border:1px solid #333;border-top:0px;text-align:center;">
	<thead>
	  <tr>
		  <th colspan="6" align="right" style="padding-right:25px;">Signature</th>
	  </tr>
	</thead>
	<tbody>';
	
	$html.='<tr><td colspan="6" align="right" style="padding-top:25px;padding-bottom:25px;">&nbsp;</td></tr>';
	  
$html.='</tbody>
</table>';
	
echo $html;
?>
