<?php
$custom_phpjs_path = "assets/js/custom/brand.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Brand':'Add Brand')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="#" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Brand':'Add Brand')?></span>
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
										<?=($id?'Edit Brand':'Add Brand')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/brand.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="title">Title</label>
										<input type="text" class="form-control m-input m-input--square" id="title" value="<?=$brand_data['title']?>" name="title">
									</div>
									<div class="col-lg-6">
										<label for="sef_url">Sef Url</label>
										<input type="text" class="form-control m-input m-input--square" id="sef_url" value="<?=$brand_data['sef_url']?>" name="sef_url">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="meta_title">Meta Title</label>
									<input type="text" class="form-control m-input m-input--square" id="meta_title" value="<?=$brand_data['meta_title']?>" name="meta_title">
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="meta_desc">Meta Description</label>
										<textarea class="form-control m-input m-input--square" name="meta_desc" rows="3"><?=$brand_data['meta_desc']?></textarea>
									</div>
									<div class="col-lg-6">
										<label for="meta_keywords">Meta Keywords</label>
										<textarea class="form-control m-input m-input--square" name="meta_keywords" rows="3"><?=$brand_data['meta_keywords']?></textarea>
									</div>
								</div>
								<div class="form-group m-form__group ">
									<label for="meta_canonical_url">Meta Canonical URL</label>
									<input type="text" class="form-control m-input m-input--square" id="meta_canonical_url" value="<?=$brand_data['meta_canonical_url']?>" name="meta_canonical_url">
								</div>
								
								<div class="form-group m-form__group">
									<label for="title">Icon</label>
									<input type="file" class="form-control m-input m-input--square" id="image" name="image" onChange="checkFile(this);" accept="image/*">
									<?php 
									if($brand_data['image']!="") { ?>
										<br />
										<img src="../images/brand/<?=$brand_data['image']?>" width="150">
										<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$brand_data['id']?>','<?=$brand_data['id']?>')"><i class="la la-trash"></i> Remove</a>
										<input type="hidden" id="old_image" name="old_image" value="<?=$brand_data['image']?>">
									<?php 
									} ?>
								</div>
								
								<div class="form-group m-form__group">
									<label for="sub_title">Sub Title</label>
									<textarea class="sub_title" id="sub_title" name="sub_title"><?=$brand_data['sub_title']?></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label>Description</label>
									
									<textarea class="description" id="description" name="description"><?=$brand_data['description']?></textarea>
								</div>
								
								<div class="form-group m-form__group">
									<label>Long Description</label>
									<textarea class="long_description" id="long_description" name="long_description"><?=$brand_data['long_description']?></textarea>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($brand_data['published']==1||$brand_data['published']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
									<a href="brand.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$brand_data['id']?>" />
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
