<?php
$custom_phpjs_path = "assets/js/custom/fault_list.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Fault Manager</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Fault Manager</span>
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
									List<small></small>
								</h3>
							</div>
						</div>
						
						<?php /*?><div class="m-portlet__head-tools">
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
						</div><?php */?>
						
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
							<div class="col-xl-6 order-2 order-xl-1">
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
											
											<?php /*?><input type="radio" name="export_data_option" value="all" checked="checked"/>All
											<input type="radio" name="export_data_option" value="selected" />Selected
											
											<button class="btn btn-sm btn-accept m--margin-left-10" type="button" onclick="export_data('pdf');return false;"><i class="fa fa-file-import"></i> Export(pdf)</button>
											<button class="btn btn-sm btn-info m--margin-left-10" type="button" onclick="export_data('csv');"><i class="fa fa-file-export"></i> Export (csv)</button><?php */?>
											
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
								</div>
							</div>
							
							<div class="col-xl-6 order-1 order-xl-2 m--align-right">
								<div class="form-group m-form__group row align-items-center">
								<div class="col-md-12">
									<div class="m-form__group m-form__group--inline">
									
										<?php /*?><input type="radio" name="export_data_option" value="all" checked="checked"/>All
										<input type="radio" name="export_data_option" value="selected" />Selected<?php */?>
										
										
										  <label class="m-radio m-radio--state-success">
										  <input type="radio" name="export_data_option" value="all" checked="checked">
										  All <span></span> </label>&nbsp;&nbsp;
										  <label class="m-radio m-radio--state-brand">
										  <input type="radio" name="export_data_option" value="selected">
										  Selected <span></span> </label>
										
										
										<button class="btn btn-sm btn-accept m--margin-left-10" type="button" onclick="export_data('pdf');return false;"><i class="fa fa-file-import"></i> Export(pdf)</button>
										<button class="btn btn-sm btn-info m--margin-left-10" type="button" onclick="export_data('csv');"><i class="fa fa-file-export"></i> Export (csv)</button>
									</div>
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

<!--begin::Modal-------------             edit fault list data -->
<div class="modal fade" id="edit_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
	  <form id="edit_item_form">
		<div class="modal-body">
			<div class="form-group m-form__group row">
				<label for="recipient-name" class="col-lg-2 col-form-label">Name:</label>
				<div class="col-lg-6">
					<input type="text" class="form-control m-input m-input--square" id="fault_name" name="fault_name">
				</div>
			</div>
			
			<div class="form-group m-form__group row">
				<label for="recipient-name" class="col-lg-2 col-form-label">Regular Price:</label>
				<div class="col-lg-6">
					<input type="number" class="form-control m-input m-input--square" id="regular_price" name="regular_price" step="0.01" min="0">
				</div>
			</div>
			
			<div class="form-group m-form__group row">
				<label for="recipient-name" class="col-lg-2 col-form-label">On Offer:</label>
				<div class="col-lg-6">
					<label class="m-checkbox m-checkbox--solid m-checkbox--success">
						<input id="is_on_offer" type="checkbox" value="1">
						<span></span>
					</label>
				</div>
			</div>
			
			<div class="form-group m-form__group row">
				<label for="recipient-name" class="col-lg-2 col-form-label">Sale Price:</label>
				<div class="col-lg-6">
					<input type="number" class="form-control m-input m-input--square" id="sale_price" name="sale_price" step="0.01" min="0">
				</div>
			</div>
			
			
			<div class="form-group m-form__group row">
				<label for="recipient-name" class="col-lg-2 col-form-label">Offer Start Date:</label>
				<div class="col-lg-6">
					<input type="text" class="form-control m-input m-input--square datepicker" placeholder="Offer Start Date" id="offer_start_date" name="offer_start_date"  readonly=""/>
				</div>
			</div>
			
			<div class="form-group m-form__group row">
				<label for="recipient-name" class="col-lg-2 col-form-label">Offer End Date:</label>
				<div class="col-lg-6">
					<input type="text" class="form-control m-input m-input--square datepicker" placeholder="Offer End Date" id="offer_end_date" name="offer_end_date"  readonly=""/>
				</div>
			</div>
			
			<div class="form-group m-form__group row">
				<label class="col-lg-2 col-form-label">Status</label>
				<div class="col-lg-6">
					<label class="m-radio m-radio--state-success">
					<input type="radio" name="status" value="1">
					Publish <span></span> </label>&nbsp;&nbsp;
					<label class="m-radio m-radio--state-brand">
					<input type="radio" name="status" value="0">
					Unpublish <span></span> </label>
				</div>
			</div>
		
			<input type="hidden" class="form-control" id="fault_id" name="fault_id">
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal" id="CLoseEvent2">Close</button>
			<button type="button" class="btn btn-primary" id="edit_item_btn" onClick="edit_fault_data();"> Update</button>
		</div>
	   </form>
    </div>
  </div>
</div>
<!--end::Modal-->
