<?php
$custom_phpjs_path = "assets/js/custom/dashboard.php"; ?>

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
					<h3 class="m-subheader__title">Dashboard</h3>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
			<div class="row">
			
				<div class="col-xl-4">
					<!--begin:: Widgets/Audit Log-->
					<div class="m-portlet m-portlet--full-height ">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<h3 class="m-portlet__head-text">
										Orders
									</h3>
								</div>
							</div>
							<div class="m-portlet__head-tools">
								<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
									<li class="nav-item m-tabs__item">
										<a href="addedit_appointment.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
											<span>
												<i class="la la-plus"></i>
												<span>Add New</span>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="m-portlet__body">
							
							<?php /*?><div class="m-widget4">	
								<div class="m-widget4__item">
									<div class="m-widget4__info">
										<span class="m-widget4__title">
											Phyton
										</span>
									</div>
									<span class="m-widget4__ext">
										<span class="m-widget4__number m--font-danger">123</span>
									</span>
								</div>
							</div><?php */?>				
														
							<div class="tab-content">
								<div class="tab-pane active" id="m_widget4_tab1_content">
									<div class="m-list-timeline m-list-timeline--skin-light">
										<div class="m-list-timeline__items">
											<?php
											if($num_of_order_rows>0) {
												while($appointment_data=mysqli_fetch_assoc($query)) {
													if($appointment_data['status_name']!="") {
														 $status_id = $appointment_data['status_id'];
														 $status_color_style = ($appointment_data['status_color']?'style="background-color:'.$appointment_data['status_color'].';"':'');
														 echo ($appointment_data['status_color']?'<style>.status-dot-color-'.$status_id.':before{background-color:'.$appointment_data['status_color'].' !important;}</style>':'');
														 ?>
														<div class="m-list-timeline__item">
															<span class="m-list-timeline__badge m-list-timeline__badge--success status-dot-color-<?=$status_id?>"></span>
															<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide" <?=$status_color_style?>><?=$appointment_data['status_name']?></span></span>
															<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="appointment.php?status=<?=$appointment_data['status_id']?>" class="m-badge m-badge--success m-badge--wide" <?=$status_color_style?>><?=$appointment_data['num_of_orders']?></a></span></span>
														</div>
													<?php
													}
												}
											} else { ?>
												<div class="alert alert-info alert-dismissible fade show" role="alert">
													Report Not Available
												</div>
											<?php
											} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end:: Widgets/Audit Log-->
				</div>
				<div class="col-xl-4">
					<!--begin:: Widgets/Audit Log-->
					<div class="m-portlet m-portlet--full-height ">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<h3 class="m-portlet__head-text">
										Customers
									</h3>
								</div>
							</div>
							<div class="m-portlet__head-tools">
								<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
									<li class="nav-item m-tabs__item">
										<a href="add_user.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
											<span>
												<i class="la la-plus"></i>
												<span>Add New</span>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="m-portlet__body">
							<div class="tab-content">
								<div class="tab-pane active" id="m_widget4_tab1_content">
									<div class="m-list-timeline m-list-timeline--skin-light">
										<div class="m-list-timeline__items">
											<?php
											if($num_of_user_rows>0) {
												while($user_data=mysqli_fetch_assoc($user_query)) {
													if($user_data['status']=='1') { ?>
														<div class="m-list-timeline__item">
															<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
															<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Published</span></span>
															<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="users.php?status=<?=$user_data['status']?>" class="m-badge m-badge--success m-badge--wide"><?=$user_data['num_of_users']?></a></span></span>
														</div>
													<?php
													}
													elseif($user_data['status']=='0') { ?>
														<div class="m-list-timeline__item">
															<span class="m-list-timeline__badge m-list-timeline__badge--metal"></span>
															<span class="m-list-timeline__text"><span class="m-badge m-badge--metal m-badge--wide">Unpublished</span></span>
															<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="users.php?status=<?=$user_data['status']?>" class="m-badge m-badge--metal m-badge--wide"><?=$user_data['num_of_users']?></a></span></span>
														</div>
													<?php
													}
												}
											} else { ?>
												<div class="alert alert-info alert-dismissible fade show" role="alert">
													Report Not Available
												</div>
											<?php
											} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end:: Widgets/Audit Log-->
				</div>
				
				<?php
				if($contractor_concept == '1') { ?>
				<div class="col-xl-4">
					<!--begin:: Widgets/Audit Log-->
					<div class="m-portlet m-portlet--full-height ">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<h3 class="m-portlet__head-text">
										Contractors
									</h3>
								</div>
							</div>
							<div class="m-portlet__head-tools">
								<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
									<li class="nav-item m-tabs__item">
										<a href="add_contractor.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
											<span>
												<i class="la la-plus"></i>
												<span>Add New</span>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="m-portlet__body">
							<div class="tab-content">
								<div class="tab-pane active" id="m_widget4_tab1_content">
									<div class="m-list-timeline m-list-timeline--skin-light">
										<div class="m-list-timeline__items">
											<?php
											if($num_of_contractor_rows>0) {
												while($contractor_data=mysqli_fetch_assoc($contractor_query)) {
													if($contractor_data['status']=='1') { ?>
														<div class="m-list-timeline__item">
															<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
															<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Published</span></span>
															<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="contractors.php?status=<?=$contractor_data['status']?>" class="m-badge m-badge--success m-badge--wide"><?=$contractor_data['num_of_contractors']?></a></span></span>
														</div>
													<?php
													}
													elseif($contractor_data['status']=='0') { ?>
														<div class="m-list-timeline__item">
															<span class="m-list-timeline__badge m-list-timeline__badge--metal"></span>
															<span class="m-list-timeline__text"><span class="m-badge m-badge--metal m-badge--wide">Unpublished</span></span>
															<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="contractors.php?status=<?=$contractor_data['status']?>" class="m-badge m-badge--metal m-badge--wide"><?=$contractor_data['num_of_contractors']?></a></span></span>
														</div>
													<?php
													}
												}
											} else { ?>
												<div class="alert alert-info alert-dismissible fade show" role="alert">
													Report Not Available
												</div>
											<?php
											} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end:: Widgets/Audit Log-->
				</div>
				<?php
				} ?>
				
				<div class="col-xl-4">
					<!--begin:: Widgets/Audit Log-->
					<div class="m-portlet m-portlet--full-height ">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<h3 class="m-portlet__head-text">
										Devices Info
									</h3>
								</div>
							</div>
							<div class="m-portlet__head-tools">
								<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
									<li class="nav-item m-tabs__item">
										<a href="add_product.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
											<span>
												<i class="la la-plus"></i>
												<span>Add New</span>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="m-portlet__body">
							<div class="tab-content">
								<div class="tab-pane active" id="m_widget4_tab1_content">
									
									<div class="m-list-timeline m-list-timeline--skin-light">
										<div class="m-list-timeline__items">
											<div class="m-list-timeline__item">
												<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
												<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Models</span></span>
												<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="mobile.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_mobile_rows?></a></span></span>
											</div>
											<div class="m-list-timeline__item">
												<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
												<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Devices</span></span>
												<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="device.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_device_rows?></a></span></span>
											</div>
											<div class="m-list-timeline__item">
												<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
												<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Brands</span></span>
												<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="brand.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_brand_rows?></a></span></span>
											</div>
											<div class="m-list-timeline__item">
												<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
												<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Categories</span></span>
												<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="device_categories.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_category_rows?></a></span></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end:: Widgets/Audit Log-->
				</div>					
				
			</div>
		</div>
		
	</div>
</div>
<!-- end:: Body -->
