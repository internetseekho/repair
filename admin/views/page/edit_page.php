<?php
$custom_phpjs_path = "assets/js/custom/page.php";

$edit_pg_label = 'Edit '.ucfirst($p_type).' Page';
$add_pg_label = 'Add '.ucfirst($p_type).' Page'; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?$edit_pg_label:$add_pg_label)?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?$edit_pg_label:$add_pg_label)?></span>
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
										<?=($id?$edit_pg_label:$add_pg_label)?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/page.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<?php
								if(!in_array($post['slug'],array("home"))) { ?>
									<div class="m-form__group form-group">
										<label for="">&nbsp;</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="cats_in_menu" value="cat" name="catsbrands_in_menu" class="catsbrands_in_menu" <?=($page_data['cats_in_menu']=='1'?'checked="checked"':'')?>> Categories In Submenu
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="brands_in_menu" value="brand" name="catsbrands_in_menu" class="catsbrands_in_menu" <?=($page_data['brands_in_menu']=='1'?'checked="checked"':'')?>> Brands In Submenu
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="devices_in_menu" value="device" name="catsbrands_in_menu" class="catsbrands_in_menu" <?=($page_data['devices_in_menu']=='1'?'checked="checked"':'')?>> Devices In Submenu
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" value="none" name="catsbrands_in_menu" class="catsbrands_in_menu" <?=($page_data['cats_in_menu']!='1'&&$page_data['brands_in_menu']!='1'&&$page_data['devices_in_menu']!='1'?'checked="checked"':'')?>> None
												<span></span>
											</label>
										</div>
									</div>
									
									<div class="form-group m-form__group device_section_for_device_menu" <?=($page_data['devices_in_menu']=='1'?'style="display:block;"':'style="display:none;"')?>>
										<label for="fltr_devices_in_menu">Select Device</label>
										<select class="form-control select2 m_select2" name="fltr_devices_in_menu[]" id="fltr_devices_in_menu[]" multiple>
											<?php
											$fltr_arr_device_id = explode(",",$page_data['fltr_devices_in_menu']);
											foreach($devices_list_arr as $device_data) { ?>
												<option value="<?=$device_data['id']?>" <?php if(in_array($device_data['id'],$fltr_arr_device_id)){echo 'selected="selected"';}?>><?=$device_data['title']?></option>
											<?php
											} ?>
										</select>
									</div>
									
									<div class="form-group m-form__group category_section" <?=($page_data['cats_in_menu']=='1'||$page_data['brands_in_menu']=='1'||$page_data['devices_in_menu']=='1'?'style="display:none;"':'style="display:block;"')?>>
										<label for="page_id">Select Category</label>
										<select class="form-control select2 m_select2" name="cat_id" id="cat_id">
											<option value=""> -Select- </option>
											<?php
											//Fetch device list
											$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
											while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
												<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$page_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
											<?php
											} ?>
										</select>
									</div>
									<div class="form-group m-form__group brand_section" <?=($page_data['cats_in_menu']=='1'||$page_data['brands_in_menu']=='1'||$page_data['devices_in_menu']=='1'?'style="display:none;"':'style="display:block;"')?>>
										<label for="brand_id">Select Brand</label>
										<select class="form-control select2 m_select2" name="brand_id" id="brand_id">
											<option value=""> -Select- </option>
											<?php
											//Fetch brand list
											$brands_q=mysqli_query($db,'SELECT * FROM brand WHERE published=1');
											while($brands_list=mysqli_fetch_assoc($brands_q)) { ?>
												<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$page_data['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
											<?php
											} ?>
										</select>
										<div class="m-checkbox-inline m--margin-top-5">
											<label class="m-checkbox">
											<input type="checkbox" id="devices_in_submenu" value="1" name="devices_in_submenu" <?=($page_data['devices_in_submenu']=='1'?'checked="checked"':'')?>> Devices In Submenu <span></span>
											</label>
											<span class="models_in_menu">
											<label class="m-checkbox">
											<input type="checkbox" id="models_in_menu" value="1" name="models_in_menu" <?=($page_data['models_in_menu']=='1'?'checked="checked"':'')?>> Models In Submenu <span></span>
											</label>
											</span>
										</div>
									</div>
									
									<div class="form-group m-form__group device_section" <?=($page_data['cats_in_menu']=='1'||$page_data['brands_in_menu']=='1'||$page_data['devices_in_menu']=='1'?'style="display:none;"':'style="display:block;"')?>>
										<label for="device_id">Select Device</label>
										<select class="form-control select2 m_select2" name="device_id[]" id="device_id[]" onchange="changedevice(this.value);" multiple>
											<!--<option value=""> -Select- </option>-->
											<?php
											$arr_device_id = explode(",",$page_data['device_id']);
											foreach($devices_list_arr as $device__data) { ?>
												<option value="<?=$device__data['id']?>" <?php if(in_array($device__data['id'],$arr_device_id)){echo 'selected="selected"';}?>><?=$device__data['title']?></option>
											<?php
											} ?>
										</select>
									</div>
								<?php
								} ?>
								
								<div class="form-group m-form__group">
									<label for="title">Title</label>
									<input type="text" class="form-control m-input m-input--square" id="title" value="<?=($title?$title:$inbuild_page_data['title'])?>" name="title">
									<div class="m-checkbox-inline m--margin-top-5">
										<label class="m-checkbox">
										<input type="checkbox" id="show_title" value="1" name="show_title" <?=($page_data['show_title']=='1'?'checked="checked"':'')?>> Show Title <span></span>
										</label>
									</div>
								</div>
								
								<?php
								if(!in_array($post['slug'],array("home"))) { ?>
								<div class="form-group m-form__group">
									<label for="is_custom_url">Url</label>
									<input type="text" class="form-control m-input m-input--square" id="url" value="<?=$finl_url?>" name="url">
									<?php /*?><div class="m-checkbox-inline m--margin-top-5">
										<label class="m-checkbox">
										<input type="checkbox" id="is_custom_url" value="1" name="is_custom_url" <?=($page_data['is_custom_url']=='1'?'checked="checked"':'')?>> Custom Url <span></span>
										</label>
										<label class="m-checkbox">
										<input type="checkbox" id="is_open_new_window" value="1" name="is_open_new_window" <?=($page_data['is_open_new_window']=='1'?'checked="checked"':'')?>> Is Open New Window <span></span>
										</label>
									</div><?php */?>
								</div>
								<?php
								} ?>
								
								<div class="form-group m-form__group">
									<label for="meta_title">Meta Title</label>
									<input type="text" class="form-control m-input m-input--square" id="meta_title" value="<?=$page_data['meta_title']?>" name="meta_title">
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="meta_desc">Meta Description</label>
										<textarea class="form-control m-input m-input--square" name="meta_desc" rows="3"><?=$page_data['meta_desc']?></textarea>
									</div>
									<div class="col-lg-6">
										<label for="meta_keywords">Meta Keywords</label>
										<textarea class="form-control m-input m-input--square" name="meta_keywords" rows="3"><?=$page_data['meta_keywords']?></textarea>
									</div>
								</div>
								<div class="form-group m-form__group ">
									<label for="meta_canonical_url">Meta Canonical URL</label>
									<input type="text" class="form-control m-input m-input--square" id="meta_canonical_url" value="<?=$page_data['meta_canonical_url']?>" name="meta_canonical_url">
								</div>
								
								<?php
								//,'contact'
								$slug_desc_not_show_array = array('blog','terms-and-conditions');
								if(!in_array($post['slug'],$slug_desc_not_show_array)) { ?>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								<div class="form-group m-form__group">
									<div class="m-checkbox-list">
										<label class="m-checkbox">
											<input type="checkbox" id="header_section" value="1" name="header_section" <?=($page_data['header_section']=='1'?'checked="checked"':'')?>>
											Page Header
											<span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="image">Header Image</label>
										<div class="custom-file">
											<input type="file" class="form-control m-input m-input--square" id="image" name="image" onChange="checkFile(this);" accept="image/*">
										</div>
										<?php 
										if($page_data['image']!="") { ?>
											<img class="m--margin-top-10 img-container" src="../images/pages/<?=$page_data['image']?>" width="100">
											<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeImage('<?=$page_data['id']?>','<?=$page_data['id']?>')"><i class="la la-trash"></i> Remove</a>
											<input type="hidden" id="old_image" name="old_image" value="<?=$page_data['image']?>">
										<?php 
										} ?>
									</div>
									
									<div class="col-lg-6">
										<label for="image_text">Header Image Text</label>
										<input type="text" class="form-control m-input m-input--square" id="image_text" value="<?=$page_data['image_text']?>" name="image_text">
									</div>
								</div>
								
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								<div class="form-group m-form__group">
									<label for="description">Description</label>
									<textarea class="description" name="description" rows="3"><?=$page_data['content']?></textarea>
								</div>
								<?php
								} ?>
								
								<?php
								if(!in_array($page_data['slug'],array("home"))) { ?>
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($page_data['published']==1||$page_data['published']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
								<?php
								} else {
									echo '<input name="published" type="hidden" value="1">';
								} ?>	
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="add_edit"><?=($id?'Update':'Save')?></button>
									<a href="page.php?p_type=<?=$p_type?>" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$page_data['id']?>" />
							<input type="hidden" name="slug" value="<?=$post['slug']?>" />
							<input type="hidden" name="p_type" value="<?=$post['p_type']?>" />
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
