<?php
$custom_phpjs_path = "assets/js/custom/location.php"; ?>

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
					<h3 class="m-subheader__title m-subheader__title--separator"><?=($id?'Edit Location':'Add Location')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text"><?=($id?'Edit Location':'Add Location')?></span>
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
										<?=($id?'Edit Location':'Add Location')?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/location.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								<div class="form-group m-form__group">
									<label for="name">Name</label>
									<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$location_data['name']?>" name="name">
								</div>
								<div class="form-group m-form__group">
									<label for="address">Address</label>
									<textarea class="form-control m-input m-input--square" cols="30" rows="3" id="address" name="address"><?=$location_data['address']?></textarea>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-3">
										<label for="country">Country</label>
										<input type="text" class="form-control m-input m-input--square" id="country" value="<?=$location_data['country']?>" name="country">
									</div>
									<div class="col-lg-3">
										<label for="state">State</label>
										<input type="text" class="form-control m-input m-input--square" id="state" value="<?=$location_data['state']?>" name="state">
									</div>
									<div class="col-lg-3">
										<label for="city">City</label>
										<input type="text" class="form-control m-input m-input--square" id="city" value="<?=$location_data['city']?>" name="city">
									</div>
									<div class="col-lg-3">
										<label for="zipcode">Zipcode</label>
										<input type="text" class="form-control m-input m-input--square" id="zipcode" value="<?=$location_data['zipcode']?>" name="zipcode">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="email">Email</label>
										<input type="text" class="form-control m-input m-input--square" id="email" value="<?=$location_data['email']?>" name="email">
									</div>
									<div class="col-lg-4">
										<label for="cc_email">CC Email</label>
										<input type="text" class="form-control m-input m-input--square" id="cc_email" value="<?=$location_data['cc_email']?>" name="cc_email">
									</div>
									<div class="col-lg-4">
										<label for="phone">Phone</label>
										<input type="text" class="form-control m-input m-input--square" id="phone" value="<?=$location_data['phone']?>" name="phone">
									</div>
								</div>
								
								<?php
								$h_inc = (60 * 60);
								$start = (strtotime('01:00'));
								$end = (strtotime('24:00')); ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="start_time">Appt. Start Time</label>
										<select class="form-control select2 m_select2" name="start_time" id="start_time">
											<option value=""> - Select - </option>
											<?php
											$saved_start_time=$location_data['start_time'];
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("g:i a", $i);
												if($saved_start_time==$start_appt_time)
													$isSelected="selected";
												else
													$isSelected="";
												echo '<option value="'.$start_appt_time.'" '.$isSelected.'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-4">
										<label for="end_time">Appt. End Time</label>
										<select class="form-control select2 m_select2" name="end_time" id="end_time">
											<option value=""> - Select - </option>
											<?php
											$saved_start_time=$location_data['end_time'];
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("g:i a", $i);
												if($saved_start_time==$start_appt_time)
													$isSelected="selected";
												else
													$isSelected="";
												echo '<option value="'.$start_appt_time.'" '.$isSelected.'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-4">
										<label for="time_interval">Appt. Time Interval (Minute)</label>
										<select class="form-control select2 m_select2" name="time_interval" id="time_interval">
											<option value=""> - Select - </option>
											<?php
											$saved_time_interval=$location_data['time_interval'];
											for($i = 5; $i <= 60; $i += 5) {
												if($saved_time_interval==$i)
													$isSelected="selected";
												else
													$isSelected="";
												echo '<option value="'.$i.'" '.$isSelected.'>'.$i.'</option>';
											} ?>
										</select>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="allowed_num_of_booking_per_time_slot">Set number of booking allowed per time slot</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input id="allowed_num_of_booking_per_time_slot" type="checkbox" value="1" name="allowed_num_of_booking_per_time_slot" <?php if($location_data['allowed_num_of_booking_per_time_slot']=="1"){echo 'checked="checked"';}?>>
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group booking_allowed_per_time_slot" <?php if($location_data['allowed_num_of_booking_per_time_slot']=="1"){echo 'style="display:block;"';} else {echo 'style="display:none;"';}?>>
									<label for="num_of_booking_per_time_slot">Enter number of booking per time slot</label>
									<input type="number" class="form-control m-input m-input--square" name="num_of_booking_per_time_slot" value="<?=$location_data['num_of_booking_per_time_slot']?>">
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Google Calendar API</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" id="google_cal_api" name="google_cal_api" value="1" <?=($location_data['google_cal_api']=='1'?'checked="checked"':'')?>> Yes
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" id="google_cal_api" name="google_cal_api" value="0" <?=($location_data['google_cal_api']=='0'||$location_data['google_cal_api']==''?'checked="checked"':'')?>> No
											<span></span>
										</label>
									</div>
									<?php
									if($location_data['is_google_cal_auth'] == '1') {
										$google_cal_auth_info = json_decode($location_data['google_cal_auth_info']);
										echo '<a href="'.SITE_URL.'admin/social/index.php?UnAuthorize=yes&location_id='.$location_data['id'].'" onclick="return confirm(\'Are you sure you want to unauthorize?\');">UnAuthorize ('.$google_cal_auth_info->auth_email.')</a>';
									} else {
										echo '<a href="'.SITE_URL.'admin/social/index.php?location_id='.$location_data['id'].'">Authorize</a>';
									} ?>
								</div>
								
								<?php
								$h_inc = (60 * 30); ?>
								<div class="form-group m-form__group m--padding-bottom-5">
									<h4 class="m-section__heading">Service Hours</h4>
								</div>
								<div class="form-group m-form__group row m--padding-top-10 m--padding-bottom-5">
									<div class="col-lg-2">
										<label for="days"><h5>Days</h5></label>
									</div>
									<div class="col-lg-2">
										<label for="open_time"><h5>Open Time</h5></label>
									</div>
									<div class="col-lg-2">
										<label for="close_time"><h5>Close Time</h5></label>
									</div>
									<div class="col-lg-2">
										<label for="closed"><h5>Closed</strong></h5>
									</div>
								</div>

								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Sunday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[sunday]" id="open_time[sunday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->sunday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[sunday]" id="close_time[sunday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->sunday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[sunday]" name="closed[sunday]" value="yes" onclick="close_day(this.id);" <?php if($closed->sunday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Monday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[monday]" id="open_time[monday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->monday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[monday]" id="close_time[monday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->monday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[monday]" name="closed[monday]" value="yes" onclick="close_day(this.id);" <?php if($closed->monday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Tuesday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[tuesday]" id="open_time[tuesday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->tuesday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[tuesday]" id="close_time[tuesday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->tuesday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[tuesday]" name="closed[tuesday]" value="yes" onclick="close_day(this.id);" <?php if($closed->tuesday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Wednesday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[wednesday]" id="open_time[wednesday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->wednesday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[wednesday]" id="close_time[wednesday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->wednesday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[wednesday]" name="closed[wednesday]" value="yes" onclick="close_day(this.id);" <?php if($closed->wednesday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Thursday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[thursday]" id="open_time[thursday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->thursday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[thursday]" id="close_time[thursday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->thursday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[thursday]" name="closed[thursday]" value="yes" onclick="close_day(this.id);" <?php if($closed->thursday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Friday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[friday]" id="open_time[friday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->friday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[friday]" id="close_time[friday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->friday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[friday]" name="closed[friday]" value="yes" onclick="close_day(this.id);" <?php if($closed->friday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
									<div class="col-lg-2 m--padding-top-10">
										<strong>Saturday</strong>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="open_time[saturday]" id="open_time[saturday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$start_appt_time=date("h:i a", $i);
												echo '<option value="'.$start_appt_time.'" '.($open_time->saturday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<select class="form-control select2 m_select2" name="close_time[saturday]" id="close_time[saturday]">
											<option value=""> - Select - </option>
											<?php
											for($i = $start; $i <= $end; $i += $h_inc) {
												$close_appt_time=date("h:i a", $i);
												echo '<option value="'.$close_appt_time.'" '.($close_time->saturday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
											} ?>
										</select>
									</div>
									<div class="col-lg-2">
										<label class="m-checkbox">
										<input type="checkbox" id="closed[saturday]" name="closed[saturday]" value="yes" onclick="close_day(this.id);" <?php if($closed->saturday=='yes'){echo 'checked';}?>> <span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label for="">Publish</label>
									<div>
										<input name="published" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($location_data['published']==1||$location_data['published']==''?'checked="checked"':'')?> value="1">
									</div>
								</div>
								
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
									<a href="location.php" class="btn btn-secondary">Back</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?=$location_data['id']?>" />
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
