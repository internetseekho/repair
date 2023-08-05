<?php
$csrf_token = generateFormToken('bulk_order');

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

<section id="content" class="<?=(!$is_show_title?'py-5':'')?>">
	<div class="container clearfix">
		<div class="row">
			<div class="col-md-12">
				<?php
				if($is_show_title && $show_title == '1') { ?>
				<div class="heading-block topmargin-sm bottommargin-sm center">
					<h3><?=$page_title?></h3>
				</div>
				<?php
				}

			    //START for confirm message
			    $confirm_message = getConfirmMessage()['msg'];
			    echo $confirm_message;
			    //END for confirm message ?>
			  
				 <form action="controllers/bulk_order_form.php" class="phone-sell-form" method="post" id="bulk_order_form">
					<div class="form-row">
						<div class="form-group col-md-4">
							<input type="text" name="name" id="name" placeholder="<?=$name_field_placeholder_text?>" class="sm-form-control" value="<?=$user_full_name?>" />
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" class="sm-form-control" value="<?=$user_email?>" />
						</div>
				  		<div class="form-group col-md-4">
							<input type="tel" id="cell_phone" name="cell_phone" class="sm-form-control" placeholder="<?=$phone_field_placeholder_text?>" value="<?=($user_phone?'+'.$user_phone:'')?>">
							<input type="hidden" name="phone" id="phone" />
						</div>
						<div class="form-group col-md-4">
							<select name="country" id="country" class="sm-form-control">
								<option value=""> - <?=$country_field_title?> - </option>
								<?php
								foreach($countries_list as $c_k => $c_v) { ?>
									<option value="<?=$c_v?>"><?=$c_v?></option>
								<?php
								} ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="state" id="state" placeholder="<?=$state_field_placeholder_text?>" class="sm-form-control" value="<?=$user_data['state']?>" />
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="city" id="city" placeholder="<?=$city_field_placeholder_text?>" class="sm-form-control" value="<?=$user_data['city']?>" />
						</div>
						<div class="form-group col-md-6">
							<input type="text" name="zip_code" id="zip_code" placeholder="<?=$zipcode_field_placeholder_text?>" class="sm-form-control" value="<?=$user_data['postcode']?>" />
						</div>
						<div class="form-group col-md-6">
							<input type="text" name="company_name" id="company_name" placeholder="Enter company name" class="sm-form-control" value="<?=$user_data['company_name']?>" />
						</div>
						<div class="form-group col-md-12">
							<h4 class="nobottommargin"><?=$bulk_order_form_devices_text?></h4>
							<div class="checkbox-roll">
							<?php
							$device_data_list = get_device_data_list();
							foreach($device_data_list as $dk => $device_data) { ?>
								<div class="checkbox-fancy">
									<input type="checkbox" class="checkbox-style" name="devices[]" id="devices<?=$dk?>" value="<?=$device_data['title']?>"/> <label for="devices<?=$dk?>" class="checkbox-style-3-label"><?=$device_data['title']?></label>
								</div>
							<?php
							} ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<textarea name="content" id="content" placeholder="<?=$content_field_placeholder_text?>" class="sm-form-control" rows="6" cols="30"></textarea>
						</div>
						
						<?php
						if($bulk_order_form_captcha == '1') { ?>
							<div class="form-group col-md-12">
								<div id="g_form_gcaptcha"></div>
								<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
							</div>
						<?php
						} ?>
					  
						<div class="form-group col-md-12">
							<button type="submit" class="button button-3d nomargin sbmt_button"><?=$submit_btn_text?></button>
							<input type="hidden" name="submit_form" id="submit_form" />
						</div>
					</div>
					
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				 </form>
			</div>
		</div>
  </div>
</section>
				
<script>
<?php
//if($bulk_order_form_captcha == '1') { ?>
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
		  utilsScript: "js/intlTelInput-utils.js"
		});
		
		$('#bulk_order_form').bootstrapValidator({
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
				state: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_state_msg_text?>'
						}
					}
				},
				city: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_city_msg_text?>'
						}
					}
				},
				zip_code: {
					validators: {
						notEmpty: {
							message: '<?=$validation_zipcode_msg_text?>'
						}
					}
				},
				title: {
					validators: {
						notEmpty: {
							message: '<?=$validation_title_msg_text?>'
						}
					}
				},
				content: {
					validators: {
						notEmpty: {
							message: '<?=$validation_message_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#bulk_order_form').data('bootstrapValidator').resetForm();

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