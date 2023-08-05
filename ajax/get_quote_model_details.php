<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

//Url params
$req_model_id=$post['model_id'];
$location_id=$post['location_id'];
if($req_model_id>0) {

	//Fetching data from model
	require_once('../models/model.php');
	
	//Get data from models/model.php, get_single_model_data function
	$model_data = get_single_model_data($req_model_id);
	
	$models_text = $model_data['models'];
	$models_text = ($models_text?" - ".$models_text:"");
	
	$csrf_token = generateFormToken('model_details'); ?>

	<script>
	var online_booking_hide_price = '<?=$online_booking_hide_price?>';
	</script>
	<script src="<?=SITE_URL?>js/front-ajax.js"></script>

	<form id="model_details_form" action="<?=SITE_URL?>controllers/model.php" method="post" enctype="multipart/form-data" onSubmit="return check_form_data();">
	<section id="content">	
		<div class="container clearfix">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<div class="fancy-title title-bottom-border">
							<h2><?=$model_data['title'].$models_text?></h2>
						</div>
								
						<?php
						$path_info = parse_path();
						$call_parts_params = $path_info['call_parts'];
	
						$feilds_val = array();
						$rr=0;
						$tr=1;
						foreach($call_parts_params as $k=>$v) {
							if($k>0) {
								if($rr==0 || $rr==1) {
									$rr++;
									continue;
								}
								$feilds_val[$tr] = $v;
								$rr++;
								$tr++;
							}
						}
						
						function updatePrice($thisprice, $add_sub, $price_type, $total_price, $price) {
							if($price_type==0) {
								$temp_price = ($price*$thisprice)/100;
							} else {
								$temp_price = $thisprice;
							}
						
							if($add_sub=="+") {
								$total_price = $total_price + $temp_price;
							} else {
								$total_price = $total_price - $temp_price;
							}
							return $total_price;
						}
						
						$sql_pro = "SELECT * FROM mobile WHERE id = '".$req_model_id."'";
						$exe_pro = mysqli_query($db,$sql_pro);
						$row_pro = mysqli_fetch_assoc($exe_pro);
						$price = $row_pro['price'];
						$total_price = $row_pro['price']; ?>
					
						<input type="hidden" name="base_price" value="<?=$price?>" />
						<div id="device-prop-area">  
							<div class="accordion accordion-bg clearfix">
							<?php
							$sql_cus_fld = "SELECT * FROM product_fields WHERE product_id = '".$req_model_id."' ORDER BY sort_order";
							$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
							$fid=1;

							while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
								if(($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {
									continue;
								} ?>
								<div class="model-details-panel" data-row_type="<?=$row_cus_fld['input_type']?>" data-required="<?=$row_cus_fld['is_required']?>">
									<div class="acctitle">
										<!--<i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>-->
										<?php
										if($row_cus_fld['icon']!="") {
										   echo '<img src="'.SITE_URL.'images/'.$row_cus_fld['icon'].'" width="30px" />';
										}
										echo '<span class="h5 pb-1 ml-2">'.$row_cus_fld['title'].'</span>';
										if($row_cus_fld['tooltip']!="" && $tooltips_of_model_fields == '1') { ?>
										<small><a data-toggle="tooltip" data-placement="top" title="<?=$row_cus_fld['tooltip']?>" data-original-title="<?=$row_cus_fld['tooltip']?>"><span class="acc-open icon-info-circle"></span></a></small>
										<?php
										}
										if(isset($feilds_val[$fid])) {
										   echo '<span class="selected-option-value">'.strip_tags($feilds_val[$fid]).'</span>';
										} else {
										   echo '<span class="selected-option-value"></span>';
										} ?>
										<span class="validation-msg text-danger"></span>
									</div>
	
									<div class="acc_content clearfix nopadding m-4">
										<?php
										//Added By IPE TEAM
										$add_or_sub = '+';
										$price_type = '1';
									
										if(($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio") && $row_cus_fld['is_dropdown']=='1') {
											$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."'";
											$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
											$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
											$temp_fld_no = count($feilds_val) + 1;
						
											if($no_of_dd_options>0) {
												$checked = "";
												$tooltip_tabs = array(); ?>
												<div class="row dropdowns" data-input-type="<?=$row_cus_fld['input_type']?>">
													<div class="col-md-6">
														<select class="form-control m-bootstrap-select dropdown-select" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" id="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" data-input-type="<?=$row_cus_fld['input_type']?>">
															<option value=""> - Select - </option>
															<?php
															while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
																$checked = '';
						
																//Added By IPE TEAM
																if($row_cus_opt['is_default'] == '1') {
																	$checked = 'selected';
																	$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
																} ?>
																	
																<option value="<?=$row_cus_opt['label'].'::'.$row_cus_opt['id']?>" id="<?=createSlug($row_cus_fld['title']).'::'.$row_cus_opt['id']?>" <?=$checked?>><?=$row_cus_opt['label']?></option>
															<?php
															} ?>
														</select>
													</div>
												</div>
											<?php
											}
										}
										elseif(($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio") && $row_cus_fld['is_dropdown']!='1') {
											$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."'";
											$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
											$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
											$temp_fld_no = count($feilds_val) + 1;
									
											if($no_of_dd_options>0) {
												$checked = "";
												
												$tooltip_tabs = array();
												
												echo '<div class="btn-group btn-group-toggle flex-wrap radio_select_buttons" data-toggle="buttons">';
												while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
													$checked = '';
	
													//Added By IPE TEAM
													if($row_cus_opt['is_default'] == '1') {
														$checked = 'checked';
														$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
													} ?>
														<label for="<?=createSlug($row_cus_fld['title']).'::'.$row_cus_opt['id']?>" class="radios btn btn-outline-dark font-body ls0 nott rounded-0 radio_btn d-flex align-items-center <?php if($row_cus_opt['icon']!=""){echo ' image_have';} if($checked == 'checked'){echo ' active';}?>" data-input-type="<?=$row_cus_fld['input_type']?>">
															<div class="inner">
																<?php
																if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {
																   echo '<div class="images"><img src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="30px" id="'.$row_cus_opt['id'].'" /></div>';
																} ?>
	
																<input type="radio" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" id="<?=createSlug($row_cus_fld['title']).'::'.$row_cus_opt['id']?>" value="<?=$row_cus_opt['label'].'::'.$row_cus_opt['id']?>" autocomplete="off" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?> <?=$checked?>/>
																<h5 class="mb-0"><?=$row_cus_opt['label']?>
																<?php
																if($row_cus_opt['tooltip'] && $tooltips_of_model_fields == '1') { ?>
																	<span class="tooltip-text" data-toggle="tooltip" title="<?=$row_cus_opt['tooltip']?>" data-original-title="<?=$row_cus_opt['tooltip']?>"><i class="icon-info-circle"></i></span>
																<?php
																} ?>
																</h5>
																<?php
																if($row_cus_opt['price']>0 && $show_repair_item_price == '1') { ?>
																	<div class="item_price text-primary h5 mb-0"><strong><?=$amount_sign_with_prefix.$row_cus_opt['price'].$amount_sign_with_postfix?></strong></div>
																<?php
																} ?>
															</div>
														</label>
												<?php
												}
												echo '</div>';
											}
										}
										elseif($row_cus_fld['input_type']=="checkbox") {
											$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."'";
											$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
											$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
											$temp_fld_no = count($feilds_val) + 1;
										
											if($no_of_dd_options>0) {
												echo '<div class="checkboxes btn-group-toggle radio_select_buttons radio_select_repair_buttons" data-input-type="'.$row_cus_fld['input_type'].'" data-toggle="buttons">';
												$chks = explode(",",$feilds_val[$fid]);
												while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
													$checked = '';
													$chk_lab = $row_cus_opt['label'];
													
													if($row_cus_opt['is_default'] == '1') {
														$checked = 'checked';
														$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
													} ?>
													
													<label for="<?=$chk_lab.'::'.$row_cus_opt['id']?>" class="btn btn-outline-dark font-body rounded-0 radio_btn d-flex align-items-center <?php if($row_cus_opt['icon']!=""){echo ' image_have';} if($checked == 'checked'){echo ' active';}?>">
														<div class="inner">	
															<input name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>[]" id="<?=$chk_lab.'::'.$row_cus_opt['id']?>" <?=$checked?> value="<?=$chk_lab.'::'.$row_cus_opt['id']?>" type="checkbox" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?>>
															<?php
															if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {
																echo '<div class="images"><img src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="30px" id="'.$row_cus_opt['id'].'" /></div>';
															} ?>
															<h5 class="mb-0"><?=$chk_lab?>
															<?php
															if($row_cus_opt['tooltip'] && $tooltips_of_model_fields == '1') { ?>
																<span class="tooltip-icon" data-toggle="tooltip" title="<?=$row_cus_opt['tooltip']?>" data-original-title="<?=$row_cus_opt['tooltip']?>"><i class="icon-info-circle"></i></span>
															<?php
															} ?>
															</h5>
															<?php 
															if($row_cus_opt['price']>0 && $show_repair_item_price == '1') { ?>
																<div class="item_price text-primary h5 mb-0"><strong><?=$amount_sign_with_prefix.$row_cus_opt['price'].$amount_sign_with_postfix?></strong></div>
															<?php
															} ?>
														</div>
													</label>
												<?php
												}
												echo '</div>';
											}
										}
										elseif($row_cus_fld['input_type']=="text") { ?>
											<input type="text" name="<?=$row_cus_fld['title']?>" class="sm-form-control input" data-input-type="<?=$row_cus_fld['input_type']?>"/>
										<?php
										}
										elseif($row_cus_fld['input_type']=="textarea") { ?>
											<textarea name="<?=$row_cus_fld['title']?>" class="sm-form-control input" data-input-type="<?=$row_cus_fld['input_type']?>" rows="3"></textarea>
										<?php
										}
										elseif($row_cus_fld['input_type']=="datepicker") { ?>
											<input type="text" class="sm-form-control input py-2 datepicker" name="<?=$row_cus_fld['title']?>" data-input-type="<?=$row_cus_fld['input_type']?>" autocomplete="nope"/>
										<?php
										}
										elseif($row_cus_fld['input_type']=="file") { ?>
											<input name="<?=$row_cus_fld['title']?>" id="<?=createSlug($row_cus_fld['title'])?>" type="file" class="sm-form-control input" data-input-type="<?=$row_cus_fld['input_type']?>"/>
										<?php
										} ?>
									</div>
								</div>
							<?php
							$fid++;
							} ?>
							</div>
						</div>
	
						<div class="row clearfix">
							<div class="col-md-6">
								<?php
								if($promocode_section=='1') { ?>
									<div class="form-inline">
										<div class="form-group mb-2">
											<input type="text" class="sm-form-control" name="promo_code" id="promo_code" placeholder="Coupon Code">
										</div>
										<button type="button" class="btn btn-info mb-2 ml-2" name="apl_promo_code" id="apl_promo_code" onclick="getPromoCode();">APPLY</button>
									</div>
									<div class="showhide_promocode_msg" style="display:none;">
										<div class="promocode_msg text-left"></div>
									</div>
									<input type="hidden" name="promocode_id" id="promocode_id" value=""/>
									<input type="hidden" name="promocode_value" id="promocode_value" value=""/>
								<?php
								} ?>  
							</div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table cart">
										<tbody>
											<tr class="cart_item showhide_total_section" <?=($total_price<=0?'style="display:none;"':'')?>>
												<td class="notopborder cart-product-name">
													<strong><?=($promocode_section=='1'?"Sub":"Estimate")?> Total:</strong>
												</td>
												<td class="notopborder cart-product-name">
													<span class="show_final_amt"><?=amount_fomat($total_price)?></span>
												</td>
											</tr>
											<?php
											if($promocode_section=='1') { ?>
											<tr class="cart_item" id="showhide_promocode_row" style="display:none;">
												<td class="cart-product-name">
													<strong>Discount<span id="promocode_per_label"></span></strong>
												</td>
												<td class="cart-product-name">
													<span id="promocode_amt"></span>&nbsp;<a href="javascript:void(0);" id="promocode_removed"><i class="icon-remove"></i></a>
												</td>
											</tr>
											<tr class="cart_item showhide_total_section" id="showhide_total_row" <?=($total_price<=0?'style="display:none;"':'')?>>
												<td class="cart-product-name">
													<strong>Estimate Total</strong>
												</td>
												<td class="cart-product-name">
													<span id="total_amt" class="show_final_amt color lead"><strong><?=amount_fomat($total_price)?></strong></span>
												</td>
											</tr>
											<?php
											} ?>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row clearfix fright">
							<div class="col-md-12">
								<div class="form-group mx-sm-3 mb-2">
									<button type="submit" class="button button-3d nomargin sell-this-device" name="sell_this_device" id="get-price-btn">Next</button>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>
	<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
	<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total_price?>"/>
	<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
	<input id="total_price_org" value="<?=$price?>" type="hidden" />
	<input name="id" type="hidden" value="<?=$req_model_id?>" />
	<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
	</form>

	<script>
	var tpj=jQuery;
	
	function get_price() {
		tpj.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/get_model_price.php',
			data: tpj('#model_details_form').serialize(),
			success: function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
	
					//tpj("#order_items").val(resp_data.order_items);
					var total_price = resp_data.payment_amt;
	
					var _t_price=formatMoney(total_price);
					var f_price=format_amount(_t_price);
					
					if(total_price > 0 && online_booking_hide_price == '0') {
						tpj(".showhide_total_section").show();
					} else {
						tpj(".showhide_total_section").hide();	
					}
					
					tpj(".show_final_amt").html(f_price);
					tpj(".show_final_amt_val").html(total_price);
					
					tpj('#get-price-btn').removeAttr("disabled");
					
					var promo_code = tpj("#promo_code").val();
					if(promo_code) {
						getPromoCode();
					}
				}
			}
		});
	}

	tpj(document).ready(function($) {
		$('#device-prop-area .radio_select_buttons, #device-prop-area .checkboxes, #device-prop-area .dropdown-select').bind('click keyup', function(event) {
			
			$("#get-price-btn").attr("disabled", true);
			if(online_booking_hide_price == '0') {
				$(".show_final_amt").html('<div class="css3-spinner" style="position:absolute;z-index:auto;"><div class="css3-spinner-clip-rotate"><div></div></div></div>');
			}

			setTimeout(function(){
				get_price();
			}, 500);
		});
	});
	
	function getPromoCode()
	{
		<?php
		if($promocode_section=='1') { ?>
		var sub_total = tpj(".show_final_amt_val").html();
		var promo_code = document.getElementById('promo_code').value.trim();
		if(promo_code=="") {
			tpj(".showhide_promocode_msg").show();
			tpj("#promo_code").focus();
			tpj(".promocode_msg").html('Please enter a coupon code.');
			return false;
		}
	
		post_data = "promo_code="+promo_code+"&amt="+sub_total+"&user_id=<?=$user_id?>&token=<?=md5(uniqid());?>";
		tpj(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/promocode_verify.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						console.log(resp_data);
						if(resp_data.msg!="" && resp_data.mode == "expired") {
							
							var sub_total = $(".show_final_amt_val").html();
							var _sub_total=formatMoney(sub_total);
							var f_sub_total=format_amount(_sub_total);
			
							$("#promo_code").val('');
							$("#showhide_promocode_row").hide();
							$("#promocode_id").val('');
							$("#promocode_value").val('');
							$("#total_amt").html(f_sub_total);
	
							$(".showhide_promocode_msg").show();
							$(".promocode_msg").html(resp_data.msg);
							$(".promocode_msg").removeClass('text-success');
							$(".promocode_msg").addClass('text-danger');
						} else {
							//$(".showhide_promocode_msg").hide();
							//$(".promocode_msg").html('');
							if(resp_data.plain_total>0) {
								if(online_booking_hide_price == '1') {
									$("#showhide_promocode_row").hide();
								} else {
									$("#showhide_promocode_row").show();
								}
	
								if(resp_data.coupon_type=='percentage') {
									//$("#promocode_amt").html("("+resp_data.percentage_amt+"%): "+resp_data.discount_of_amt);
									$("#promocode_per_label").html(" ("+resp_data.percentage_amt+"%)");
									$("#promocode_amt").html(resp_data.discount_of_amt);
								} else {
									$("#promocode_per_label").html("");
									$("#promocode_amt").html(resp_data.discount_of_amt);
								}
							}
							$("#promocode_id").val(resp_data.promocode_id);
							$("#promocode_value").val(resp_data.promocode_value);
							$("#total_amt").html(resp_data.total);
							$(".showhide_promocode_msg").show();
							$(".promocode_msg").html(resp_data.msg);
							$(".promocode_msg").addClass('text-success');
							$(".promocode_msg").removeClass('text-danger');
							if(online_booking_hide_price == '1') {
								$(".showhide_total_section").hide();
							}
						}
					} else {
						$('.promocode_msg').html('Something wrong so please try again...');
					}
				}
			});
		});
		<?php
		} ?>
	}
	
	tpj(document).ready(function($){
		$("#promo_code").on("keyup",function() {
			var promo_code = document.getElementById('promo_code').value.trim();
			if(promo_code!="") {
				$(".showhide_promocode_msg").hide();
				$(".promocode_msg").html('');
				return false;
			}
		});
	
		$("#promocode_removed").click(function() {
			var sub_total = $(".show_final_amt_val").html();
			var _sub_total=formatMoney(sub_total);
			var f_sub_total=format_amount(_sub_total);
	
			$("#promo_code").val('');
			$("#showhide_promocode_row").hide();
			$("#promocode_id").val('');
			$("#promocode_value").val('');
			$("#total_amt").html(f_sub_total);
			$(".showhide_promocode_msg").hide();
		});
	});
	</script>
<?php
} ?>