<?php
$custom_js_path = "assets/js/custom/password_reset.js"; ?>

<script type="text/javascript">
function check_form(a){
	if(a.new_password.value.trim()==""){
		alert('Please enter your new password.');
		a.new_password.focus();
		a.new_password.value='';
		return false;
	}
	if(a.confirm_password.value.trim()==""){
		alert('Please enter your confirm password.');
		a.confirm_password.focus();
		a.confirm_password.value='';
		return false;
	}
	if(a.new_password.value.trim()!=a.confirm_password.value.trim()){
		alert('New password and confirm password not matched.');
		a.confirm_password.focus();
		a.confirm_password.value='';
		return false;
	}	
}
</script>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(assets/app/media/img//bg/bg-3.jpg);">
		<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
			<div class="m-login__container">
				<div class="m-login__logo">
					<a href="<?=ADMIN_URL?>" title="<?=ADMIN_PANEL_NAME?>">
						<img src="<?=$admin_logo_url?>">
					</a>
				</div>
				<div class="m-login__signin">
					<div class="m-login__head">
						<h3 class="m-login__title">Change Password</h3>
					</div>
					<form class="m-login__form m-form" action="controllers/admin_user/confirm_password_reset.php" method="post" onSubmit="return check_form(this);">
						<?php
						require_once('confirm_message.php'); ?>
						
						<div class="form-group m-form__group">
							<input type="password" class="form-control m-input" name="new_password" placeholder="New Password" autocomplete="off" />
						</div>
						<div class="form-group m-form__group">
							<input type="password" class="form-control m-input" name="confirm_password" placeholder="Confirm Password" autocomplete="off" />
						</div>
						<div class="m-login__form-action">
							<button type="submit" id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" name="reset">Submit</button>
						</div>
						<input type="hidden" name="uid" value="<?=$check_token_data['id']?>" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Page -->
