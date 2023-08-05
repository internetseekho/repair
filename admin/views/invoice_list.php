<?php
$custom_phpjs_path = "assets/js/custom/invoice_list.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Invoices</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Invoices</span>
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
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Invoice List<small></small>
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body" id="list_body">
					
					<div class="m-form__content">
						<?php include('confirm_message.php'); ?>
					</div>
					
					<!--begin: Search Form -->
					<form method="post">
					<div class="m-form m-form--label-align-right m--margin-top-10 m--margin-bottom-10">
						<div class="row align-items-center">
							<div class="col-xl-12 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__control">
												<input type="text" class="form-control m-input m-input--square datepicker w-auto" placeholder="From Date" name="from_date" id="from_date" value="<?=$post['from_date']?>">
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__control">
												<input type="text" class="form-control m-input m-input--square datepicker w-auto" placeholder="To Date" name="to_date" id="to_date" value="<?=$post['to_date']?>">
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__control">
												<button class="btn btn-primary searchbx" type="submit" name="search"><i class="la la-search"></i> Search</button>
												<?php
												if($post['from_date']!="" || $post['to_date']!="") {
													echo '<a href="invoice_list.php"><button class="btn btn-danger" type="button"><i class="la la-times"></i> Clear</button></a>';
												} ?>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Payment Status:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_p_status">
													<option value="">All</option>
													<?php
													if(!empty($payment_status_list_array)) {
														foreach($payment_status_list_array as $payment_status_k => $payment_status_v) { ?>
															<option value="<?=$payment_status_v?>"><?=$payment_status_v?></option>
														<?php
														}
													} ?>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Payment Method:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_p_method">
													<option value="">All</option>
													<?php
													if(!empty($payment_method_list_array)) {
														foreach($payment_method_list_array as $payment_method_k => $payment_method_v) { ?>
															<option value="<?=$payment_method_v?>"><?=$payment_method_v?></option>
														<?php
														}
													} ?>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>Select Customer:</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" id="m_form_customer">
													<option value="">All</option>
													<?php
													while($customer_data = mysqli_fetch_assoc($users_query)) { ?>
														<option value="<?=$customer_data['name']?>"> <?=$customer_data['name']?> </option>
													<?php
													} ?>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</form>
					
					<div class="m-form m-form--label-align-right pb-3">
						<div class="row align-items-center">
							<div class="col-xl-12 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									<div class="col-md-8">
										<div class="m-form__group m-form__group--inline">
											<?php
											if($prms_invoice_delete == '1') { ?>
											<button class="btn btn-sm btn-danger" type="button" onclick="selected_items_action('remove');"><i class="la la-trash"></i> Bulk Remove</button>
											<?php
											} ?>
											<?php /*?><button class="btn btn-sm btn-success m--margin-left-10" type="button" onclick="selected_items_action('published');"><i class="la la-check"></i> Publish</button>
											<button class="btn btn-sm btn-metal m--margin-left-10" type="button" onclick="selected_items_action('unpublished');"><i class="la la-times"></i> Unpublish</button><?php */?>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-4">
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


