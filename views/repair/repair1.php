<?php
$location_list = get_location_data_list();
$csrf_token = generateFormToken('repair');

//Header section
include("include/header.php");

$order_id=$url_second_param;
$appt_auto_inc_id=$url_third_param;
$exp_appt_auto_inc_id = array_reverse(explode("-",$appt_auto_inc_id));
$appt_auto_inc_id=trim($exp_appt_auto_inc_id['0']);
$location_id=$_SESSION['location_id'];

if($order_id=='') {
	$msg='Direct access denied';
	setRedirectWithMsg('/',$msg,'danger');
	exit;
} elseif($order_id!='' && $appt_auto_inc_id=="") {
	$exst_appt_q = mysqli_query($db,"SELECT * FROM appointments WHERE appt_id='".$order_id."' AND appt_id!=''");
	$exist_appt_data = mysqli_fetch_assoc($exst_appt_q);
	if(!empty($exist_appt_data)) {
		$msg='This order already exists in our system. If you have a new repair order please submit a new request';
		setRedirectWithMsg('/',$msg,'danger');
		exit;
	}
}

$sql_appt = "SELECT * FROM appointments WHERE id='".$appt_auto_inc_id."'";
$exe_sql_appt = mysqli_query($db,$sql_appt);
$appointments_data = mysqli_fetch_assoc($exe_sql_appt);

$order_item_list = get_order_item_list($order_id);
foreach($order_item_list as $order_item_list_data) {
	$product_id = $order_item_list_data['model_id'];
	$model_id = $order_item_list_data['model_id'];
	$order_item_data = get_order_item($order_item_list_data['id'],'list');
	$total_amount = $order_item_list_data['price'];
}

$model_q = mysqli_query($db,"SELECT * FROM mobile WHERE id='".$model_id."'");
$model_data = mysqli_fetch_assoc($model_q);
$product_name = $model_data['title'];

$p_order_data = get_order_data($order_id);
if($p_order_data['promocode_id']>0 && $p_order_data['promocode_amt']>0) {
	$promocode_amt = $p_order_data['promocode_amt'];
	$discount_amt_label = "<strong>Promocode Discount:</strong> -";
	if($appointment_data['discount_type']=="percentage")
		$discount_amt_label = "<strong>Promocode Discount (".$p_order_data['discount']."% of Initial Quote):</strong> -";

	$f_promocode_info = $discount_amt_label.amount_fomat($promocode_amt);
}
?>

<link rel="stylesheet" href="<?=SITE_URL?>assets/css/style.css">

<div class="container">
	<div class="row form-box" style="margin-bottom:40px;">
		<div class="col-md-8">
			<?php
			//START for confirm message
			$confirm_message = getConfirmMessage()['msg'];
			echo $confirm_message;
			//END for confirm message

			if($appt_auto_inc_id>0) { ?>
				<h3>Thanks <?=$appointments_data['name']?>, we received your request</h3>
				<p>We will provide your tech's name and arrival time by SMS and email</p>
				<p><strong>Devices:</strong> <?=$appointments_data['item_name']?></p>
				<?php
				if($online_booking_hide_price != '1') { ?>
				<p><strong>Cost:</strong> <?=amount_fomat($appointments_data['item_amount'])?></p>
				<?php
				}
				if($appointments_data['shipping_method']=="come_to_you"){
					echo '';
				} elseif($appointments_data['shipping_method']=="bring_to_shop"){ ?>
					<p><strong>Location:</strong> Bring To Shop (Free)<br> <?=$company_name?><br>
					<?=$company_address?><br>
					<?=$company_city?>, <?=$company_state?> <?=$company_zipcode?></p>
				<?php
				} ?>
				<p><strong>Time:</strong> <?=$appointments_data['appt_date'].', '.str_replace("_"," to ",$appointments_data['appt_time'])?></p>
				<p><strong>Your info:</strong><br /><?=$appointments_data['email']?><br /><?=$appointments_data['phone']?><br /><br />We come to you<br /><?=$appointments_data['address']?><br /><?=$appointments_data['floor_no']?><br /><?=$appointments_data['instructions']?></p>
				<h3>What happens next?</h3>
				<p>We're selecting the best tech in your area and will confirm your appointment soon.</p>
				<p>Once we assign a technician, we will provide the tech's name and arrival time by email and sms.</p>
				<p>Payment is collected with a credit/debit card once the service is completed.</p>
				<p><?=SITE_NAME?></p>
			<?php
			} else { ?>
				<form role="form" action="<?=SITE_URL?>controllers/repair.php" method="post" class="f1" id="steps_form">
					<input type="hidden" name="product_id" id="product_id" value="<?=$product_id?>">
					<input type="hidden" name="item_name" id="item_name" value="<?=$order_item_data['device_type']?>">
					<input type="hidden" name="item_amount" id="item_amount" value="<?=$total_amount?>">
					<input type="hidden" name="appt_id" id="appt_id" value="<?=$order_id?>">
					<input type="hidden" name="user_id" id="user_id" value="<?=$user_data['id']?>">

					<h3><?=$product_name?></h3>
					
					<div class="f1-steps">
						<!--<div class="f1-progress">
							<div class="f1-progress-line" data-now-value="33.3" data-number-of-steps="3" style="width: 33.3%;"></div>
						</div>-->
						<div class="f1-step first-step active">
							<div class="f1-step-icon step1"><p>Step 1</p></div>
						</div>
						<div class="f1-step second-step">
							<div class="f1-step-icon step2"><p>Step 2</p></div>
						</div>
						<div class="f1-step third-step">
							<div class="f1-step-icon step3"><p>Step 3</p></div>
						</div>
					</div>

					<fieldset id="first_step_frm">
						<?php
						//START for social login
						if($social_login=='1') { ?>
						
						<script type="text/javascript" src="<?=SITE_URL?>social/js/oauthpopup.js"></script>
						
						<?php /*?>
						<script type="text/javascript">
						jQuery(document).ready(function($){
							//For Facebook
							$('#facebook').oauthpopup({
								path: '/social/social.php?only_data_from_fb',
								width:800,
								height:800,
							});
						});
						</script><?php */?>

						<script>
						jQuery(document).ready(function($){
							//For Google
							$('a.login').oauthpopup({
								path: '/social/social.php?only_data_from_gl',
								width:650,
								height:350,
							});
							$('a.google_logout').googlelogout({
								redirect_url:'<?php echo $base_url; ?>social/logout.php?google'
							});
						});
							
						$(document).ready(function() {
						  $.ajaxSetup({ cache: true });
						  $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
							$("#facebookAuth").click(function() {
								FB.init({
								  appId: '<?=$fb_app_id?>',
								  version: 'v2.8'
								});

								FB.login(function(response) {
									if(response.authResponse) {
									 console.log('Welcome! Fetching your information.... ');
									 FB.api('/me?fields=id,name,first_name,middle_name,last_name,email,gender,locale', function(response) {
									 	 console.log('Response',response);							 	
									     $("#name").val(response.name);
										 $("#email").val(response.email);
										 
										 if(response.email!="") {
											 $.ajax({
												type: "POST",
												url:"../ajax/social_login.php",
												data:response,
												success:function(data) {
													if(data!="") {
														var resp_data = JSON.parse(data);
														if(resp_data.msg!="" && resp_data.status == true) {
															location.reload(true);
														} else {
															alert("Something went wrong!!!");
														}
													} else {
														alert("Something went wrong!!!");
													}
												}
											});
										}		
		
									 });
									} else {
									    console.log('User cancelled login or did not fully authorize.');
									}
								},{scope: 'email'});
							});
						  });
						});
						</script>
						
						<div class="block social" style="padding-bottom:0px !important;">
							<ul>
								<?php
								if($social_login_option=="g_f") { ?>
									<li class="facebook"><a id="facebookAuth" href="javascript:void(0);"><i class="fa fa-facebook"></i>Continue With Facebook</a></li>
									<li class="google"><a class="login" href="javascript:void(0);"><i class="fa fa-google-plus"></i>Google</a></li>
								<?php
								} elseif($social_login_option=="g") { ?>
									<li class="facebook"><a id="facebookAuth" href="javascript:void(0);"><i class="fa fa-facebook"></i>Continue With Facebook</a></li>
								<?php
								} elseif($social_login_option=="f") { ?>
									<li class="google"><a class="login" href="javascript:void(0);"><i class="fa fa-google-plus"></i>Google</a></li>
								<?php
								} ?>
							</ul>
						</div>
						<?php
						} //END for social login
						$facebook_data = $_SESSION['facebook_data'];
						?>
						<div class="or_text_box">OR</div>
						
						<h4>Enter your personal info</h4>

						<div class="form-group">
							<label class="sr-only" for="f1-name">Name</label>
							<input type="text" name="name" placeholder="Name..." class="name form-control" id="name" value="<?=($facebook_data['name']?$facebook_data['name']:$user_data['name'])?>">
						</div>

						<div class="form-group">
							<label class="sr-only" for="f1-email">E-mail</label>
							<input type="email" name="email" placeholder="E-mail..." class="email form-control" id="email" value="<?=($facebook_data['email']?$facebook_data['email']:$user_data['email'])?>">
						</div>
						
						<div class="form-group">
							<label class="sr-only" for="f1-last-name">Phone</label>
							<input type="text" name="phone" placeholder="Phone..." class="phone form-control" id="phone" value="<?=$user_data['phone']?>" maxlength="10">
						</div>

						<div class="f1-buttons">
							<button type="button" class="btn btn-next">Next</button>
						</div>
					</fieldset>

					<fieldset id="second_step_frm">
						<h4>Choose your Location</h4>
						<div class="payment-method clearfix">
							<div class="clearfix">
							<ul>
								<li class="payment_method_bank_li active <?php if($select_payment_method=="bank"){echo 'active';}?>">
									<input checked="checked" id="payment_method_bank" class="payment_method" name="shipping_method" value="bring_to_shop" type="radio" <?php if($select_payment_method=="bank"){echo 'checked="checked"';}?>>
									<div class="clearfix">
										<div class="payment_method_checkbox"><i class="fa fa-circle"></i></div>
										<div class="payment_method_text"><strong>Bring to shop (free)</strong></div>
										<div class="payment_method_image"><img loading="lazy" src="<?=SITE_URL?>images/phone-hand.svg" width="100"></div>
									</div>
									<div class="payment-method-form payment_method_bank clearfix">
										<div class="arrow-up"></div>
										<?php
										if(count($location_list)<1) { ?>
										<div class="form-inline">
											<strong><?=$company_name?></strong>
											<?=$company_address?><br>
											<?=$company_city?>, <?=$company_state?> <?=$company_zipcode?>
										</div>
										<?php
										} elseif(count($location_list)==1) { ?>
										<div class="form-inline">
											<strong><?=$company_name?><?=($location_list[0]['name']?' - '.$location_list[0]['name']:'')?></strong>
											<?=$location_list[0]['address']?><br>
											<?=$location_list[0]['city']?>, <?=$location_list[0]['state']?> <?=$location_list[0]['zipcode']?><br />
											<?=$location_list[0]['country']?>
										</div>
										<?php
										} ?>
										<div class="f1-buttons"></div>
									</div>
								</li>
								
								<li class="payment_method_cheque_li <?php if($select_payment_method=="cheque"){echo 'active';}?>">
									<input id="payment_method_cheque" class="payment_method" name="shipping_method" value="come_to_you" type="radio" <?php if($select_payment_method=="cheque"){echo 'checked="checked"';}?>>
									<div class="clearfix">
										<div class="payment_method_checkbox"><i class="fa fa-circle"></i></div>
										<div class="payment_method_text"><strong>We come to you</strong></div>
										<div class="payment_method_image"><img loading="lazy" src="<?=SITE_URL?>images/phone-hand.svg" width="100"></div>
										<!-- Coming soon -->
									</div>
									
									<div class="payment-method-form payment_method_cheque clearfix" style="display:none!important">
										<div class="arrow-up"></div>
										<div class="form-group">
											<label class="sr-only" for="f1-last-name">Address</label>
											<textarea name="address" placeholder="Address..." class="address form-control" id="address"><?=$user_data['address'].' '.$user_data['address2']?></textarea>
										</div>
										<div class="form-group">
											<label class="sr-only" for="f1-last-name">Add / suite / floor No. (optional)</label>
											<input type="text" name="floor_no" placeholder="Add / suite / floor No. (optional)" class="floor_no form-control" id="floor_no">
										</div>
										<div class="form-group">
											<label class="sr-only" for="f1-last-name">Add instructions (optional)</label>
											<textarea name="instructions" placeholder="Add instructions (optional)" class="instructions form-control" id="instructions"></textarea>
										</div>
									</div>
								</li>
							</ul>
							</div>
							<div class="device-get-price clearfix" style="clear:both;">
								<button type="button" class="btn btn-previous btn-large pull-left">Previous</button>
								<button type="button" class="btn btn-next pull-right" style="margin-left:10px">Next</button>
							</div>
						</div>
					</fieldset>
					
					<fieldset id="third_step_frm">
						<h4>Make an appointment</h4>
						<p>Choose when you will bring your device to the shop.<br>Most repairs are completed within 15 to 20 minutes.</p>
						
						<?php
						if(count($location_list)>0) { ?>
						<div class="form-group">
							<label for="f1-google-plus">Shop Location</label><br />
							<select required id="location_id" name="location_id" class="form-control" onchange="getTimeSlotList(this.value);">
							  <option value=""> - Select - </option>
							  <?php
							  foreach($location_list as $location_data) { ?>
							  	<option value="<?=$location_data['id']?>" <?php if($location_data['id']==$location_id){echo 'selected="selected"';}?>><?=$location_data['name']?></option>
							  <?php
							  } ?>
							</select>
						</div>
						<?php
						} else {
							echo '<input type="hidden" id="location_id" name="location_id" value="0" />';
						} ?>
						
						<div class="form-group">
							<label class="sr-only" for="f1-twitter">Date</label>
							<input type="text" name="date" placeholder="Date..." class="date form-control datepicker_from_current_date repair_appt_date" id="date" autocomplete="off" readonly>
						</div>

						<div class="form-group">
							<label for="f1-google-plus">Time Slot</label><br />
							<select id="time_slot" name="time_slot" class="form-control repair_time_slot">
								<?php
								if(count($location_list)<=0) {
									$time_interval   = ($appt_time_interval * 60);
									$start_time = (strtotime($appt_start_time));
									$end_time   = (strtotime($appt_end_time));
									
									echo '<option value=""> - Select - </option>';
									for($i = $start_time; $i<=$end_time; $i+=$time_interval) {
										$range = date('g:i a',$i);
										echo "<option value=\"$range\">$range</option>".PHP_EOL;
									}
								} ?>
							</select>
							<small class="time-slot-msg" style="display:none;"></small>
						</div>

						<div class="form-group">
							<label class="sr-only" for="Extra_remarks">Extra remarks</label>
							<textarea name="extra_remarks" placeholder="Extra remarks..." class="extra_remarks form-control" id="extra_remarks" rows="4"></textarea>
						</div>
						
						<?php
						if($appt_form_captcha == '1') { ?>
						<div class="form-group">
							<div id="g_form_gcaptcha"></div>
							<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
						</div>
						<?php
						} ?>
		  
						<div class="f1-buttons">
							<button type="button" class="btn btn-submit pull-left">Previous</button>
							<button type="submit" class="button request-repair-button" name="request_repair">Submit Repair Request</button>
						</div>
					</fieldset>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				</form>
			<?php
			} ?>
		</div>

		<div class="col-md-4 contact-new">
			<div class="right-sidebar clarfix" style="margin-bottom:0px;">
				<?php
				if($model_data['model_img']) {
					$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=144'; ?>
					<img loading="lazy" src="<?=$md_img_path?>">
				<?php
				} ?>

				<p><strong><?=$product_name?></strong></p>
				<ul class="contact">
					<li><strong>Devices:</strong> (<?=$order_item_data['device_type']?>)</li>
					<?php
					if($online_booking_hide_price != '1') {
						echo '<li><strong>Amount:</strong> '.amount_fomat($total_amount).'</li>';
						if($promocode_amt>0) {
							echo '<li>'.$f_promocode_info.'</li>';
							echo '<li><strong>Total:</strong> '.amount_fomat($total_amount-$promocode_amt).'</li>';
						}
					} ?>
				</ul>
			</div>
			
			
			<div class="col-md-4">
		<div class="right-sidebar clarfix">
		  <div class="h2">Address</div>
		  <p>
		  <?php
		  if($company_name) {
			 echo '<strong>'.$company_name.'</strong>';
		  }
		  if($company_address) {
			 echo '<br />'.$company_address;
		  }
		  if($company_city) {
			 echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode;
		  }
		  if($company_country) {
			 echo '<br />'.$company_country;
		  } ?>
		  <ul class="contact">
			<?php
			if($site_phone) {
				echo '<li><i class="fa fa-phone-square" aria-hidden="true"></i><a href="tel:'.$site_phone.'">'.$site_phone.'</a></li>';
			}
			if($site_email) {
				echo '<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:'.$site_email.'">'.$site_email.'</a></li>';
			}
			if($website) {
				echo '<li><i class="fa fa-globe" aria-hidden="true"></i><a href="'.$website.'">'.$website.'</a></li>';
			} ?>
		  </ul>
			<?php 
			//START for socials link
			if($socials_link) { ?>
			 <div class="h2">Social</div>
				<div class="social clearfix">
				  <ul><?=$socials_link?></ul>
				</div>
			<?php
			} //END for socials link
			?>
		</div>
	  </div>
			
			
			<div class="clearfix" style="padding-left:25px;">
				<a href="<?=$contact_link?>" class="btn-general pull-left mt0">Contact Us</a>
			</div>
		</div>
	</div>
</div>

<script>
<?php
if($appt_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};
	
var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

function getTimeSlotList(id)
{
	var location_id = id.trim();
	if(location_id>0) {
		post_data = "location_id="+location_id+"&option=1&token=<?=uniqid();?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/get_timeslot_list.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.html!="") {
							$('#time_slot').html(resp_data.html);
						}
					} else {
						alert('Something went wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

<?php
if($location_id>0) {
	echo "getTimeSlotList('".$location_id."')";
} ?>

function check_booking_available() {
	jQuery(document).ready(function($) {
		var date = $("#date").val();
		var time = $(".repair_time_slot").val();
		var location_id = $("#location_id").val();
		if(time) {
			post_data = "date="+date+"&time="+time+"&location_id="+location_id+"&token=<?=uniqid()?>";
			$.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/check_booking_available.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.booking_allow==false) {
							$(".request-repair-button").attr("disabled", "disabled");
							$(".time-slot-msg").show();
							$(".time-slot-msg").html(resp_data.msg);
						} else {
							$(".request-repair-button").removeAttr("disabled");
							$(".time-slot-msg").hide();
						}
					} else {
						return false;
					}
				}
			});
		}
	});
}

jQuery(document).ready(function($) {  
	$("#payment_method_cheque").click(function() {
		$(".payment_method_cheque").slideDown(),
		$(".payment_method_bank").slideUp(),
		$('.payment_method_cheque_li').addClass('active'),
		$(".payment_method_bank_li").removeClass('active');
	});

	$("#payment_method_bank").click(function() {
		$(".payment_method_bank").slideDown(),
		$(".payment_method_cheque").slideUp(),
		$('.payment_method_bank_li').addClass('active'),
		$(".payment_method_cheque_li").removeClass('active');
	});
});
</script>

<!-- Javascript -->
<script src="<?=SITE_URL?>assets/js/jquery-1.11.1.min.js"></script>
<script src="<?=SITE_URL?>assets/js/jquery.backstretch.min.js"></script>
<script src="<?=SITE_URL?>assets/js/retina-1.1.0.min.js"></script>
<script src="<?=SITE_URL?>assets/js/scripts.js"></script>
