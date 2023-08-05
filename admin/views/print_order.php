<?php
$html.='<h2>Invoice #'.($invoice_id!=''?$invoice_id:'xxxxxxxx').'</h2>
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
		<dl style="margin-top:0px;">
			<dt><strong>Order ID:</strong>  '.$appointment_data['appt_id'].',  <strong>Product Name:</strong> '.$product_name.',  <strong>Estimate Amount:</strong> '.amount_fomat($appointment_data['item_amount']).'</dt>
		</dl>
		<h3 style="margin-bottom:0px;">Invoice Details:</h3>
		<dl style="margin-top:0px;">
			<dt><strong>Invoice Number:</strong>  #'.($invoice_id!=''?$invoice_id:'xxxxxxxx').', <strong>Invoice Date:</strong> '.($invoice_date!=""?date("m-d-Y h:i",strtotime($invoice_date)):"xx-xx-xxxx xx:xx").', <strong>Payment Method:</strong> '.ucwords($invoice_data['payment_method']).', <strong>Payment Status:</strong> '.ucwords($invoice_data['payment_status']).'</dt>
		</dl>
	</td>
  </tr>
</tbody>
</table>';
	
$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;border:1px solid #333;border-top:0px;text-align:center;">
	<thead>
	  <tr>
		<th>Item Name</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Discount</th>
		<th>Tax</th>
		<th>Price Total</th>
	  </tr>
	</thead>
	<tbody>';
	
	  $product_item_k = 0;
	  if(!empty($invoice_details) && $invoice_details!="") {
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
			
			$html.='<tr>
				<td>'.$product_item_data['item_name'].'</td>
				<td>'.$product_item_data['qty'].'</td>
				<td>'.amount_fomat($product_item_data['price']).'</td>
				<td>'.amount_fomat($discount_sum).($discount_type == '%'?' ('.$f_discount.'%)':'').'</td>
				<td>'.amount_fomat($tax_sum).($tax_type == '%'?' ('.$f_tax.'%)':'').'</td>
				<td>'.amount_fomat($row_total).'</td>
			 </tr>';
		  }
	  } else {
	  	$html.='<tr><td colspan="6" align="center">Item Not Available</td></tr>';
	  }
	  
	  $f_row_total = array_sum($row_total_array);
	  $f_discount_total = array_sum($discount_sum_array);
	  $f_tax_total = array_sum($tax_sum_array);
	  
	  $html.='<tr><td colspan="6">&nbsp;</td></tr>';
	  
	 if($f_row_total>0) {
	 $html.='<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="2" align="right"><strong>Price Sub Total:</strong></td>
		<td><strong>'.amount_fomat($f_row_total).'</strong></td>
	  </tr>';
	  }

	  if($f_discount_total>0) {
	  $html.='<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="2" align="right"><strong>Discount Total:</strong></td>
		<td><strong>-'.amount_fomat($f_discount_total).'</strong></td>
	  </tr>';
	  }
	  
	  if($promocode_amt>0) {
		  $html.='<tr>
			<td colspan="3">&nbsp;</td>
			<td colspan="2" align="right"><strong>'.$discount_amt_label.'</strong></td>
			<td><strong>-'.amount_fomat($promocode_amt).'</strong></td>
		  </tr>';
	  }
			  
	  if($f_tax_total>0) {
	  $html.='<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="2" align="right"><strong>Tax Total:</strong></td>
		<td><strong>'.amount_fomat($f_tax_total).'</strong></td>
	  </tr>';
	  }
	  
	  if($f_row_total>0) {
	  $html.='<tr>
		<td colspan="3">&nbsp;</td>
		<td colspan="2" align="right"><strong>Grand Total:</strong></td>
		<td><strong>'.amount_fomat(($f_tax_total+($f_row_total-($f_discount_total+$promocode_amt)))).'</strong></td>
	  </tr>';
	  }
	  
	$html.='</tbody>
</table>';
	
echo $html;

/*<dt><strong>Invoice Number:</strong> #'.($invoice_id!=''?$invoice_id:'xxxxxxxx').'</dt>
			<dt><strong>Invoice Date:</strong> '.($invoice_date!=""?date("m-d-Y h:i",strtotime($invoice_date)):"xx-xx-xxxx xx:xx").'</dt>
			<dt><strong>Payment Method:</strong> '.ucwords($invoice_data['payment_method']).'</dt>
			<dt><strong>Payment Status:</strong> '.ucwords($invoice_data['payment_status']).'</dt>*/
?>
