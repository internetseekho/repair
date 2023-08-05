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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Menu':'Add Menu')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Menu':'Add Menu')?></span>
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
										<?=($id?'Edit Menu':'Add Menu')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/menu.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="page_id">Select Page</label>
										<select class="form-control m-input" name="page_id" id="page_id" onchange="SelectPage(this.value)">
											<option value=""> -Select- </option>
											<?php
											//Fetch page list
											$pages_data=mysqli_query($db,'SELECT * FROM pages WHERE published=1');
											while($pages_list=mysqli_fetch_assoc($pages_data)) { ?>
												<option value="<?=$pages_list['id']?>" <?php if($pages_list['id']==$menu_data['page_id']){echo 'selected="selected"';}?>><?=$pages_list['title']?></option>
											<?php
											} ?>
										</select>
									</div>
									<div class="col-lg-6">
										<label for="title">Name</label>
										<input type="text" class="form-control m-input m-input--square" id="menu_name" value="<?=$menu_data['menu_name']?>" name="menu_name">
									</div>
								</div>
								<div class="form-group m-form__group showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
									<label for="title">Url</label>
									<input type="text" class="form-control m-input m-input--square" id="url" value="<?=$menu_data['url']?>" name="url">
									<?php /*?><div class="m-checkbox-inline m--margin-top-5">
										<label class="m-checkbox">
											<input type="checkbox" id="is_custom_url" value="1" name="is_custom_url" <?=($menu_data['is_custom_url']=='1'?'checked="checked"':'')?>> Custom Url
											<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" id="is_open_new_window" value="1" name="is_open_new_window" <?=($menu_data['is_open_new_window']=='1'?'checked="checked"':'')?>> Is Open New Window
											<span></span>
										</label>
									</div><?php */?>
								</div>
								<div class="form-group m-form__group">
									<div class="m-checkbox-inline m--margin-top-5">
										<label class="m-checkbox showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
											<input type="checkbox" id="is_custom_url" value="1" name="is_custom_url" <?=($menu_data['is_custom_url']=='1'?'checked="checked"':'')?>> Custom Url
											<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" id="is_open_new_window" value="1" name="is_open_new_window" <?=($menu_data['is_open_new_window']=='1'?'checked="checked"':'')?>> Is Open New Window
											<span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="title">Custom CSS Class</label>
										<input type="text" class="form-control m-input m-input--square" id="css_menu_class" value="<?=$menu_data['css_menu_class']?>" name="css_menu_class">
									</div>
									<div class="col-lg-6">
										<label for="title">Custom CSS Fa Icon</label>
										<input type="text" class="form-control m-input m-input--square" id="css_menu_fa_icon" value="<?=$menu_data['css_menu_fa_icon']?>" name="css_menu_fa_icon">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="title">Parent Menu</label>
										<select name="parent" id="parent" class="form-control m-input">
											<option value=""> -Select- </option>
											
											<?php
											$main_menu_list = get_menu_list($menu_position);
											if(!empty($main_menu_list)) {
												//START for main menu
												foreach($main_menu_list as $main_menu_data) { ?>
													<option value="<?=$main_menu_data['id']?>" <?php if($main_menu_data['id']==$menu_data['parent']){echo 'selected="selected"';}?>><?=$main_menu_data['menu_name']?></option>
														<?php
														//START for submenu of main menu		
														if(count($main_menu_data['submenu'])>0) {
															$submenu_list = $main_menu_data['submenu'];
															  foreach($submenu_list as $submenu_data) { ?>
																  <option value="<?=$submenu_data['id']?>" <?php if($submenu_data['id']==$menu_data['parent']){echo 'selected="selected"';}?> disabled="disabled"><?=str_repeat('&nbsp;', 5).' - '.$submenu_data['menu_name']?></option>
																	<?php
																	/*//START for submenu of submenu of main menu
																	if(count($submenu_data['submenu'])>0) {
																		$sub_sub_menu_list = $submenu_data['submenu'];
																		  foreach($sub_sub_menu_list as $sub_sub_menu_data) { ?>
																			  <option value="<?=$sub_sub_menu_data['id']?>" <?php if($sub_sub_menu_data['id']==$menu_data['parent']){echo 'selected="selected"';}?> disabled="disabled"><?=str_repeat('&nbsp;', 10).' - '.$sub_sub_menu_data['menu_name']?></option>
																		  <?php
																		  }
																	} //END for submenu of submenu of main menu*/
															  }
														} //END for submenu of main menu
												} //END for main menu
											} ?>
												
											<?php
											//Fetch page list
											/*$pmenus_data=mysqli_query($db,"SELECT * FROM menus WHERE status=1 AND position='".$menu_position."'");
											while($parent_menus_list=mysqli_fetch_assoc($pmenus_data)) { ?>
												<option value="<?=$parent_menus_list['id']?>" <?php if($parent_menus_list['id']==$menu_data['parent']){echo 'selected="selected"';}?>><?=$parent_menus_list['menu_name']?></option>
											<?php
											}*/ ?>
										</select>
									</div>
									<div class="col-lg-6">
										<label for="title">Order (Must be numeric)</label>
										<input class="form-control m-input m-input--square" id="ordering" type="number" name="ordering" value="<?=$menu_data['ordering']?>">
									</div>
								</div>
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($menu_data['status']==1||$menu_data['status']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>	
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="add_edit"><?=($id?'Update':'Save')?></button>
									<a href="menu.php?position=<?=$menu_position?>" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$menu_data['id']?>" />
							<input type="hidden" name="position" value="<?=$menu_position?>" />
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
