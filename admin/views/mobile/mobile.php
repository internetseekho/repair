<?php
$custom_phpjs_path = "assets/js/custom/mobile.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Models</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Models</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__head">
					<div class="m-portlet__head-wrapper">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Model List<small></small>
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<?php
							if($prms_model_add == '1') { ?>
							<a title="Add New Model" href="add_product.php" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill m--margin-right-10">
								<span>
									<i class="la la-plus"></i>
									<span>Add New</span>
								</span>
							</a>
							<?php
							} ?>
						</div>
					</div>
				</div>
				
				<div class="m-portlet__body" id="list_body">
					
					<div class="m-form__content">
						<?php include('confirm_message.php'); ?>
					</div>
		
					<!--begin: Search Form -->
					<div class="m-form m-form--label-align-right m--margin-top-10 m--margin-bottom-10">
						<div class="row align-items-center">
							<div class="col-xl-12 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Status:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_status">
													<option value="">All</option>
													<option value="1">Published</option>
													<option value="0">Unpublished</option>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Category:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_cat">
													<option value="">All</option>
													<?php
													while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
														<option value="<?=$categories_list['title']?>"><?=$categories_list['title']?></option>
													<?php
													} ?>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Brand:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_brand">
													<option value="">All</option>
													<?php
													while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
														<option value="<?=$brands_list['title']?>"><?=$brands_list['title']?></option>
													<?php
													} ?>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Device:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_device">
													<option value="">All</option>
													<?php
													while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
														<option value="<?=$devices_list['title']?>"><?=$devices_list['title']?></option>
													<?php
													} ?>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-3">
										<div class="m-input-icon m-input-icon--left">
											<input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
											<span class="m-input-icon__icon m-input-icon__icon--left">
												<span><i class="la la-search"></i></span>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-form m-form--label-align-right m--margin-top-10 m--margin-bottom-10">
						<div class="row align-items-center">
							<div class="col-xl-10 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									<div class="col-md-12">
										<div class="m-form__group m-form__group--inline">
											<?php
											if($prms_model_delete == '1') { ?>
											<button class="btn btn-sm btn-danger" type="button" onclick="selected_items_action('remove');"><i class="la la-trash"></i> Bulk Remove</button>
											<?php
											} ?>
											<button class="btn btn-sm btn-success m--margin-left-10" type="button" onclick="selected_items_action('published');"><i class="la la-check"></i> Publish</button>
											<button class="btn btn-sm btn-metal m--margin-left-10" type="button" onclick="selected_items_action('unpublished');"><i class="la la-times"></i> Unpublish</button>
											<button class="btn btn-sm btn-accept m--margin-left-10" type="button" onclick="ImportDataModal();return false;"><i class="fa fa-file-import"></i> Import</button>
											<button class="btn btn-sm btn-info m--margin-left-10" type="button" onclick="selected_items_action('export');"><i class="fa fa-file-export"></i> Export</button>
											<button class="btn btn-sm btn-accept m--margin-left-10" type="button" onclick="ImportDataModal2();return false;"><i class="fa fa-file-import"></i> Import Meta</button>
											<button class="btn btn-sm btn-info m--margin-left-10" type="button" onclick="selected_items_action('export_meta');"><i class="fa fa-file-export"></i> Export Meta</button>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end: Search Form -->

					<!--begin: Datatable -->
					<div class="m_datatable" id="local_data"></div>
					<!--end: Datatable -->
				</div>
			</div>
		</div>

	</div>
</div>
<!-- end:: Body -->

<!--begin::Modal-->
<div class="modal fade" id="export_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Model(s) Import</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/mobile.php" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="form-control-label">Select File</label>
					<input type="file" class="form-control" id="file_name" name="file_name">
				</div>
				<div class="form-group">
					<a href="sample_files/sample_file.csv" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download Sample File</a>
					<br />
					<small>Models icon you need to upload in this folder by FTP/Cpanel (<?=CP_ROOT_PATH?>/images/mobile)</small>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="import">IMPORT</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="export_modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel2">Model(s) Import</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/mobile.php" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="form-control-label">Select File</label>
					<input type="file" class="form-control" id="file_name" name="file_name">
				</div>
				<div class="form-group">
					<a href="sample_files/sample_file_for_meta.csv" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download Sample File</a>
					<?php /*?><br />
					<small>Models icon you need to upload in this folder by FTP/Cpanel (<?=CP_ROOT_PATH?>/images/mobile)</small><?php */?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="import_meta">IMPORT</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--end::Modal-->
