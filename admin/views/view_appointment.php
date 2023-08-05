<?php
$custom_phpjs_path = "assets/js/custom/appointment.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator">Order View</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Order View</span>
							</a>
						</li>
						
						<li class="m-nav__item">
							<form action="controllers/appointment.php" method="post">
								<?php
								if(!empty($last_time_sheet_data) && ($last_time_sheet_data['clock_out_datetime']!="" && $last_time_sheet_data['clock_out_datetime']=="0000-00-00 00:00:00")) { ?>
									<button type="submit" name="clock_inout" class="btn btn-alt btn-small btn-success">
										<span><i class="fa fa-clock"></i> <span>Clock Out</span></span>
									</button>
									<input type="hidden" name="mode" id="mode" value="check_out" />
									<input type="hidden" name="time_sheet_id" id="time_sheet_id" value="<?=$last_time_sheet_data['id']?>" />
								<?php
								} else { ?>
									<button type="submit" name="clock_inout" class="btn btn-alt btn-small btn-success">
										<span><i class="fa fa-clock"></i> <span>Clock In</span></span>
									</button>
									<input type="hidden" name="mode" id="mode" value="check_in" />
								<?php
								} ?>
								<input type="hidden" name="appt_auto_inc_id" id="appt_auto_inc_id" value="<?=$appointment_data['id']?>" />
								<input type="hidden" name="order_id" id="order_id" value="<?=$appointment_data['appt_id']?>" />
								<input type="hidden" name="staff_id" id="staff_id" value="<?=$admin_l_id?>" />
							</form>
						</li>
						<li class="m-nav__item">
							<button type="button" onclick="showTimeSheetListAjaxModal();" class="btn btn-alt btn-small btn-metal">
								<span><i class="fa fa-eye"></i> <span>Time Sheet</span></span>
							</button>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
			<?php include('confirm_message.php'); ?>
	
			<div class="row">
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Customer Info
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<div class="m-section">
								<span class="m-section__sub">
									<dd><strong>Customer Name:</strong> <?php if($appointment_data['user_id']>0 && $appointment_data['customer_name']) {echo '<a href="edit_user.php?id='.$appointment_data['user_id'].'">'.$appointment_data['customer_name'].'</a>';} else {echo 'Guest';} ?></dd>
									<dd><strong>Name:</strong> <?=$appointment_data['name']?></dd>
									<dd><strong>Email:</strong> <?=$appointment_data['email']?></dd>
									<dd><strong>Phone:</strong> <?=$appointment_data['phone']?></dd>
									<dd><strong>Shop Location:</strong> <a href="edit_location.php?id=<?=$appointment_data['location_id']?>"><?=$appointment_data['location_name']?></a></dd>
									<dd><strong>Location:</strong> <?php if($appointment_data['shipping_method']=="come_to_you"){echo 'We come to you';}elseif($appointment_data['shipping_method']=="bring_to_shop"){echo 'Bring To Shop';}elseif($appointment_data['shipping_method']=="ship_device"){echo 'Ship Device';}?></dd>
									<dd><strong>Address:</strong> <?=($appointment_data['shipping_address']?$appointment_data['shipping_address']:'No Data')?></dd>
									<dd><strong>City:</strong> <?=($appointment_data['shipping_city']?$appointment_data['shipping_city']:'No Data')?></dd>
									<dd><strong>State:</strong> <?=($appointment_data['shipping_state']?$appointment_data['shipping_state']:'No Data')?></dd>
									<dd><strong>Zip Code:</strong> <?=($appointment_data['shipping_zipcode']?$appointment_data['shipping_zipcode']:'No Data')?></dd>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Order Info
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<span class="m-section__sub">
									<dd><strong>Appt. ID:</strong> <?=$appointment_data['appt_id']?></dd>
									<dd><strong>Product Name:</strong> <?=$product_name?></dd>
									<dd><strong>Product Items:</strong> <a data-toggle="modal" href="#ProductItems"><span class="la la-info-circle"></span></a></dd>
									<?php /*?><dd><?=$appointment_data['item_name'];.($order_files_html!=""?'<br>'.$order_files_html:'')?></dd>
									<dd><strong>Estimate Amount:</strong> <?=amount_fomat($appointment_data['item_amount'])?></dd>
									<?php
									if($f_promocode_info) { ?>
									<dd><?=$f_promocode_info?></dd>
									<?php
									} ?><?php */?>
									<dd><strong>Appt. Date:</strong> <?=format_date($appointment_data['appt_date'])?></dd>
									<dd><strong>Appt. Time:</strong> <?=str_replace("_"," to ",format_time($appointment_data['appt_time']))?></dd>
									<dd><strong>Status:</strong> <?=ucwords(str_replace('_',' ',$appointment_data['status_name']))?></dd>
									<dd><strong>Submitted Date:</strong> <?=format_date($appointment_data['added_date']).' '.format_time($appointment_data['added_date'])?></dd>
									<dd><strong>Estimate Amount:</strong> <?=amount_fomat($estimate_cost)?></dd>
								</span>
							</div>
							<!--end::Section-->
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Extra Info
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<span class="m-section__sub">
									<dd><strong>Instructions:</strong> <?=($appointment_data['instructions']?$appointment_data['instructions']:'No Data')?></dd>
									<dd><strong>Extra Remarks:</strong> <?=$appointment_data['extra_remarks']?></dd>
                                    
                                    <?php
                                    /*$stripe_response_dt = json_decode($appointment_data['stripe_response'],true);
									if(!empty($stripe_response_dt)) { ?>
                                    <dd><strong>Paid Amount: </strong><?=amount_fomat($appointment_data['stripe_amount'])?></dd>
                                    <dd><strong>Stripe Cust. ID: </strong><?=$appointment_data['stripe_customer_id']?></dd>
                                    <dd><strong>Stripe Email: </strong><?=$appointment_data['stripe_email']?></dd>
                                    <dd><strong>Transaction ID: </strong><?=$stripe_response_dt['id']?></dd>
                               		<?php
									}*/ ?>
								</span>
							</div>
							<!--end::Section-->
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Shipping Info
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<div class="m-section">
								<span class="m-section__sub">
								
									<?php
									if($appointment_data['shipping_api']=="easypost" && $appointment_data['shipment_id']!="") { ?>
										<dl class="no-bottom-margin">
											<dd><strong>Shipping API:</strong> 
											<?php 
											if($appointment_data['shipping_api']=="easypost") {
												echo 'Easy Post';
											} ?>
											</dd>
											<dd><strong>Shipment ID:</strong> <?=$appointment_data['shipment_id']?></dd>
											<dd><strong>Shipment Tracking Code:</strong> <?=$appointment_data['shipment_tracking_code']?></dd>
											<dd><strong>Shipment Label:</strong> <strong><a target="_blank" href="<?=$appointment_data['shipment_label_url']?>">View</a> | <a href="<?=SITE_URL.'controllers/download.php?download_link='.$appointment_data['shipment_label_url']?>">Download</a></strong></dd>
										</dl>
										<?php
										$shipment_alert_msg = "Are you sure you want to re-create shipment for this order? current shipment may be in proccess.";
									} else {
										echo '<h5>Shipment Was Not Created</h5>';
										$shipment_alert_msg = "Are you sure you want to create shipment for this order?";
									} ?>
									
									<dl class="no-bottom-margin">
										<form action="controllers/appointment.php" role="form" class="form-horizontal form-groups-bordered" method="post">
											<input type="hidden" name="create_shipment" id="create_shipment" value="yes" />
											<input type="hidden" name="id" id="id" value="<?=$appointment_data['id']?>" />
											
											<button class="btn btn-alt btn-primary" type="submit" name="create_shipment" onclick="return confirm('<?=$shipment_alert_msg?>');">Create Shipment</button>
										</form>
									</dl>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Shipping Tracking Details
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<span class="m-section__sub">
									<?php
									if($appointment_data['shipping_api']=="easypost" && $appointment_data['shipment_id']!="") { 
										if($appointment_data['shipping_api']=="easypost") {
											if($appointment_data['shipment_id']) { ?>
												<dl class="no-bottom-margin">
													<?php
													try {
														require_once("../libraries/easypost-php-master/lib/easypost.php");
														\EasyPost\EasyPost::setApiKey($shipping_api_key);
	
														$shipment = \EasyPost\Shipment::retrieve($appointment_data['shipment_id']);
														
														echo '<h5>Current Status</h5>';
														echo '<dd><strong>Date:</strong> '.date('m-d-Y h:i A',strtotime($shipment->tracker->created_at)).'</dd>';
														echo '<dd><strong>Tracking Code:</strong> '.$shipment->tracker->tracking_code.'</dd>';
														echo '<dd><strong>Est. Delivery Date:</strong> '.date('m-d-Y h:i A',strtotime($shipment->tracker->est_delivery_date)).'</dd>';
														echo '<dd><strong>Status:</strong> '.$shipment->tracker->status.'</dd>';
														echo '<dd><strong>Public Url:</strong> <a target="_blank" href="'.$shipment->tracker->public_url.'">Click Here To See</a></dd>';
													} catch(Exception $e) {
														echo "Status: ".$e->getHttpStatus().":";
														echo $e->getMessage()."\n";
													} ?>
												</dl>
											<?php
											}
										}
									} else {
										echo '<h5>Data not Available</h5>';
									} ?>
								</span>
							</div>
							<!--end::Section-->
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Shipping Tracking History
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<span class="m-section__sub" style="overflow-y:auto; max-height:200px;">
									<?php
									if(!empty($shipment->tracker->tracking_details)) {
										foreach($shipment->tracker->tracking_details as $tracking_details) {
											echo '<dd><strong>'.date('m-d-Y h:i A',strtotime($tracking_details->datetime)).'</strong><br>'.$tracking_details->message.'</dd>';
											if($tracking_details->tracking_location->city && $tracking_details->tracking_location->state) {
												echo '<dd>'.$tracking_details->tracking_location->city.', '.$tracking_details->tracking_location->state.($tracking_details->tracking_location->country?', '.$tracking_details->tracking_location->country:'').', '.$tracking_details->tracking_location->zip.'</dd>';
											}
											echo '<br>';
										}
									} else {
										echo '<h5>Data not Available</h5>';
									} ?>
								</span>
							</div>
							<!--end::Section-->
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										<?=($contractor_concept=='1'?'Assign to Contractor, ':'')?>Send Message to Customer
									</h3>
								</div>
							</div>
						</div>
						
						<form action="controllers/appointment.php" method="post" class="m-form m-form--fit m-form--label-align-right">
						<div class="m-portlet__body m--padding-top-10 m--padding-bottom-10">
							<?php /*?><div class="m-form__content">
								<?php include('confirm_message.php'); ?>
							</div><?php */?>
							
							<?php
							if($contractor_concept == '1') { ?>
							<div class="form-group m-form__group">
								<h4 class="m-section__heading">Assign to Contractor</h4>
								<a class="btn btn-md btn-primary" data-toggle="modal" href="#demoModal">Assign to Contractor</a>
								<?php
								if(!empty($assigned_contractor_data)) { ?>
									<br />
									<span class="m-form__help">Already Assigned: <a href="edit_contractor.php?id=<?=$assigned_contractor_data['id']?>"><?=$assigned_contractor_data['name'].'('.$assigned_contractor_data['phone'].')'?></a></span>
								<?php
								} ?>
							</div>
							<?php
							} ?>
							
							<div class="form-group m-form__group">
								<?php
								if($contractor_concept == '1') { ?>
								<h4 class="m-section__heading">Send Message to Customer</h4>
								<?php
								} ?>
								<label for="note">Email Content</label>
								<textarea class="description" id="note" name="note"><?=$email_body_text?></textarea>
							</div>
							
							<div class="form-group m-form__group">
							   <label for="sms_content">SMS Content</label>
							   <textarea class="form-control m-input m-input--square" id="sms_content" name="sms_content" rows="5"><?=$sms_body_text?></textarea>
							</div>
							
							<div class="form-group m-form__group">
								<label for="is_send_alert">You want to send alert to customer ?</label>
								<div class="m-checkbox-inline">
									<label class="m-checkbox">
										<input id="is_send_alert" type="checkbox" value="1" name="is_send_alert" checked="checked"> Email <span></span>
									</label>
									<label class="m-checkbox">
										<input id="is_send_sms_alert" type="checkbox" value="1" name="is_send_sms_alert" checked="checked"> SMS <span></span>
									</label>
								</div>
							</div>
							
							<div class="form-group m-form__group">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control m-input">
								<?php
								while($appt_status_list = mysqli_fetch_assoc($appt_status_query)) {?>
									<option value="<?=$appt_status_list['id']?>" <?php if($appointment_data['status'] == $appt_status_list['id']){echo 'selected="selected"';}?>> <?=$appt_status_list['name']?> </option>
								<?php
								} ?>
								</select>
							</div>
						
							<input type="hidden" name="appt_id" id="appt_id" value="<?=$appointment_data['appt_id']?>" />
						
							<?php /*?><div class="m-form__group form-group">
								<label for="">Publish</label>
								<div class="m-radio-inline">
									<label class="m-radio">
										<input type="radio" id="published_1" name="published" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($brand_data['published']==1?'checked="checked"':'')?>> Yes
										<span></span>
									</label>
									<label class="m-radio">
										<input type="radio" id="published_0" name="published" value="0" <?=($brand_data['published']=='0'?'checked="checked"':'')?>> No
										<span></span>
									</label>
								</div>
							</div><?php */?>
							
							<?php /*?><div class="m-form__group form-group">
								<label for="">Publish</label>
								<div>
									<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($brand_data['published']==1?'checked="checked"':'')?> value="1">
								</div>
							</div><?php */?>	
						</div>
						<div class="m-portlet__foot m-portlet__foot--fit">
							<div class="m-form__actions">
								<button id="m_form_submit" type="submit" class="btn btn-primary" name="update">Change & Send</button>
								<a href="appointment.php" class="btn btn-secondary">Back</a>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			
			<?php
			if($assigned_contractor_data['contractor_id']>0) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Leave Comments
									</h3>
								</div>
							</div>
						</div>
						
						<form action="controllers/appointment.php" method="post" class="m-form m-form--fit m-form--label-align-right comment_form">
						<div class="m-portlet__body m--padding-top-10 m--padding-bottom-10">
							<div class="m-form__content">
								<?php include('confirm_message.php'); ?>
							</div>
							
							<div class="form-group m-form__group">
								<label>Order Status</label>
								<select name="c_status" id="c_status" class="form-control m-input">
									<option value=""> -Select- </option>
									<?php
									while($appt_cb_status_list = mysqli_fetch_assoc($appt_cb_status_query)) {?>
										<option value="<?=$appt_cb_status_list['id']?>" <?php //if($appointment_data['status'] == $appt_cb_status_list['id']){echo 'selected="selected"';}?>> <?=$appt_cb_status_list['name']?> </option>
									<?php
									} ?>
								</select>
							</div>
							
							<div class="form-group m-form__group">
								<label>Comment * </label>
								<textarea class="form-control m-input m-input--square" name="comment" id="comment" placeholder="Comment" rows="3" required></textarea>
							</div>
							
							<input type="hidden" name="contractor_id" id="contractor_id" value="<?=$assigned_contractor_data['contractor_id']?>" />
							<input type="hidden" name="appt_id" id="appt_id" value="<?=$appointment_data['appt_id']?>" />
							
							<div class="form-group m-form__group">
							<h4 class="m-section__heading">Comments History</h4>
							<div class="chat-messages" style="overflow-y:auto; max-height:350px;">
								<table class="table" width="100%">
									<tbody class="apd-chat-message">
										<?php
										if($num_of_comment>0) {
											while($comment_list = mysqli_fetch_assoc($comment_query)) {
												if($comment_list['thread_type'] == "admin") { ?>
													<tr>
														<td>
															<img src="img/admin_avatar.png" width="15">
															<span><?=format_date($comment_list['date']).' '.format_time($comment_list['date'])?> <span class="label label-success"><?=$comment_list['status_name']?></span></span>
															<p><?=$comment_list['comment']?></p>
														</td>
													</tr>
												<?php
												} else { ?>
													<tr>
														<td style="text-align:right;">
															<span><?=format_date($comment_list['date']).' '.format_time($comment_list['date'])?> <span class="label label-success"><?=$comment_list['status_name']?></span></span><img src="img/user-avatar.png" width="20">
															<p style="text-align:left;"><?=$comment_list['comment']?></p>
														</td>
													</tr>
												<?php
												}
											}
										} else {
											echo '<small>History Not Available</small>';
										} ?>
									</tbody>
								</table>
							</div>
							</div>	
						</div>
						</form>
					</div>
				</div>
			</div>
			<?php
			} ?>
		</div>
	</div>
</div>
<!-- end:: Body -->

<div class="modal fade" id="ProductItems" tabindex="-1" role="dialog" aria-labelledby="ProductItemsLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ProductItemsLabel">Items</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<?php
				$item_name_array = json_decode($appointment_data['item_name'],true);
				$item_name = json_encode($item_name_array);
				$total_amount = ($appointment_data['item_amount']>0?$appointment_data['item_amount']:0);
				$f_total_amount = $total_amount;
				
				$order_files_html = '';
				if(isset($appointment_data['files']) && $appointment_data['files']!="") {
					$order_files_list = explode(",",$appointment_data['files']);
					foreach($order_files_list as $file_k=>$file_v) {
						if($file_v!="") {
							$file_image_ext = pathinfo($file_v, PATHINFO_EXTENSION);
							$order_files_html .= '<tr>
								<td colspan="2" width="100%"><a href="'.SITE_URL.'images/orders/files/'.$file_v.'" '.($file_image_ext!="txt"&&$file_image_ext!="pdf"?'data-lightbox="image"':'target="_blank"').'>'.$file_v.'</a></td>
							</tr>';
						}
					}
				}
				
				$item_list_html = '';
				if(!empty($item_name_array)) {
					foreach($item_name_array as $item_name_data) {
						$items_name = '';
						$items_opt_name = '';
			
						$items_opt_price = '';
						$items_opt_price_arr = array();
			
						$items_name = '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).'</strong>';
			
						$item_list_html .= '<tr>
							<td colspan="2" width="100%">'.$items_name.'</td>
						</tr>';
			
						if(!empty($item_name_data['opt_data'])) {
							foreach($item_name_data['opt_data'] as $opt_data) {
								$items_opt_name = $opt_data['opt_name'];
								
								$item_list_html .= '<tr>
									<td width="80%">'.$items_opt_name.'</td>
									<td width="20%" style="text-align:center;">'.amount_fomat($opt_data['opt_price']).'</td>
								</tr>';
							}
						}
					}
				}
			
				if($order_files_html) {
					$item_list_html .= '<tr>
						<td colspan="2" width="100%"><b>Files</b></td>
					</tr>';
					$item_list_html .= $order_files_html;
				}

				//if($online_booking_hide_price != '1') {
					if($appointment_data['promocode_amt']>0) {
						$item_list_html .= '<tr>
							<td width="80%"><b>Item Total</b></td>
							<td width="20%">'.amount_fomat($total_amount).'</td>
						</tr>';
						$item_list_html .= '<tr>
							<td width="80%">'.$discount_amt_label.'</td>
							<td width="20%">-'.amount_fomat($appointment_data['promocode_amt']).'</td>
						</tr>';
					} else {
						$appointment_data['promocode_amt'] = 0;
					}
				
					$item_list_html .= '<tr>
						<td width="80%"><b>Total</b></td>
						<td width="20%">'.amount_fomat($total_amount-$appointment_data['promocode_amt']).'</td>
					</tr>';
				//}
				
				$f_total_amount = ($total_amount-$appointment_data['promocode_amt']);

				$p_amt_arr = array(0);
				if(!empty($payment_history_list)) {
					foreach($payment_history_list as $payment_history_data) {
						$stripe_response_dt = json_decode($payment_history_data['stripe_response'],true);
						$item_list_html .= '<tr>
							<td width="80%"><b>Paid Amount On '.format_date($payment_history_data['date']).' '.format_time($payment_history_data['date']).($stripe_response_dt['id']?'<br><small>Tra. ID: '.$stripe_response_dt['id'].'</small>':'').($payment_history_data['stripe_customer_id']?'<br><small>Stripe Cust. ID: '.$payment_history_data['stripe_customer_id'].'</small>':'').'</b></td>
							<td width="20%">-'.amount_fomat($payment_history_data['paid_amount']).'</td>
						</tr>';
						$p_amt_arr[] = $payment_history_data['paid_amount'];
					}
				}
				$p_amt_total = array_sum($p_amt_arr);
				
				if($p_amt_total) {
				$item_list_html .= '<tr>
					<td width="80%"><b>Remaining Amount</b></td>
					<td width="20%">'.amount_fomat($f_total_amount-$p_amt_total).'</td>
				</tr>';
				}
				
				$items_body_html = '';
				$items_body_html .= '<table width="650" class="table m-table m-table--head-bg-brand">';
					$items_body_html .= '
						<tr>
							<td width="80%"><strong>Repair Selected Item</strong></td>
							<td width="20%" style="text-align:right;"><strong>Price</strong></td>
						</tr>';
					$items_body_html .= '<tbody>'.$item_list_html.'</tbody>';
				$items_body_html .= '</table>';
			
				echo $items_body_html; ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Assign to contractor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<form action="controllers/appointment.php" method="post">
			<div class="modal-body">
				<div class="form-group m-form__group">
					<label>Contractor * </label>
					<select required="required" id="contractor_id" name="contractor_id" class="form-control m-input">
						  <option value=""> - Select - </option>
						  <?php
						  $contractor_data_list = get_contractor_list();
						  $contr_num_of_rows = count($contractor_data_list);
						  if($contr_num_of_rows>0) {
							  foreach($contractor_data_list as $contractor_data) { ?>
								<option value="<?=$contractor_data['id']?>" <?php if($contractor_data['id'] == $assigned_contractor_data['contractor_id']) {echo 'selected="selected"';}?>><?=$contractor_data['company_name']?></option>
							  <?php
							  }
						  } ?>
					</select>
					<span class="m-form__help contractor_info"><?=($assigned_contractor_data['contractor_id']>0?'<b>Name:</b> '.$assigned_contractor_data['name'].'<br><b>Email:</b> '.$assigned_contractor_data['email'].'<br><b>Phone:</b> '.$assigned_contractor_data['phone']:'')?></span>
				</div>
				
				<div class="form-group m-form__group">
					<label>Amount *</label>
					<input type="number" required="required" class="form-control m-input m-input--square" id="amount" value="<?=$assigned_contractor_data['amount']?>" name="amount">
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="assign_to_contractor">Assign</button>
			</div>
			
			<input type="hidden" name="appt_id" id="appt_id" value="<?=$appointment_data['appt_id']?>" />
			<input type="hidden" name="appt_auto_inc_id" id="appt_auto_inc_id" value="<?=$post['id']?>" />
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="timesheet_details_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Time Sheet List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php
				if($admin_type == "super_admin") { ?>
					<table class="table m-table m-table--head-bg-brand">
						<thead>
						  <tr>
							<th>Clock In</th>
							<th>Clock Out</th>
							<th>Total (H:M)</th>
						  </tr>
						</thead>
						<tbody>
						<?php
						$total_hours_array = array();
						foreach($time_sheet_data_array as $time_sheet_staff_data) { ?>
							<tr>
								<td colspan="3"><strong><?=$time_sheet_staff_data['name'];?></strong></td>
							</tr>
							<?php
							$total_staff_hours_array = array();
							foreach($time_sheet_staff_data['time_sheet_data'] as $time_sheet_data) {
								$clock_in_datetime = $time_sheet_data['clock_in_datetime'];
								$clock_out_datetime = $time_sheet_data['clock_out_datetime'];
								$f_clock_out_datetime = "";
								if($clock_out_datetime!="" && $clock_out_datetime!="0000-00-00 00:00:00") {
									$f_clock_out_datetime = format_date($clock_out_datetime).' '.format_time($clock_out_datetime);//date("m/d/Y h:i A",strtotime($clock_out_datetime));
								} ?>
								<tr>
									<td><?=format_date($clock_in_datetime).' '.format_time($clock_in_datetime);//date("m/d/Y h:i A",strtotime($clock_in_datetime))?></td>
									<td><?=($f_clock_out_datetime?$f_clock_out_datetime:"Pending")?></td>
									<td>
									<?php
									if(!$f_clock_out_datetime) {
										echo ' -- ';
									} else {
										$time_diff = time_diff_from_two_datetime($clock_in_datetime,$clock_out_datetime);
										echo $time_diff;
										$total_staff_hours_array[] = $time_diff;
										$total_hours_array[] = $time_diff;
									} ?></td>
								</tr>
							<?php
							}
							if(!empty($total_staff_hours_array)) { ?>
								<tr>
									<td>&nbsp;</td>
									<td><strong>Total (H:M)</strong></td>
									<td><strong><?=sum_of_time_array($total_staff_hours_array)?></strong></td>
								</tr>
							<?php
							}
						}
						if(!empty($total_hours_array)) { ?>
							<tr>
								<td>&nbsp;</td>
								<td><strong class="m--font-danger">Grand Total (H:M)</strong></td>
								<td><strong class="m--font-danger"><?=sum_of_time_array($total_hours_array)?></strong></td>
							</tr>
						<?php
						} ?>
						</tbody>
					</table>	
				<?php
				} else { ?>		
					<table class="table m-table m-table--head-bg-brand">
						<thead>
						  <tr>
							<th>Clock In</th>
							<th>Clock Out</th>
							<th>Total (H:M)</th>
						  </tr>
						</thead>
						<tbody>
						<?php
						$total_hours_array = array();
						while($time_sheet_data = mysqli_fetch_assoc($time_sheet_q)) {
							$clock_in_datetime = $time_sheet_data['clock_in_datetime'];
							$clock_out_datetime = $time_sheet_data['clock_out_datetime'];
							$f_clock_out_datetime = "";
							if($clock_out_datetime!="" && $clock_out_datetime!="0000-00-00 00:00:00") {
								$f_clock_out_datetime = format_date($clock_out_datetime).' '.format_time($clock_out_datetime);//date("m/d/Y h:i A",strtotime($clock_out_datetime));
							} ?>
							<tr>
								<td><?=format_date($clock_in_datetime).' '.format_time($clock_in_datetime);//date("m/d/Y h:i A",strtotime($clock_in_datetime))?></td>
								<td><?=($f_clock_out_datetime?$f_clock_out_datetime:"Pending")?></td>
								<td>
								<?php
								if(!$f_clock_out_datetime) {
									echo ' -- ';
								} else {
									$time_diff = time_diff_from_two_datetime($clock_in_datetime,$clock_out_datetime);
									echo $time_diff;
									$total_hours_array[] = $time_diff;
								} ?></td>
							</tr>
						<?php
						}
						if(!empty($total_hours_array)) { ?>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Total (H:M)</strong></td>
							<td><strong><?=sum_of_time_array($total_hours_array)?></strong></td>
						</tr>
						<?php
						} ?>
						</tbody>
					</table>
				<?php
				} ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
