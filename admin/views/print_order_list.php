<?php
$html='';
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
			
			$items_name = "";
			$item_name_array = json_decode($appointment_data['item_name'],true);
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
			
			$html.='<tr>
				<td>'.$appointment_data['appt_id'].'</td>
				<td>'.$items_name.'</td>
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

echo $html;
?>
