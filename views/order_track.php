<?php
$csrf_token = generateFormToken('order_track');

$order_id = isset($_SESSION['track_order_id'])?$_SESSION['track_order_id']:'';
$order_data = get_appt_data($order_id);
$payment_history_list = get_payment_history_data($order_id)['list'];
if($order_id!="") {
	//unset($_SESSION['track_order_id']);
}

$error_message = isset($_SESSION['error_message'])?$_SESSION['error_message']:'';
if($error_message!="") {
	unset($_SESSION['error_message']);
}

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];

//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section id="head-graphics" <?php if($header_image != ""){echo 'style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="d-flex align-items-center justify-content-center">
						<div class="text-center clearfix">
							<?php
							if($show_title == '1') {
								echo '<h1>'.$page_title.'</h1>';
							}
							if($image_text) {
								echo '<p>'.$image_text.'</p>';
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
}

if($show_breadcrumbs == '1') { ?>
<section class="border-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=SITE_URL?>">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$active_page_data['menu_name']?></li>
				</ol>
			</div>
		</div>
	</div>
</section>
<?php
} ?>

<section id="content" class="py-5">
	<div class="container clearfix">
		<div class="row divcenter nobottommargin clearfix" style="max-width:500px;">
			<div class="col-md-12">
				<?php
				if($is_show_title && $show_title == '1') { ?>
				<div class="heading-block bottommargin-sm center">
					<h3><?=$page_title?></h3>
				</div>
				<?php
				}
				
				if($error_message!="") { ?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?=$error_message?>
					</div>
				<?php
				}
				
				if($active_page_data['content']) { ?>
					<div class="form-group">
						<?=$active_page_data['content']?>
					</div>
				<?php
				}
				
				 if(!empty($order_data)) { ?>
                    <div class="form-group">
                        <h4><strong><?=$email_title?>:</strong> <?=$order_data['email']?><br />
                        <strong><?=$order_id_title?>:</strong> <?=$order_data['appt_id']?><br />
                        <strong><?=$order_status_title?>:</strong> <?=$order_data['appt_status_name']?></h4>
                        <a href="<?=SITE_URL?>controllers/order_track.php?retry" class="btn btn-primary btn-lg"><?=$retry_btn_text?></a>
                        <?php
                        if($cust_payment_option == '1' && $stripe_publishable_key) { ?>
                        <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#PayNow"><?=$payment_btn_text?></a>
                        <?php
                        } ?>
                    </div>
				  <?php
				  } else { ?>
					<form action="controllers/order_track.php" method="post" id="contact_form" class="phone-sell-form mb-0">
						<div class="form-row">
							<div class="form-group col-md-12">
							<input type="text" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" class="sm-form-control" value="<?=$user_email?>"/>
							</div>
							<div class="form-group col-md-12">
							<input type="text" name="order_id" id="order_id" placeholder="<?=$order_number_placeholder_text?>" class="sm-form-control" />
							</div>
					  
							<?php
							if($order_track_form_captcha == '1') { ?>
								<div class="form-group col-md-12">
									<div id="g_form_gcaptcha"></div>
									<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
								</div>
							<?php
							} ?>
						  
							<div class="form-group col-md-12">
								<button type="submit" class="button button-3d nomargin" style="margin-top:0px;"><?=$track_order_btn_text?></button>
								<input type="hidden" name="submit_form" id="submit_form" />
							</div>
						</div>
						
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
					 </form>
				<?php
				} ?>
			</div>
		</div>
  </div>
</section>

<?php
if($cust_payment_option == '1' && $stripe_publishable_key && !empty($order_data)) { ?>
<div class="editAddress-modal modal fade HelpPopup" id="PayNow" tabindex="-1" role="dialog" aria-labelledby="PayNowLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<form method="post" action="<?=SITE_URL?>controllers/repair.php" id="pay_now_form" class="nobottommargin">
			<div class="modal-header">
			  <h4 class="modal-title" id="PayNowLabel"><?=$order_track_form_payment_summary_heading_text?></h4>
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<?php
				$item_name_array = json_decode($order_data['item_name'],true);
				$item_name = json_encode($item_name_array);
				$total_amount = ($order_data['item_amount']>0?$order_data['item_amount']:0);
				$f_total_amount = $total_amount;
				
				$order_files_html = '';
				if(isset($order_data['files']) && $order_data['files']!="") {
					$order_files_list = explode(",",$order_data['files']);
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
						<td colspan="2" width="100%"><b>'.$order_track_form_files_text.'</b></td>
					</tr>';
					$item_list_html .= $order_files_html;
				}
				
				if($order_data['promocode_amt']>0) {
					$item_list_html .= '<tr>
						<td width="80%"><b>'.$order_track_form_item_total_text.'</b></td>
						<td width="20%">'.amount_fomat($total_amount).'</td>
					</tr>';
					$item_list_html .= '<tr>
						<td width="80%">'.$discount_amt_label.'</td>
						<td width="20%">-'.amount_fomat($order_data['promocode_amt']).'</td>
					</tr>';
				} else {
					$order_data['promocode_amt'] = 0;
				}
			
				$item_list_html .= '<tr>
					<td width="80%"><b>'.$order_track_form_total_text.'</b></td>
					<td width="20%">'.amount_fomat($total_amount-$order_data['promocode_amt']).'</td>
				</tr>';
				
				$f_total_amount = ($total_amount-$order_data['promocode_amt']);

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
					<td width="80%"><b>'.$order_track_form_remaining_amount_text.'</b></td>
					<td width="20%">'.amount_fomat($f_total_amount-$p_amt_total).'</td>
				</tr>';
				$f_total_amount = $f_total_amount-$p_amt_total;

				$items_body_html = '';
				$items_body_html .= '<table width="650" class="table m-table m-table--head-bg-brand">';
					$items_body_html .= '
						<tr>
							<td width="80%"><strong>'.$order_track_form_repair_selected_item_text.'</strong></td>
							<td width="20%" style="text-align:right;"><strong>'.$price_heading_text.'</strong></td>
						</tr>';
					$items_body_html .= '<tbody>'.$item_list_html.'</tbody>';
				$items_body_html .= '</table>';
				
				echo $items_body_html; ?>
			</div>
			<div class="modal-footer">
            	<?php
				if($f_total_amount>0) { ?>
				<button type="button" class="button ml-0" id="stripe-button"><?=$order_track_form_pay_btn_text?> <span id="payable_amount_lbl"></span></button>
                <?php
				} ?>
				<button type="button" class="button button-danger mt-0" data-dismiss="modal">Close</button>
			</div>
            
            <input type="hidden" name="payable_amount" id="payable_amount" value="">
            <input type="hidden" name="pay_now_request" value="yes" />
            <input type="hidden" name="appt_id" value="<?=$order_id?>" />
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
<?php
if($order_track_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};

var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

(function( $ ) {
	$(function() {
		
		<?php
		if($cust_payment_option == '1' && $stripe_publishable_key && !empty($order_data)) { ?>
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
				var email = '<?=$order_data['email']?>';
				
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
	
		$('#contact_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: '<?=$validation_email_msg_text?>'
						},
						emailAddress: {
							message: '<?=$validation_valid_email_msg_text?>'
						}
					}
				},
				order_id: {
					validators: {
						notEmpty: {
							message: '<?=$validation_order_id_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>