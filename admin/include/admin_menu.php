<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
	<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
		<li class="m-menu__item <?php if($file_name=="dashboard"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="dashboard.php" class="m-menu__link ">
				<i class="m-menu__link-icon la la-home"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Dashboard</span>
						<!--<span class="m-menu__link-badge">
							<span class="m-badge m-badge--danger">2</span>
						</span>-->
					</span>
				</span>
			</a>
		</li>
		
		<li class="m-menu__item <?php if($file_name=="calendar"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="calendar.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-calendar-alt"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Calendar</span>
					</span>
				</span>
			</a>
		</li>
		
		<?php
		if($prms_category_view == '1' || $prms_brand_view == '1' || $prms_device_view == '1' || $prms_model_view == '1') { ?>
		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="device_categories" || $file_name=="brand" || $file_name=="device" || $file_name=="mobile" || $file_name=="custom_fields"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-laptop"></i><span class="m-menu__link-text">Devices</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Devices</span></span></li>
					<?php
					if($prms_category_view == '1') { ?>
					<li class="m-menu__item <?php if($file_name=="device_categories"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="device_categories.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Categories</span></a></li>
					<?php
					}
					if($prms_brand_view == '1') { ?>
					<li class="m-menu__item <?php if($file_name=="brand"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="brand.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Brand</span></a></li>
					<?php
					}
					if($prms_device_view == '1') { ?>
					<li class="m-menu__item <?php if($file_name=="device"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="device.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Devices</span></a></li>
					<?php
					}
					if($prms_model_view == '1') { ?>
					<li class="m-menu__item <?php if($file_name=="mobile"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="mobile.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Models</span></a></li>
					<li class="m-menu__item <?php if($file_name=="custom_fields"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="custom_fields.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Custom Fields Group</span></a></li>
					<?php
					} ?>
				</ul>
			</div>
		</li>
		<?php
		}
		
		if($prms_customer_view == '1') { ?>
		<li class="m-menu__item <?php if($file_name=="users"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="users.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-users"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Customers</span>
					</span>
				</span>
			</a>
		</li>
		<?php
		}

		if($prms_contractor_view == '1' && $contractor_concept == '1') { ?>
		<li class="m-menu__item <?php if($file_name=="contractors"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="contractors.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-users"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Contractors</span>
					</span>
				</span>
			</a>
		</li>
		<?php
		}
		
		if($prms_order_view == '1') { ?>
		<li class="m-menu__item <?php if($file_name=="appointments"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="appointment.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-list"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Orders</span>
					</span>
				</span>
			</a>
		</li>
		<li class="m-menu__item <?php if($file_name=="time_sheet"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="time_sheet.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-clock"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Time Sheet</span>
					</span>
				</span>
			</a>
		</li>
		<?php
		}
		
		if($prms_invoice_view == '1') { ?>
		<li class="m-menu__item <?php if($file_name=="invoice_list"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="invoice_list.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-file-invoice"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Invoices</span>
					</span>
				</span>
			</a>
		</li>
		<?php
		} ?>
		
		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="contact" || $file_name=="review" || $file_name=="add_edit_review" || $file_name=="bulk_order" || $file_name=="affiliate" || $file_name=="newsletter"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-list-alt"></i><span class="m-menu__link-text">Forms</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Forms</span></span></li>
					<li class="m-menu__item <?php if($file_name=="contact"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="contact.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Contacts</span></a></li>
					<li class="m-menu__item <?php if($file_name=="review" || $file_name=="add_edit_review"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="review.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Reviews</span></a></li>
					<li class="m-menu__item <?php if($file_name=="bulk_order"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="bulk_order.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Bulk Orders</span></a></li>
					<?php /*?><li class="m-menu__item <?php if($file_name=="affiliate"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="affiliate.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Affiliates</span></a></li><?php */?>
					<li class="m-menu__item <?php if($file_name=="newsletter"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="newsletter.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Newsletters</span></a></li>
				</ul>
			</div>
		</li>
		
		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="blog" || $file_name=="categories"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-newspaper"></i><span class="m-menu__link-text">Blog</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Blog</span></span></li>
					<li class="m-menu__item <?php if($file_name=="blog"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="blog.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Blog</span></a></li>
					<li class="m-menu__item <?php if($file_name=="categories"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="categories.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Categories</span></a></li>
				</ul>
			</div>
		</li>
		
		<?php
		if($prms_page_view == '1') { ?>
		<!--<li class="m-menu__item <?php if($file_name=="page"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="page.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-list"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Pages</span>
					</span>
				</span>
			</a>
		</li>-->

		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="page"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-list"></i><span class="m-menu__link-text">Pages</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Pages</span></span></li>
					<li class="m-menu__item <?php if($file_name=="page" && ($_GET['p_type']=="system" || $_GET['p_type']=="")){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="page.php?p_type=system" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">System Pages</span></a></li>
					<li class="m-menu__item <?php if($file_name=="page" && $_GET['p_type']=="custom"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="page.php?p_type=custom" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Custom Pages</span></a></li>
				</ul>
			</div>
		</li>
		<?php
		}

		if($prms_menu_view == '1') { ?>
		<li class="m-menu__item <?php if($file_name=="menu"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="menu.php?position=header" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-list"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Menus</span>
					</span>
				</span>
			</a>
		</li>
		<?php
		} ?>

		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="staff" || $file_name=="staff_group"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-users-cog"></i><span class="m-menu__link-text">Staffs</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Staffs</span></span></li>
					<li class="m-menu__item <?php if($file_name=="staff"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="staff.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Staffs</span></a></li>
					<li class="m-menu__item <?php if($file_name=="staff_group"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="staff_group.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Staff Groups</span></a></li>
				</ul>
			</div>
		</li>

		<li class="m-menu__item <?php if($file_name=="location"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="location.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-map-marker"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Locations</span>
					</span>
				</span>
			</a>
		</li>
		
		<li class="m-menu__item <?php if($file_name=="promocode"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="promocode.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-tags"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Promo Codes</span>
					</span>
				</span>
			</a>
		</li>
		
		<li class="m-menu__item <?php if($file_name=="email_template"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="email_templates.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-share"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Email Templates</span>
					</span>
				</span>
			</a>
		</li>

		<!--<li class="m-menu__item <?php if($file_name=="faqs"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="faqs.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-question"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Faqs</span>
					</span>
				</span>
			</a>
		</li>-->

		<li class="m-menu__item <?php if($file_name=="service"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="service.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-list"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Services</span>
					</span>
				</span>
			</a>
		</li>
		
		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="faqs" || $file_name=="faqs_groups"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-question"></i><span class="m-menu__link-text">Faqs</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Faqs</span></span></li>
					<li class="m-menu__item <?php if($file_name=="faqs"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="faqs.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Faqs</span></a></li>
					<li class="m-menu__item <?php if($file_name=="faqs_groups"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="faqs_groups.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Faqs Groups</span></a></li>
				</ul>
			</div>
		</li>
		<?php
		if($show_fault_prices == '1') { ?>
		<li class="m-menu__item <?php if($file_name=="fault_list"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
			<a href="fault_list.php" class="m-menu__link ">
				<i class="m-menu__link-icon fa fa-users"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap"> 
						<span class="m-menu__link-text">Fault Price Management</span>
					</span>
				</span>
			</a>
		</li>
		<?php
		} ?>
		<!--<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="promocode" || $file_name=="email_template" || $file_name=="appointment_status" || $file_name=="appt_ticket_status" || $file_name=="faqs" || $file_name=="location"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-list"></i><span class="m-menu__link-text">More</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">More</span></span></li>
					<li class="m-menu__item <?php if($file_name=="location"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="location.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Locations</span></a></li>
					<li class="m-menu__item <?php if($file_name=="promocode"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="promocode.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Promo Codes</span></a></li>
					<li class="m-menu__item <?php if($file_name=="email_template"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="email_templates.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Email Templates</span></a></li>
					<li class="m-menu__item <?php if($file_name=="appointment_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="appointment_status.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Order Status</span></a></li>
					<li class="m-menu__item <?php if($file_name=="appt_ticket_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="appt_ticket_status.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Ticket Status</span></a></li>
					<li class="m-menu__item <?php if($file_name=="faqs"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="faqs.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Faqs</span></a></li>
				</ul>
			</div>
		</li>-->

		<?php
		$type = isset($post['type'])?$post['type']:''; ?>
		<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="general_settings" || $file_name=="appointment_status" || $file_name=="appt_ticket_status" || $file_name=="home_settings"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-cog"></i><span class="m-menu__link-text">Settings</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Settings</span></span></li>
					<li class="m-menu__item <?php if($type=="general"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=general" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">General Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="company"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=company" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Company Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="email"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=email" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Email Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="socials"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=socials" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Socials Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="sms"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=sms" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">SMS Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="appointment"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=appointment" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Appointment Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="blog"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=blog" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Blog Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="captcha"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=captcha" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Captcha Settings</span></a></li>
					<li class="m-menu__item <?php if($file_name=="home_settings"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="home_settings.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Home Page Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="sitemap"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=sitemap" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sitemap (XML)</span></a></li>
					<li class="m-menu__item <?php if($type=="ticket"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=ticket" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Ticket Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="menutype"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=menutype" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Menu Type Settings</span></a></li>
					<li class="m-menu__item <?php if($type=="payment_method"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=payment_method" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Payment Method</span></a></li>
					<li class="m-menu__item <?php if($type=="payment_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=payment_status" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Payment Status</span></a></li>
					<li class="m-menu__item <?php if($type=="testimonial"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=testimonial" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Testimonial</span></a></li>
					<li class="m-menu__item <?php if($type=="recently_ordered"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=recently_ordered" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Recently Ordered</span></a></li>
					<li class="m-menu__item <?php if($file_name=="appointment_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="appointment_status.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Order Status</span></a></li>
					<li class="m-menu__item <?php if($file_name=="appt_ticket_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="appt_ticket_status.php" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Ticket Status</span></a></li>
					<li class="m-menu__item <?php if($type=="shipping_api"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=shipping_api" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Shipping API</span></a></li>
					<li class="m-menu__item <?php if($type=="model_fields"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=model_fields" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Model Fields</span></a></li>
                    <li class="m-menu__item <?php if($type=="payment"){echo 'm-menu__item--active';}?>" aria-haspopup="true"><a href="settings.php?type=payment" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Payment</span></a></li>	
				</ul>
			</div>
		</li>

	</ul>
</div>