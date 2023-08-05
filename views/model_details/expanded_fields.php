<div id="device-prop-area" class="<?php if($select_fields_as_box_or_add_remove_button == "box"){echo 'fields-as-boxes';}else{echo 'fields-as-ar-brn';}?>">
	<div class="accordion accordion-bg clearfix">
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
		<div class="model-details-panel" data-row_type="<?=$input_type?>" data-required="<?=$row_cus_fld['is_required']?>">
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
						echo '<div class="checkboxes btn-group-toggle radio_select_buttons radio_select_repair_buttons" data-input-type="'.$input_type.'" data-toggle="buttons">';
						while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
							$checked = '';
							$chk_lab = $row_cus_opt['label'];
							$chk_lab_slug = createSlug($chk_lab);
							
							if($row_cus_opt['is_default'] == '1') {
								$checked = 'checked';
								$total_price = updatePrice($row_cus_opt['price'],$add_or_sub,$price_type,$total_price,$price);
							} ?>
							<label for="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" id="label-<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" class="font-body rounded-0 radio_btn d-flex align-items-center <?php if($select_fields_as_box_or_add_remove_button == "box"){echo ' btn btn-outline-dark';} if($row_cus_opt['icon']!=""){echo ' image_have';} if($checked == 'checked'){echo ' active';}?>">
								<input name="<?=$fld_title.':'.$fld_id?>[]" id="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" <?=$checked?> value="<?=$chk_lab.'::'.$row_cus_opt['id']?>" type="checkbox" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?>>
								<div class="inner">
									<?php
									if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {
										echo '<div class="images"><img loading="lazy" src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="30px" id="'.$row_cus_opt['id'].'" /></div>';
									} ?>
									<h5 class="mb-0"><?=$chk_lab?>
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
<div class="row clearfix fright">
	<div class="col-md-12">
		<div class="form-group mx-sm-3 mb-2">
			<button type="submit" class="button button-3d nomargin sell-this-device" name="sell_this_device" id="get-price-btn"><?=$next_btn_text?></button>
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

tpj(document).ready(function($) {
	
	$('.add_item').on('click', function() {
		var id = $(this).attr("data-id");
		$("#"+id).prop("checked", true);
		$("#addbtn-"+id).hide();
		$("#removebtn-"+id).show();
		$("#label-"+id).addClass("active");

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

		setTimeout(function(){
			get_price();
		}, 500);
	});
	
	$('.radio_remove_item').on('click', function() {
		//return false;
		var id = $(this).attr("data-id");
		$("#"+id).prop("checked", false);

		//var fieldid = $(this).attr("data-fieldid");
		//$("#field-"+fieldid+" .radio_add_item").hide();
		//$("#field-"+fieldid+" .radio_remove_item").show();
		
		$("#addbtn-"+id).show();
		$("#removebtn-"+id).hide();
		$("#label-"+id).removeClass("active");
		
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$('#device-prop-area .radio_select_buttons, #device-prop-area .checkboxes, #device-prop-area .dropdown-select').bind('click keyup change', function(event) {
	
		$("#get-price-btn").attr("disabled", true);
		if(online_booking_hide_price == '0') {
			$(".show_final_amt").html('<div class="css3-spinner" style="position:absolute;z-index:auto;"><div class="css3-spinner-clip-rotate"><div></div></div></div>');
		}

		setTimeout(function(){
			get_price();
		}, 500);
	});
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