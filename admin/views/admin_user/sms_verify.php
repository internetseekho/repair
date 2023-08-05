<?php
$custom_js_path = "assets/js/custom/sms_verify.js"; ?>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(assets/app/media/img//bg/bg-3.jpg);">
		<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
			<div class="m-login__container">
				<div class="m-login__logo">
					<a href="<?=ADMIN_URL?>" title="<?=ADMIN_PANEL_NAME?>">
						<img src="<?=$admin_logo_url?>" style="max-width:200px;">
					</a>
				</div>
				<div class="m-login__signin">
					<div class="m-login__head">
						<h3 class="m-login__title">Sign In To Admin</h3>
					</div>
					<form class="m-login__form m-form" action="controllers/admin_user/sms_verify.php" method="post">
						<?php
						require_once('confirm_message.php'); ?>
						
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" name="sms_code" id="sms_code" placeholder="Enter Verify Code" autocomplete="off" maxlength="7">
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" name="login">Verify</button>
							<a href="controllers/admin_user/sms_verify.php?cancel=yes" class="btn btn-danger m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--danger">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Page -->
