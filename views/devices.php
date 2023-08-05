<?php
if($active_page_data['image'] != "") { ?>
  <section>
    <div class="row">

    <?php
    if($active_page_data['image_text'] != "") {
       echo '<h2>'.$active_page_data['image_text'].'</h2>';
    } ?>

    <img loading="lazy" src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
    </div>
  </section>
<?php
}

//Fetching data from model
require_once('models/devices.php');

//Get model data list from models/search/devices.php, function get_device_data_list
$device_data_list = get_b_device_data_list($brand_id);
$num_of_device = count($device_data_list);
if($num_of_device>0) { ?>
<section id="model">
<div class="container clearfix center">
	<div class="clear"></div>
	<div class="heading-block topmargin-sm bottommargin-sm center">
		<h3><?=$device_list_page_title?></h3>
	</div>
	
	<?php
	//START for confirm message
	$confirm_message = getConfirmMessage()['msg'];
	echo $confirm_message;
	//END for confirm message ?>
	
	<ul class="clients-grid grid-4 bottommargin-sm clearfix">
	
		<?php
		foreach($device_data_list as $device_data) { ?>
			<li><a href="<?=$device_data['sef_url']?>">
				<?php
				if($device_data['device_img']) {
					//$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=153';
					$device_img_path = SITE_URL.'images/device/'.$device_data['device_img']; ?>
					<img loading="lazy" src="<?=$device_img_path?>" alt="<?=$device_data['title']?>">
				<?php
				} ?>
			<h4><?=$device_data['title']?></h4></a></li>
		<?php
		}

		/*//START missing product section & quote request email...
		if($show_missing_device_section=='1') {
			if(trim($device_single_data['missing_product_url'])!="") { ?>
				<li><a href="<?=$device_single_data['missing_product_url']?>"><img loading="lazy" src="<?=SITE_URL?>/images/iphone-missing.png" alt="I don't see my Device"><h4>I don't see my Device</h4></a></li>
			<?php
			} else { ?>
				<li><a href="#" data-toggle="modal" data-target="#MissingProduct"><img loading="lazy" src="<?=SITE_URL?>/images/iphone-missing.png" alt="I don't see my Device"><h4>I don't see my Device</h4></a></li>
			<?php
			}
		} //END missing product section & quote request email...*/ ?>
	</ul>
	
	<?php
	//START missing product section & quote request email...
	if($show_missing_device_section=='1') { ?>
	<div class="promo promo-border bottommargin topmargin-sm">
		<h3><?=$missing_product_box_title?></h3>
		<span><?=$missing_product_box_sub_title?></span>
		<a href="#" class="button button-xlarge button-rounded" data-toggle="modal" data-target="#MissingProduct"><?=$missing_product_box_btn_text?></a>
	</div>
	<?php
	} //END missing product section & quote request email... ?>
</div>
</div>
<?php
}

if($active_page_data['content']) { ?>
<section class="content">
	<div class="container clearfix">
		<?=$active_page_data['content']?>
	</div>
</section>
<?php
} ?>

<?php
if($display_on_device_page == '1') {
  //Get review list
  $review_list_data = get_review_list_data_random();
  if(!empty($review_list_data)) { ?>
	<div class="container clearfix">
		<div class="fslider testimonial testimonial-full bottommargin nobottompadding" data-animation="fade" data-arrows="false">
			<div class="flexslider">
				<div class="slider-wrap">
					<div class="slide">
						<div class="testi-image">
							<?php
							if($review_list_data['photo']) { ?>
								<a href="#"><img loading="lazy" src="<?=SITE_URL.'images/review/'.$review_list_data['photo']?>"></a>
							<?php
							} else { ?>
								<a href="#"><img loading="lazy" src="<?=SITE_URL?>images/placeholder_avatar.jpg"></a>
							<?php
							} ?>
						</div>
						<div class="testi-content">
							<p><?=$review_list_data['content']?></p>
							<div class="testi-meta">
								<?=$review_list_data['name']?>
								<span><?=($review_list_data['country']?$review_list_data['country'].', ':'').$review_list_data['state'].', '.$review_list_data['city']?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <?php
  }
} ?>
  
<div class="editAddress-modal modal fade HelpPopup" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<form method="post" action="<?=SITE_URL?>controllers/model.php" id="req_quote_form" class="nobottommargin">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel"><?=$quote_request_popup_title?></h4>
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<h4 class="nobottommargin"><?=$quote_request_popup_sub_title?></h4>
				<p><?=$quote_request_popup_desc?></p>
				<div class="form-row">
					<div class="form-group col-md-12">
					<input type="text" name="name" id="name" placeholder="<?=$name_field_placeholder_text?>" class="form-control" value="<?=$user_full_name?>" />
					</div>
					<div class="form-group col-md-12">
					<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="<?=$phone_field_placeholder_text?>" value="<?=$user_phone?>">
					<input type="hidden" name="phone" id="phone" />
					</div>
					<div class="form-group col-md-12">
					<input type="text" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" class="form-control" value="<?=$user_email?>" />
					</div>
					<div class="form-group col-md-12">
					<input type="text" name="item_name" id="item_name" placeholder="<?=$item_name_field_placeholder_text?>" class="form-control" />
					</div>
					<div class="form-group col-md-12">
					<textarea name="message" id="message" placeholder="<?=$message_field_placeholder_text?>" class="form-control"></textarea>
					</div>
					<?php
					if($missing_product_form_captcha == '1') { ?>
						<div class="form-group col-md-12">
							<div id="g_form_gcaptcha"></div>
							<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
						</div>
					<?php
					} ?>
					<!--<div class="form-group col-md-12">
						<button type="submit" class="btn btn-primary mt-0">Submit</button>
						<input type="hidden" name="missing_product" id="missing_product" />
					</div>-->
				</div>
				<?php
				$missing_p_csrf_token = generateFormToken('missing_product'); ?>
				<input type="hidden" name="csrf_token" value="<?=$missing_p_csrf_token?>">
			</div>
			<div class="modal-footer">
				<button type="submit" class="button mt-0"><?=$submit_btn_text?></button>
				<input type="hidden" name="missing_product" id="missing_product" />
				<button type="button" class="button button-danger mt-0" data-dismiss="modal">Close</button>
			</div>
		</form>
	</div>
  </div>
</div>
					
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
