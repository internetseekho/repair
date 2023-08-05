<?php
$custom_phpjs_path = "assets/js/custom/appointment.php"; ?>

<script>
function getModelDetails(val,mode)
{
	var model_id = val.trim();
	if(model_id) {
		post_data = "model_id="+model_id+"&appt_id=<?=$id?>&token=<?=unique_id()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_oe_model_details.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#oe_model_details').html(data);
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}
</script>

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

	<!-- BEGIN: Left Aside -->
	<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

		<!-- BEGIN: Aside Menu -->
		<?php
		include("include/admin_menu.php"); ?>
		<!-- END: Aside Menu -->
	</div>

	<!-- END: Left Aside -->
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Order':'Add Order')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Order':'Add Order')?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
			<div class="row">
				<div class="col-lg-12">

					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										<?=($id?'Edit Order':'Add Order')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/appointment.php" method="post" enctype="multipart/form-data" id="addedit_appointment_details_form">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="product_id">Product</label>
										<select required="required" id="product_id" name="product_id" class="form-control select2 m_select2" onchange="getModelDetails(this.value,'');">
										  <option value=""> - Select - </option>
										  <?php
										  $model_data_list = get_model_data_list($device_id, $devices_id, $cat_id);
										  $model_num_of_rows = count($model_data_list);
										  if($model_num_of_rows>0) {
											  foreach($model_data_list as $model_data) { ?>
												<option value="<?=$model_data['id']?>" <?php if($model_data['id'] == $appointment_data['product_id']) {echo 'selected="selected"';}?>><?=$model_data['device_title'].' - '.$model_data['title']?></option>
											  <?php
											  }
										  } ?>
										</select>
									</div>
									<div class="col-lg-4">
										<label for="item_amount">Product Amount</label>
										<input type="number" required="required" class="form-control m-input m-input--square" id="item_amount" value="<?=$appointment_data['item_amount']?>" name="item_amount">
										<?php
										if($f_promocode_info) { ?>
											<small><?=$f_promocode_info?></small>
											<small><br /><strong>Total:</strong> <?=amount_fomat($appointment_data['item_amount']-$promocode_amt)?></small>
										<?php
										} ?>
									</div>
									<div class="col-lg-4">
										<label for="status">Status</label>
										<select name="status" id="status" class="form-control m-input m-input--square" required="required">
											<?php
											while($appt_status_list = mysqli_fetch_assoc($appt_status_query)) {?>
												<option value="<?=$appt_status_list['id']?>" <?php if($appointment_data['status'] == $appt_status_list['id']){echo 'selected="selected"';}?>> <?=$appt_status_list['name']?> </option>
											<?php
											} ?>
										</select>
									</div>
								</div>
								<?php /*?><div class="form-group m-form__group">
									<label for="item_name">Product Item</label>
									<textarea name="item_name" required="required" class="form-control m-input m-input--square" id="item_name" rows="3"><?=$appointment_data['item_name']?></textarea>
								</div><?php */?>
								
								<div class="form-group m-form__group">
									<div id="oe_model_details" style="margin-top:15px;"></div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<h4 class="m-section__heading">Enter personal info</h4>
										<label for="user_id">Customer</label>
										<select name="user_id" id="user_id" class="form-control select2 m_select2">
											 <option value=""> - Select - </option>
											<?php
											$selected_user_data = array();
											while($user_list = mysqli_fetch_assoc($user_query)) {
												if($appointment_data['user_id'] == $user_list['id']) {
													$selected_user_data = $user_list;
												} ?>
												<option value="<?=$user_list['id']?>" <?php if($appointment_data['user_id'] == $user_list['id']){echo 'selected="selected"';}?>> <?=$user_list['name']?> </option>
											<?php
											} ?>
										</select>
									</div>
									<div class="col-lg-4">
										<button type="button" id="add_user" class="btn btn-alt btn-small btn-success m--margin-top-50"><span><i class="fa fa-plus"></i> <span>Add User</span></span></button>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="name">Name</label>
										<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$appointment_data['name']?>" name="name" required="required">
									</div>
									<div class="col-lg-4">
										<label for="email">Email</label>
										<input type="email" class="form-control m-input m-input--square" id="email" value="<?=$appointment_data['email']?>" name="email" required="required">
									</div>
									<div class="col-lg-4">
										<label for="phone">Phone</label>
										<input type="text" id="phone" name="phone" class="form-control m-input m-input--square" value="<?=$appointment_data['phone']?>" required="required" maxlength="10">
									</div>
								</div>
								
								<div class="form-group m-form__group row add_user_fields" style="display:none;">
									<div class="col-lg-6">
										<h4 class="m-section__heading">Shipping Address</h4>
										<label for="address1">Address Line1</label>
										<textarea type="text" class="form-control m-input m-input--square" id="address1" name="address1" rows="3"><?=(isset($selected_user_data['address'])?$selected_user_data['address']:'')?></textarea>
									</div>
									<div class="col-lg-6 m--margin-top-30">
									<label for="address2">Address Line2</label>
									<textarea type="text" class="form-control m-input m-input--square" id="address2" name="address2" rows="3"><?=(isset($selected_user_data['address2'])?$selected_user_data['address2']:'')?></textarea>
									</div>
								</div>
								<div class="form-group m-form__group row add_user_fields" style="display:none;">
									<div class="col-lg-4">
										<label for="city">City</label>
										<input type="text" class="form-control m-input m-input--square" id="city" value="<?=(isset($selected_user_data['city'])?$selected_user_data['city']:'')?>" name="city">
									</div>
									<div class="col-lg-4">
										<label for="state">State</label>
										<input type="text" class="form-control m-input m-input--square" id="state" value="<?=(isset($selected_user_data['state'])?$selected_user_data['state']:'')?>" name="state">
									</div>
									<div class="col-lg-4">
										<label for="postcode">Post Code</label>
										<input type="text" class="form-control m-input m-input--square" id="postcode" value="<?=(isset($selected_user_data['postcode'])?$selected_user_data['postcode']:'')?>" name="postcode">
									</div>
								</div>
								<input type="hidden" id="user_other_fields_status" value="0" name="user_other_fields_status">
								
								<?php
								$shipping_method = $appointment_data['shipping_method']; ?>
								<div class="form-group m-form__group m--padding-bottom-5">
									<h4 class="m-section__heading">Choose your Location</h4>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input checked="checked" id="payment_method_bank" class="payment_method" name="shipping_method" value="bring_to_shop" type="radio" <?php if($shipping_method=="bring_to_shop"){echo 'checked="checked"';}?>> Bring to shop (free) <span></span>
										</label>
										<label class="m-radio">
											<input id="payment_method_cheque" class="payment_method" name="shipping_method" value="come_to_you" type="radio" <?php if($shipping_method=="come_to_you"){echo 'checked="checked"';}?>> We come to you <span></span>
										</label>
										<label class="m-radio">
											<input id="payment_method_ship_device" class="payment_method" name="shipping_method" value="ship_device" type="radio" <?php if($shipping_method=="ship_device"){echo 'checked="checked"';}?>> Ship Your Device <span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group row m--padding-top-5 payment_method_cheque" <?php if($shipping_method=="come_to_you"){echo '';}else{echo 'style="display:none;"';}?>>
									<?php /*?><div class="col-lg-4">
										<label for="">Address</label>
										<textarea name="address" placeholder="Address..." class="address form-control m-input m-input--square" id="address" rows="3"><?=$appointment_data['address']?></textarea>
									</div><?php */?>
									
									<div class="col-lg-3">
										<label for="cometoyou_address">Address</label>
										<textarea name="cometoyou_address" placeholder="Address..." class="cometoyou_address form-control m-input m-input--square" id="cometoyou_address" rows="3"><?=$appointment_data['shipping_address']?></textarea>
									</div>
									<div class="col-lg-3">
										<label for="cometoyou_city">City</label>
										<input type="text" name="cometoyou_city" placeholder="Enter City" class="cometoyou_city form-control m-input m-input--square" id="cometoyou_city" value="<?=$appointment_data['shipping_city']?>">
									</div>
									<div class="col-lg-3">
										<label for="cometoyou_state">State</label>
										<input type="text" name="cometoyou_state" placeholder="Enter State" class="cometoyou_state form-control m-input m-input--square" id="cometoyou_state" value="<?=$appointment_data['shipping_state']?>">
									</div>
									<div class="col-lg-3">
										<label for="cometoyou_zipcode">Zip Code</label>
										<input type="text" name="cometoyou_zipcode" placeholder="Enter Zip Code" class="cometoyou_zipcode form-control m-input m-input--square" id="cometoyou_zipcode" value="<?=$appointment_data['shipping_zipcode']?>">
									</div>
								</div>
								<div class="form-group m-form__group row m--padding-top-5 payment_method_cheque" <?php if($shipping_method=="come_to_you"){echo '';}else{echo 'style="display:none;"';}?>>
									<div class="col-lg-3">
										<label for="">Add instructions (optional)</label>
										<textarea name="instructions" placeholder="Add instructions (optional)" class="instructions form-control m-input m-input--square" id="instructions" rows="3"><?=$appointment_data['instructions']?></textarea>
									</div>
									<?php /*?><div class="col-lg-4">
										<label for="">Add / suite / floor No. (optional)</label>
										<input type="text" name="floor_no" placeholder="Add / suite / floor No. (optional)" class="floor_no form-control m-input m-input--square" id="floor_no" value="<?=$appointment_data['floor_no']?>">
									</div><?php */?>
								</div>

								<div class="form-group m-form__group row m--padding-top-5 payment_method_ship_device" <?php if($shipping_method=="ship_device"){echo '';}else{echo 'style="display:none;"';}?>>
									<div class="col-lg-3">
										<label for="shipping_address">Address</label>
										<textarea name="shipping_address" placeholder="Address..." class="shipping_address form-control m-input m-input--square" id="shipping_address" rows="3"><?=$appointment_data['shipping_address']?></textarea>
									</div>
									<div class="col-lg-3">
										<label for="shipping_city">City</label>
										<input type="text" name="shipping_city" placeholder="Enter City" class="shipping_city form-control m-input m-input--square" id="shipping_city" value="<?=$appointment_data['shipping_city']?>">
									</div>
									<div class="col-lg-3">
										<label for="shipping_state">State</label>
										<input type="text" name="shipping_state" placeholder="Enter State" class="shipping_state form-control m-input m-input--square" id="shipping_state" value="<?=$appointment_data['shipping_state']?>">
									</div>
									<div class="col-lg-3">
										<label for="shipping_zipcode">Zip Code</label>
										<input type="text" name="shipping_zipcode" placeholder="Enter Zip Code" class="shipping_zipcode form-control m-input m-input--square" id="shipping_zipcode" value="<?=$appointment_data['shipping_zipcode']?>">
									</div>
								</div>
								
								<?php
								if(count($location_list)>0) { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="location_id">Shop Location</label>
										<select required="required" id="location_id" name="location_id" class="form-control m-input" onchange="getTimeSlotList(this.value,'location');">
										  <option value=""> - Select - </option>
										  <?php
										  foreach($location_list as $location_data) { ?>
											<option value="<?=$location_data['id']?>" <?php if($location_data['id'] == $appointment_data['location_id']) {echo 'selected="selected"';}?>><?=$location_data['name']?></option>
										  <?php
										  } ?>
										</select>
									</div>
								</div>
								<?php
								} ?>

								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<h4 class="m-section__heading">Make an appointment</h4>
										<label for="date">Date</label>
										<input required="required" type="text" name="date" placeholder="Date..." class="form-control m-input m-input--square date_picker" id="date" autocomplete="off" value="<?=($appointment_data['appt_date']!=""?date("m/d/Y",strtotime($appointment_data['appt_date'])):'')?>">
									</div>
									<div class="col-lg-6 m--margin-top-30">
										<label for="time_slot">Time Slot</label>
										<select required="required" id="time_slot" name="time_slot" class="form-control select2 m_select2">
											<?php
											//if(count($location_list)<=0) {
											$time_interval   = ($appt_time_interval * 60);
											$start_time = (strtotime($appt_start_time));
											$end_time   = (strtotime($appt_end_time));
											?>
										
											<option value=""> - Select - </option>
											<option value="<?=$appointment_data['appt_time']?>" selected="selected"><?=$appointment_data['appt_time']?></option>
											<?php
											for($i = $start_time; $i<=$end_time; $i+=$time_interval) {
												$range = date('g:i a',$i);
												echo "<option value=\"$range\">$range</option>".PHP_EOL;
											}
											//} ?>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group">
									<label for="extra_remarks">Extra remarks</label>
									<textarea name="extra_remarks" placeholder="Extra remarks..." class="extra_remarks form-control m-input m-input--square" id="extra_remarks" rows="4"><?=$appointment_data['extra_remarks']?></textarea>
								</div>
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($appointment_data['published']==1||$appointment_data['published']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>	
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="addedit_appt"><?=($id?'Update':'Make')?></button>
									<a href="appointment.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$id?>" />
						</form>
						<!--end::Form-->
					</div>
					<!--end::Portlet-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Body -->

<script>
getModelDetails('<?=$appointment_data['product_id']?>','onload');
</script>
