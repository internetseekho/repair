<?php
$custom_js_path = "assets/js/custom/profile.js"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Profile</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="profile.php" class="m-nav__link">
								<span class="m-nav__link-text">Profile</span>
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
										Edit Profile
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--state m-form--fit m-form--label-align-right" action="controllers/admin_user/profile.php" method="post">
							<div class="m-portlet__body m--padding-top-10 m--padding-bottom-10">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label>Username:</label>
										<input type="text" class="form-control m-input" value="<?=$get_userdata_row['username']?>" name="username" placeholder="Enter username">
									</div>
									<div class="col-lg-6">
										<label class="">Email:</label>
										<input type="email" class="form-control m-input" value="<?=$get_userdata_row['email']?>" name="email" placeholder="Enter email">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label>Password:</label>
										<input type="password" class="form-control m-input" name="password" id="password" placeholder="Enter password">
									</div>
									<div class="col-lg-6">
										<label class="">Confirm Password:</label>
										<input type="password" class="form-control m-input" name="rpassword" id="rpassword" placeholder="Enter confirm password">
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$get_userdata_row['id']?>" />
         						<input type="hidden" name="old_password" value="<?=$get_userdata_row['password']?>" />
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions m-form__actions">
									<div class="row">
										<div class="col-lg-6 ml-lg-auto">
											<button id="m_profile_submit" type="submit" class="btn btn-primary" name="update">Update</button>
											<!--<button type="reset" class="btn btn-secondary">Cancel</button>-->
										</div>
										<div class="col-lg-6 ml-lg-auto m--align-right">
											<!--<button type="reset" class="btn btn-danger">Delete</button>-->
										</div>
									</div>
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
