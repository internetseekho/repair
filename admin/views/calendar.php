<?php
$custom_phpjs_path = "assets/js/custom/calendar.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Calendar</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Calendar</span>
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
					<div class="m-portlet" id="m_portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon">
										<i class="flaticon-map-location"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Repair Orders
									</h3>
								</div>
							</div>
							<div class="m-portlet__head-tools">
								<ul class="m-portlet__nav">
									<li class="m-portlet__nav-item">
										<a href="addedit_appointment.php" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
											<span>
												<i class="la la-plus"></i>
												<span>Add New Repair</span>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="m-portlet__body">
							<div id="m_calendar"></div>
						</div>
					</div>
		
					<!--end::Portlet-->
				</div>
			</div>
		</div>
		
	</div>
</div>
<!-- end:: Body -->
