<?php
$custom_phpjs_path = "assets/js/custom/email_template.php"; ?>

<script src="assets/js/jquery.copy.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#copy-constant").click(function() {
  	var constant_name = $("#constant_name").val();
	if(constant_name == "") {
		alert("Please select constant.");
		return false;
	} else {
   		var res = $.copy(constant_name);
    	//$("#status").text(res);
	}
  });
});
</script>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($template_data['id']?'Edit Email Template':'Add Email Template')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($template_data['id']?'Edit Email Template':'Add Email Template')?></span>
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
										<?=($template_data['id']?'Edit Email Template':'Add Email Template')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/email_template.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group">
									<label for="type">Template Type</label>
									<?php
									if($template_data['id']!="") { ?>
										<input type="text" class="form-control m-input m-input--square" id="type" value="<?=$template_type_array[$template_data['type']]?>" readonly="" />
									<?php 
									} else{ ?>
										<select class="form-control m-input" name="type" id="type">
											<option value="">Select Template Type</option>
											<?php
											foreach($template_type_final_array as $template_type_key=>$template_type_value) {
												echo '<option value="'.$template_type_key.'">'.$template_type_value.'</option>';
											} ?>
										</select>
									<?php 
									} ?>
								</div>
								
								<div class="form-group m-form__group">
									<label for="subject">Subject</label>
									<input type="text" class="form-control m-input m-input--square" id="subject" value="<?=$template_data['subject']?>" name="subject">
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
									  <label for="constant_name">Copy</label>
									  <select class="form-control m-input" name="constant_name" id="constant_name">
										 <option value="">Select Constant to Copy</option>
										 <?php 
										 foreach($constants_array as $constants_value) { ?>
										 	<option value="<?=$constants_value?>"><?=$constants_value?></option>
										 <?php 
										 } ?>
									  </select>
									 </div>
									 <div class="col-lg-4 m--padding-top-25">
									 	<input type="button" class="btn btn-alt btn-md btn-primary" id="copy-constant" style="cursor:pointer;" value="COPY">
									 </div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="content">Email Content</label>
									<textarea class="description" id="text_editor" name="content"><?=$template_data['content']?></textarea>
								</div>
								
								<?php
								if(in_array($template_data['type'],$sms_sec_show_in_tmpl_array)) { ?>		
								<div class="m-form__group form-group">
									<label for="">SMS Section</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" id="published_1" name="sms_status" value="1" <?=($template_data['sms_status']==1 || $template_data['sms_status']==''?'checked="checked"':'')?>> Active
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" id="published_0" name="sms_status" value="0" <?=($template_data['sms_status']=='0'?'checked="checked"':'')?>> Inactive
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label>SMS Content</label>
									<textarea class="form-control m-input m-input--square" id="sms_content" name="sms_content" rows="5"><?=$template_data['sms_content']?></textarea>
								</div>
								<?php
								} ?>
									
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($template_data['status']==1?'checked="checked"':'')?> value="1">
									</div>
								</div>
									
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="update">Submit</button>
									<a href="email_templates.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$template_data['id']?>" />
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
