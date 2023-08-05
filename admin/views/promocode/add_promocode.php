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
					<h3 class="m-subheader__title m-subheader__title--separator">Add Promo Code</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Add Promo Code</span>
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
										Add Promo Code
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
										<input type="text" class="form-control m-input m-input--square" id="name" name="name" maxlength="15" placeholder="Enter promo name">
									</div>
									<div class="col-lg-6">
										<label for="promocode">Promo Code</label>
										<input type="text" class="form-control m-input m-input--square" id="promocode" name="promocode" maxlength="15" placeholder="Enter promocode">
									</div>
								</div>
								<div class="form-group m-form__group">
									<label for="description">Description</label>
									<textarea class="form-control m-input m-input--square description" rows="3" id="description" name="description" placeholder="Enter description"></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label for="image">Image</label>
									<input type="file" class="form-control m-input m-input--square" id="image" name="image" onChange="checkFile(this);" accept="image/*">
								</div>
									
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="from_date">From Date</label>
										<input type="text" class="form-control m-input m-input--square datepicker" id="from_date" name="from_date" placeholder="Enter from_date date (mm/dd/yyyy)">
									</div>
									<div class="col-lg-4">
										<label for="to_date">Expire Date</label>
										<input type="text" class="form-control m-input m-input--square datepicker" id="to_date" name="to_date" placeholder="Enter To date (mm/dd/yyyy)">
									</div>
									<div class="col-lg-4">
										<label for="never_expire">Never expire</label>
										<div class="m-checkbox-inline">
											<label class='m-checkbox'>
												<input type="checkbox" value="1" id="never_expire" name="never_expire"> Never expire <span></span>
											</label>
										</div>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Discount Type</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" id="discount_type_on" name="discount_type" value="flat" onchange="change_disc_type(this.value)"> Flat
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" id="discount_type_off" name="discount_type" value="percentage" checked="checked" onchange="change_disc_type(this.value)"> Percentage
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label class="discount_lbl" for="discount">Discount (%)</label>
										<input type="text" class="form-control m-input m-input--square" id="discount" name="discount" placeholder="Enter discount">
									</div>
									<div class="col-lg-6">
										<label for="act_by_cust">How many times can this code be activated?</label>
										<input type="number" min="1" class="form-control m-input m-input--square" id="act_by_cust" name="act_by_cust">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<div class="m-checkbox-inline">
											<label class='m-checkbox'>
												<input type="checkbox" value="1" id="multiple_act_by_same_cust" name="multiple_act_by_same_cust" onchange="change_multi_act_by_same_cust()"> Set limit for multiple activation by same customer <span></span>
											</label>
										</div>
										<input type="number" min="1" class="form-control m-input m-input--square showhide_cust_qty" id="multi_act_by_same_cust_qty" name="multi_act_by_same_cust_qty" placeholder="Enter Qty">
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="add">Update</button>
									<a href="promocode.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
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
