<?php
$custom_phpjs_path = "assets/js/custom/appt_ticket_status.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Ticket Status':'Add Ticket Status')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Ticket Status':'Add Ticket Status')?></span>
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
										<?=($id?'Edit Ticket Status':'Add Ticket Status')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/appt_ticket_status.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="name">Status Name</label>
										<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$appt_ticket_status_data['name']?>" name="name">
									</div>
									<div class="col-lg-6">
										<label for="color">Status Color</label>
										<input type="color" class="form-control m-input m-input--square" id="color" value="<?=$appt_ticket_status_data['color']?>" name="color">
									</div>
								</div>
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($appt_ticket_status_data['status']==1||$appt_ticket_status_data['status']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
									<a href="appt_ticket_status.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$appt_ticket_status_data['id']?>" />
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
