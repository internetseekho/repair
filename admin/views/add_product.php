<?php
$custom_phpjs_path = "assets/js/custom/add_edit_mobile.php";

if($tooltips_of_model_fields == '0') {
	echo '<style>.tooltips_hide{display:none;}</style>';
}
if($icons_of_model_fields == '0') {
	echo '<style>.icons_hide{display:none;}</style>';
} ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit '.$row_pro['title'].'':'Add Product')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Product':'Add Product')?></span>
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
										<?=($id?'Edit':'Add Product')?>
									</h3>
								</div>
							</div>
						</div>
						
						<div class="m-portlet__body">
							<div class="m-form__content">
								<?php include('confirm_message.php'); ?>
							</div>
							
							<!--begin::Form-->
							<form id="form_step_1" class="m-form m-form--fit m-form--label-align-right" action="action.php" method="post" enctype="multipart/form-data">
								<ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link <?=($step_track=='1'||$step_track==''?'active':'')?>" data-toggle="tab" href="#m_tabs_general" role="tab" id="general_tab">
											<i class="la la-home"></i> General
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link <?=($step_track=='2'?'active':'')?>" data-toggle="tab" href="#m_tabs_fields" role="tab" id="add_fields_tabs">
											<i class="fa fa-list"></i> Questions
										</a>
									</li>
									<?php
									if($show_fault_prices == '1') { ?>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link <?=($step_track=='3'?'active':'')?>" data-toggle="tab" href="#m_fault_price" role="tab" id="fault_price_tabs">
											<i class="fa fa-list"></i> Fault Prices
										</a>
									</li>
									<?php
									} ?>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link <?=($step_track=='4'?'active':'')?>" data-toggle="tab" href="#m_description" role="tab" id="fault_description_tabs">
											<i class="fa fa-info"></i> Description
										</a>
									</li>
								</ul>
								<div class="tab-content">
									
									<div class="tab-pane <?=($step_track=='4'?'active':'')?>" id="m_description" role="tabpanel">
										<div class="form-group">
											<label for="heading_text">Heading Text (H1 Title)</label>
											<input type="text" class="form-control m-input m-input--square" id="heading_text" value="<?=$row_pro['heading_text']?>" name="heading_text">
										</div>
										<div class="form-group">
											<label for="description">Description</label>
											<textarea class="description" name="description" rows="5"><?=$row_pro['description']?></textarea>
										</div>
										
										<div class="form-group">
											<input type="hidden" name="action" value="add_products">
											<input type="hidden" name="step" value="4">
											<input type="hidden" name="user_id" value="0">
											<input type="hidden" name="id" value="<?=$id;?>">
											<input type="submit" id="m_form_submit4" class="btn btn-primary" value="Save" onclick="StepTrack(4)">
											<a href="mobile.php" class="btn btn-secondary">Back</a>
										</div>
										
									</div>
									
									<div class="tab-pane <?=($step_track=='3'?'active':'')?>" id="m_fault_price" role="tabpanel">
										<div class="form-group">
											<table class="table m-table m-table--head-bg-brand" id="tab_logic">
												<thead>
												  <tr>
													<th><small>Device fault *</small></th>
													<th><small>Regular Price (<?=$currency_symbol?>) *</small></th>
													<th><small>On offer</small></th>
													<th><small>Sale Price (<?=$currency_symbol?>) *</small></th>
													<th><small>Offer Start Date</small></th>
													<th><small>Offer End Date</small></th>
													<!--<th>Image</th>-->
													<th><small>Action</small></th>
												  </tr>
												</thead>
												<tbody>
												  <?php
												  $product_item_k = 0;
												  if(empty($model_fault_price_list)) { ?>
												  <tr id='addr0'>
													<td>
														<div class="form-group">
															<input type="text" name='fault_name[]' placeholder='Name' class="form-control m-input m-input--square" style="width:150px;"/>
															<input type="hidden" name='fault_id[]'/>
														</div>
													</td>
													<td>
														<div class="form-group">
															<input type="number" name='regular_price[]' placeholder='regular price' class="form-control m-input m-input--square" step="0.01" min="0" style="width:100px;"/>
														</div>
													</td>
													
													<td>
														<div class="form-group">
															<label class="m-checkbox">
																<input name="is_on_offer[]" value="1" type="checkbox">
																<span></span>
															 </label>
														</div>
													</td>
													
													<td>
														<div class="form-group">
															<input type="number" name='sale_price[]' placeholder='sale price' class="form-control m-input m-input--square" step="0.01" min="0" style="width:100px;"/>
														</div>
													</td>
													
													<td>
														<div class="form-group">
															<input type="text" name='offer_start_date[]' class="form-control m-input m-input--square datepicker" readonly="" style="width:90px;"/>
														</div>
													</td>
													
													<td>
														<div class="form-group">
															<input type="text" name='offer_end_date[]' class="form-control m-input m-input--square datepicker" readonly="" style="width:90px;"/>
														</div>
													</td>
													
													<?php /*?><td>
														<div class="col-lg-10 form-group">
															<input type="file" name='photo[]' class="form-control m-input" accept="image/*"/>
														</div>
													</td><?php */?>
													
													<td>
														<a href="javascript:void(0);" id="deleter0" data-id="0" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill delete_per_row" data-fault_id=""><span><i class="la la-trash-o"></i><span>Delete</span></span></a>
													</td>
													
												  </tr>
												  <?php
												  } else {
													  foreach($model_fault_price_list as $product_item_k => $product_item_data) { ?>
													  <tr id='addr<?=$product_item_k?>'>
													  
														<td>
															<div class="form-group">
																<input type="text" name='fault_name[]' placeholder='Name' value="<?=$product_item_data['fault_name']?>" class="form-control m-input m-input--square" style="width:150px;"/>
																<input type="hidden" name='fault_id[]' value="<?=$product_item_data['id']?>"/>
															</div>
														</td>
														
														<td>
															<div class="form-group">
																<input type="number" name='regular_price[]' placeholder='regular price' class="form-control m-input m-input--square" step="0.01" min="0" value="<?=$product_item_data['regular_price']?>" style="width:100px;"/>
															</div>
														</td>
														
														<td>
															<div class="form-group">
																<label class="m-checkbox">
																	<input name="is_on_offer[]" value="1" type="checkbox"  <?=($product_item_data['is_on_offer']==1?'checked="checked"':'')?> >
																	<span></span>
																 </label>
															</div>
														</td>
														
														<td>
															<div class="form-group">
																<input type="number" name='sale_price[]' placeholder='sale price' class="form-control m-input m-input--square" step="0.01" min="0" value="<?=$product_item_data['sale_price']?>" style="width:100px;"/>
															</div>
														</td>
														
														<td>
															<div class="form-group">
																<input type="text" name='offer_start_date[]' class="form-control m-input m-input--square datepicker" value="<?=($product_item_data['offer_start_date']!=''?date('m/d/Y',strtotime($product_item_data['offer_start_date'])):'')?>" readonly="" style="width:90px;"/>
															</div>
														</td>
														
														<td>
															<div class="form-group">
																<input type="text" name='offer_end_date[]' class="form-control m-input m-input--square datepicker" value="<?=($product_item_data['offer_end_date']!=''?date('m/d/Y',strtotime($product_item_data['offer_end_date'])):'')?>" readonly="" style="width:90px;"/>
															</div>
														</td>
														
														<?php /*?><td>
															<div class="col-lg-10 form-group">
																<input type="file" name='photo[]' class="form-control m-input" accept="image/*"/>
															</div>
															
															<?php 
															if($product_item_data['photo']!="") { ?>
															<div class="form-group m-form__group">
																<label for="image">&nbsp;</label>
																	<img src="../images/<?=$product_item_data['photo']?>" width="150">
																	<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$product_item_data['id']?>','<?=$product_item_data['id']?>')"><i class="la la-trash"></i> Remove</a>
																	<input type="hidden" id="old_image" name="old_image" value="<?=$product_item_data['image']?>">
															</div>
															<?php 
															} ?>
														</td><?php */?>
														
														<td>
															<a href="javascript:void(0);" id="deleter<?=$product_item_k?>" data-id="<?=$product_item_k?>" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill delete_per_row" data-fault_id="<?=$product_item_data['id']?>"><span><i class="la la-trash-o"></i><span>Delete</span></span></a>
														</td>
													  </tr>
													  <?php
													  }
												  } ?>
												  
												  <tr id='addr<?=($product_item_k+1)?>'></tr>
												</tbody>
											</table>
										</div>
										
										<div class="m-form__group form-group m--align-right m--padding-top-0 m--padding-bottom-0 m--padding-right-20">
											<div id="add_row" class="add_payment_method btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
												<span>
													<i class="la la-plus"></i>
													<span>Add Row</span>
												</span>
											</div>
										</div>
										
										<div class="form-group">
											<input type="hidden" name="action" value="add_products">
											<input type="hidden" name="step" value="3">
											<input type="hidden" name="user_id" value="0">
											<input type="hidden" name="id" value="<?=$id;?>">
											<input type="submit" id="m_form_submit" class="btn btn-primary" value="Save" onclick="StepTrack(3)">
											<input type="hidden" name="fault_fields_data_array" value="" id="fault_fields_data_array">
											<input type="hidden" name="deleted_fault_id_array" value="" id="deleted_fault_id_array">
											<a href="mobile.php" class="btn btn-secondary">Back</a>
										</div>		
									</div>
								
									<div class="tab-pane <?=($step_track=='1'||$step_track==''?'active':'')?>" id="m_tabs_general" role="tabpanel">
										
										<div class="form-group row">
											<div class="col-lg-4">
												<label for="device_id">Select Device</label>
												<select class="form-control m-input custom-select" name="device_id" id="device_id">
													<option value=""> - Select - </option>
													<?php
													//Fetch device list
													$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');
													while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
														<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$row_pro['device_id']){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
													<?php
													} ?>
												</select>
											</div>
											<div class="col-lg-4">
												<label for="brand_id">Select Brand</label>
												<select class="form-control m-input custom-select" name="brand_id" id="brand_id">
													<option value=""> - Select - </option>
													<?php
													//Fetch brand list
													$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');
													while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
														<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$row_pro['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
													<?php
													} ?>
												</select>
											</div>
											<div class="col-lg-4">
												<label for="cat_id">Select Category</label>
												<select class="form-control m-input custom-select" name="cat_id" id="cat_id">
													<option value=""> - Select - </option>
													<?php
													//Fetch device list
													$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
													while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
														<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$row_pro['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
													<?php
													} ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-6">
												<label for="title">Title</label>
												<input type="text" class="form-control m-input m-input--square" id="title" value="<?=$row_pro['title']?>" name="title">
											</div>
											<div class="col-lg-6">
												<label for="sef_url">Sef Url</label>
												<input type="text" class="form-control m-input m-input--square" id="sef_url" value="<?=$row_pro['sef_url']?>" name="sef_url">
                                                <small><a href="" target="_blank" id="apnd_url_slug_a" style="display:none;"><?=SITE_URL.$model_details_page_slug?><span id="apnd_url_slug"></span></a></small>
											</div>
										</div>
									
										<div class="form-group row">
											<div class="col-lg-4">
												<label for="models">Models</label>
												<input type="text" class="form-control m-input m-input--square" id="models" value="<?=$row_pro['models']?>" name="models">
											</div>
											<?php /*?><div class="col-lg-3">
												<label for="price">Base Price</label>
												<input type="number" class="form-control m-input m-input--square" id="price" value="<?=($row_pro['price']>0?$row_pro['price']:'')?>" name="price">
											</div><?php */?>
											<input type="hidden" id="price" value="0" name="price">
											<div class="col-lg-4">
												<label for="released_year_month">Released Year/Month</label>
												<?php
												$released_year_month = "";
												if($row_pro['released_year_month']!="") {
													$exp_released_year_month = explode("-",$row_pro['released_year_month']);
													$released_year_month = $exp_released_year_month['1'].'/'.$exp_released_year_month['0'];
												} ?>
												<input type="text" class="form-control m-input m-input--square" id="released_year_month" value="<?=$released_year_month?>" name="released_year_month">
											</div>
											<div class="col-lg-4">
												<label for="top_seller">Top Seller</label>
												<div class="m-checkbox-inline">
													<label class="m-checkbox">
														<input type="checkbox" id="top_seller" value="1" name="top_seller" <?php if($row_pro['top_seller']=='1'){echo 'checked="checked"';}?>>
														<span></span>
													</label>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label for="input">Searchable Words (Comma Separated)</label>
											<textarea class="form-control m-input m-input--square" name="searchable_words" rows="5"><?=$row_pro['searchable_words']?></textarea>
										</div>
										
										<?php
										if($tooltips_of_model_fields == '1') { ?>
										<div class="form-group">
											<label for="title">Tooltip of Device</label>
											<textarea class="tooltip_device" name="tooltip_device" rows="5"><?=$row_pro['tooltip_device']?></textarea>
										</div>
										<?php
										} ?>
										
										<div class="form-group row">
											<div class="col-lg-6">
												<label for="model_img">Model Image</label>
												<div class="custom-file">
												<label class="custom-file-label" for="model_img">Choose file</label>
												<input type="file" class="custom-file-input" id="model_img" name="model_img" onChange="checkFile(this);" accept="image/*">
												</div>
												<!-- <input type="file" class="form-control m-input m-input--square" id="model_img" name="model_img" onChange="checkFile(this);" accept="image/*"> -->
												<?php 
												if($row_pro['model_img']!="") { ?>
													<img class="m--margin-top-10" src="../images/mobile/<?=$row_pro['model_img']?>" width="100">
													<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$row_pro['id']?>','<?=$row_pro['id']?>')"><i class="la la-trash"></i> Remove</a>
													<input type="hidden" id="old_image" name="old_image" value="<?=$row_pro['model_img']?>">
												<?php 
												} ?>
											</div>
										</div>
									
										<div class="form-group ">
											<label for="title">Meta Title</label>
											<input type="text" class="form-control m-input m-input--square" id="meta_title" value="<?=$row_pro['meta_title']?>" name="meta_title">
										</div>
										<div class="form-group  row">
											<div class="col-lg-6">
												<label for="meta_desc">Meta Description</label>
												<textarea class="form-control m-input m-input--square" name="meta_desc" rows="3"><?=$row_pro['meta_desc']?></textarea>
											</div>
											<div class="col-lg-6">
												<label for="meta_keywords">Meta Keywords</label>
												<textarea class="form-control m-input m-input--square" name="meta_keywords" rows="3"><?=$row_pro['meta_keywords']?></textarea>
											</div>
										</div>
										<div class="form-group ">
											<label for="meta_canonical_url">Meta Canonical URL</label>
											<input type="text" class="form-control m-input m-input--square" id="meta_canonical_url" value="<?=$row_pro['meta_canonical_url']?>" name="meta_canonical_url">
										</div>
										
										<div class=" form-group">
											<label for="">Publish</label>
											<div>
												<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($row_pro['published']==1||$row_pro['published']==''?'checked="checked"':'')?> value="1">
											</div>
										</div>
										
										<div class=" form-group">
											<input type="button" class="btn btn-success" onclick="showOtherTab()" value="Next >> ">
											<?php
											if(isset($id) && $id!="") { ?>
												<input type="hidden" name="action" value="add_products">
												<input type="hidden" name="step" value="1">
												<input type="hidden" name="user_id" value="0">
												<input type="hidden" name="id" value="<?=$id;?>">
												<input type="submit" id="m_form_submit2" class="btn btn-primary" value="Save" onclick="StepTrack(1)">
											<?php
											} ?>
											<a href="mobile.php" class="btn btn-secondary">Back</a>
										</div>
												
									</div>
									
									<div class="tab-pane <?=($step_track=='2'?'active':'')?>" id="m_tabs_fields" role="tabpanel">
									
										<?php
										$no_of_fields = 0; ?>

										<script>
										function up_title(id) {
											if($("#title_"+id).val()!="") {
												$("#tab_title_"+id).html($("#title_"+id).val());
											}
										}
										</script>
	
										<div class=" form-group">
											<button type="button" class="btn btn-success" onclick="add_fields()"><i class="fa fa-plus"></i> Add More Fields</button> 
											<button type="button" class="btn btn-metal" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Choose From Fields Groups</button>
											<button type="button" class="btn btn-danger" onclick="del_current_tab()"><i class="la la-trash"></i> Delete Field</button>
										</div>

										<div class=" form-group row dd" id="nestable_list_3">
											<input name="sorting_order" id="sorting_order" value="" type="hidden" />
											<div class="col-lg-3">
												<ul class="nav nav-pills nav-pills--accent tablist" id="tab_titles" role="tablist">
													<?php
													if(isset($id) && $id!="") {
														$sql_cus_fld = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$row_pro['id']."' ORDER BY sort_order");
														$no_of_fields = mysqli_num_rows($sql_cus_fld);
														$fid=1;
														while($row_cus_fld = mysqli_fetch_assoc($sql_cus_fld)) {
															if(($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {
																continue;
															} ?>
															<li id="tab_<?=$fid?>" class="dd-item dd3-item nav-item" data-id="<?=$fid?>">
																<!-- <div class="dd-handle dd3-handle"> -->
																<div class="dd-handle-new">
																  <i class="fa fa-list"></i>
																</div>
																<!--<div class="dd3-content">-->
																	<a class="dd3-content nav-link <?php if($fid==1){echo "active";}?>" href="#field_<?=$fid?>" onclick="up_current_tab(<?=$fid?>)" data-toggle="tab"><span id="tab_title_<?=$fid?>"><?=$row_cus_fld['title']?></span></a>
																<!--</div>-->
															</li>
														<?php
														$fid++;
														}
													} ?>
												</ul>
											</div>
											
											<div class="col-lg-9 tab-content fields" id="tab_contents">	
											<?php
											if(isset($id) && $id!=""){
												$sql_cus_fld = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$row_pro['id']."' ORDER BY sort_order");
												$fid=1;
												while($row_cus_fld = mysqli_fetch_assoc($sql_cus_fld)) {
													if(($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {
														continue;
													} ?>
													<div class="tab-pane <?=($fid==1?"active":"")?>" id="field_<?=$fid;?>" role="tabpanel">
														<div class=" form-group row">
															<div class="col-sm-7">
																<label for="title_<?=$fid?>">Title *</label>
																<input name="field[<?=$fid?>][title]" required="" id="title_<?=$fid;?>" type="text" class="form-control m-input m-input--square" onkeyup="up_title('<?=$fid;?>')" onkeydown="up_title('<?=$fid;?>')" value="<?php echo $row_cus_fld['title']; ?>" />
															</div>
															<div class="col-sm-5">
																<label for="input_type_<?=$fid?>">Input Type *</label>
																<select name="field[<?=$fid?>][input_type]" id="input_type_<?=$fid?>" class="form-control m-input custom-select" data-style="btn-default" onchange="change_input_type('<?=$fid;?>')">
																	<?php
																	if($text_field_of_model_fields == '1') { ?>
																	<option <?php if($row_cus_fld['input_type']=="text"){ echo "selected"; } ?> value="text">Text Field</option>
																	<?php
																	}
																	if($text_area_of_model_fields == '1') { ?>
																	<option <?php if($row_cus_fld['input_type']=="textarea"){ echo "selected"; } ?> value="textarea">Text Area</option>
																	<?php
																	} ?>
																	<?php /*?><option <?php if($row_cus_fld['input_type']=="select"){ echo "selected"; } ?> value="select">Drop-down List</option><?php */?>
																	<option <?php if($row_cus_fld['input_type']=="radio"){ echo "selected"; } ?> value="radio">Radio Buttons</option>
																	<option <?php if($row_cus_fld['input_type']=="checkbox"){ echo "selected"; } ?> value="checkbox">Checkboxes</option>
																	<?php
																	if($calendar_of_model_fields == '1') { ?>
																	<option <?php if($row_cus_fld['input_type']=="datepicker"){ echo "selected"; } ?> value="datepicker">Date Picker</option>
																	<?php
																	}
																	if($file_upload_of_model_fields == '1') { ?>
																	<option <?php if($row_cus_fld['input_type']=="file"){ echo "selected"; } ?> value="file">Upload File</option>
																	<?php
																	} ?>
																</select>
															</div>
														</div>
														<div class=" form-group row">
															<div class="col-sm-7 tooltips_hide">
																<label for="tooltip_<?=$fid?>">Tooltip</label>
																<div class="m-input-icon m-input-icon--right">
																	<input name="field[<?=$fid?>][tooltip]" id="tooltip_<?=$fid?>" type="text" class="form-control" value="<?php echo @$row_cus_fld['tooltip']; ?>" />
																	<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
																</div>
															</div>
															
															<div class="col-sm-2 icons_hide">
																<label for="tooltip">Icon</label><br />
																<button class="btn btn-md" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
																<input name="field[<?=$fid?>][icon]" id="icon_<?=$fid?>" type="file" class="filestyle" data-input="false" style="display:none;">
															</div>
															<div class="col-sm-3 icons_hide">
																<!-- <label for="">&nbsp;</label> -->
																<?php
																if($row_cus_fld['icon']!="") { ?>
																  <img class="float-left" src="../images/<?=$row_cus_fld['icon']?>" style="display:block;" width="40" />
																  <i style="padding-left:5px; padding-top:10px;" class="la la-trash float-left" onclick="deleteImage(this);"></i>
																<?php
																} ?>
																<input name="field[<?=$fid?>][icon_hidden]" value="<?=$row_cus_fld['icon']?>" type="hidden" />
															</div>
														</div>
														<div class=" form-group row">
															<div class="col-sm-6">
																<div class="m-checkbox-inline">
																	<label class="m-checkbox">
																		<input name="field[<?=$fid?>][is_required]" id="is_required_<?=$fid?>" value="1" type="checkbox" <?php if($row_cus_fld['is_required']==1){ echo "checked"; } ?>>
																		 Require customer selection <span></span>
																	 </label>
																</div>
															</div>
															<div class="col-sm-6">
																<div class="m-checkbox-inline showhide_val_as_dropdown" <?php if($row_cus_fld['input_type']!="radio"){ echo 'style="display:none;"'; } ?>>
																	<label class="m-checkbox">
																		<input name="field[<?=$fid?>][is_dropdown]" id="is_dropdown_<?=$fid?>" value="1" type="checkbox" <?php if($row_cus_fld['is_dropdown']==1){ echo "checked"; } ?>>
																		 Display Value As Drop Down <span></span>
																	 </label>
																</div>
															</div>
														</div>
														
														<div id="type_options_<?=$fid?>">
															<?php
															$sql_cus_opt = mysqli_query($db,"SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."' ORDER BY sort_order");
															$no_of_dd_options = mysqli_num_rows($sql_cus_opt);
															if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio" || $row_cus_fld['input_type']=="checkbox")
															{ ?>
																<div class="form-group">
																	<button type="button" class="btn btn-md btn-success" id="add_more_options_<?=$fid?>" onclick="add_more_options('<?=$fid;?>')"> <i class="fa fa-plus"></i>  Add New Value</button>
																</div>
																<div class=" form-group row dd_header dd_header-new">
																	<div class="col-sm-3">
																		<label for="">Title</label>
																	</div>
																	<div class="col-sm-2">
																		<label for="">Price <?php /*?>Modifier<?php */?></label>
																	</div>
																	<div class="col-sm-3 tooltips_hide">
																		<label for="">Tooltip</label>
																	</div>
																	<div class="col-sm-2 icons_hide">
																		<label for="">Icon</label>
																	</div>
																	<div class="col-sm-2">
																		<label for="">Default <a href="javascript:void(0);" onclick="clear_default('<?=$fid;?>')"><i class="fa fa-times"></i></a></label>
																		
																	</div>
																	<!-- <div class="col-sm-1">
																		&nbsp;
																	</div> -->
																	<input id="no_of_dd_options_<?=$fid?>" value="<?=$no_of_dd_options?>" type="hidden" />
																</div>
															<?php    
															} ?>
															
															<div id="dd_options_<?=$fid;?>">    
																<?php
																if($no_of_dd_options>0) {
																	$oid=1;
																	echo '<ul id="sortable_'.$fid.'">';
																	while($row_cus_opt = mysqli_fetch_assoc($sql_cus_opt)) { ?>
																		<li class="ui-state-default m--margin-bottom-20" data-id="<?=$oid;?>">
																			<div class=" form-group row">
																				<div class="col-sm-3">
																					<input name="field[<?=$fid?>][options][<?=$oid?>][label]" required="" id="dd_label_<?=$fid;?>_<?=$oid;?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['label']?>" />
																				</div>
																				<div class="col-sm-2">
																					<div class="row">
																						<?php /*?><div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																						<select name="field[<?=$fid?>][options][<?=$oid?>][add_sub]" id="dd_add_sub_<?=$fid;?>_<?=$oid;?>" class="form-control m-input custom-select">
																							<option <?php if($row_cus_opt['add_sub']=="+"){ echo "selected"; } ?> value="+">+</option>
																							<option <?php if($row_cus_opt['add_sub']=="-"){ echo "selected"; } ?> value="-">-</option>
																						</select>
																						</div>
																						<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																						<select name="field[<?=$fid?>][options][<?=$oid?>][price_type]" id="dd_price_type_<?=$fid;?>_<?=$oid;?>" class="form-control m-input custom-select">
																							<option <?php if($row_cus_opt['price_type']=="1"){ echo "selected"; } ?> value="1">Fixed</option>
																							<option <?php if($row_cus_opt['price_type']=="0"){ echo "selected"; } ?> value="0">%</option>
																						</select>
																						</div><?php */?>
																						<div class="col-sm-8" style="padding-left:2px;padding-right:2px;">
																						<input name="field[<?=$fid?>][options][<?=$oid?>][price]" id="dd_price_<?=$fid;?>_<?=$oid;?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['price']?>" placeholder="0.00" />
																						</div>
																					</div>
																				</div>
																				<div class="col-sm-3 tooltips_hide">
																					<div class="m-input-icon m-input-icon--right">
																
																					<input name="field[<?=$fid?>][options][<?=$oid?>][tooltip]" id="dd_tooltip_<?=$fid?>_<?=$oid?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['tooltip']?>" />
																					<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
																					</div>
																				</div>
																				<div class="col-sm-2 icons_hide">
																					<div class="row">
																						<div class="col-sm-6" style="padding-left:2px;padding-right:2px;">
																							<button class="btn btn-sm" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
																							<input name="field[<?=$fid?>][options][<?=$oid?>][icon]" id="dd_icon_<?=$fid;?>_<?=$oid;?>" class="filestyle" type="file" data-input="false" style="display: none;">
																							<input name="field[<?=$fid?>][options][<?=$oid?>][icon_hidden]" class="icon_hidden" value="<?=$row_cus_opt['icon']?>" type="hidden">
																						</div>
																						
																						<?php
																						if($row_cus_opt['icon']!="") { ?>
																							<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																							<img src="../images/<?=$row_cus_opt['icon']?>" style="display:block;" width="30"/>
																							</div>
																							<div class="col-sm-2" style="padding-left:2px;padding-right:2px;">
																								<i class="la la-trash text-danger" onclick="deleteImageOpt(this);"></i>
																							</div>
																						<?php
																						} ?>
																					</div>
																				</div>
																				<div class="col-sm-1">
																					<label class="m-radio">
																						<input name="field[<?=$fid?>][options][<?=$oid?>][is_default]" id="is_default_<?=$fid?>_<?=$oid?>" <?php if($row_cus_opt['is_default']=="1"){echo "checked";}?> value="1" type="radio" class="radio_class radio_<?=$fid?>" onclick="check_default('<?=$fid;?>')" />
																						<span></span>
																					</label>
																				</div>
																				<div class="col-sm-1">
																					<i class="la la-trash trash" style="cursor:pointer;" onclick="remove_row(this)"></i>
																				</div>
																			</div>
																		</li>
																	<?php
																	$oid++;
																	} ?>
																	</ul>
																	
																	<script>
																	$(function() {
																		$("#sortable_<?=$fid?>").sortable();
																		$("#sortable_<?=$fid?>").disableSelection();    
																	});
																	</script>
																<?php
																} ?>
															</div>
															<?php
															if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio" || $row_cus_fld['input_type']=="checkbox") { ?>
																<div class=" form-group">
																	<button type="button" class="btn btn-md btn-success" id="add_more_options_<?=$fid;?>" onclick="add_more_options('<?=$fid;?>')"> <i class="fa fa-plus"></i>  Add New Value</button>
																</div>
															<?php
															}
															?>
														</div>
													</div>
													<?php
													$fid++;
													}
												} ?>
											</div>
										</div>
										
										<div class=" form-group">
											<input type="hidden" name="action" value="add_products">
											<input type="hidden" name="step" value="1">
											<input type="hidden" name="user_id" value="0">
											<input type="hidden" name="id" value="<?=$id?>">
											<input type="hidden" name="step_track" id="step_track" value="1">
											<input type="submit" id="m_form_submit3" class="btn btn-primary" value="Save" onclick="StepTrack(2)">
											<a href="mobile.php" class="btn btn-secondary">Back</a>
										</div>
												
									</div>
								</div>
							</form>
							<!--end::Form-->
						</div>
					</div>
					<!--end::Portlet-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Body -->

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<form onsubmit="return add_group_fields()" method="post" action="action.php">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Manage Fields Groups</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table m-table m-table--head-bg-brand">
						<thead>
							<tr>
								<th>#</th>
								<th>Groups</th>
								<th width="100">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$sql_grp = mysqli_query($db,"SELECT * FROM custom_group WHERE status = '1'");
						$sr=1;
						while($row_grp = mysqli_fetch_assoc($sql_grp)) { ?>
							<tr>
								<td><?=$sr++?></td>
								<td><?=$row_grp['name']?></td>
								<td width="100">
								<div class="m-checkbox-inline">
									<label class="m-checkbox">
										<input name="custom_groups" type="checkbox" value="<?=$row_grp['id']?>" />
										<span></span>
									</label>
								</div>
								</td>
							</tr>
						<?php
						} ?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add Fields</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="field_structure" style="display:none;">   
	<div class="tab-pane active" id="field_f-no"> 
		<div class=" form-group row">
			<div class="col-sm-7">
				<label for="title">Title * :</label>
				<input name="field[f-no][title]" required="" id="title_f-no" type="text" class="form-control m-input m-input--square" onkeyup="up_title('f-no')" onkeydown="up_title('f-no')" />
			</div>
			<div class="col-sm-5">
				<label for="name">Input Type * :</label>
				<select name="field[f-no][input_type]" id="input_type_f-no" class="form-control m-input custom-select" onchange="change_input_type('f-no')">
					<?php
					if($text_field_of_model_fields == '0' && $text_area_of_model_fields == '0') {
						echo '<option value=""> - Select - </option>';
					}
					if($text_field_of_model_fields == '1') { ?>
					<option value="text">Text Field</option>
					<?php
					}
					if($text_area_of_model_fields == '1') { ?>
					<option value="textarea">Text Area</option>
					<?php
					} ?>
					<?php /*?><option value="select">Drop-down List</option><?php */?>
					<option value="radio">Radio Buttons</option>
					<option value="checkbox">Checkboxes</option>
					<?php
					if($calendar_of_model_fields == '1') { ?>
					<option value="datepicker">Date Picker</option>
					<?php
					}
					if($file_upload_of_model_fields == '1') { ?>
					<option value="file">Upload File</option>
					<?php
					} ?>
				</select>
			</div>
		</div>
		<div class=" form-group row">
			<?php
			if($tooltips_of_model_fields == '1') { ?>
			<div class="col-sm-7">
				<label for="tooltip">Tooltip :</label>
				<div class="m-input-icon m-input-icon--right">
					<input name="field[f-no][tooltip]" id="tooltip_f-no" type="text" class="form-control m-input m-input--square" value="" />
					<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
				</div>
			</div>
			<?php
			}
			if($icons_of_model_fields == '1') { ?>
			<div class="col-sm-5">
				<label for="tooltip">Icon :</label><br />
				<button class="btn btn-md" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
				<input name="field[f-no][icon]" id="icon_f-no" type="file" data-input="false" style="display: none;">
			</div>
			<?php
			} ?>
		</div>
		<div class=" form-group row">
			<div class="col-sm-6">
				<div class="m-checkbox-inline">
					<label class="m-checkbox">
						<input type="checkbox" name="field[f-no][is_required]" value="1" id="is_required_f-no" />
						Require customer selection <span></span>
					</label>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="m-checkbox-inline showhide_val_as_dropdown" style="display:none;">
					<label class="m-checkbox">
						<input type="checkbox" name="field[f-no][is_dropdown]" id="is_dropdown_f-no" value="1">
						 Display Value As Drop Down <span></span>
					 </label>
				</div>
			</div>
		</div>
		
		<div id="type_options_f-no">
			
		</div>
	</div>
</div>

<div id="dd_structure" style="display:none;">
	<div class=" form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_options('f-no')"> <i class="fa fa-plus"></i>  Add New Value</button>
	</div>
	<div class=" form-group row dd_header">
		<div class="col-sm-2">
			<label for="">Title</label>
		</div>
		<div class="col-sm-3">
			<label for="">Price <?php /*?>Modifier<?php */?></label>
		</div>
		<?php
		if($tooltips_of_model_fields == '1') { ?>
		<div class="col-sm-3">
			<label for="">Tooltip</label>
		</div>
		<?php
		}
		if($icons_of_model_fields == '1') { ?>
		<div class="col-sm-2">
			<label for="">Icon</label>
		</div>
		<?php
		} ?>
		<div class="col-sm-2">
			<label for="">Default</label>
			<a href="javascript:void(0);" onclick="clear_default('f-no')"><i class="fa fa-times"></i></a>
		</div>
		<!--<div class="col-sm-1">
			&nbsp;
		</div>-->
		<input id="no_of_dd_options_f-no" value="0" type="hidden" />
	</div>
	<div id="dd_options_f-no">
		<ul id="sortable_f-no" style="padding-left:0px;">
		
		</ul>
	</div>
	<div class=" form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_options('f-no')"> <i class="fa fa-plus"></i>  Add New Value</button>
	</div>
</div>

<div id="dd_options_structure" style="display:none;">
	<li class="ui-state-default m--margin-bottom-20" data-id="o-no">
		<div class=" form-group row">
			<div class="col-sm-3">
				<input name="field[f-no][options][o-no][label]" required="" id="dd_label_f-no_o-no" type="text" class="form-control m-input" />
			</div>
			<div class="col-sm-2">
				<div class="row">
					<?php /*?><div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
					<select name="field[f-no][options][o-no][add_sub]" id="dd_add_sub_f-no_o-no" class="form-control m-input custom-select">
						<option value="+">+</option>
						<option value="-">-</option>
					</select>
					</div>
					<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
					<select name="field[f-no][options][o-no][price_type]" id="dd_price_type_f-no_o-no" class="form-control m-input custom-select">
						<option value="1">Fixed</option>
						<option value="0">%</option>
					</select>
					</div><?php */?>
					<div class="col-sm-8" style="padding-left:2px;padding-right:2px;">
						<input name="field[f-no][options][o-no][price]" id="dd_price_f-no_o-no" type="text" class="form-control m-input" value="0" placeholder="0.00" />
					</div>
				</div>
			</div>
			<?php
			if($tooltips_of_model_fields == '1') { ?>
			<div class="col-sm-3">
				<div class="m-input-icon m-input-icon--right">
					<input name="field[f-no][options][o-no][tooltip]" id="dd_tooltip_f-no_o-no" type="text" class="form-control m-input" value="" />
					<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
				</div>
			</div>
			<?php
			}
			if($icons_of_model_fields == '1') { ?>																
			<div class="col-sm-2">
				<button class="btn btn-sm" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
				<input name="field[f-no][options][o-no][icon]" id="dd_icon_f-no_o-no" type="file" data-input="false" style="display: none;">
			</div>
			<?php
			} ?>
			<div class="col-sm-1">
				<label class="m-radio">
					<input name="field[f-no][options][o-no][is_default]" id="is_default_f-no_o-no" value="1" type="radio" class="radio_class radio_f-no" onclick="check_default('f-no')" />
					<span></span>
				</label>
			</div>
			<div class="col-sm-1">
				<i class="la la-trash trash" style="cursor:pointer;" onclick="remove_row(this)"></i>
			</div>
		</div>
	</li>
</div>

<div id="radio_structure" style="display:none;">
	<div class=" form-group row">
		<div class="col-sm-3">
			<label for="label">Label * :</label>
		</div>
		<div class="col-sm-3">
			<label for="Price">Default * :</label>
		</div>
		<input id="no_of_radio_options" value="0" type="hidden" />
	</div>
	<div id="radio_options_f-no">

	</div>
	<div class=" form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_radios('f-no')"> <i class="fa fa-plus"></i>  Add More Option</button>
	</div>
</div>

<div id="radio_options_structure" style="display: none;">
	<div class=" form-group row">
		<div class="col-sm-3">
			<input name="radio_label[f-no][o-no]" id="dd_label_f-no_o-no" type="text" class="form-control" />
		</div>
		<div class="col-sm-3">
			<input name="radio_default[f-no][o-no]" id="dd_price_f-no_o-no" type="radio" class="form-control" />
		</div>
		<div class="col-sm-1">
			<i class="la la-trash trash" onclick="remove_row(this)"></i>
		</div>
	</div>
</div>

<div id="checkbox_structure" style="display: none;">
	<div class=" form-group row">
		<div class="col-sm-3">
			<label for="label">Label * :</label>
		</div>
		<input id="no_of_checkbox_options" value="0" type="hidden" />
	</div>
	<div id="checkbox_options_f-no">
		
	</div>
	<div class=" form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_checkboxs('f-no')"> <i class="fa fa-plus"></i>  Add More Option</button>
	</div>
</div>

<div id="checkbox_options_structure" style="display: none;">
	<div class=" form-group row">
		<div class="col-sm-3">
			<input name="checkbox_label[f-no][o-no]" id="checkbox_label_f-no_o-no" type="text" class="form-control" />
		</div>
		<div class="col-sm-1">
			<i class="la la-trash trash" onclick="remove_row(this)"></i>
		</div>
	</div>
</div>

<input id="no_of_fields" value="<?=$no_of_fields?>" type="hidden" />
<input id="current_field" value="1" type="hidden" />

<script>
function url_slug(s, opt) {
	s = String(s);
	opt = Object(opt);
	
	var defaults = {
		'delimiter': '-',
		'limit': undefined,
		'lowercase': true,
		'replacements': {},
		'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
	};
	
	// Merge options
	for (var k in defaults) {
		if (!opt.hasOwnProperty(k)) {
			opt[k] = defaults[k];
		}
	}
	
	var char_map = {
		// Latin
		'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C', 
		'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I', 
		'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O', 
		'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH', 
		'ß': 'ss', 
		'� ': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c', 
		'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i', 
		'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o', 
		'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th', 
		'ÿ': 'y',

		// Latin symbols
		'©': '(c)',

		// Greek
		'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
		'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', '� ': 'P',
		'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
		'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
		'Ϋ': 'Y',
		'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
		'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
		'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
		'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
		'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

		// Turkish
		'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
		'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g', 

		// Russian
		'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
		'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
		'П': 'P', '� ': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
		'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
		'Я': 'Ya',
		'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
		'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
		'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
		'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
		'я': 'ya',

		// Ukrainian
		'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
		'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

		// Czech
		'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', '� ': 'S', 'Ť': 'T', 'Ů': 'U', 
		'Ž': 'Z', 
		'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
		'ž': 'z', 

		// Polish
		'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z', 
		'Ż': 'Z', 
		'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
		'ż': 'z',

		// Latvian
		'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N', 
		'� ': 'S', 'Ū': 'u', 'Ž': 'Z', 
		'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
		'š': 's', 'ū': 'u', 'ž': 'z'
	};
	
	// Make custom replacements
	for (var k in opt.replacements) {
		s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
	}
	
	// Transliterate characters to ASCII
	if (opt.transliterate) {
		for (var k in char_map) {
			s = s.replace(RegExp(k, 'g'), char_map[k]);
		}
	}
	
	// Replace non-alphanumeric characters with our delimiter
	var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
	s = s.replace(alnum, opt.delimiter);
	
	// Remove duplicate delimiters
	s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);
	
	// Truncate slug to max. characters
	s = s.substring(0, opt.limit);
	
	// Remove delimiter from ends
	s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');
	
	return opt.lowercase ? s.toLowerCase() : s;
}

function gnrt_slug(sef_url) {
	if(sef_url) {
	var mk_slug = url_slug(sef_url);
    $("#apnd_url_slug").html(mk_slug);
	$("#apnd_url_slug_a").attr("href",'<?=SITE_URL.$model_details_page_slug?>'+mk_slug);
	$("#apnd_url_slug_a").show();
	} else {
	$("#apnd_url_slug_a").hide();
	}
}

$( "#sef_url" ).keyup(function() {
  var sef_url = $(this).val();
  gnrt_slug(sef_url);
});
gnrt_slug('<?=$row_pro['sef_url']?>');
</script>