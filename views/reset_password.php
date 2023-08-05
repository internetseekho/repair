<?php
$csrf_token = generateFormToken('reset_password');

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/user/reset_password.php'); ?>

<form action="controllers/user/reset_password.php" method="post" id="reset_psw_form" role="form">
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
					<h3><?=$reset_password_page_title?></h3>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-12">
					   <label for="new_password"><?=$new_password_field_title?></label>
					   <input type="password" class="sm-form-control" id="new_password" name="new_password" placeholder="<?=$new_password_field_placeholder_text?>" autocomplete="off">
					</div>
					<div class="form-group col-md-12">
					   <label for="confirm_password"><?=$confirm_password_field_title?></label>
					   <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="<?=$confirm_password_field_placeholder_text?>" autocomplete="off">
					</div>
					<div class="form-group col-md-12">
						<button type="submit" class="button button-3d nomargin sbmt_button"><?=$submit_btn_text?></button>&nbsp;<a class="button button-3d button-red" href="<?=$login_link?>"><?=$return_to_login_btn_text?></a>
						<input type="hidden" name="reset" id="reset" />
						<input type="hidden" name="t" id="t" value="<?=$post['t']?>" />
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
		$('#reset_psw_form').bootstrapValidator({
			fields: {
				new_password: {
					validators: {
						regexp: {
							//regexp: /^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/,
							regexp: /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?!.*\s).{8,}$/,
							message: '<?=$validation_valid_psw_msg_text?>'
						},
						notEmpty: {
							message: '<?=$validation_new_password_msg_text?>'
						},
						identical: {
							field: 'confirm_password',
							message: '<?=$validation_new_confirm_password_not_match_msg_text?>'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: '<?=$validation_confirm_password_msg_text?>'
						},
						identical: {
							field: 'new_password',
							message: '<?=$validation_new_confirm_password_not_match_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#reset_psw_form').data('bootstrapValidator').resetForm();

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
