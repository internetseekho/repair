<?php
$custom_phpjs_path = "assets/js/custom/appointment.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Orders</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Orders</span>
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
									Order List<small></small>
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<?php
							if($prms_order_add == '1') { ?>
							<a href="addedit_appointment.php" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill m--margin-right-10">
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
					<form method="post" class="filter_form">
						<div class="m-form m-form--label-align-right m--margin-top-10 m--margin-bottom-10">
							<div class="row align-items-center">
								<div class="col-xl-12 order-2 order-xl-1">
									<div class="form-group m-form__group row align-items-center">
										<div class="col-md-3">
											<div class="m-form__group">
												<div class="m-form__control">
													<input type="text" class="form-control m-input m-input--square date_picker" placeholder="From Date" name="from_date" id="from_date" value="<?=$post['from_date']?>">
												</div>
											</div>
											<div class="d-md-none m--margin-bottom-10"></div>
										</div>
										<div class="col-md-3">
											<div class="m-form__group">
												<div class="m-form__control">
													<input type="text" class="form-control m-input m-input--square date_picker" placeholder="To Date" name="to_date" id="to_date" value="<?=$post['to_date']?>">
												</div>
											</div>
											<div class="d-md-none m--margin-bottom-10"></div>
										</div>
										<div class="col-md-2">
											<div class="m-form__group">
												<div class="m-form__control">
													<button class="btn btn-info searchbx" type="submit" name="search"><i class="la la-search"></i> Search</button>
													<?php
													if($post['from_date']!="" || $post['to_date']!="") {
														echo '<a href="appointment.php"><button class="btn btn-danger" type="button"><i class="la la-times"></i> Clear</button></a>';
													} ?>
													<?php /*?><button class="btn btn-accent" type="submit" name="export"><i class="fa fa-file-export"></i> Export</button>
													<button class="btn btn-metal print" type="button" name="print"><i class="fa fa-print"></i> Print</button><?php */?>
												</div>
											</div>
											<div class="d-md-none m--margin-bottom-10"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>

					<div class="m-form m-form--label-align-right m--margin-top-10 m--margin-bottom-10">
						<div class="row align-items-center">
							<div class="col-xl-12 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									<div class="col-md-4">
										<div class="m-form__group m-form__group--inline">
											<?php
											if($prms_order_delete == '1') { ?>
											<button class="btn btn-sm btn-danger" type="button" onclick="selected_items_action('remove');"><i class="la la-trash"></i> Bulk Remove</button>
											<?php
											} ?>
											<?php /*?><button class="btn btn-sm btn-success m--margin-left-10" type="button" onclick="selected_items_action('published');"><i class="la la-check"></i> Publish</button>
											<button class="btn btn-sm btn-metal m--margin-left-10" type="button" onclick="selected_items_action('unpublished');"><i class="la la-times"></i> Unpublish</button><?php */?>
											<button class="btn btn-sm btn-info m--margin-left-10" type="button" onclick="selected_items_action('export');"><i class="fa fa-file-export"></i> Export</button>
											<button class="btn btn-sm btn-metal m--margin-left-10 print" type="button" name="print"><i class="fa fa-print"></i> Print</button>
										</div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_location">
													<option value=""> - Location - </option>
													<?php
													while($location_data = mysqli_fetch_assoc($lcn_query)) { ?>
														<option value="<?=$location_data['name']?>"> <?=$location_data['name']?> </option>
													<?php
													} ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__control">
												<select id="m_status" class="form-control m-bootstrap-select">
													<option value=""> - Status - </option>
													<?php
													while($appt_status_list = mysqli_fetch_assoc($appt_status_query)) {?>
														<option value="<?=$appt_status_list['name']?>"> <?=$appt_status_list['name']?> </option>
													<?php
													} ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_contractor_type">
													<option value=""> All </option>
													<option value="contractor"> Contractor </option>
													<option value="inhouse"> In-House </option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
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
							<div class="col-xl-12 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									<div class="col-md-12">
										
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
								</div>
							</div>
							<?php /*?><div class="col-xl-4 order-1 order-xl-2 m--align-right">
								<?php
								if($prms_order_add == '1') { ?>
								<a href="addedit_appointment.php" class="btn btn-accent m-btn btn-sm m-btn--custom m-btn--icon m-btn--air m-btn--pill">
									<span>
										<i class="la la-plus"></i>
										<span>Add New</span>
									</span>
								</a>
								<?php
								} ?>
								<div class="m-separator m-separator--dashed d-xl-none"></div>
							</div><?php */?>
						</div>
					</div>
					<!--end: Search Form -->

					<!--begin: Datatable -->
					<div class="m_datatable" id="local_data"></div>
					<!--end: Datatable -->
				</div>
			</div>
			
			<?php
			if(count($estimate_cost_array)>0) { ?>
			<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
				<div class="m-alert__icon">
					<i class="flaticon-info m--font-primary"></i>
				</div>
				<div class="m-alert__text">
					<div class="form-group m-form__group row align-items-center m--margin-top-10 m--margin-bottom-10">
						<div class="col-md-4">
						<?='<b>Total Estimation:</b> '.amount_fomat(array_sum($estimate_cost_array))?>
						</div>
						<div class="col-md-4">
						<?='<b>Total Contractor Cost:</b> '.amount_fomat(array_sum($contractor_cost_array))?>
						</div>
						<div class="col-md-4">
						<?='<b>Total Commision:</b> '.amount_fomat(array_sum($commision_array))?>
						</div>
					</div>
				</div>
			</div>
			<?php
			} ?>
			
		</div>

	</div>
</div>
<!-- end:: Body -->

<div class="modal fade" id="invoice_details_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Invoice Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body comment_form_data">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
