<?php
$current_date = date('Y-m-d');
$location_list = get_location_data_list();
$csrf_token = generateFormToken('repair');

//Header section
include("include/header.php");

$order_id=$url_second_param;
$appt_auto_inc_id=$url_third_param;
$exp_appt_auto_inc_id = array_reverse(explode("-",$appt_auto_inc_id));
$appt_auto_inc_id=trim($exp_appt_auto_inc_id['0']);
$location_id=isset($_SESSION['location_id'])?$_SESSION['location_id']:0;
$location_id = ($location_id?$location_id:'0');
unset($_SESSION['location_id']);

$promocode_amt = 0;
$discount_amt_label = "";

$exst_appt_q = mysqli_query($db,"SELECT * FROM appointments WHERE appt_id='".$order_id."' AND appt_id!=''");
$appointments_data = mysqli_fetch_assoc($exst_appt_q);

if($order_id=='') {
	$msg='Direct access denied';
	setRedirectWithMsg('/',$msg,'danger');
	exit;
} elseif($order_id!='' && $appt_auto_inc_id=='' && !empty($appointments_data)) {
	$msg=$validation_order_already_in_system_msg_text;
	setRedirectWithMsg('/',$msg,'danger');
	exit;
} elseif($order_id!='' && $appt_auto_inc_id!='') {
	$exst_appt_q_2 = mysqli_query($db,"SELECT * FROM appointments WHERE appt_id='".$order_id."' AND id='".$appt_auto_inc_id."'");
	$exist_appt_by_id = mysqli_num_rows($exst_appt_q_2);
	if($exist_appt_by_id<=0) {
		$msg='Direct access denied';
		setRedirectWithMsg('/',$msg,'danger');
		exit;
	}

	if($appointments_data['promocode_id']>0 && $appointments_data['promocode_amt']>0) {
		$promocode_amt = $appointments_data['promocode_amt'];
		$discount_amt_label = "<strong>".$repair_form_coupon_code_discount_label."</strong>";
		if($appointments_data['discount_type']=="percentage")
			$discount_amt_label = "<strong>".$repair_form_coupon_code_discount_label." (".$appointments_data['discount']."% of Initial Quote)</strong>";
	
		//$f_promocode_info = $discount_amt_label.amount_fomat($promocode_amt);
	}
	
	$order_files_html = '';
	if($appointments_data['item_files']!="") {
		$order_files_list = explode(",",$appointments_data['item_files']);
		foreach($order_files_list as $file_k=>$file_v) {
			if($file_v!="") {
				$file_image_ext = pathinfo($file_v, PATHINFO_EXTENSION);
				$order_files_html .= '<li class="h6 pb-1"><i class="icon-line-circle-check"></i><div class="row"><div class="col-md-8"><a href="'.SITE_URL.'images/orders/files/'.$file_v.'" '.($file_image_ext!="txt"&&$file_image_ext!="pdf"?'data-lightbox="image"':'target="_blank"').'>'.$file_v.'</a></div></div></li>';
			}
		}
	}
	
	$product_id = $appointments_data['product_id'];
	$total_amount = $appointments_data['item_amount'];
	$item_name_array = json_decode($appointments_data['item_name'],true);
} else {
	$p_order_data = get_order_data($order_id);
	if(empty($p_order_data)) {
		$msg='Direct access denied';
		setRedirectWithMsg('/',$msg,'danger');
		exit;
	}
	
	if($p_order_data['promocode_id']>0 && $p_order_data['promocode_amt']>0) {
		$promocode_amt = $p_order_data['promocode_amt'];
		$discount_amt_label = "<strong>".$repair_form_coupon_code_discount_label."</strong>";
		if($p_order_data['discount_type']=="percentage")
			$discount_amt_label = "<strong>".$repair_form_coupon_code_discount_label." (".$p_order_data['discount']."% of Initial Quote)</strong>";
	
		//$f_promocode_info = $discount_amt_label.amount_fomat($promocode_amt);
	}

	$order_files_list = array();
	$order_files_html = '';
	$order_item_list = get_order_item_list($order_id);
	foreach($order_item_list as $order_item_list_data) {
		if($order_item_list_data['files']!="") {
			$order_files_list = explode(",",$order_item_list_data['files']);
			foreach($order_files_list as $file_k=>$file_v) {
				if($file_v!="") {
					$file_image_ext = pathinfo($file_v, PATHINFO_EXTENSION);
					$order_files_html .= '<li class="h6 pb-1"><i class="icon-line-circle-check"></i><div class="row"><div class="col-md-8"><a href="'.SITE_URL.'images/orders/files/'.$file_v.'" '.($file_image_ext!="txt"&&$file_image_ext!="pdf"?'data-lightbox="image"':'target="_blank"').'>'.$file_v.'</a></div></div></li>';
				}
			}
		}
		
		$product_id = $order_item_list_data['model_id'];
		$order_item_data = get_order_item($order_item_list_data['id'],'list');
		$total_amount = $order_item_list_data['price'];
		$item_name_array = json_decode($order_item_data['data']['item_name'],true);
		$item_id = $order_item_data['data']['id'];
	}
}

$model_q = mysqli_query($db,"SELECT * FROM mobile WHERE id='".$product_id."'");
$model_data = mysqli_fetch_assoc($model_q);

$models_text = $model_data['models'];
$models_text = ($models_text?" - ".$models_text:"");
$product_name = $model_data['title'].$models_text;
?>

<section id="content">
	<div class="container clearfix">
		
		<?php
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		if($confirm_message) {
			echo '<div class="row topmargin-sm"><div class="col-12">'.$confirm_message.'</div></div>';
		} //END for confirm message ?>
		
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<?php
			if($appt_auto_inc_id>0) { ?>
				<h3><?=str_replace("[name]",$appointments_data['name'],$repair_form_completed_title)?></h3>
				<span><?=$repair_form_completed_sub_title?></span>
			<?php
			} else { ?>
				<h3><?=$repair_form_title?></h3>
				<span><?=$repair_form_sub_title?></span>
			<?php
			} ?>
		</div>

		<div class="row">
			<div class="col-lg-8">
				<?php
				if($appt_auto_inc_id>0) { ?>
					<div class="col-12">
						<div class="card p-3 mb-5">
							<div class="row">
								<div class="col-12">
									<ul class="iconlist">
										<?php
										$shipment_label_url = $appointments_data['shipment_label_url'];
										if($appointments_data['shipping_method'] == "ship_device" && $shipment_label_url == "") { ?>
											<li class="h6 pb-1">
												<div class="alert alert-success alert-dismissable">
													<?=$unable_to_create_shipment_text?>
												</div>
											</li>
										<?php
										} elseif($appointments_data['shipping_method'] == "ship_device") { ?>
											<li class="h6 pb-1">
												<a href="<?=SITE_URL.'controllers/download.php?download_link='.$shipment_label_url?>" class="btn btn-success mb-2"><?=$download_address_label_text?> <i class="icon-download"></i></a>
											</li>
										<?php
										}/* ?>
										<li class="h6 pb-1"><strong>Devices:</strong> <?=$appointments_data['item_name']?></li>
										<?php
										if($online_booking_hide_price != '1') { ?>
											<li class="h6 pb-1"><strong>Cost:</strong> <?=amount_fomat($appointments_data['item_amount'])?></li>
										<?php
										}*/
										if($appointments_data['shipping_method']=="come_to_you") {
											echo '';
										} elseif($appointments_data['shipping_method']=="bring_to_shop") { ?>
											<li class="h6 pb-1"><strong>Location:</strong> <?=$repair_form_completed_bring_to_shop_text?><br><?=$company_name?><br>
											<?=$company_address.'<br>'.$company_city.', '.$company_state.' '.$company_zipcode?></li>
										<?php
										} ?>
										<li class="h6 pb-1"><strong><?=$repair_form_completed_time_text?>:</strong> <?=$appointments_data['appt_date'].', '.str_replace("_"," to ",$appointments_data['appt_time'])?></li>
										<li class="h6 pb-1"><strong><?=$repair_form_completed_your_info_text?>:</strong><br /><?=$appointments_data['name']?><br /><?=$appointments_data['email']?><br /><?=$appointments_data['phone']?></li>
										
                                        <?php
										/*$stripe_response_dt = json_decode($appointments_data['stripe_response'],true);
										if(!empty($stripe_response_dt)) { ?>
                                        <li class="h6 pb-1"><strong>Paid info:</strong><br />
											<strong>Amount: </strong><?=amount_fomat($appointments_data['stripe_amount'])?><br />
											<strong>Transaction ID: </strong><?=$stripe_response_dt['id']?>
                                        </li>
										<?php
										}*/
										
										if($appointments_data['address'] || $appointments_data['floor_no']) { ?>
										<li class="h6 pb-1">
											<strong>We come to you</strong><br /><?=$appointments_data['address'].($appointments_data['floor_no']?'<br />'.$appointments_data['floor_no']:'').($appointments_data['instructions']?'<br />'.$appointments_data['instructions']:'')?>
										</li>
										<?php
										} ?>
										
										<div class="mt-5 nobottommargin clearfix">
											<h3><?=$repair_form_what_happens_next_title?></h3>
											<blockquote>
												<?=$repair_form_what_happens_next_desc?>
												<footer class="blockquote-footer"><?=SITE_NAME?></footer>
											</blockquote>
										</div>
									</ul>
								</div>
							</div>
						</div>
					</div>
				<?php
				} else { ?>
					<form id="booking-form" class="row" action="<?=SITE_URL?>controllers/repair.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="product_id" id="product_id" value="<?=$product_id?>">
						<input type="hidden" name="item_id" id="item_id" value="<?=$item_id?>">
						<input type="hidden" name="item_name" id="item_name" value="">
						<input type="hidden" name="item_amount" id="item_amount" value="<?=$total_amount?>">
						<input type="hidden" name="appt_id" id="appt_id" value="<?=$order_id?>">
						<input type="hidden" name="user_id" id="user_id" value="<?=$user_data['id']?>">

						<div class="col-12">
							<div class="card p-3">
								<div class="row">
									
									<?php
									//START for social login
									if($social_login=='1') { ?>
									<script type="text/javascript" src="<?=SITE_URL?>social/js/oauthpopup.js"></script>
									<script>
									var tpj=jQuery;
									tpj(document).ready(function($) {
										//For Google
										$('a.login').oauthpopup({
											path: '/social/social.php?only_data_from_gl',
											width:650,
											height:350,
										});
									});
										
									tpj(document).ready(function() {
									  tpj.ajaxSetup({ cache: true });
									  tpj.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
										tpj("#facebookAuth").click(function() {
											FB.init({
											  appId: '<?=$fb_app_id?>',
											  version: 'v2.8'
											});

											FB.login(function(response) {
												if(response.authResponse) {
												 console.log('Welcome! Fetching your information.... ');
												 FB.api('/me?fields=id,name,first_name,middle_name,last_name,email,gender,locale', function(response) {
													 console.log('Response',response);							 	
													 tpj("#name").val(response.name);
													 tpj("#email").val(response.email);
													 
													 if(response.email!="") {
														 tpj.ajax({
															type: "POST",
															url:"../ajax/social_login.php",
															data:response,
															success:function(data) {
																if(data!="") {
																	var resp_data = JSON.parse(data);
																	if(resp_data.msg!="" && resp_data.status == true) {
																		location.reload(true);
																	} else {
																		alert("<?=$validation_something_went_wrong_msg_text?>");
																	}
																} else {
																	alert("<?=$validation_something_went_wrong_msg_text?>");
																}
															}
														});
													}		

												 });
												} else {
													console.log('User cancelled login or did not fully authorize.');
												}
											},{scope: 'email'});
										});
									  });
									});
									</script>
									
									<div class="col-12 form-group center">
										<?php
										if($social_login_option=="g_f") { ?>
											<a id="facebookAuth" href="javascript:void(0);" class="button button-rounded si-facebook si-colored"><i class="icon-facebook"></i>Facebook</a>&nbsp;<a href="javascript:void(0);" class="button button-rounded si-google si-colored login"><i class="icon-google"></i>Google</a>
										<?php
										} elseif($social_login_option=="g") { ?>
											<a href="javascript:void(0);" class="button button-rounded si-google si-colored login"><i class="icon-google"></i>Google</a>
										<?php
										} elseif($social_login_option=="f") { ?>
											<a id="facebookAuth" href="javascript:void(0);" class="button button-rounded si-facebook si-colored"><i class="icon-facebook"></i>Facebook</a>
										<?php
										} ?>
									</div>
									<div class="col-12 form-group nomargin center">
										<h4 style="margin-bottom: 15px;">OR</h4>
									</div>
									<?php
									} //END for social login
									$facebook_data = isset($_SESSION['facebook_data'])?$_SESSION['facebook_data']:''; ?>
									
									<div class="col-md-12 form-group">
										<label for="name"><?=$name_field_title?>:</label>
										<input type="text" name="name" placeholder="<?=$name_field_placeholder_text?>" class="name sm-form-control" id="name" value="<?=(isset($facebook_data['name'])?$facebook_data['name']:$user_data['name'])?>">
										<small id="name_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
									<div class="col-md-12 form-group">
										<label for="email"><?=$email_field_title?>:</label>
										<input type="text" name="email" placeholder="<?=$email_field_placeholder_text?>" class="email sm-form-control" id="r_email" value="<?=(isset($facebook_data['email'])?$facebook_data['email']:$user_data['email'])?>">
										<small id="email_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
									<div class="col-md-12 form-group">
										<label for="email"><?=$phone_field_title?>:</label>
										<input type="text" name="phone" placeholder="<?=$phone_field_placeholder_text?>" class="phone sm-form-control" id="phone" value="<?=$user_data['phone']?>" maxlength="10">
										<small id="phone_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								</div>
							</div>
						</div>
						
						<?php
						if($location_option_bring_to_shop == '1' || $location_option_come_for_you == '1' || $location_option_ship_device == '1') { ?>
						<div class="col-12">
							<div class="card p-3 mt-3">
								<div class="row">
									<div class="col-md-12 form-group">
										<label for="shipping_method" class="mb-3"><?=$choose_your_location_text?>:<small class="text-danger">*</small></label><br>
										<div class="btn-group my-tab btn-group-toggle nav" data-toggle="buttons">
											<?php
											if($location_option_bring_to_shop == '1') { ?>
											<a href="#tab-payment_method_bringtoshop" class="btn btn-outline-secondary flex-fill <?=($location_option_default['bring_to_shop']=='1'?'active':'')?>" data-toggle="tab">
												<input type="radio" name="shipping_method" id="payment_method_bringtoshop" value="bring_to_shop" <?=($location_option_default['bring_to_shop']=='1'?'checked="checked"':'')?>><?=$bring_to_shop_title_text?>
											</a>
											<?php
											}
											if($location_option_come_for_you == '1') { ?>
											<a href="#tab-payment_method_wecomeyou" class="btn btn-outline-secondary flex-fill <?=($location_option_default['come_for_you']=='1'?'active':'')?>" data-toggle="tab">
												<input type="radio" name="shipping_method" id="payment_method_wecomeyou" value="come_to_you" <?=($location_option_default['come_for_you']=='1'?'checked="checked"':'')?>><?=$we_come_for_you_title_text?>
											</a>
											<?php
											}
											if($location_option_ship_device == '1') { ?>
											<a href="#tab-payment_method_ship_device" class="btn btn-outline-secondary flex-fill <?=($location_option_default['ship_device']=='1'?'active':'')?>" data-toggle="tab">
												<input type="radio" name="shipping_method" id="payment_method_ship_device" value="ship_device" <?=($location_option_default['ship_device']=='1'?'checked="checked"':'')?>><?=$ship_your_device_title_text?>
											</a>
											<?php
											} ?>
										</div>
										
										<div class="tab-content">
											<div class="tab-pane fade mt-3 <?=($location_option_default['bring_to_shop']=='1'?'active show':'')?>" id="tab-payment_method_bringtoshop">
												<?php
												if(count($location_list)<1) { ?>
													<label><?=$company_name?></label><br>
													<?=$company_address?><br>
													<?=$company_city?>, <?=$company_state?> <?=$company_zipcode?>
												<?php
												} elseif(count($location_list)==1) { ?>
													<label><?=$company_name.($location_list[0]['name']?' - '.$location_list[0]['name']:'')?></label><br>
													<?=$location_list[0]['address']?><br>
													<?=$location_list[0]['city'].', '.$location_list[0]['state'].' '.$location_list[0]['zipcode']?><br />
													<?=$location_list[0]['country']?>
												<?php
												} ?>
											</div>
											<div class="tab-pane fade mt-3 <?=($location_option_default['come_for_you']=='1'?'active show':'')?>" id="tab-payment_method_wecomeyou">
												<?php /*?><div class="form-group">
													<label for="address">Address:</label>
													<textarea name="address" placeholder="Address..." class="address sm-form-control" id="address"><?=$user_data['address'].($user_data['address2']?", ".$user_data['address2']:"")?></textarea>
													<small id="address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="floor_no">Add / suite / floor No. (optional):</label>
													<input type="text" name="floor_no" placeholder="Add / suite / floor No. (optional)" class="floor_no sm-form-control" id="floor_no">
												</div><?php */?>
												
												<div class="form-group">
													<label for="address"><?=$address_field_title?>:</label>
													<textarea name="address" placeholder="<?=$address_field_placeholder_text?>" class="address sm-form-control" id="address"><?=$user_data['address'].($user_data['address2']?", ".$user_data['address2']:"")?></textarea>
													<small id="address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="city"><?=$city_field_title?>:</label>
													<input type="text" name="city" placeholder="<?=$city_field_placeholder_text?>" class="city sm-form-control" id="city" value="<?=$user_data['city']?>">
													<small id="city_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="state"><?=$state_field_title?>:</label>
													<input type="text" name="state" placeholder="<?=$state_field_placeholder_text?>" class="state sm-form-control" id="state" value="<?=$user_data['state']?>">
													<small id="state_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="zipcode"><?=$zipcode_field_title?>:</label>
													<input type="text" name="zipcode" placeholder="<?=$zipcode_field_placeholder_text?>" class="zipcode sm-form-control" id="zipcode" value="<?=$user_data['postcode']?>">
													<small id="zipcode_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="instructions"><?=$instructions_field_title?>:</label>
													<textarea name="instructions" placeholder="<?=$instructions_field_placeholder_text?>" class="instructions sm-form-control" id="instructions"></textarea>
												</div>
											</div>
											<div class="tab-pane fade mt-3 <?=($location_option_default['ship_device']=='1'?'active show':'')?>" id="tab-payment_method_ship_device">
												<div class="form-group">
													<label for="shipping_address"><?=$address_field_title?>:</label>
													<textarea name="shipping_address" placeholder="<?=$address_field_placeholder_text?>" class="shipping_address sm-form-control" id="shipping_address"><?=$user_data['address'].($user_data['address2']?", ".$user_data['address2']:"")?></textarea>
													<small id="shipping_address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="shipping_city"><?=$city_field_title?>:</label>
													<input type="text" name="shipping_city" placeholder="<?=$city_field_placeholder_text?>" class="shipping_city sm-form-control" id="shipping_city" value="<?=$user_data['city']?>">
													<small id="shipping_city_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="shipping_state"><?=$state_field_title?>:</label>
													<input type="text" name="shipping_state" placeholder="<?=$state_field_placeholder_text?>" class="shipping_state sm-form-control" id="shipping_state" value="<?=$user_data['state']?>">
													<small id="shipping_state_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
												<div class="form-group">
													<label for="shipping_zipcode"><?=$zipcode_field_title?>:</label>
													<input type="text" name="shipping_zipcode" placeholder="<?=$zipcode_field_placeholder_text?>" class="shipping_zipcode sm-form-control" id="shipping_zipcode" value="<?=$user_data['postcode']?>">
													<small id="shipping_zipcode_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						} ?>
										
						<div class="col-12">
							<div class="card p-3 mt-3">
								<div class="row">
									<div class="col-12 form-group">
										<?php
										if(count($location_list)>0) { ?>
											<label for="location_id"><?=$shop_location_field_title?>:</label>
											<select id="location_id" name="location_id" class="sm-form-control" onchange="getTimeSlotList(this.value);">
											  <option value=""> - Select - </option>
											  <?php
											  foreach($location_list as $location_data) { ?>
												<option value="<?=$location_data['id']?>" <?php if($location_data['id']==$location_id){echo 'selected="selected"';}?>><?=$location_data['name']?></option>
											  <?php
											  } ?>
											</select>
											<small id="location_id_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
										<?php
										} else {
											echo '<input type="hidden" id="location_id" name="location_id" value="0" />';
										}
										
										foreach($location_list as $location_data) { ?>
											<div class="location-adr-show-hide" id="location-adr-<?=$location_data['id']?>" style="display:none;">
												<strong><?=$company_name.($location_data['name']?' - '.$location_data['name']:'')?></strong><br />
												<?=$location_data['address']?><br />
												<?=$location_data['city'].', '.$location_data['state'].' '.$location_data['zipcode']?><br />
												<?=$location_data['country']?>
											</div>
										<?php
										} ?>
									</div>
							
									<div class="col-12 form-group">
										<label for="date"><?=$date_field_title?></label>
										<input type="text" name="date" placeholder="<?=$date_field_placeholder_text?>" class="sm-form-control repair_appt_date" id="date" autocomplete="off">
										<small id="date_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
		
									<div class="col-12 form-group time_slot_sec_showhide" style="display:none;">
										<label for="time_slot"><?=$time_slot_field_title?></label>
										<select id="time_slot" name="time_slot" class="sm-form-control repair_time_slot">
											<?php
											if(count($location_list)<=0) {
												$time_interval   = ($appt_time_interval * 60);
												$start_time = (strtotime($appt_start_time));
												$end_time   = (strtotime($appt_end_time));
												
												echo '<option value=""> - Select - </option>';
												for($i = $start_time; $i<=$end_time; $i+=$time_interval) {
													$range = date('g:i a',$i);
													echo "<option value=\"$range\">".format_time_without_timezone($range)."</option>".PHP_EOL;
												}
											} ?>
										</select>
										<small id="time_slot_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
										<small class="time-slot-msg" style="display:none;"></small>
									</div>

									<div class="col-12 form-group">
										<label for="extra_remarks"><?=$extra_remarks_field_title?>:</label>
										<textarea name="extra_remarks" placeholder="<?=$extra_remarks_placeholder_text?>" class="extra_remarks sm-form-control" id="extra_remarks" rows="4"></textarea>
									</div>

									<?php
									if($appt_form_captcha == '1') { ?>
									<div class="col-12 form-group">
										<div id="g_form_gcaptcha"></div>
										<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
									</div>
									<?php
									} ?>
								</div>
							</div>
						</div>
	
						<!--<div class="col-12 mt-2 mb-3">
							<div class="card p-3 bg-light">
								<div class="car-body">
									<h3 class="mb-2">Make an appointment</h3>
									<p class="mb-0">Choose when you will bring your device to the shop. Most repairs are completed within 15 to 20 minutes.</p>
								</div>
							</div>
						</div>-->
	
						<div class="col-12 mt-3">
                        	<?php
							if($cust_payment_option == '1' && $stripe_publishable_key) { ?>
                            <input type="hidden" name="payable_amount" id="payable_amount" value="">
                            <input type="hidden" name="request_repair" value="yes" />
                        	<button type="button" class="button ml-0 btn-lg" id="stripe-button"><?=$repair_form_pay_btn_text?> <span id="payable_amount_lbl"></span></button>
                            <?php
							} else { ?>
							<button type="submit" name="request_repair" class="button ml-0 btn-lg request-repair-button"><?=$repair_form_sbmt_btn_text?></button>
                            <?php
							} ?>
						</div>
	
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                        
					    <input type="hidden" name="stripeToken" id="stripeToken" value=""/>
					    <input type="hidden" name="stripeEmail" id="stripeEmail" value=""/>
					</form>
				<?php
				} ?>
			</div>
			<div class="col-lg-4 mb-4">
				<div class="card">
					<div class="card-body">
						<h4 class="mb-3 d-block"><?=$repair_form_order_summary_heading_text?></h4>

						<?php
						if($model_data['model_img']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=144';
							echo '<img loading="lazy" src="'.$md_img_path.'">';
						} ?>
						<h4 class="mt-2"><strong><?=$product_name?></strong></h4>

						<div class="line line-sm my-2"></div>
						<ul class="iconlist mb-0">
							<?php /*?><li class="h6 pb-1">
								<div class="row">
									<div class="col-md-8">
										<strong><?=$product_name?> Repair Options</strong>
									</div>
									<div class="col-md-4">
										<!-- <strong>Amount</strong> -->
									</div>
								</div>
								<div class="line line-sm my-2"></div>
							</li><?php */?>

							<?php
							$f_total_amount = $total_amount;
							if(!empty($item_name_array)) {
								foreach($item_name_array as $item_name_data) {
									$items_name = '';
									$items_opt_name = '';

									$items_opt_price = '';
									$items_opt_price_arr = array();

									$items_name = '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).'</strong> ';
									//foreach($item_name_data['opt_data'] as $opt_data) {
										//$items_opt_price_arr[] = $opt_data['opt_price'];
										//$items_opt_name_tmp .= $opt_data['opt_name'].', ';
									//}
									//$items_opt_name .= rtrim($items_opt_name_tmp,', ');
									//$items_opt_price = array_sum($items_opt_price_arr); ?>

									<li class="h6 pb-1">
										<div class="row">
											<div class="col-md-12">
												<strong><?=$items_name?></strong>
											</div>
										</div>
										<div class="line line-sm my-2"></div>
									</li>

									<?php
									if(!empty($item_name_data['opt_data'])) {
										foreach($item_name_data['opt_data'] as $opt_data) {
											$items_opt_name = $opt_data['opt_name']; ?>
											<li class="h6 pb-1">
												<i class="icon-line-circle-check"></i>
												<div class="row">
													<div class="col-8">
														<?=$items_opt_name?>
													</div>
													<div class="col-4">
														<strong><?=amount_fomat($opt_data['opt_price'])?></strong>
													</div>
												</div>
												<div class="line line-sm my-2"></div>
											</li>
										<?php
										}
									}
								}
							}

							if($order_files_html) { ?>
							<li class="h6 pb-1">
								<div class="row">
									<div class="col-md-12">
										<strong><?=$repair_form_files_text?></strong>
									</div>
								</div>
								<div class="line line-sm my-2"></div>
							</li>
							<?php
							echo $order_files_html;
							}

							if($online_booking_hide_price != '1') {
							if($promocode_amt>0) { ?>
							<li class="h6 pb-1">
								<div class="row">
									<div class="col-8">
										<strong><?=$repair_form_item_total_text?></strong>
									</div>
									<div class="col-4">
										<strong class="text-primary"><?=amount_fomat($total_amount)?></strong>
									</div>
								</div>
							</li>
							<li class="h6 pb-1">
								<div class="row">
									<div class="col-8">
										<strong><?=$discount_amt_label?></strong>
									</div>
									<div class="col-4">
										<strong class="text-primary">-<?=amount_fomat($promocode_amt)?></strong>
									</div>
								</div>
							</li>
							<?php
							} ?>
							
							<li class="h6 pb-1">
								<div class="row">
									<div class="col-8">
										<strong><?=$repair_form_total_text?></strong>
									</div>
									<div class="col-4">
										<strong class="text-primary"><?=amount_fomat($total_amount-$promocode_amt)?></strong>
									</div>
								</div>
							</li>
							<?php
							$f_total_amount = ($total_amount-$promocode_amt);
							}
				
							$item_list_html = '';			
							$p_amt_arr = array(0);
							$payment_history_list = get_payment_history_data($order_id)['list'];
							if(!empty($payment_history_list)) {
								foreach($payment_history_list as $payment_history_data) {
									$stripe_response_dt = json_decode($payment_history_data['stripe_response'],true);
									$item_list_html .= '<li class="h6 pb-1">
								<div class="row">
									<div class="col-8">
										<strong>Paid Amount On '.format_date($payment_history_data['date']).' '.format_time($payment_history_data['date']).($stripe_response_dt['id']?'<br><small>Tra. ID: '.$stripe_response_dt['id'].'</small>':'').'</strong>
									</div>
									<div class="col-4">
										<strong class="text-primary">-'.amount_fomat($payment_history_data['paid_amount']).'</strong>
									</div>
								</div>
							</li>';
									$p_amt_arr[] = $payment_history_data['paid_amount'];
								}
							}
							$p_amt_total = array_sum($p_amt_arr);
							if($p_amt_total>0) {
							$item_list_html .= '<li class="h6 pb-1">
								<div class="row">
									<div class="col-8">
										<strong>'.$repair_form_remaining_amount_text.'</strong>
									</div>
									<div class="col-4">
										<strong class="text-primary">'.amount_fomat($f_total_amount-$p_amt_total).'</strong>
									</div>
								</div>
							</li>';
							}
							echo $item_list_html;
							
							if($cust_payment_option == '1' && $stripe_publishable_key && $cust_payment_type == "percentage") {
								$f_total_amount = ($f_total_amount * $cust_payment_per_val / 100);
							} ?>
						</ul>
						
					</div>
				</div>
				
				<div class="card mt-3">
					<div class="card-body">
						<address>
						  <h4 class="mb-3 d-block"><?=$repair_form_address_heading_text?>:</h4>
						  <?php
						  if($company_name) {
							 echo '<strong>'.$company_name.'</strong>';
						  }
						  if($company_address) {
							 echo '<br />'.$company_address;
						  }
						  if($company_city) {
							 echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode;
						  }
						  if($company_country) {
							 echo '<br />'.$company_country;
						  } ?>
						</address>
						
						<?php
						if($site_phone) {
							echo '<abbr title="'.$phone_title.'"><strong>'.$phone_title.':</strong></abbr> '.$site_phone.'<br>';
						}
						if($site_email) {
							echo '<abbr title="'.$email_title.'"><strong>'.$email_title.':</strong></abbr> '.$site_email.'<br>';
						}
						/*if($website) {
							echo '<abbr title="Website"><strong>Website:</strong></abbr> '.$website;
						}*/ ?>
		
						<div class="widget noborder notoppadding">
							<?php //START for socials link
							if($socials_link) { ?>
								<?=$socials_link?>
							<?php
							} //END for socials link ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if($cust_payment_option == '1' && $stripe_publishable_key) { ?>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php
} ?>

<script>
var tpj=jQuery;
<?php
if($appt_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(tpj('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};
	
var onSubmitForm = function(response) {
	if(response.length == 0) {
		tpj("#g_captcha_token").val('');
	} else {
		tpj("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

function getTimeSlotList(id)
{
	var location_id = id.trim();
	if(location_id>0) {

		tpj(".location-adr-show-hide").hide();
		tpj("#location-adr-"+id).show();

		tpj(".time_slot_sec_showhide").show();

		var date = tpj("#date").val();
		post_data = "location_id="+location_id+"&date="+date+"&option=1&token=<?=get_unique_id_on_load()?>";
		tpj(document).ready(function($){
			tpj.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/get_timeslot_list.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.html!="") {
							tpj('#time_slot').html(resp_data.html);
						}
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	} else {
		tpj("#date").val('');
		tpj(".time_slot_sec_showhide").hide();
	}
}

function getTimeSlotListByDate()
{
	var location_id = tpj("#location_id").val();
	if(location_id>0) {
		tpj(".time_slot_sec_showhide").show();
		var date = tpj("#date").val();
		post_data = "location_id="+location_id+"&date="+date+"&option=1&token=<?=get_unique_id_on_load()?>";
		tpj(document).ready(function($){
			tpj.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/get_timeslot_list.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.html!="") {
							tpj('#time_slot').html(resp_data.html);
							check_booking_available();
						}
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}

<?php
if($location_id>0) {
	echo "getTimeSlotList('".$location_id."')";
} else {
	echo 'tpj(".time_slot_sec_showhide").show();';
} ?>

function check_booking_available() {
	var date = tpj("#date").val();
	var time = tpj(".repair_time_slot").val();
	var location_id = tpj("#location_id").val();
	if(time) {
		post_data = "date="+date+"&time="+time+"&location_id="+location_id+"&token=<?=get_unique_id_on_load()?>";
		tpj.ajax({
			type: "POST",
			url:"<?=SITE_URL?>ajax/check_booking_available.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					if(resp_data.booking_allow==false) {
						tpj(".request-repair-button").attr("disabled", "disabled");
						tpj(".time-slot-msg").show();
						tpj(".time-slot-msg").html(resp_data.msg);
					} else {
						tpj(".request-repair-button").removeAttr("disabled");
						tpj(".time-slot-msg").hide();
					}
				} else {
					return false;
				}
			}
		});
	}
}

function check_validations() {
	tpj(".m_validations_showhide").hide();

	var email = document.getElementById("r_email").value.trim();
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	if(document.getElementById("name").value.trim()=="") {
		tpj("#name_error_msg").show().text('<?=$validation_name_msg_text?>');
		return false;
	} else if(email=="") {
		tpj("#email_error_msg").show().text('<?=$validation_email_msg_text?>');
		return false;
	} else if(email!='' && !email.match(mailformat)) {
		tpj("#email_error_msg").show().text('<?=$validation_valid_email_msg_text?>');
		return false;
	} else if(document.getElementById("phone").value.trim()=="") {
		tpj("#phone_error_msg").show().text('<?=$validation_phone_msg_text?>');
		return false;
	} 
	
	<?php
	if($location_option_come_for_you == '1') { ?>
	if(document.getElementById("payment_method_wecomeyou").checked==true) {
		if(document.getElementById("address").value.trim()=="") {
			tpj("#address_error_msg").show().text('<?=$validation_shipping_address_msg_text?>');
			return false;
		} else if(document.getElementById("city").value.trim()=="") {
			tpj("#city_error_msg").show().text('<?=$validation_shipping_city_msg_text?>');
			return false;
		} else if(document.getElementById("state").value.trim()=="") {
			tpj("#state_error_msg").show().text('<?=$validation_shipping_state_msg_text?>');
			return false;
		} else if(document.getElementById("zipcode").value.trim()=="") {
			tpj("#zipcode_error_msg").show().text('<?=$validation_shipping_zipcode_msg_text?>');
			return false;
		}
	} 
	<?php
	}
	if($location_option_ship_device == '1') { ?>
	if(document.getElementById("payment_method_ship_device").checked==true) {
		if(document.getElementById("shipping_address").value.trim()=="") {
			tpj("#shipping_address_error_msg").show().text('<?=$validation_shipping_address_msg_text?>');
			return false;
		} else if(document.getElementById("shipping_city").value.trim()=="") {
			tpj("#shipping_city_error_msg").show().text('<?=$validation_shipping_city_msg_text?>');
			return false;
		} else if(document.getElementById("shipping_state").value.trim()=="") {
			tpj("#shipping_state_error_msg").show().text('<?=$validation_shipping_state_msg_text?>');
			return false;
		} else if(document.getElementById("shipping_zipcode").value.trim()=="") {
			tpj("#shipping_zipcode_error_msg").show().text('<?=$validation_shipping_zipcode_msg_text?>');
			return false;
		}
	} 
	<?php
	} ?>
	
	if(document.getElementById("location_id").value.trim()=="") {
		tpj("#location_id_error_msg").show().text('<?=$validation_sel_location_msg_text?>');
		return false;
	} else if(document.getElementById("date").value.trim()=="") {
		tpj("#date_error_msg").show().text('<?=$validation_sel_date_msg_text?>');
		return false;
	} else if(document.getElementById("time_slot").value.trim()=="") {
		tpj("#time_slot_error_msg").show().text('<?=$validation_sel_time_msg_text?>');
		return false;
	}
}
		
function form_dt_submit() {
	tpj("#booking-form").submit();
}

tpj(document).ready(function($) {
	$('#phone').keyup(function(e) {
		if(/\D/g.test(this.value)) {
			this.value = this.value.replace(/\D/g, '');
		}
	});

	$("#booking-form").on('blur keyup change paste', 'input, select, textarea', function(event) {
		check_validations();
	});
	
	$('#booking-form').on('submit', function(e) {
		var ok = check_validations();
		if(ok == false) {
			return false;
		}
		//$("#booking-form").submit();
		form_dt_submit();
	});

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
			$("#booking-form")[0].submit();
			//form_dt_submit();
		}
	});

	$('#stripe-button').on('click', function(e) {
		var ok = check_validations();
		if(ok == false) {
			return false;
		}
		
		if(stripe_publishable_key!="") {
			var email = $("#r_email").val();
			
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
</script>