<?php
$meta_title = "Forgot your password?";
$meta_desc = "Forgot your password?";
$meta_keywords = "Forgot your password?";

//Header section
include("include/header.php");

//If already loggedin and try to access lost password page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('lost_password');
?>

<form action="controllers/user/lost_password.php" method="post" id="lost_psw_form" role="form">
<section id="content">
	<div class="container clearfix">
		<div class="row divcenter nobottommargin clearfix" style="max-width:600px;">
			<div class="col-md-12">
				
				<?php
				//START for confirm message
				$confirm_message = getConfirmMessage()['msg'];
				echo $confirm_message;
				//END for confirm message ?>
				
				<div class="heading-block topmargin-sm bottommargin-sm center">
					<h3><?=$lost_password_page_title?></h3>
					<span><?=str_replace("[website_name]",SITE_NAME,$lost_password_page_desc)?></span>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-12">
					   <label for="email"><?=$email_field_title?></label>
					   <input type="text" class="sm-form-control" id="email" name="email" placeholder="<?=$email_field_placeholder_text?>" autocomplete="off">
					</div>
					<div class="form-group col-md-12">
						<button type="submit" class="button button-3d nomargin sbmt_button"><?=$submit_btn_text?></button>&nbsp;<a class="button button-3d button-red" href="<?=$login_link?>"><?=$return_to_login_btn_text?></a>
						<input type="hidden" name="reset" id="reset" />
						<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
					</div>
				</div>
			</div>
		  </div>
		</div>
  </section>
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
</form>

<script>
(function( $ ) {
	$(function() {
		$('#lost_psw_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: '<?=$validation_email_msg_text?>'
						},
						emailAddress: {
							message: '<?=$validation_valid_email_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#lost_psw_form').data('bootstrapValidator').resetForm();

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