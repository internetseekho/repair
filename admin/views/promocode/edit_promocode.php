<?php
$custom_phpjs_path = "assets/js/custom/promocode.php"; ?>

<script type="text/javascript">
function change_disc_type(val) {
	if(val == "percentage") {
		jQuery(".discount_lbl").html('Discount (%) *');
	} else {
		jQuery(".discount_lbl").html('Discount (<?=$currency_symbol?>) *');
	}
}

function change_multi_act_by_same_cust() {
	if(document.getElementById("multiple_act_by_same_cust").checked == true) {
		jQuery(".showhide_cust_qty").show();
	} else {
		jQuery(".showhide_cust_qty").hide();
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
					<h3 class="m-subheader__title m-subheader__title--separator">Edit Promo Code</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Edit Promo Code</span>
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
										Edit Promo Code
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/promocode.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="name">Promo Name</label>
										<input type="text" class="form-control m-input m-input--square" id="name" name="name" maxlength="15" placeholder="Enter promo name" value="<?=$promocode_data['name']?>">
									</div>
									<div class="col-lg-6">
										<label for="promocode">Promo Code</label>
										<input type="text" class="form-control m-input m-input--square" id="promocode" name="promocode" maxlength="15" placeholder="Enter promocode" value="<?=$promocode_data['promocode']?>">
									</div>
								</div>
								<div class="form-group m-form__group">
									<label for="description">Description</label>
									<textarea class="form-control m-input m-input--square description" rows="3" id="description" name="description" placeholder="Enter description"><?=$promocode_data['description']?></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label for="image">Image</label>
									<input type="file" class="form-control m-input m-input--square" id="image" name="image" onChange="checkFile(this);" accept="image/*">
								</div>
								<?php 
								if($promocode_data['image']!="") { ?>
								<div class="form-group m-form__group">
									<label for="image">&nbsp;</label>
										<img src="../images/promocodes/<?=$promocode_data['image']?>" width="150">
										<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$promocode_data['id']?>','<?=$promocode_data['id']?>')"><i class="la la-trash"></i> Remove</a>
										<input type="hidden" id="old_image" name="old_image" value="<?=$promocode_data['image']?>">
								</div>
								<?php 
								} ?>
									
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="from_date">From Date</label>
										<input type="text" class="form-control m-input m-input--square datepicker" id="from_date" name="from_date" placeholder="Enter from_date date (mm/dd/yyyy)" value="<?=($promocode_data['from_date']!='0000-00-00'?date('m/d/Y',strtotime($promocode_data['from_date'])):'')?>">
									</div>
									<div class="col-lg-4">
										<label for="to_date">Expire Date</label>
										<input type="text" class="form-control m-input m-input--square datepicker" id="to_date" name="to_date" placeholder="Enter To date (mm/dd/yyyy)" value="<?=($promocode_data['to_date']!='0000-00-00'?date('m/d/Y',strtotime($promocode_data['to_date'])):'')?>">
									</div>
									<div class="col-lg-4">
										<label for="never_expire">Never expire</label>
										<div class="m-checkbox-inline">
											<label class='m-checkbox'>
												<input type="checkbox" value="1" id="never_expire" name="never_expire" <?php if($promocode_data['never_expire']=='1'){echo 'checked="checked"';}?>> Never expire <span></span>
											</label>
										</div>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Discount Type</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" id="discount_type_on" name="discount_type" value="flat" onchange="change_disc_type(this.value)" <?php if($promocode_data['discount_type']=='flat'){echo 'checked="checked"';}?>> Flat
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" id="discount_type_off" name="discount_type" value="percentage" checked="checked" onchange="change_disc_type(this.value)" <?php if($promocode_data['discount_type']=='unconfirmed'){echo 'checked="checked"';}?>> Percentage
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label class="discount_lbl" for="discount">Discount <?=($promocode_data['discount_type']=='flat'?'('.$currency_symbol.') ':'(%)')?></label>
										<input type="text" class="form-control m-input m-input--square" id="discount" name="discount" placeholder="Enter discount" value="<?=$promocode_data['discount']?>">
									</div>
									<div class="col-lg-6">
										<label for="act_by_cust">How many times can this code be activated?</label>
										<input type="number" min="1" class="form-control m-input m-input--square" id="act_by_cust" name="act_by_cust" value="<?=($promocode_data['act_by_cust']>0?$promocode_data['act_by_cust']:'')?>">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<div class="m-checkbox-inline">
											<label class='m-checkbox'>
												<input type="checkbox" value="1" id="multiple_act_by_same_cust" name="multiple_act_by_same_cust" <?php if($promocode_data['multiple_act_by_same_cust']=='1'){echo 'checked="checked"';}?> onchange="change_multi_act_by_same_cust()"> Set limit for multiple activation by same customer <span></span>
											</label>
										</div>
										<input type="number" min="1" class="form-control m-input m-input--square showhide_cust_qty" id="multi_act_by_same_cust_qty" name="multi_act_by_same_cust_qty" value="<?=($promocode_data['multi_act_by_same_cust_qty']>0?$promocode_data['multi_act_by_same_cust_qty']:'')?>" placeholder="Enter Qty" <?php if($promocode_data['multiple_act_by_same_cust']=='1'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($promocode_data['status']==1?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="edit">Update</button>
									<a href="promocode.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$promocode_data['id']?>" />
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
