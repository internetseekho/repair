<?php
include("_config/config.php");
include("include/functions.php");
is_allowed_ip();
check_admin_staff_auth();

//Set pagination limit
$domain_url = DOMAIN_URL;

if(!isset($post['id'])) {
	$post['id'] = "";
}
if(!isset($post['filter_by'])) {
	$post['filter_by'] = "";
}
if(!isset($post['brand_title'])) {
	$post['brand_title'] = "";
}
if(!isset($post['cat_id'])) {
	$post['cat_id'] = "";
}
if(!isset($post['brand_id'])) {
	$post['brand_id'] = "";
}
if(!isset($post['device_id'])) {
	$post['device_id'] = "";
}
if(!isset($post['status'])) {
	$post['status'] = "";
}

if(!isset($post['filter_by_location'])) {
	$post['filter_by_location'] = "";
}
if(!isset($post['contractor_type'])) {
	$post['contractor_type'] = "";
}
if(!isset($post['from_date'])) {
	$post['from_date'] = "";
}
if(!isset($post['to_date'])) {
	$post['to_date'] = "";
}

if(!isset($post['staff_id'])) {
	$post['staff_id'] = "";
}
if(!isset($post['order_id'])) {
	$post['order_id'] = "";
}
if(!isset($post['slug'])) {
	$post['slug'] = "";
}

$_SESSION['file_name'] = $file_name;

//If session expired then it will redirect to login page
if(empty($_SESSION['is_admin']) || empty($_SESSION['admin_username'])) {
    setRedirect(ADMIN_URL);
	exit();
} else {
	$admin_l_id = $_SESSION['admin_id'];
	$admin_type = $_SESSION['admin_type'];

	$query=mysqli_query($db,"SELECT * FROM admin WHERE id = '".$admin_l_id."'");
	$loggedin_user_data = mysqli_fetch_assoc($query);
	$loggedin_user_name = $loggedin_user_data['name'];
	$loggedin_user_email = $loggedin_user_data['email'];

	//START access level based on loggedin user
	$emp_g_query=mysqli_query($db,"SELECT eg.* FROM staff_groups AS eg WHERE eg.id='".$loggedin_user_data['group_id']."'");
	$staff_groups_data=mysqli_fetch_assoc($emp_g_query);

	if($admin_type=="super_admin") {
		$staff_permissions_data = json_decode('{"order_view":"1","order_add":"1","order_edit":"1","order_delete":"1","order_invoice":"1","model_view":"1","model_add":"1","model_edit":"1","model_delete":"1","device_view":"1","device_add":"1","device_edit":"1","device_delete":"1","brand_view":"1","brand_add":"1","brand_edit":"1","brand_delete":"1","category_view":"1","category_add":"1","category_edit":"1","category_delete":"1","customer_view":"1","customer_add":"1","customer_edit":"1","customer_delete":"1","page_view":"1","page_add":"1","page_edit":"1","page_delete":"1","menu_view":"1","menu_add":"1","menu_edit":"1","menu_delete":"1","contractor_view":"1","contractor_add":"1","contractor_edit":"1","contractor_delete":"1","invoice_view":"1","invoice_add":"1","invoice_delete":"1"}', true);
	} else {
		$access_file_name_array = array('general_settings','staff','location');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
		$staff_permissions_data = json_decode($staff_groups_data['permissions'], true);
	}

	$prms_order_view = isset($staff_permissions_data['order_view'])?$staff_permissions_data['order_view']:'';
	$prms_order_add = isset($staff_permissions_data['order_add'])?$staff_permissions_data['order_add']:'';
	$prms_order_edit = isset($staff_permissions_data['order_edit'])?$staff_permissions_data['order_edit']:'';
	$prms_order_delete = isset($staff_permissions_data['order_delete'])?$staff_permissions_data['order_delete']:'';
	$prms_order_invoice = isset($staff_permissions_data['order_invoice'])?$staff_permissions_data['order_invoice']:'';
	$prms_model_view = isset($staff_permissions_data['model_view'])?$staff_permissions_data['model_view']:'';
	$prms_model_add = isset($staff_permissions_data['model_add'])?$staff_permissions_data['model_add']:'';
	$prms_model_edit = isset($staff_permissions_data['model_edit'])?$staff_permissions_data['model_edit']:'';
	$prms_model_delete = isset($staff_permissions_data['model_delete'])?$staff_permissions_data['model_delete']:'';
	$prms_device_view = isset($staff_permissions_data['device_view'])?$staff_permissions_data['device_view']:'';
	$prms_device_add = isset($staff_permissions_data['device_add'])?$staff_permissions_data['device_add']:'';
	$prms_device_edit = isset($staff_permissions_data['device_edit'])?$staff_permissions_data['device_edit']:'';
	$prms_device_delete = isset($staff_permissions_data['device_delete'])?$staff_permissions_data['device_delete']:'';
	$prms_brand_view = isset($staff_permissions_data['brand_view'])?$staff_permissions_data['brand_view']:'';
	$prms_brand_add = isset($staff_permissions_data['brand_add'])?$staff_permissions_data['brand_add']:'';
	$prms_brand_edit = isset($staff_permissions_data['brand_edit'])?$staff_permissions_data['brand_edit']:'';
	$prms_brand_delete = isset($staff_permissions_data['brand_delete'])?$staff_permissions_data['brand_delete']:'';
	$prms_category_view = isset($staff_permissions_data['category_view'])?$staff_permissions_data['category_view']:'';
	$prms_category_add = isset($staff_permissions_data['category_add'])?$staff_permissions_data['category_add']:'';
	$prms_category_edit = isset($staff_permissions_data['category_edit'])?$staff_permissions_data['category_edit']:'';
	$prms_category_delete = isset($staff_permissions_data['category_delete'])?$staff_permissions_data['category_delete']:'';
	$prms_customer_view = isset($staff_permissions_data['customer_view'])?$staff_permissions_data['customer_view']:'';
	$prms_customer_add = isset($staff_permissions_data['customer_add'])?$staff_permissions_data['customer_add']:'';
	$prms_customer_edit = isset($staff_permissions_data['customer_edit'])?$staff_permissions_data['customer_edit']:'';
	$prms_customer_delete = isset($staff_permissions_data['customer_delete'])?$staff_permissions_data['customer_delete']:'';
	$prms_page_view = isset($staff_permissions_data['page_view'])?$staff_permissions_data['page_view']:'';
	$prms_page_add = isset($staff_permissions_data['page_add'])?$staff_permissions_data['page_add']:'';
	$prms_page_edit = isset($staff_permissions_data['page_edit'])?$staff_permissions_data['page_edit']:'';
	$prms_page_delete = isset($staff_permissions_data['page_delete'])?$staff_permissions_data['page_delete']:'';
	$prms_menu_view = isset($staff_permissions_data['menu_view'])?$staff_permissions_data['menu_view']:'';
	$prms_menu_add = isset($staff_permissions_data['menu_add'])?$staff_permissions_data['menu_add']:'';
	$prms_menu_edit = isset($staff_permissions_data['menu_edit'])?$staff_permissions_data['menu_edit']:'';
	$prms_menu_delete = isset($staff_permissions_data['menu_delete'])?$staff_permissions_data['menu_delete']:'';
	$prms_contractor_view = isset($staff_permissions_data['contractor_view'])?$staff_permissions_data['contractor_view']:'';
	$prms_contractor_add = isset($staff_permissions_data['contractor_add'])?$staff_permissions_data['contractor_add']:'';
	$prms_contractor_edit = isset($staff_permissions_data['contractor_edit'])?$staff_permissions_data['contractor_edit']:'';
	$prms_contractor_delete = isset($staff_permissions_data['contractor_delete'])?$staff_permissions_data['contractor_delete']:'';
	$prms_invoice_view = isset($staff_permissions_data['invoice_view'])?$staff_permissions_data['invoice_view']:'';
	$prms_invoice_add = isset($staff_permissions_data['invoice_add'])?$staff_permissions_data['invoice_add']:'';
	$prms_invoice_edit = isset($staff_permissions_data['invoice_edit'])?$staff_permissions_data['invoice_edit']:'';
	$prms_invoice_delete = isset($staff_permissions_data['invoice_delete'])?$staff_permissions_data['invoice_delete']:'';
	
	$access_file_name_array = array();
	if($prms_order_view!='1') {
		$access_file_name_array[] = 'appointments';
	}
	if($prms_category_view!='1') {
		$access_file_name_array[] = 'device_categories';
	}
	if($prms_brand_view!='1') {
		$access_file_name_array[] = 'brand';
	}
	if($prms_device_view!='1') {
		$access_file_name_array[] = 'device';
	}
	if($prms_model_view!='1') {
		$access_file_name_array[] = 'mobile';
		$access_file_name_array[] = 'groups';
	}
	if($prms_customer_view!='1') {
		$access_file_name_array[] = 'users';
	}
	if($prms_page_view!='1') {
		$access_file_name_array[] = 'page';
	}
	if($prms_menu_view!='1') {
		$access_file_name_array[] = 'menu';
	}
	if($prms_invoice_view!='1') {
		$access_file_name_array[] = 'invoice_list';
	}
	
	if($file_name!="" && in_array($file_name,$access_file_name_array)) {
		header('Location: profile.php');
		exit;
	} //END access level based on loggedin user
} ?>

<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title><?=ucfirst(str_replace('_',' ',$file_name))?> | Admin Panel</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		
		<link rel="stylesheet" href="assets/custom.css">
		<link rel="stylesheet" href="../css/intlTelInput.css">
		
		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="<?=SITE_URL?>images/favicon.ico" />
		
		<!--begin::Global Theme Bundle -->
		<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<?php
		if($file_name=="mobile" || $file_name=="custom_fields") { ?>
		<script src="assets/vendors/custom/jquery-ui/jquery-ui.repairdevice.js" type="text/javascript"></script>
		<?php
		} ?>
		<!--end::Page Vendors -->
		
		<script src="assets/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>
		
		<?php
		require_once("../include/custom_js.php"); ?>
	</head>
	<!-- end::Head -->
<style>
.m-aside-menu.m-aside-menu--skin-dark .m-menu__nav>.m-menu__item>.m-menu__heading .m-menu__link-text, .m-aside-menu.m-aside-menu--skin-dark .m-menu__nav>.m-menu__item>.m-menu__link .m-menu__link-text {
    color: #ffffff;
}
.m-aside-menu.m-aside-menu--skin-dark .m-menu__nav>.m-menu__item.m-menu__item--active>.m-menu__heading .m-menu__link-text, .m-aside-menu.m-aside-menu--skin-dark .m-menu__nav>.m-menu__item.m-menu__item--active>.m-menu__link .m-menu__link-text {
    color: #fcff34;
}
.m-aside-menu.m-aside-menu--skin-dark .m-menu__nav>.m-menu__item .m-menu__submenu .m-menu__item>.m-menu__heading .m-menu__link-text, .m-aside-menu.m-aside-menu--skin-dark .m-menu__nav>.m-menu__item .m-menu__submenu .m-menu__item>.m-menu__link .m-menu__link-text {
    color: #f1f1f1;
}
</style>
	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="<?=ADMIN_URL?>" class="m-brand__logo-wrapper" title="<?=ADMIN_PANEL_NAME?>">
										<?=ADMIN_PANEL_NAME?>
										<!--<img src="assets/demo/default/media/img/logo/logo_default_dark.png" alt="<?=ADMIN_PANEL_NAME?>" />-->
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">

									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  " title="<?=ADMIN_PANEL_NAME?>">
										<span></span>
									</a>
									<!-- END -->

									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block" title="<?=ADMIN_PANEL_NAME?>">
										<span></span>
									</a>
									<!-- END -->

									<!-- BEGIN: Responsive Header Menu Toggler -->
									<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block" title="<?=ADMIN_PANEL_NAME?>">
										<span></span>
									</a>
									<!-- END -->

									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block" title="<?=ADMIN_PANEL_NAME?>">
										<i class="flaticon-more"></i>
									</a>
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li class="m-nav__item" style="font-size: 150%;padding-top: 20px;"><a target="_blank" href="/">Website Frontend</a></li>
										<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
										 m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<span class="m-type m--bg-danger"><span class="m--font-light"><?=substr(($loggedin_user_name?$loggedin_user_name:'Admin'),0,1)?></span></span>
												</span>
												<span class="m-topbar__username m--hide">Admin</span>
											</a>
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center" style="background: url(assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
														<div class="m-card-user m-card-user--skin-dark">
															<div class="m-card-user__pic">
																<span class="m-type m-type--lg m--bg-danger"><span class="m--font-light"><?=substr(($loggedin_user_name?$loggedin_user_name:'Admin'),0,1)?></span></span>
															</div>
															<div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500"><?=($loggedin_user_name?$loggedin_user_name:'Admin')?></span>
																<a href="" class="m-card-user__email m--font-weight-300 m-link"><?=$loggedin_user_email?></a>
															</div>
														</div>
													</div>
													<div class="m-dropdown__body">
														<div class="m-dropdown__content">
															<ul class="m-nav m-nav--skin-light">
																<li class="m-nav__section m--hide">
																	<span class="m-nav__section-text">Section</span>
																</li>
																<li class="m-nav__item <?php if($file_name=="profile"){echo 'class="active"';}?>">
																	<a href="profile.php" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-profile-1"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">My Profile</span>
																				<!--<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>-->
																			</span>
																		</span>
																	</a>
																</li>
																<li class="m-nav__separator m-nav__separator--fit"></li>
																<li class="m-nav__item">
																	<a href="logout.php" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" title="Logout" onClick="return confirm('Are you sure you want to logout?');">Logout</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<!-- END: Topbar -->
						</div>
					</div>
				</div>
			</header>
			<!-- END: Header -->
