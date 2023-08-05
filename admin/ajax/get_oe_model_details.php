<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

//Url params
$req_model_id=$post['model_id'];
if($req_model_id>0) {

$appt_id = $post['appt_id'];
$order_item_data = array();
if($appt_id>0) {
	$a_query=mysqli_query($db,"SELECT a.*, aps.name AS appt_status_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status WHERE a.id='".$appt_id."'");
	$order_item_data = mysqli_fetch_assoc($a_query);
}
if($order_item_data['product_id']!=$req_model_id) {
	$order_item_data = array();
}

$item_name_array = json_decode($order_item_data['item_name'],true);
if(!empty($item_name_array)) {
	foreach($item_name_array as $ei_k => $item_name_data) {
		$fld_id_array[] = $ei_k;
		$items_opt_name = "";
		foreach($item_name_data['opt_data'] as $opt_data) {
			if($opt_data['opt_id']>0) {
				$items_opt_name .= $opt_data['opt_name'].', ';
				$opt_id_array[] = $opt_data['opt_id'];
			} else {
				$items_opt_name .= $opt_data['opt_name'].', ';
			}
		}
		$opt_name_array[$ei_k] .= rtrim($items_opt_name,', ');		
	}
}

if($order_item_data['item_files']!="") {
	$order_files_list = explode(",",$order_item_data['item_files']);
	foreach($order_files_list as $file_k=>$file_v) {
		if($file_v!="") {
			$file_image_nm = pathinfo($file_v, PATHINFO_FILENAME);
			$file_image_nm_arr = array_reverse(explode('_',$file_image_nm));

			$f_field_id = $file_image_nm_arr['0'];
			$fld_id_array[] = $f_field_id;
			$opt_name_array[$f_field_id] = $file_v;
		}
	}
}


//Fetching data from model
require_once('../../models/model.php');

require_once("../../include/custom_js.php");

//Get data from models/model.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id); ?>

<link href="assets/edit-order.css?u=<?=unique_id()?>" rel="stylesheet" type="text/css" />
<script src="assets/js/front.js?u=<?=unique_id()?>"></script>

<div class="row phone-details">
	<div class="col-md-12">
		<h3><strong><?=$model_data['title']?></strong></h3>
		<h4><strong><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span></strong></h4>

		<?php
		function updatePrice($thisprice,$add_sub,$price_type,$total_price,$price) {
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
	
		$sql_pro = "select * from mobile where id = '".$req_model_id."'";
		$exe_pro = mysqli_query($db,$sql_pro);
		$row_pro = mysqli_fetch_assoc($exe_pro);
		$price = $row_pro['price'];
		$total_price = $row_pro['price']; ?>
	
		<input type="hidden" name="base_price" value="<?=$price?>" />
		<div class="modern-text" id="device-prop-area">
			<div class="sell-help">
			   &nbsp;
			</div>
	
			<?php
			$sql_cus_fld = "select * from product_fields where product_id = '".$req_model_id."' order by sort_order";
			$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
			$no_of_dd_fld = mysqli_num_rows($exe_cus_fld);
			$no_of_fields = mysqli_num_rows($exe_cus_fld);
			$fid=1;
	
			while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
				
				if(($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {
					continue;
				}

				$nn = $nn+1;
				$last_next_button = "";
				if($no_of_fields == $nn) {
					$last_next_button = "yes";
				}

				if(in_array($row_cus_fld['id'],$fld_id_array)) {
					$class = "selected";
				} elseif($fid==1) {
					$class = "opened";
				} else {
					$class = "disabled";
				} ?>

				<div class="modern-text__row capacity-base-row modern-block__row <?=$class?> clearfix" data-row_type="<?=$row_cus_fld['input_type']?>" data-required="<?=$row_cus_fld['is_required']?>">
					<span class="modern-text__area">
						<span class="modern-text__num">
							<b class="modern-num"><?=$fid?></b>
							<b data-toggle="tooltip" title="Edit" class="modern-selected needhelp"></b>
						</span>
						<span class="modern-text__title">
							<?php
							if($row_cus_fld['icon']!="") {
								echo '<img src="/images/'.$row_cus_fld['icon'].'" width="50px" />';
							}
							echo $row_cus_fld['title']; ?>
						</span>
					</span>
					<div id="capacities" class="modern-block__content block-content-base">
						<?php
						if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio")
						{
							$sql_cus_opt = "select * from product_options where product_field_id = '".$row_cus_fld['id']."'";
							$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
							$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
							$temp_fld_no = 1;
	
							if($no_of_dd_options>0) {
								$oid=1;
								$checked = "";
								$sel_class = "";
								$tooltip_tabs = array(); ?>
								<div class="option_value_outer radio_select_buttons clearfix">
									<?php
									while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
										$checked = '';
										$sel_class = "";
										$tab_sel_class = "false";
										$tab_sel__content_class = "";
		
										if(in_array($row_cus_opt['id'],$opt_id_array)) {
											$checked = 'checked';
											$sel_class = "sel";
											$tab_sel_class = "true";
											$tab_sel__content_class = "active";
											$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
										}
										elseif($temp_fld_no == $fid) {
											if($row_cus_opt['is_default']==1) {
												$checked = 'checked';
												$sel_class = "sel";
												$tab_sel_class = "true";
												$tab_sel__content_class = "active";
												$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
											}
										} ?>
										<span class="options_values">
											<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$row_cus_fld['input_type']?>">
											<?php
											if($row_cus_opt['icon']!="") {
												echo '<img src="/images/'.$row_cus_opt['icon'].'" width="50px" id="'.$row_cus_opt['id'].'" /><br />';
											}
											echo $row_cus_opt['label'];?></button>
											<input class="radioele" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" value="<?=$row_cus_opt['label'].':'.$row_cus_opt['id']?>" <?=$checked?> type="radio" style="display:none;" data-default="<?=$row_cus_opt['is_default']?>" />
										</span>
										<?php
										$oid++;
									} ?>
								</div>
								<div class="tab-content tab_con">
									
								</div>
								<span class="text-danger"></span>
							<?php
							}
						}
						elseif($row_cus_fld['input_type']=="checkbox") {
							$sql_cus_opt = "select * from product_options where product_field_id = '".$row_cus_fld['id']."'";
							$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
							$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
							$temp_fld_no = 1;
	
							if($no_of_dd_options>0) {
								$oid=1; ?>
								<div class="form-group checkboxes">
								<?php
								while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
									$checked = '';
									$chk_lab = $row_cus_opt['label'];
									$chk_id = $row_cus_opt['id'];
									
									if(in_array($row_cus_opt['id'],$opt_id_array)) {
										$checked = 'checked';
										$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
									} elseif($temp_fld_no == $fid) {
										if($row_cus_opt['is_default']==1) {
											$checked = 'checked';
											$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
										}
									} ?>
									<span class="options_values form-group">
										<div class="checkbox checkbox-success">
											<label class="m-checkbox" for="<?=$chk_lab.$chk_id?>"><input class="checkboxele" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>[]" id="<?=$chk_lab.$chk_id?>" <?=$checked?> value="<?=$chk_lab.':'.$chk_id?>" type="checkbox" data-default="<?=$row_cus_opt['is_default']?>"><span class="checkmark"></span>
											 <?=$chk_lab?> </label>
										</div>
									</span>
								<?php
								} ?>
								</div>
								<a href="#" class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" data-issubmit="<?=$last_next_button?>">Next</a>
								<span class="text-danger"></span>
							<?php
							}
						}
						elseif($row_cus_fld['input_type']=="text") { ?>
							<input name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" class="form-control input" value="<?=$opt_name_array[$row_cus_fld['id']]?>"/>
							<a class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-top-5" data-issubmit="<?=$last_next_button?>">Next</a>
						<?php
						}
						elseif($row_cus_fld['input_type']=="textarea") { ?>
							<textarea name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" class="form-control textarea input"><?=$opt_name_array[$row_cus_fld['id']]?></textarea>
							<a class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-top-5" data-issubmit="<?=$last_next_button?>">Next</a>
						<?php
						}
						elseif($row_cus_fld['input_type']=="datepicker") { ?>
							<input type="date" class="form-control input" id="datepicker" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" autocomplete="off" value="<?=$opt_name_array[$row_cus_fld['id']]?>"/>
							<a class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-top-5" data-issubmit="<?=$last_next_button?>">Next</a>
						<?php
						}
						elseif($row_cus_fld['input_type']=="file") { ?>
							<span></span>
							<div class="custom-file fileupload">
								<input name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" type="file" class="input" onChange="changefile(this)" /> <?=($opt_name_array[$row_cus_fld['id']]?'<img src="'.SITE_URL.'images/orders/files/'.$opt_name_array[$row_cus_fld['id']].'" width="25">':'')?>
							</div>
							<a class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-top-5" data-issubmit="<?=$last_next_button?>">Next</a>
						<?php
						} ?>
					</div>
					<div class="modern-block__selected">
						<span class="mobile-block">Capacity: </span>
						<span class="current-item">
							<?=$opt_name_array[$row_cus_fld['id']]?>
						</span>
					</div>
					<div class="modern-disabled"></div>
				</div>
				<?php
				$fid++;
				$last_field_id = $row_cus_fld['id'];
			} ?>
			
			<div class="device-get-price clearfix">
				<button type="button" class="btn btn-secondary" onClick="backFeild()">Back</button>
				<?php /*?><button type="submit" class="btn btn-primary arrow" id="quantity-section" <?=($opt_name_array[$last_field_id]?'style="display:block;"':'style="display:none;"')?>><?=($edit_item_id>0?'Update':'Save')?></button><?php */?>
			</div>
			
		</div>
	</div>

	<span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>

	<input type="hidden" name="quantity" id="quantity" value="1"/>
	<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
	<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total_price?>"/>
	<input id="total_price_org" value="<?=$price?>" type="hidden" />
</div>
<?php
} ?>

<script>
var tpj=jQuery;

function get_price() {
	tpj.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>admin/ajax/get_model_price.php',
		data: tpj('#addedit_appointment_details_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);

				var total_price = resp_data.payment_amt;

				var _t_price=formatMoney(total_price);
				var f_price=format_amount(_t_price);
				
				tpj(".showhide_total_section").show();
				
				tpj(".show_final_amt").html(f_price);
				tpj(".show_final_amt_val").html(total_price);
				tpj("#item_amount").val(tpj(".show_final_amt_val").html());
				
				//tpj('#get-price-btn').removeAttr("disabled");
			}
		}
	});
}

tpj(document).ready(function($) {
	$('#device-prop-area .radio_select_buttons, #device-prop-area .checkboxes').bind('click keyup', function(event) {
		$(".show_final_amt").html('<i class="fa fa-spinner fa-spin" style="font-size:24px;margin-top:10px;"></i>');

		setTimeout(function() {
			get_price();
		}, 500);
	});
});

get_price();
</script>