<?php
$custom_phpjs_path = "assets/js/custom/review.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Review':'Add Review')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Review':'Add Review')?></span>
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
										<?=($id?'Edit Review':'Add Review')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/review.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="name">Name</label>
										<input type="text" class="form-control m-input m-input--square" name="name" id="name" value="<?=$review_data['name']?>">
									</div>
								
									<div class="col-lg-6">
										<label for="email">Email</label>
										<input type="email" class="form-control m-input m-input--square" name="email" id="email" value="<?=$review_data['email']?>">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="stars">Rating Star</label>
										<select name="stars" id="stars" class="form-control">
											<option value=""> - Rating Star - </option>
											<?php
											for($si = 0.5; $si<= 5.0; $si=$si+0.5) { ?>
												<option value="<?=$si?>" <?php if($si==$review_data['stars']){echo 'selected="selected"';}?>><?=$si?></option>
											<?php
											} ?>
										</select>
									</div>
									
									<div class="col-lg-4">
										<label for="state">State</label>
										<input type="text" class="form-control m-input m-input--square" name="state" id="state" value="<?=$review_data['state']?>">
									</div>
								
									<div class="col-lg-4">
										<label for="city">City</label>
										<input type="text" class="form-control m-input m-input--square" name="city" id="city" value="<?=$review_data['city']?>">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="title">Title</label>
									<input type="text" class="form-control m-input m-input--square" name="title" id="title" value="<?=$review_data['title']?>">
								</div>
								<div class="form-group m-form__group">
									<label for="sef_url">Content</label>
									<textarea class="description" name="content"><?=$review_data['content']?></textarea>
								</div>
								
								<div class="form-group m-form__group row">
									<label for="date">Date</label>
									<input type="text" class="form-control m-input m-input--square" id="m_datepicker_1" name="date" placeholder="Select date (mm/dd/yyyy)" value="<?=($review_data['date']!='0000-00-00 00:00:00' && $review_data['date']!=''?date('m/d/Y',strtotime($review_data['date'])):'')?>">
								</div>
								
								<div class="form-group m-form__group">
									<label for="image">Image</label>
									<input type="file" class="form-control m-input m-input--square" id="image" name="image" onChange="checkFile(this);" accept="image/*">
								</div>
								<div class="form-group m-form__group">
									<label for="image">&nbsp;</label>
									<?php 
									if($review_data['photo']!="") { ?>
										<img src="../images/review/<?=$review_data['photo']?>" width="150">
										<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$review_data['id']?>','<?=$review_data['id']?>')"><i class="la la-trash"></i> Remove</a>
										<input type="hidden" id="old_image" name="old_image" value="<?=$review_data['photo']?>">
									<?php 
									} ?>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($review_data['status']==1||$review_data['status']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_edit_form_submit" type="submit" class="btn btn-primary" name="add_update"><?=($id?'Update':'Save')?></button>
									<a href="review.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$review_data['id']?>" />
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
