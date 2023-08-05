<?php
$csrf_token = generateFormToken('affiliate');

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

<section>
  <div class="container">
	<div class="row">
	  <div class="col-md-8">
		<div class="block content-block clearfix">
			
		<?php
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
		//END for confirm message ?>
		
		  <form action="controllers/affiliates.php" class="phone-sell-form" method="post" id="affiliate_form">
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="name" id="name" placeholder="<?=$name_field_placeholder_text?>" class="form-control" value="<?=$user_full_name?>" />
			  </div>
			</div>
			<div class="col-md-6 tel-phone">
			  <div class="form-group">
				<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="<?=$phone_field_placeholder_text?>" value="<?=$user_phone?>">
				<input type="hidden" name="phone" id="phone" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" class="form-control" value="<?=$user_email?>" />
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="company" id="company" placeholder="<?=$company_name_field_placeholder_text?>" class="form-control" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="subject" id="subject" placeholder="<?=$subject_field_placeholder_text?>" class="form-control" />
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" name="web_address" id="web_address" placeholder="<?=$web_address_field_placeholder_text?>" class="form-control" />
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<textarea name="message" id="message" placeholder="<?=$message_field_placeholder_text?>" class="form-control"></textarea>
			  </div>
			</div>
		  </div>
		  
		  <?php
		  if($affiliate_form_captcha == '1') { ?>
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div id="g_form_gcaptcha"></div>
					<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
				</div>
			</div>
		  </div>
		  <?php
		  } ?>
		  
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<button type="submit" class="btn btn-submit sbmt_button"><?=$submit_btn_text?></button>
				<input type="hidden" name="submit_form" id="submit_form" />
			  </div>
			</div>
		  </div>
		  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
		</form>
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="right-sidebar clearfix">
		  <div class="h3">Benifits of Joining Affiliate </div>
		  <ul class="no-links">
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Attractive commission for each handset sold</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Independent verification of transactions</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Online reporting</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Free use of banners adverts</span></li>
			<li><i class="fa fa-angle-right" aria-hidden="true"></i><span>Free and easy to join</span></li>
		  </ul>
		</div>
	  </div>
  </div>
  </div>
</section>

<script>
<?php
//if($affiliate_form_captcha == '1') { ?>
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

		$('#affiliate_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_name_msg_text?>'
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
            $('#affiliate_form').data('bootstrapValidator').resetForm();

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