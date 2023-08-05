<?php
$custom_phpjs_path = "assets/js/custom/contractor.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Edit Contractor</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Edit Contractor</span>
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
										Edit Contractor
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/contractor.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="name">Name</label>
										<input type="text" class="form-control m-input m-input--square" id="name" name="name" value="<?=$contractor_data['name']?>">
									</div>
									
									<div class="col-lg-4">
										<label for="company_name">Company Name</label>
										<input type="text" class="form-control m-input m-input--square" id="company_name" name="company_name" value="<?=$contractor_data['company_name']?>">
									</div>
									
									<div class="col-lg-4">
										<label for="phone">Phone</label><br />
										<input type="tel" class="form-control m-input m-input--square" id="cell_phone" name="cell_phone" placeholder="" value="<?=$contractor_data['phone']?>">
										<input type="hidden" name="phone" id="phone" />
										<br /><span id="valid-msg" class="hide">✓ Valid</span>
										<span id="error-msg" class="hide">Invalid number</span>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="email">Email</label>
										<input type="text" class="form-control m-input m-input--square" id="email" name="email" value="<?=$contractor_data['email']?>" autocomplete="off">
									</div>
								
									<div class="col-lg-6">
										<label for="password">Password</label>
										<input type="password" class="form-control m-input m-input--square" id="password" name="password" autocomplete="off">
									</div>
								</div>
									
								<div class="form-group m-form__group row">
									<div class="col-lg-3">
										<label for="country">Country</label>
										<input type="text" class="form-control m-input m-input--square" id="country" name="country" value="<?=$contractor_data['country']?>">
									</div>
									
									<div class="col-lg-3">
										<label for="state">State</label>
										<input type="text" class="form-control m-input m-input--square" id="state" name="state" value="<?=$contractor_data['state']?>">
									</div>
									
									<div class="col-lg-3">
										<label for="city">City</label>
										<input type="text" class="form-control m-input m-input--square" id="city" name="city" value="<?=$contractor_data['city']?>">
									</div>
									
									<div class="col-lg-3">
										<label for="zip_code">Zip Code</label>
										<input type="text" class="form-control m-input m-input--square" id="zip_code" name="zip_code" value="<?=$contractor_data['zip_code']?>">
									</div>
								</div>

								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" value="1" <?=($contractor_data['status']==1?'checked="checked"':'')?>>
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_edit_form_submit" type="submit" class="btn btn-primary" name="update">Submit</button>
									<a href="contractors.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$contractor_data['id']?>" />
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
