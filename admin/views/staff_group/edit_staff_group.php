<?php
$custom_phpjs_path = "assets/js/custom/staff_group.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Staff Group':'Add Staff Group')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Staff Group':'Add Staff Group')?></span>
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
										<?=($id?'Edit Staff Group':'Add Staff Group')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/staff_group.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group">
									<label for="name">Name</label>
									<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$staff_group_data['name']?>" name="name" />
								</div>
								
								<div class="form-group m-form__group">
									<h4 class="m-section__heading">Permissions</h4>
									<label for="">Orders</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[order_view]" <?php if($permissions_array['order_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[order_add]" <?php if($permissions_array['order_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[order_edit]" <?php if($permissions_array['order_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[order_delete]" <?php if($permissions_array['order_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[order_invoice]" <?php if($permissions_array['order_invoice']=='1'){echo 'checked="checked"';}?>>
											Invoice<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Models</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[model_view]" <?php if($permissions_array['model_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[model_add]" <?php if($permissions_array['model_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[model_edit]" <?php if($permissions_array['model_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[model_delete]" <?php if($permissions_array['model_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Devices</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[device_view]" <?php if($permissions_array['device_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[device_add]" <?php if($permissions_array['device_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[device_edit]" <?php if($permissions_array['device_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[device_delete]" <?php if($permissions_array['device_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Brands</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[brand_view]" <?php if($permissions_array['brand_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[brand_add]" <?php if($permissions_array['brand_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[brand_edit]" <?php if($permissions_array['brand_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[brand_delete]" <?php if($permissions_array['brand_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Category</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[category_view]" <?php if($permissions_array['category_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[category_add]" <?php if($permissions_array['category_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[category_edit]" <?php if($permissions_array['category_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[category_delete]" <?php if($permissions_array['category_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Customers</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[customer_view]" <?php if($permissions_array['customer_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[customer_add]" <?php if($permissions_array['customer_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[customer_edit]" <?php if($permissions_array['customer_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[customer_delete]" <?php if($permissions_array['customer_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Pages Management</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[page_view]" <?php if($permissions_array['page_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[page_add]" <?php if($permissions_array['page_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[page_edit]" <?php if($permissions_array['page_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[page_delete]" <?php if($permissions_array['page_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Menu Management</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[menu_view]" <?php if($permissions_array['menu_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[menu_add]" <?php if($permissions_array['menu_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[menu_edit]" <?php if($permissions_array['menu_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[menu_delete]" <?php if($permissions_array['menu_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Contractors</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[contractor_view]" <?php if($permissions_array['contractor_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[contractor_add]" <?php if($permissions_array['contractor_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[contractor_edit]" <?php if($permissions_array['contractor_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[contractor_delete]" <?php if($permissions_array['contractor_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="">Invoices</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[invoice_view]" <?php if($permissions_array['invoice_view']=='1'){echo 'checked="checked"';}?>>
											View<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[invoice_add]" <?php if($permissions_array['invoice_add']=='1'){echo 'checked="checked"';}?>>
											Add<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[invoice_edit]" <?php if($permissions_array['invoice_edit']=='1'){echo 'checked="checked"';}?>>
											Edit<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="permissions[invoice_delete]" <?php if($permissions_array['invoice_delete']=='1'){echo 'checked="checked"';}?>>
											Delete<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($staff_group_data['status']==1||$staff_group_data['status']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
									<a href="staff_group.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$staff_group_data['id']?>" />
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
