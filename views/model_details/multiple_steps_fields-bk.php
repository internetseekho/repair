<div id="device-prop-area" class="<?php if($select_fields_as_box_or_add_remove_button == "box"){echo 'fields-as-boxes';}else{echo 'fields-as-ar-brn';}?> fields-multiple-steps">
	<?php
	$sql_cus_fld = "SELECT * FROM product_fields WHERE product_id = '".$req_model_id."' ORDER BY sort_order";
	$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
	while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
		$input_type = $row_cus_fld['input_type'];

		if(($input_type == "text" && $text_field_of_model_fields == '0') || ($input_type == "textarea" && $text_area_of_model_fields == '0') || ($input_type == "datepicker" && $calendar_of_model_fields == '0') || ($input_type == "file" && $file_upload_of_model_fields == '0')) {
			continue;
		}

		$fld_title = $row_cus_fld['title'];
		$fld_title_slug = createSlug($fld_title);
		$fld_id = $row_cus_fld['id']; ?>
		<div class="model-details-panel" id="fld-<?=$fld_id?>" data-row_type="<?=$input_type?>" data-required="<?=$row_cus_fld['is_required']?>">
			<div class="acctitle pl-2">
				<?php
				if($row_cus_fld['icon']!="") {
				   echo '<img loading="lazy" src="'.SITE_URL.'images/'.$row_cus_fld['icon'].'" width="27px" />';
				}
				echo '<span class="h5 pb-0 mb-0 ml-2">'.$fld_title.'</span>';
				if($row_cus_fld['tooltip']!="" && $tooltips_of_model_fields == '1') { ?>
				   <a data-toggle="tooltip" data-placement="top" title="<?=$row_cus_fld['tooltip']?>" data-original-title="<?=$row_cus_fld['tooltip']?>"><span class="acc-open icon-info-circle"></span></a> 
				<?php
				} ?>
				<span class="validation-msg text-danger"></span>
			</div>

			<div class="acc_content clearfix nopadding my-4">
				<?php
				$add_or_sub = '+';
				$price_type = '1';

				if(($input_type=="select" || $input_type=="radio") && $row_cus_fld['is_dropdown']=='1') {
					$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$fld_id."'";
					$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
					$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
					if($no_of_dd_options>0) {
						$checked = "";
						$tooltip_tabs = array(); ?>
						<div class="row dropdowns" data-input-type="<?=$input_type?>">
							<div class="col-md-6">
								<select class="form-control m-bootstrap-select dropdown-select" name="<?=$fld_title.':'.$fld_id?>" id="<?=$fld_title.':'.$fld_id?>" data-input-type="<?=$input_type?>">
									<option value=""> - Select - </option>
									<?php
									while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
										$checked = '';
										if($row_cus_opt['is_default'] == '1') {
											$checked = 'selected';
											$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
										} ?>

										<option value="<?=$row_cus_opt['label'].'::'.$row_cus_opt['id']?>" id="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" <?=$checked?>><?=$row_cus_opt['label']?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>
					<?php
					}
				}
				elseif(($input_type=="select" || $input_type=="radio") && $row_cus_fld['is_dropdown']!='1') {
					$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$fld_id."'";
					$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
					$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
					if($no_of_dd_options>0) {
						$checked = "";
						$tooltip_tabs = array();

						echo '<div class="btn-group-toggle radio_select_buttons radio_select_repair_buttons" id="field-'.$fld_id.'" data-toggle="buttons">';
						while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
							$checked = '';
							if($row_cus_opt['is_default'] == '1') {
								$checked = 'checked';
								$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
							} ?>

							<label for="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" id="label-<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" class="radios font-body ls0 nott rounded-0 radio_btn d-flex align-items-center <?php if($select_fields_as_box_or_add_remove_button == "box"){echo ' btn btn-outline-dark';} if($row_cus_opt['icon']!=""){echo ' image_have';} if($checked == 'checked'){echo ' active';}?>" data-input-type="<?=$input_type?>">
								<div class="inner">
									<?php
									if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {
										echo '<div class="images"><img loading="lazy" src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="30px" id="'.$row_cus_opt['id'].'" /></div>';
									} ?>

									<input type="radio" name="<?=$fld_title.':'.$fld_id?>" id="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" value="<?=$row_cus_opt['label'].'::'.$row_cus_opt['id']?>" autocomplete="off" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?> <?=$checked?>/>
									<h5 class="mb-0"><?=$row_cus_opt['label']?>
									<?php
									if($row_cus_opt['tooltip'] && $tooltips_of_model_fields == '1') { ?>
										<span class="tooltip-icon" data-toggle="tooltip" title="<?=$row_cus_opt['tooltip']?>" data-original-title="<?=$row_cus_opt['tooltip']?>"><i class="icon-info-circle"></i></span>
									<?php
									} ?>
									</h5>

									<?php
									if($select_fields_as_box_or_add_remove_button == "a_r_btn") { ?>
									<a href="javascript:void(0);" data-id="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" data-fieldid="<?=$fld_id?>" class="radio_add_item" id="addbtn-<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'style="display:none;"';}else{echo 'style="display:block;"';}?>>Add</a>
									<a href="javascript:void(0);" data-id="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" data-fieldid="<?=$fld_id?>" class="radio_remove_item" id="removebtn-<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>Remove</a>
									<?php
									}

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
				elseif($input_type=="checkbox") {
					$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$fld_id."'";
					$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
					$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
					if($no_of_dd_options>0) {
						echo '<div class="checkboxes btn-group-toggle radio_select_repair_buttons" data-input-type="'.$input_type.'" data-toggle="buttons">';
						while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
							$checked = '';
							$chk_lab = $row_cus_opt['label'];
							$chk_lab_slug = createSlug($chk_lab);
							
							if($row_cus_opt['is_default'] == '1') {
								$checked = 'checked';
								$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
							} ?>
							<label style="width: 25.3%;margin:5px;min-height: 250px;" for="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" id="label-<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" class="font-body rounded-0 radio_btn d-flex align-items-center <?php if($select_fields_as_box_or_add_remove_button == "box"){echo ' btn btn-outline-dark';} if($row_cus_opt['icon']!=""){echo ' image_have';} if($checked == 'checked'){echo ' active';}?>">
								<input name="<?=$fld_title.':'.$fld_id?>[]" id="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" <?=$checked?> value="<?=$chk_lab.'::'.$row_cus_opt['id']?>" type="checkbox" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?>>
								<div class="inner">
									<?php
									if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {
										//echo '<div class="images"><img loading="lazy" src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="30px" id="'.$row_cus_opt['id'].'" /></div>';
										echo '<div class=""><img loading="lazy" style="width:160px;" src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="" id="'.$row_cus_opt['id'].'" /></div>';
									} ?>
									<h5 class="mb-0" style="text-align: center;font-size: 12px;"><?=$chk_lab?>
									<?php
									if($row_cus_opt['tooltip'] && $tooltips_of_model_fields == '1') { ?>
										<span class="tooltip-icon" data-toggle="tooltip" title="<?=$row_cus_opt['tooltip']?>" data-original-title="<?=$row_cus_opt['tooltip']?>"><i class="icon-info-circle"></i></span>
									<?php
									} ?>
									</h5>

									<?php
									if($select_fields_as_box_or_add_remove_button == "a_r_btn") { ?>
									<a href="javascript:void(0);" data-id="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" class="add_item" id="addbtn-<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'style="display:none;"';}else{echo 'style="display:block;"';}?>>Add</a>
									<a href="javascript:void(0);" data-id="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" class="remove_item" id="removebtn-<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>Remove</a>
									<?php
									}

									if($row_cus_opt['price']>0 && $show_repair_item_price == '1') { ?>
										<div class="item_price text-primary h5 mb-0" style="text-align: center;"><strong><?=$amount_sign_with_prefix.$row_cus_opt['price'].$amount_sign_with_postfix?></strong></div>
									<?php
									} ?>
								</div>
							</label>
						<?php
						}
						echo '</div>';
					}
				}
				elseif($input_type=="text") { ?>
					<input type="text" name="<?=$fld_title.':'.$fld_id?>" class="sm-form-control input" data-input-type="<?=$input_type?>"/>
				<?php
				}
				elseif($input_type=="textarea") { ?>
					<textarea name="<?=$fld_title.':'.$fld_id?>" class="sm-form-control input" data-input-type="<?=$input_type?>" rows="3"></textarea>
				<?php
				}
				elseif($input_type=="datepicker") { ?>
					<input type="text" class="sm-form-control input py-2 datepicker" name="<?=$fld_title.':'.$fld_id?>" data-input-type="<?=$input_type?>" autocomplete="nope"/>
				<?php
				}
				elseif($input_type=="file") { ?>
					<input name="<?=$fld_title.':'.$fld_id?>" id="<?=$fld_title_slug?>" type="file" class="sm-form-control input" data-input-type="<?=$input_type?>"/>
				<?php
				} ?>
			</div>
		</div>
	<?php
	} ?>
</div>

<input type="hidden" name="base_price" value="<?=$price?>" />
<div class="row clearfix">
	<div class="col-md-6">
		<?php
		if($promocode_section=='1') { ?>
			<div class="form-inline">
				<div class="form-group mb-2">
					<input type="text" class="sm-form-control" name="promo_code" id="promo_code" placeholder="<?=$coupon_code_placeholder_text?>">
				</div>
				<button type="button" class="btn btn-primary mb-2 ml-2" name="apl_promo_code" id="apl_promo_code" onclick="getPromoCode();"><?=$coupon_code_btn_text?></button>
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
					<tr class="cart_item" id="showhide_subtotal_row" <?=($promocode_section=='1' || $total_price<=0?'style="display:none;"':'style="display:block;"')?>>
						<td class="notopborder cart-product-name">
							<strong><?=($promocode_section=='1'?$model_details_sub_total_text:$model_details_estimate_total_text)?>:</strong>
						</td>
						<td class="notopborder cart-product-name">
							<span class="show_final_amt"><?=amount_fomat($total_price)?></span>
						</td>
					</tr>
					<?php
					if($promocode_section=='1') { ?>
					<tr class="cart_item" id="showhide_promocode_row" style="display:none;">
						<td class="cart-product-name">
							<strong><?=$coupon_code_discount_text?><span id="promocode_per_label"></span></strong>
						</td>
						<td class="cart-product-name">
							<span id="promocode_amt"></span>&nbsp;<a href="javascript:void(0);" id="promocode_removed"><i class="icon-remove text-danger"></i></a>
						</td>
					</tr>
					<tr class="cart_item showhide_total_section" id="showhide_total_row" <?=($total_price<=0?'style="display:none;"':'')?>>
						<td class="cart-product-name">
							<strong><?=$model_details_estimate_total_text?></strong>
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
<div class="row">
	<div class="col-md-12">
		<div class="step-navigation clearfix">
			<a href="javascript:void(0)" id="prevBtn" class="btn float-left btn-secondary"><?=$back_btn_text?></a>
			<a href="javascript:void(0)" id="nextBtn" class="btn float-right btn-primary"><?=$next_btn_text?></a>
			<button type="submit" class="float-right button button-3d nomargin sell-this-device" name="sell_this_device" id="get-price-btn"><?=$next_btn_text?></button>
		</div>
	</div>
</div>

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

				<?php
				if($promocode_section!='1') {
					echo 'tpj("#showhide_subtotal_row").show();';
				} ?>

				tpj(".show_final_amt").html(f_price);
				tpj(".show_final_amt_val").html(total_price);

				if(resp_data.order_items_name) {
					tpj("#items_name").show();
					tpj("#items_name").html(resp_data.order_items_name);
				} else {
					tpj("#items_name").hide();
				}

				tpj('#get-price-btn').removeAttr("disabled");
				
				var promo_code = tpj("#promo_code").val();
				if(promo_code) {
					getPromoCode();
				}
			}
		}
	});
}

function field_spining_icon() {
	tpj("#get-price-btn").attr("disabled", true);
	if(online_booking_hide_price == '0') {
		tpj(".show_final_amt").html('<div class="css3-spinner" style="position:absolute;z-index:auto;"><div class="css3-spinner-clip-rotate"><div></div></div></div>');
	}
}

function field_next_step() {
	var current_step = tpj(".model-details-panel:visible");
	var next_step = tpj(".model-details-panel:visible").next(".model-details-panel");
	var next_id = tpj(next_step).attr("id");

	var last_step = tpj(".model-details-panel").last(".model-details-panel");
	var last_id = tpj(last_step).attr("id");
	
	var current_step = tpj(".model-details-panel:visible");
	var current_id = tpj(current_step).attr("id");

	var row_type = tpj(next_step).attr("data-row_type");
	if(row_type == "radio") {
		tpj('#nextBtn').hide();
	} else {
		tpj('#nextBtn').show();
	}

	if(next_id == last_id || current_id == last_id) {
		tpj('#get-price-btn').show();
		tpj('#nextBtn').hide();
	}

	if(next_step.length != 0) {
		tpj(".model-details-panel").hide();
		next_step.show();
	}

	tpj("#prevBtn").show();
}

function field_prev_step() {
	var prev_step = tpj(".model-details-panel:visible").prev(".model-details-panel");
	var prev_id = tpj(prev_step).attr("id");
	
	var first_step = tpj(".model-details-panel").first(".model-details-panel");
	var first_id = tpj(first_step).attr("id");
	
	var row_type = tpj(prev_step).attr("data-row_type");

	if(prev_id == first_id) {
		tpj('#prevBtn').hide();
	}

	if(prev_step.length != 0) {
		tpj(".model-details-panel").hide();
		prev_step.show();
	}

	tpj('#get-price-btn').hide();
	tpj('#nextBtn').show();
}

tpj(document).ready(function($) {
	
	var num_of_step = tpj(".model-details-panel").length;
	var current_step = tpj(".model-details-panel").first(".model-details-panel");
	var current_id = tpj(current_step).attr("id");
	var row_type = $(current_step).attr("data-row_type");
	if(row_type == "radio") {
		$('#nextBtn').hide();
	}

	$("#prevBtn").hide();
	if(num_of_step>1) {
		$('#get-price-btn').hide();
	} else if(num_of_step==1) {
		$("#nextBtn").hide();
		$('#get-price-btn').show();
	}
	$(".model-details-panel:first").show();

	$("#nextBtn").click(function() {
		var is_true = "yes";
		$('.model-details-panel:visible .radios, .model-details-panel:visible .checkboxes').each(function(i, element) {
			var html = $(this).html();
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="radio" || data_input_type == "select") {
				var crt_row_type = $(this).parent().parent().parent().attr("data-row_type");
				var is_required = $(this).parent().parent().parent().attr("data-required");
				if(is_required=="1"){
					if(crt_row_type=="radio" || crt_row_type=="select"){
						var cc = $(this).parent().find("input:checked").length;
						if(cc==0){
							$(this).parent().parent().prev().find(".validation-msg").html('Please choose an option');
							is_true = "no";
						}
					}
				} 
			} else if(data_input_type=="checkbox"){
				var crt_row_type = $(this).parent().parent().attr("data-row_type");
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var cc = $(this).parent().find("input:checked").length;
					if(cc==0){
						$(this).parent().prev().find(".validation-msg").html('Please choose an option');
						is_true = "no";
					}
				}
			}
		});
		
		$('.model-details-panel:visible .dropdowns').each(function(i, element) {
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="radio") {
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var html = $(this).children().children().val();
					if(html=="") {
						$(this).parent().prev().find(".validation-msg").html('Please select value');
						is_true = "no";
					}
				}
			}
		});

		$(".model-details-panel:visible .input").each(function(i, element) {												 
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="text" || data_input_type=="textarea" || data_input_type=="datepicker") {
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var html = $(this).val();
					if(html=="") {
						$(this).parent().prev().find(".validation-msg").html('Please enter value');
						is_true = "no";
					}
				}
			} else if(data_input_type=="file") {
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var html  = $(this).val();
					if(html=="") {
						$(this).parent().prev().find(".validation-msg").html('Please choose file');
						is_true = "no";
					}
				}
			}
		});

		if(is_true == "no") {
			return false;	
		}

		//field_spining_icon();
		field_next_step();
	});

	$("#prevBtn").click(function() {
		//field_spining_icon();
		field_prev_step();
	});
	
	$('.add_item').on('click', function() {
		var id = $(this).attr("data-id");
		$("#"+id).prop("checked", true);
		$("#addbtn-"+id).hide();
		$("#removebtn-"+id).show();
		$("#label-"+id).addClass("active");
		
		field_spining_icon();
		setTimeout(function(){
			get_price();
		}, 500);
	});
	
	$('.remove_item').on('click', function() {
		var id = $(this).attr("data-id");
		$("#"+id).prop("checked", false);
		$("#addbtn-"+id).show();
		$("#removebtn-"+id).hide();
		$("#label-"+id).removeClass("active");
		
		field_spining_icon();
		setTimeout(function(){
			get_price();
		}, 500);
	});
	
	$('.radio_add_item').on('click', function() {
		var id = $(this).attr("data-id");
		$("#"+id).prop("checked", true);

		var fieldid = $(this).attr("data-fieldid");
		$("#field-"+fieldid+" .radio_add_item").show();
		$("#field-"+fieldid+" .radio_remove_item").hide();
		$("#field-"+fieldid+" .radio_box").removeClass("active");

		$("#addbtn-"+id).hide();
		$("#removebtn-"+id).show();
		$("#label-"+id).addClass("active");
		
		field_spining_icon();
		field_next_step();
		
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$('.radio_remove_item').on('click', function() {
		var id = $(this).attr("data-id");
		$("#"+id).prop("checked", false);

		$("#addbtn-"+id).show();
		$("#removebtn-"+id).hide();
		$("#label-"+id).removeClass("active");
		
		field_spining_icon();
		field_next_step();
		
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$('.dropdown-select').on('change', function() {
		field_spining_icon();
		field_next_step();

		setTimeout(function(){
			get_price();
		}, 500);
	});
	
	<?php
	if($select_fields_as_box_or_add_remove_button == "box") { ?>								
	$('#device-prop-area .radio_select_buttons').bind('click keyup', function(event) {
		field_spining_icon();
		field_next_step();
		
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$('#device-prop-area .checkboxes').bind('click keyup', function(event) {
		field_spining_icon();

		setTimeout(function(){
			get_price();
		}, 500);
	});
	<?php
	} ?>

	get_price();
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
		tpj(".promocode_msg").html('<?=$validation_coupon_code_msg_text?>');
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
					//console.log(resp_data);
					if(resp_data.msg!="" && resp_data.mode == "expired") {
						
						var sub_total = $(".show_final_amt_val").html();
						var _sub_total=formatMoney(sub_total);
						var f_sub_total=format_amount(_sub_total);
		
						$("#promo_code").val('');
						$("#showhide_promocode_row").hide();
						$("#showhide_subtotal_row").hide();
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
								$("#showhide_subtotal_row").hide();
							} else {
								$("#showhide_promocode_row").show();
								$("#showhide_subtotal_row").show();
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
					$('.promocode_msg').html('<?=$validation_something_went_wrong_msg_text?>');
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
		$("#showhide_subtotal_row").hide();
		$("#promocode_id").val('');
		$("#promocode_value").val('');
		$("#total_amt").html(f_sub_total);
		$(".showhide_promocode_msg").hide();
	});
});
</script>