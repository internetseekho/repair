<?php
$csrf_token = generateFormToken('missing_product');

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
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="postcontent nobottommargin">
			
				<?php
				if($is_show_title && $show_title == '1') { ?>
				<div class="heading-block topmargin-sm bottommargin-sm center">
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
				
				<p>&nbsp;</p>
				<form method="post" action="controllers/model.php" id="req_quote_form">
					<div class="col_one_third form-group">
						<input type="text" name="name" id="name" placeholder="<?=$name_field_placeholder_text?>" class="sm-form-control" value="<?=$user_full_name?>" />
					</div>

					<div class="col_one_third form-group">
						<input type="tel" id="cell_phone" name="cell_phone" class="sm-form-control" placeholder="<?=$phone_field_placeholder_text?>" value="<?=$user_phone?>">
						<input type="hidden" name="phone" id="phone" />
					</div>

					<div class="col_one_third col_last form-group">
						<input type="text" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" class="sm-form-control" value="<?=$user_email?>" />
					</div>

					<div class="clear"></div>

					<div class="col_full form-group">
						<input type="text" name="item_name" id="item_name" placeholder="<?=$item_name_field_placeholder_text?>" class="sm-form-control" />
					</div>

					<div class="clear"></div>

					<div class="col_full form-group">
						<textarea name="message" id="message" placeholder="<?=$message_field_placeholder_text?>" class="sm-form-control" rows="6" cols="30"></textarea>
					</div>
					
					<?php
					if($missing_product_form_captcha == '1') { ?>
					  <div class="col_full">
							<div id="g_form_gcaptcha"></div>
							<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
					  </div>
					<?php
					} ?>	
					  
					<div class="col_full">
						<button class="button button-3d nomargin sbmt_button" type="submit" value="Submit"><?=$submit_btn_text?></button>
						<input type="hidden" name="missing_product" id="missing_product" />
					</div>

					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">

				</form>
			</div>

			<!-- Sidebar
			============================================= -->
			<div class="sidebar col_last nobottommargin">

				<address>
				  <strong><?=$missing_product_form_address_heading_text?>:</strong><br>
				  <?php
				  if($company_name) {
					 echo '<strong>'.$company_name.'</strong>';
				  }
				  if($company_address) {
					 echo '<br />'.$company_address;
				  }
				  if($company_city) {
					 echo '<br />'.$company_city.', '.$company_state.' '.$company_zipcode;
				  }
				  if($company_country) {
					 echo '<br />'.strtoupper($company_country);
				  } ?>
				</address>
				
				<?php
				if($site_phone) {
					echo '<abbr title="'.$phone_title.'"><strong>'.$phone_title.':</strong></abbr> '.$site_phone.'<br>';
				}
				if($site_email) {
					echo '<abbr title="'.$email_title.'"><strong>'.$email_title.':</strong></abbr> '.$site_email.'<br>';
				} ?>

				<div class="widget noborder notoppadding">
					<?php //START for socials link
					if($socials_link) { ?>
						<?=$socials_link?>
					<?php
					} //END for socials link ?>
				</div>
			</div><!-- .sidebar end -->
		</div>
	</div>
</section>

<script>
<?php
//if($missing_product_form_captcha == '1') { ?>
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
	
		$('#req_quote_form').bootstrapValidator({
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
				},
				item_name: {
					validators: {
						notEmpty: {
							message: '<?=$validation_item_name_msg_text?>'
						}
					}
				},
				message: {
					validators: {
						notEmpty: {
							message: '<?=$validation_message_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
			$('#req_quote_form').data('bootstrapValidator').resetForm();

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