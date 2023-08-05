<?php
$custom_phpjs_path = "assets/js/custom/device.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Device':'Add Device')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Device':'Add Device')?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
			<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
				<div class="m-alert__icon">
					<i class="flaticon-info m--font-primary"></i>
				</div>
				<div class="m-alert__text">
					You can use this shortcode in pages for display models based on device ID<br />
					[models]place device ID as comma saparate[/models]  like [models]3,2[/models]
				</div>
			</div>
					
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
										<?=($id?'Edit Device':'Add Device')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/device.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body m--padding-top-10">
								<?php /*?><div class="form-group m-form__group m--margin-top-10">
									<div class="alert m-alert m-alert--default" role="alert">
										You can use this shortcode in pages for display models based on device ID<br />
										[models]place device ID as comma saparate[/models]  like [models]3,2[/models]
									</div>
								</div><?php */?>
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<?php /*?><div class="col-lg-4">
										<label for="exampleSelect1">Select Brand</label>
										<select class="form-control m-input" name="brand_id" id="brand_id">
											<option value="">Select</option>
											<?php
											while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
												<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$device_data['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
											<?php
											} ?>
										</select>
									</div><?php */?>
									<div class="col-lg-6">
										<label for="title">Title</label>
										<input type="text" class="form-control m-input m-input--square" id="title" value="<?=$device_data['title']?>" name="title">
									</div>
								
									<div class="col-lg-6">
										<label for="sef_url">Sef Url</label>
										<input type="text" class="form-control m-input m-input--square" id="sef_url" value="<?=$device_data['sef_url']?>" name="sef_url">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<?php /*?><div class="col-lg-6">
										<label for="missing_product_url">Missing Product Url</label>
										<input type="text" class="form-control m-input m-input--square" id="missing_product_url" value="<?=$device_data['missing_product_url']?>" name="missing_product_url">
									</div>
									<div class="col-lg-6"><?php */?>
										<label for="meta_title">Meta Title</label>
										<input type="text" class="form-control m-input m-input--square" id="meta_title" value="<?=$device_data['meta_title']?>" name="meta_title">
									<?php /*?></div><?php */?>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="meta_desc">Meta Description</label>
										<textarea class="form-control m-input m-input--square" name="meta_desc" rows="3"><?=$device_data['meta_desc']?></textarea>
									</div>
									<div class="col-lg-6">
										<label for="meta_keywords">Meta Keywords</label>
										<textarea class="form-control m-input m-input--square" name="meta_keywords" rows="3"><?=$device_data['meta_keywords']?></textarea>
									</div>
								</div>
								<div class="form-group m-form__group ">
									<label for="meta_canonical_url">Meta Canonical URL</label>
									<input type="text" class="form-control m-input m-input--square" id="meta_canonical_url" value="<?=$device_data['meta_canonical_url']?>" name="meta_canonical_url">
								</div>
									
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="title">Icon</label>
										<input type="file" class="form-control m-input m-input--square" id="device_img" name="device_img" onChange="checkFile(this);" accept="image/*">
										<?php 
										if($device_data['device_img']!="") { ?>
											<br />
											<img src="../images/device/<?=$device_data['device_img']?>" width="100">
											<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$device_data['id']?>','<?=$device_data['id']?>')"><i class="la la-trash"></i> Remove</a>
											<input type="hidden" id="old_image" name="old_image" value="<?=$device_data['device_img']?>">
										<?php 
										} ?>
									</div>
									<div class="col-lg-6">
										<label for="title">Header Image</label>
										<input type="file" class="form-control m-input m-input--square" id="header_img" name="header_img" onChange="checkFile(this);" accept="image/*">
										<?php 
										if($device_data['header_img']!="") { ?>
											<br />
											<img src="../images/device/<?=$device_data['header_img']?>" width="100">
											<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeHeaderImage('<?=$device_data['id']?>','<?=$device_data['id']?>')"><i class="la la-trash"></i> Remove</a>
											<input type="hidden" id="old_h_image" name="old_h_image" value="<?=$device_data['header_img']?>">
										<?php 
										} ?>
									</div>
								</div>

								<div class="form-group m-form__group">
									<label for="sub_title">Sub Title</label>
									<textarea class="sub_title" id="sub_title" name="sub_title"><?=$device_data['sub_title']?></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label>Description</label>
									<textarea class="description" id="description" name="description"><?=$device_data['description']?></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label>Long Description</label>
									<textarea class="long_description" id="long_description" name="long_description"><?=$device_data['long_description']?></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label for="missing_product_url">Check if device is popular, popular device appear in popular section.</label>
									<div>
										<span class="m-switch m-switch--icon m-switch--primary">
											<label>
												<input id="popular_device" type="checkbox" value="1" name="popular_device" <?php if($device_data['popular_device']=='1'){echo 'checked="checked"';}?>>
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($device_data['published']==1||$device_data['published']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
									<a href="device.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$device_data['id']?>" />
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
