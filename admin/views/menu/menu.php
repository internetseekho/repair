<?php
$custom_phpjs_path = "assets/js/custom/menu.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Menus</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="#" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Menus</span>
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
								Menu List<small></small>
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						<?php
						if($prms_menu_add == '1') { ?>
						<a title="Add Menu" href="edit_menu.php?position=<?=$menu_position?>" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill m--margin-right-10">
							<span>
								<i class="la la-plus"></i>
								<span>Add New</span>
							</span>
						</a>
						<?php
						} ?>
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
									<div class="col-md-5">
										<div class="m-form__group m-form__group--inline">
											<?php
											if($prms_menu_delete == '1') { ?>
											<button class="btn btn-sm btn-danger" type="button" onclick="selected_items_action('remove');"><i class="la la-trash"></i> Bulk Remove</button>
											<?php
											} ?>
											<button class="btn btn-sm btn-success m--margin-left-10" type="button" onclick="selected_items_action('published');"><i class="la la-check"></i> Publish</button>
											<button class="btn btn-sm btn-metal m--margin-left-10" type="button" onclick="selected_items_action('unpublished');"><i class="la la-times"></i> Unpublish</button>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
									<div class="col-md-2">
										<div class="m-form__group">
											<div class="m-form__label">
												<label>&nbsp;</label>
											</div>
											<div class="m-form__control">
												<select class="form-control m-bootstrap-select" name="position" id="position" onchange="changePosition(this.value);">
													<option value="top_right" <?php if("top_right"==$menu_position){echo 'selected="selected"';}?>>Top Right Menu</option>
													<option value="header" <?php if("header"==$menu_position){echo 'selected="selected"';}?>>Header Menu</option>
													<option value="footer_column1" <?php if("footer_column1"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column1</option>
													<option value="footer_column2" <?php if("footer_column2"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column2</option>
													<option value="footer_column3" <?php if("footer_column3"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column3</option>
													<option value="copyright_menu" <?php if("copyright_menu"==$menu_position){echo 'selected="selected"';}?>>Copyright Menu</option>
												</select>
											</div>
										</div>
										<div class="d-md-none m--margin-bottom-10"></div>
									</div>
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
							<div class="col-xl-4 order-1 order-xl-2 m--align-right">
								<?php
								/*if($prms_menu_add == '1') { ?>
								<a href="edit_menu.php?position=<?=$menu_position?>" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
									<span>
										<i class="la la-plus"></i>
										<span>Add New</span>
									</span>
								</a>
								<?php
								}*/ ?>
								<div class="m-separator m-separator--dashed d-xl-none"></div>
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
