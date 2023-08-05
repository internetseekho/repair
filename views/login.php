<?php
//If already loggedin and try to access login page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('login');

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

				<div class="acctitle acc-icon-title"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-unlock"></i><?=$login_page_heading_text?></div>
				<div class="clearfix">
					<form action="controllers/user/login.php" method="post" id="login_form">
						<div class="col_full form-group">
							<label for="username"><?=$email_field_title?>:</label>
							<input type="text" class="sm-form-control" id="username" name="username" placeholder="<?=$email_field_placeholder_text?>" autocomplete="off">
						</div>

						<div class="col_full form-group">
							<label for="password"><?=$password_field_title?>:</label>
							<input type="password" class="sm-form-control" id="password" name="password" placeholder="<?=$password_field_placeholder_text?>" autocomplete="off">
						</div>
						
						<?php
						if($login_form_captcha == '1') { ?>
							<div class="col_full">
								<div id="g_form_gcaptcha"></div>
								<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
							</div>
						<?php
						} ?>
						
						<div class="col_full nobottommargin">
							<button type="submit" class="button button-3d button-black nomargin" value="login"><?=$login_btn_text?></button>
							<input type="hidden" name="submit_form" id="submit_form" />
							<a href="lost_password" class="fright"><?=$forgot_password_text?></a>
						</div>
						
						<a class="fleft" style="margin-top:10px;margin-bottom:15px;" href="<?=$signup_link?>"><?=$login_page_are_you_already_not_mbr_text?></a>
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
	
<script>
<?php
if($login_form_captcha == '1') { ?>
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

(function( $ ) {
	$(function() {
		$('#login_form').bootstrapValidator({
			fields: {
				username: {
					validators: {
						notEmpty: {
							message: '<?=$validation_email_msg_text?>'
						},
						emailAddress: {
							message: '<?=$validation_valid_email_msg_text?>'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: '<?=$validation_password_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#login_form').data('bootstrapValidator').resetForm();

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