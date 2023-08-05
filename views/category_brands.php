<?php
$category_data=$category_single_data_resp['category_single_data'];
$cat_id = $category_data['id'];

$meta_title = $category_data['meta_title'];
$meta_desc = $category_data['meta_desc'];
$meta_keywords = $category_data['meta_keywords'];
$meta_canonical_url = $category_data['meta_canonical_url'];

$main_title = $category_data['title'];
$sub_title = $category_data['sub_title'];
$description = $category_data['description'];
$long_description = $category_data['long_description'];

$main_img = '';
if($category_data['image']) {
	$main_img = '<img class="image" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$main_title.'">';
}

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/device_category.php');

//Get data from models/device_cat_brands.php, get_brand_data_list function
$brand_data_list = get_brand_data_list($cat_id);
$brand_num_of_rows = count($brand_data_list);
if($brand_num_of_rows == '1') {
	//$brand_cat_url = SITE_URL.'device-brand/'.$brand_data_list['0']['brand_id'].'/'.$cat_id;
	//setRedirect($brand_cat_url,'');
	//exit();
}
if($brand_num_of_rows>0) { ?>
<section id="model">
	<div class="container clearfix center">
		<div class="clear"></div>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$brand_list_page_title?></h3>
		</div>
		
		<?php
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
		//END for confirm message ?>
		
		<ul class="clients-grid grid-4 bottommargin-sm clearfix">
		
			<?php
			foreach($brand_data_list as $brand_data) { ?>
				<li>
					<a href="<?=SITE_URL.$category_data['sef_url'].'/'.$brand_data['brand_sef_url']?>" class="d-flex align-items-center">
						<div class="inner mx-auto">
							<?php
							if($brand_data['brand_image']) {
								echo '<img loading="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['brand_image'].'" alt="'.$brand_data['brand_title'].'">';
							} ?>
							<h4><?=$brand_data['brand_title']?></h4>
						</div>
					</a>
				</li>
			<?php
			} ?>
		</ul>
		
		<?php
		//START missing product section & quote request email...
		if($show_missing_brand_section=='1') { ?>
		<div class="promo promo-border bottommargin-sm topmargin-sm">
			<h3><?=$missing_product_box_title?></h3>
			<span><?=$missing_product_box_sub_title?></span>
			<a href="#" class="button button-xlarge button-rounded" data-toggle="modal" data-target="#MissingProduct"><?=$missing_product_box_btn_text?></a>
		</div>
		<?php
		} //END missing product section & quote request email... ?>
		
	</div>
	</section>
<?php
} else {
	$description = ""; ?>
	<div class="container topmargin-sm bottommargin clearfix">
		<div class="clear"></div>
		
		<div class="promo promo-center">
			<h3><i class="icon-warning-sign text-danger"></i> <?=$item_not_available_text?></h3>
		</div>

		<?php
		//START missing product section & quote request email...
		if($show_missing_brand_section=='1') { ?>
		<div class="promo promo-border bottommargin-sm topmargin-sm">
			<h3><?=$missing_product_box_title?></h3>
			<span><?=$missing_product_box_sub_title?></span>
			<a href="#" class="button button-xlarge button-rounded" data-toggle="modal" data-target="#MissingProduct"><?=$missing_product_box_btn_text?></a>
		</div>
		<?php
		} //END missing product section & quote request email... ?>

	</div>
<?php
}
if($description) { ?>
	<section class="content">
		<div class="container clearfix">
		<?php
		if($sub_title!="" || $description!="") { ?>
			<div class="heading-block topmargin-lg bottommargin-sm center">
				<?php
				if($sub_title!="") { ?>
					<h3><strong><?=$sub_title?></strong></h3>
				<?php
				}
				if($description!="") { ?>
					<span class="divcenter"><?=$description?></span>
				<?php
				} ?>
			</div>
		<?php
		}
		echo $long_description; ?>
		</div>
	</section>
<?php
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