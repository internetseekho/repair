<?php
//If already loggedin and try to access signup page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('signup');

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];

//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section id="head-graphics" <?php if($header_image != ""){echo 'style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="d-flex align-items-center justify-content-center">
						<div class="text-center clearfix">
							<?php
							if($show_title == '1') {
								echo '<h1>'.$page_title.'</h1>';
							}
							if($image_text) {
								echo '<p>'.$image_text.'</p>';
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
}

if($show_breadcrumbs == '1') { ?>
<section class="border-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=SITE_URL?>">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$active_page_data['menu_name']?></li>
				</ol>
			</div>
		</div>
	</div>
</section>
<?php
} ?>

<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">
				
				<?php
				if($is_show_title && $show_title == '1') { ?>
				<div class="heading-block bottommargin-sm center">
					<h3><?=$page_title?></h3>
				</div>
				<?php
				}
				
				if($active_page_data['content']) { ?>
					<div class="row">
						<div class="col-md-12">
							<?=$active_page_data['content']?>
						</div>
					</div>
				<?php
				}

				//START for confirm message
				$confirm_message = getConfirmMessage()['msg'];
				echo $confirm_message;
				//END for confirm message ?>
				
				<div class="acctitle acc-icon-title"><i class="acc-closed icon-user4"></i><i class="acc-open icon-user4"></i><?=$signup_page_heading_text?></div>
				<div class="clearfix">
					<form action="controllers/user/signup.php" method="post" id="signup_form" role="form">
						<div class="col_full form-group">
							<label for="first_name"><?=$first_name_field_title?>:</label>
							<input type="text" class="sm-form-control" name="first_name" id="first_name" placeholder="<?=$first_name_field_placeholder_text?>">
						</div>
						
						<div class="col_full form-group">
							<label for="last_name"><?=$last_name_field_title?>:</label>
							<input type="text" class="sm-form-control" name="last_name" id="last_name" placeholder="<?=$last_name_field_placeholder_text?>">
						</div>
						
						<div class="col_full form-group">
							<label for="cell_phone"><?=$phone_field_title?>:</label>
							<input type="tel" id="cell_phone" name="cell_phone" class="sm-form-control" placeholder="<?=$phone_field_placeholder_text?>">
							<input type="hidden" name="phone" id="phone" />
						</div>
						
						<div class="col_full form-group">
							<label for="email"><?=$email_field_title?>:</label>
							<input type="text" class="sm-form-control" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" value="<?=isset($_GET['email'])?$_GET['email']:''?>" autocomplete="off">
						</div>
						<div class="col_full form-group">
							<label for="password"><?=$password_field_title?>:</label>
							<input type="password" class="sm-form-control" name="password" id="password" placeholder="<?=$password_field_placeholder_text?>" autocomplete="off">
						</div>
						
						<div class="col_full form-group">
							<label for="confirm_password"><?=$confirm_password_field_title?>:</label>
							<input type="password" class="sm-form-control" name="confirm_password" id="confirm_password" placeholder="<?=$confirm_password_field_placeholder_text?>" autocomplete="off">
						</div>
						
						<div class="col_full form-group">
							<?php
							if($general_setting_data['terms_status']=='1' && $display_terms_array['ac_creation']=="ac_creation") { ?>
								<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1" class="checkbox-style"/>
								<label for="terms_conditions" class="checkbox-style-3-label"><?=$signup_page_accept_terms_text?></label>
							<?php
							} else { ?>
								<input type="hidden" name="terms_conditions" id="terms_conditions" value="1" checked="checked"/>
							<?php
							} ?>
						</div>
						
						<?php
						if($signup_form_captcha == '1') { ?>
							<div class="col_full form-group">
								<div id="g_form_gcaptcha"></div>
								<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
							</div>
						<?php
						} ?>
						
						<div class="col_full form-group nobottommargin mt-0">
							<button type="submit" class="button button-3d button-black nomargin" value="login"><?=$signup_btn_text?></button>
							<input type="hidden" name="submit_form" id="submit_form" />
						</div>
						
						<a class="fleft" style="margin-top:10px;margin-bottom:15px;" href="<?=$login_link?>"><?=$signup_page_are_you_already_mbr_text?></a>
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
					</form>

					<?php
					if($social_login=='1') { ?>
						<div class="line line-sm"></div>
						<h4 style="margin-bottom: 15px;">or Login with:</h4>
					
						<script type="text/javascript" src="social/js/oauthpopup.js"></script>
						<script type="text/javascript">
						
						var tpj=jQuery;
						tpj(document).ready(function($){
							//For Google
							tpj('a.login').oauthpopup({
								path: 'social/social.php?google',
								width:650,
								height:350,
							});
						
							//For Facebook
							/*$('#facebook').oauthpopup({
								path: 'social/social.php?facebook',
								width:600,
								height:300,
							});*/
						});
						
						tpj(document).ready(function() {
						  tpj.ajaxSetup({ cache: true });
						  tpj.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
							tpj("#facebookAuth").click(function() {
								FB.init({
								  appId: '<?=$fb_app_id?>',
								  version: 'v2.8'
								});
						
								FB.login(function(response) {
									if(response.authResponse) {
									 console.log('Welcome! Fetching your information.... ');
									 FB.api('/me?fields=id,name,first_name,middle_name,last_name,email,gender,locale', function(response) {
										 console.log('Response',response);							 	
										 tpj("#name").val(response.name);
										 tpj("#email").val(response.email);
										 
										 if(response.email!="") {
											 tpj.ajax({
												type: "POST",
												url:"ajax/social_login.php",
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
						
						<?php
						if($social_login_option=="g_f") { ?>
							<a id="facebookAuth" href="javascript:void(0);" class="button button-rounded si-facebook si-colored"><i class="icon-facebook"></i>Facebook</a>&nbsp;<a href="javascript:void(0);" class="button button-rounded si-google si-colored login"><i class="icon-google"></i>Google</a>
						<?php
						} elseif($social_login_option=="g") { ?>
							<a href="javascript:void(0);" class="button button-rounded si-google si-colored login"><i class="icon-google"></i>Google</a>
						<?php
						} elseif($social_login_option=="f") { ?>
							<a id="facebookAuth" href="javascript:void(0);" class="button button-rounded si-facebook si-colored"><i class="icon-facebook"></i>Facebook</a>
						<?php
						} 
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="editAddress-modal modal fade HelpPopup" id="PricePromiseHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel"><?=$signup_page_terms_popup_heading_text?></h4>
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>
		<div class="modal-body">
			<?=$general_setting_data['order_receipt_terms']?>
		</div>
		<div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
	</div>
  </div>
</div>
  
<script>
<?php
//if($signup_form_captcha == '1') { ?>
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
//} ?>

(function( $ ) {
	$(function() {
		var telInput = document.querySelector("#cell_phone");
		var itiTel = window.intlTelInput(telInput, {
		  allowDropdown: false,
		  initialCountry: "<?=$country_small_nm?>",
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
		});
	
		$('#signup_form').bootstrapValidator({
			fields: {
				first_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_first_name_msg_text?>'
						}
					}
				}/*,
				 last_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_last_name_msg_text?>'
						}
					}
				}*/,
				email: {
					validators: {
						notEmpty: {
							message: '<?=$validation_email_msg_text?>'
						},
						emailAddress: {
							message: '<?=$validation_valid_email_msg_text?>'
						}
					}
				},
				cell_phone: {
					validators: {
						callback: {
							message: '<?=$validation_valid_phone_msg_text?>',
							callback: function(value, validator, $field) {
								if(itiTel.isValidNumber()) {
								    var phone_number = itiTel.getNumber();
								    $("#phone").val(phone_number);
								    return true;
								} else {
								    return false;
								}
							}
						}
					}
				},
				password: {
					validators: {
						regexp: {
							//regexp: /^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/,
							regexp: /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?!.*\s).{8,}$/,
							message: '<?=$validation_valid_psw_msg_text?>'
						},
						notEmpty: {
							message: '<?=$validation_password_msg_text?>'
						},
						identical: {
							field: 'confirm_password',
							message: '<?=$validation_password_confirm_password_not_match_msg_text?>'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: '<?=$validation_confirm_password_msg_text?>'
						},
						identical: {
							field: 'password',
							message: '<?=$validation_password_confirm_password_not_match_msg_text?>'
						}
					}
				},
				terms_conditions: {
					validators: {
						callback: {
							message: '<?=$validation_terms_msg_text?>',
							callback: function(value, validator, $field) {
								var terms = document.getElementById("terms_conditions").checked;
								if(terms==false) {
									return false;
								} else {
									return true;
								}
							}
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#signup_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>