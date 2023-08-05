<?php
$custom_phpjs_path = "assets/js/custom/user.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Add Customer</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Add Customer</span>
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
										Add Customer
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/user.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="first_name">First Name</label>
										<input type="text" class="form-control m-input m-input--square" id="first_name" name="first_name">
									</div>
								
									<div class="col-lg-4">
										<label for="last_name">Last Name</label>
										<input type="text" class="form-control m-input m-input--square" id="last_name" name="last_name">
									</div>
									
									<div class="col-lg-4">
										<label for="cell_phone">Phone</label><br />
										<input type="tel" class="form-control m-input m-input--square" id="cell_phone" name="cell_phone" placeholder="">
										<input type="hidden" name="phone" id="phone" />
										<br /><span id="valid-msg" class="hide">✓ Valid</span>
										<span id="error-msg" class="hide">Invalid number</span>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="email">Email</label>
										<input type="text" class="form-control m-input m-input--square" id="email" name="email">
									</div>
								
									<div class="col-lg-6">
										<label for="password">Password</label>
										<input type="password" class="form-control m-input m-input--square" id="password" name="password">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="address">Address Line1</label>
										<textarea class="form-control m-input m-input--square" name="address" rows="3"></textarea>
									</div>
									<div class="col-lg-6">
										<label for="address2">Address Line2</label>
										<textarea class="form-control m-input m-input--square" name="address2" rows="3"></textarea>
									</div>
								</div>
									
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="city">City</label>
										<input type="text" class="form-control m-input m-input--square" id="city" name="city">
									</div>
								
									<div class="col-lg-4">
										<label for="state">State</label>
										<input type="text" class="form-control m-input m-input--square" id="state" name="state">
									</div>
									
									<div class="col-lg-4">
										<label for="postcode">Post Code</label>
										<input type="text" class="form-control m-input m-input--square" id="postcode" name="postcode">
									</div>
								</div>

								<div class="form-group m-form__group row">
									<div class="col-lg-12">
										<label for="remarks">Remarks</label>
										<textarea class="form-control m-input m-input--square" name="remarks" rows="3"></textarea>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="status">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" value="1" checked="checked">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_add_form_submit" type="submit" class="btn btn-primary" name="add">Submit</button>
									<a href="users.php" class="btn btn-secondary">Back</a>
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
