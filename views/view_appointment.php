<?php
//Url param
$appt_id = $url_second_param;
if($appt_id == "") {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL.'account'.($post['p']>0?'?p='.$post['p']:''),$msg,'danger');
	exit();
}

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

//Header section
include("include/header.php");

//Get appt. data, path of this function (get_appt_data) admin/include/functions.php
$appt_data = get_appt_data($appt_id);
$payment_history_list = get_payment_history_data($appt_id)['list'];
if($user_id>0 && $appt_data['user_id']!=$user_id) {
	//setRedirect(SITE_URL);
	//exit();
}

$items_name = "";
$item_name_array = json_decode($appt_data['item_name'],true);
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

if(count($appt_data)>0) { ?>
<section>
	<div class="container clearfix">
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><strong><?=$order_details_title?></strong></h3>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form role="form">
                	<a class="btn btn-secondary" style="margin-bottom:10px;" href="<?=SITE_URL?>account<?=(isset($post['p']) && $post['p']>0?'?p='.$post['p']:'')?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?=$back_btn_text?></a>
                    <?php
					if($cust_payment_option == '1' && $stripe_publishable_key) { ?>
					<a href="#" class="btn btn-primary" style="margin-bottom:10px;" data-toggle="modal" data-target="#PayNow"><?=$payment_btn_text?></a>
					<?php
					} ?>
				  <table class="table">
					<tr>
					  <?php
					  if($online_booking_hide_price != '1') { ?>
					  <td width="15%" class="text-right"><strong>Device:</strong></td>
					  <td width="35%"><?=$items_name?></td>
					  <td width="15%" class="text-right"><strong>Amount:</strong></td>
					  <td width="35%"><?=amount_fomat($appt_data['item_amount'])?></td>
					  <?php
					  } else { ?>
					  <td width="15%"><strong>Device:</strong></td>
					  <td width="85%" colspan="3"><?=$appt_data['item_name']?></td>
					  <?php
					  } ?>
					</tr>
					<tr>
					  <td class="text-right"><strong>Name:</strong></td>
					  <td><?=$appt_data['name']?></td>
					  <td class="text-right"><strong>Email:</strong></td>
					  <td><?=$appt_data['email']?></td>
					</tr>
					<tr>
					  <td class="text-right"><strong>Phone:</strong></td>
					  <td><?=$appt_data['phone']?></td>
					  <td class="text-right"><strong>Location:</strong></td>
					  <td><?php if($appt_data['shipping_method']=="come_to_you"){echo 'We come to you';}elseif($appt_data['shipping_method']=="bring_to_shop"){echo 'Bring To Shop';}elseif($appt_data['shipping_method']=="ship_device"){echo 'Ship Device';}?></td>
					</tr>
					<tr>
					  <td class="text-right"><strong>Address:</strong></td>
					  <td><?=($appt_data['shipping_address']?$appt_data['shipping_address']:'No Data')?></td>
					  <td class="text-right"><strong>City:</strong></td>
					  <td><?=($appt_data['shipping_city']?$appt_data['shipping_city']:'No Data')?></td>
					</tr>
					<tr>
					  <td class="text-right"><strong>State:</strong></td>
					  <td><?=($appt_data['shipping_state']?$appt_data['shipping_state']:'No Data')?></td>
					  <td class="text-right"><strong>Zip Code:</strong></td>
					  <td><?=($appt_data['shipping_zipcode']?$appt_data['shipping_zipcode']:'No Data')?></td>
					</tr>
					<tr>
					  <td class="text-right"><strong>Instructions</strong></td>
					  <td><?=($appt_data['instructions']?$appt_data['instructions']:'No Data')?></td>
					  <td class="text-right"><strong>Appt. Date & Time:</strong></td>
					  <td><?=format_date($appt_data['appt_date'])?> | <?=str_replace("_"," to ",format_time($appt_data['appt_time']))?></td>
					</tr>
					<tr>
					  <!-- <td><strong>Appt. Time:</strong></td>
					  <td><?=str_replace("_"," to ",$appt_data['appt_time'])?></td> -->
					  <td class="text-right"><strong>Status:</strong></td>
					  <td><?=ucwords(str_replace('_',' ',$appt_data['appt_status_name']))?></td>
					  <td class="text-right"><strong>Extra Remarks:</strong></td>
					  <td><?=$appt_data['extra_remarks']?></td>
					</tr>
					<tr> 
					  <td class="text-right"><strong>Submitted Date:</strong></td>
					  <td colspan="3"><?=format_date($appt_data['added_date']).' '.format_time($appt_data['added_date'])?></td>
					</tr>
                    <?php
					/*$stripe_response_dt = json_decode($appt_data['stripe_response'],true);
					if(!empty($stripe_response_dt)) { ?>
                    <tr>
                    	<td class="text-right"><strong>Paid Amount:</strong></td>
					    <td><?=amount_fomat($appt_data['stripe_amount'])?></td>
                        <td class="text-right"><strong>Transaction ID:</strong></td>
					    <td><?=$stripe_response_dt['id']?></td>
                    </tr>
                    <?php
					}*/ ?>
				  </table>		
				  <a class="btn btn-secondary" style="margin-bottom:20px;" href="<?=SITE_URL?>account<?=(isset($post['p']) && $post['p']>0?'?p='.$post['p']:'')?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?=$back_btn_text?></a>
			</form>
			</div>
		</div>
	</div>
</section>

<?php
if($cust_payment_option == '1' && $stripe_publishable_key) { ?>
<div class="editAddress-modal modal fade HelpPopup" id="PayNow" tabindex="-1" role="dialog" aria-labelledby="PayNowLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<form method="post" action="<?=SITE_URL?>controllers/repair.php" id="pay_now_form" class="nobottommargin">
			<div class="modal-header">
			  <h4 class="modal-title" id="PayNowLabel"><?=$order_details_payment_summary_heading_text?></h4>
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<?php
				$item_name_array = json_decode($appt_data['item_name'],true);
				$item_name = json_encode($item_name_array);
				$total_amount = ($appt_data['item_amount']>0?$appt_data['item_amount']:0);
				$f_total_amount = $total_amount;
				
				$order_files_html = '';
				if(isset($appt_data['files']) && $appt_data['files']!="") {
					$order_files_list = explode(",",$appt_data['files']);
					foreach($order_files_list as $file_k=>$file_v) {
						if($file_v!="") {
							$file_image_ext = pathinfo($file_v, PATHINFO_EXTENSION);
							$order_files_html .= '<tr>
								<td colspan="2" width="100%"><a href="'.SITE_URL.'images/orders/files/'.$file_v.'" '.($file_image_ext!="txt"&&$file_image_ext!="pdf"?'data-lightbox="image"':'target="_blank"').'>'.$file_v.'</a></td>
							</tr>';
						}
					}
				}
				
				$item_list_html = '';
				if(!empty($item_name_array)) {
					foreach($item_name_array as $item_name_data) {
						$items_name = '';
						$items_opt_name = '';
			
						$items_opt_price = '';
						$items_opt_price_arr = array();
			
						$items_name = '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).'</strong>';
			
						$item_list_html .= '<tr>
							<td colspan="2" width="100%">'.$items_name.'</td>
						</tr>';
			
						if(!empty($item_name_data['opt_data'])) {
							foreach($item_name_data['opt_data'] as $opt_data) {
								$items_opt_name = $opt_data['opt_name'];
								
								$item_list_html .= '<tr>
									<td width="80%">'.$items_opt_name.'</td>
									<td width="20%" style="text-align:center;">'.amount_fomat($opt_data['opt_price']).'</td>
								</tr>';
							}
						}
					}
				}
			
				if($order_files_html) {
					$item_list_html .= '<tr>
						<td colspan="2" width="100%"><b>'.$order_details_files_text.'</b></td>
					</tr>';
					$item_list_html .= $order_files_html;
				}
				
				if($appt_data['promocode_amt']>0) {
					$item_list_html .= '<tr>
						<td width="80%"><b>'.$order_details_item_total_text.'</b></td>
						<td width="20%">'.amount_fomat($total_amount).'</td>
					</tr>';
					$item_list_html .= '<tr>
						<td width="80%">'.$discount_amt_label.'</td>
						<td width="20%">-'.amount_fomat($appt_data['promocode_amt']).'</td>
					</tr>';
				} else {
					$appt_data['promocode_amt'] = 0;
				}
			
				$item_list_html .= '<tr>
					<td width="80%"><b>'.$order_details_total_text.'</b></td>
					<td width="20%">'.amount_fomat($total_amount-$appt_data['promocode_amt']).'</td>
				</tr>';
				
				$f_total_amount = ($total_amount-$appt_data['promocode_amt']);

				$p_amt_arr = array(0);
				if(!empty($payment_history_list)) {
					foreach($payment_history_list as $payment_history_data) {
						$stripe_response_dt = json_decode($payment_history_data['stripe_response'],true);
						$item_list_html .= '<tr>
							<td width="80%"><b>Paid Amount On '.format_date($payment_history_data['date']).' '.format_time($payment_history_data['date']).($stripe_response_dt['id']?'<br><small>Tra. ID: '.$stripe_response_dt['id'].'</small>':'').'</b></td>
							<td width="20%">-'.amount_fomat($payment_history_data['paid_amount']).'</td>
						</tr>';
						$p_amt_arr[] = $payment_history_data['paid_amount'];
					}
				}
				$p_amt_total = array_sum($p_amt_arr);

				$item_list_html .= '<tr>
					<td width="80%"><b>'.$order_details_remaining_amount_text.'</b></td>
					<td width="20%">'.amount_fomat($f_total_amount-$p_amt_total).'</td>
				</tr>';
				$f_total_amount = $f_total_amount-$p_amt_total;

				$items_body_html = '';
				$items_body_html .= '<table width="650" class="table m-table m-table--head-bg-brand">';
					$items_body_html .= '
						<tr>
							<td width="80%"><strong>'.$order_details_repair_selected_item_text.'</strong></td>
							<td width="20%" style="text-align:right;"><strong>'.$price_heading_text.'</strong></td>
						</tr>';
					$items_body_html .= '<tbody>'.$item_list_html.'</tbody>';
				$items_body_html .= '</table>';
				
				echo $items_body_html; ?>
			</div>
			<div class="modal-footer">
            	<?php
				if($f_total_amount>0) { ?>
				<button type="button" class="button ml-0" id="stripe-button"><?=$order_details_pay_btn_text?> <span id="payable_amount_lbl"></span></button>
                <?php
				} ?>
				<button type="button" class="button button-danger mt-0" data-dismiss="modal"><?=$popup_close_btn_text?></button>
			</div>
            
            <input type="hidden" name="payable_amount" id="payable_amount" value="">
            <input type="hidden" name="pay_now_request" value="yes" />
            <input type="hidden" name="appt_id" value="<?=$appt_id?>" />
            <input type="hidden" name="stripeToken" id="stripeToken" value=""/>
			<input type="hidden" name="stripeEmail" id="stripeEmail" value=""/>
		</form>
	</div>
  </div>
</div>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php
} ?>

<script>
(function( $ ) {
	$(function() {
		
		<?php
		if($cust_payment_option == '1' && $stripe_publishable_key) { ?>
		$("#payable_amount_lbl").html('<?=amount_fomat($f_total_amount)?>');
		$("#payable_amount").val('<?=$f_total_amount?>');
	
		var stripe_publishable_key = '<?=$stripe_publishable_key?>';
		var handler = StripeCheckout.configure({
			key: stripe_publishable_key,
			image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
			locale: 'auto',
			token: function(data) {
				$("#stripeToken").val(data.id);
				$("#stripeEmail").val(data.email);
				$("#pay_now_form")[0].submit();
			}
		});
	
		$('#stripe-button').on('click', function(e) {
			if(stripe_publishable_key!="") {
				var email = '<?=$appt_data['email']?>';
				
				handler.open({
					image: '<?=SITE_URL?>images/logo.png',
					name: '<?=SITE_NAME?>',
					description: '',
					email: email,
					currency: '<?=$currency_nm?>',
					amount: <?=($f_total_amount * 100)?>
				});
				e.preventDefault();
			} else {
				alert("<?=$validation_stripe_not_enable_msg_text?>");
				return false;
			}
		});
		$(window).on('popstate', function() {
			handler.close();
		});
		<?php
		} ?>
	});
})(jQuery);
</script>
<?php
} ?>