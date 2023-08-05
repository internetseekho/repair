<?php
$custom_phpjs_path = "assets/js/custom/staff.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Staff':'Add Staff')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Staff':'Add Staff')?></span>
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
										<?=($id?'Edit Staff':'Add Staff')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/staff.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="name">Name</label>
										<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$admin_data['name']?>" name="name">
									</div>
									<div class="col-lg-6">
										<label for="username">Username</label>
										<input type="text" class="form-control m-input m-input--square" id="username" value="<?=$admin_data['username']?>" name="username">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="email">Email</label>
										<input type="email" class="form-control m-input m-input--square" id="email" value="<?=$admin_data['email']?>" name="email">
									</div>
									<div class="col-lg-6">
										<label for="phone">Phone</label>
										<input type="number" class="form-control m-input m-input--square" id="phone" value="<?=$admin_data['phone']?>" name="phone">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="password">Password</label>
										<input type="password" class="form-control m-input m-input--square" id="password" name="password">
									</div>
									<div class="col-lg-6">
										<label for="rpassword">Confirm Password</label>
										<input type="password" class="form-control m-input m-input--square" id="rpassword" name="rpassword">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="location_id">Shop Location</label>
										<select name="location_id" id="location_id" class="form-control m-input">
											<option value="0"> -Select- </option>
											<?php
											while($location_list = mysqli_fetch_assoc($locations_query)) {?>
												<option value="<?=$location_list['id']?>" <?php if($admin_data['location_id'] == $location_list['id']){echo 'selected="selected"';}?>> <?=$location_list['name']?> </option>
											<?php
											} ?>
										</select>
									</div>
									<div class="col-lg-6">
										<label for="group_id">Group</label>
										<select name="group_id" id="group_id" class="form-control m-input">
											<option value=""> -Select- </option>
											<?php
											while($staff_group_list = mysqli_fetch_assoc($staff_groups_query)) {?>
												<option value="<?=$staff_group_list['id']?>" <?php if($admin_data['group_id'] == $staff_group_list['id']){echo 'selected="selected"';}?>> <?=$staff_group_list['name']?> </option>
											<?php
											} ?>
										</select>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="status">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($admin_data['status']==1||$admin_data['status']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_<?=($id?'edit':'add')?>_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
									<a href="staff.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$admin_data['id']?>" />
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
