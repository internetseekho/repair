<?php
//Get from index.php, get_device_single_data function
$device_single_data=$device_single_data_resp['device_single_data'];
$device_id = $device_single_data['device_id'];
if($device_id>0) {
	$meta_title = $device_single_data['d_meta_title'];
	$meta_desc = $device_single_data['d_meta_desc'];
	$meta_keywords = $device_single_data['d_meta_keywords'];
	$meta_canonical_url = $device_single_data['d_meta_canonical_url'];
	
	$sub_title = $device_single_data['device_sub_title'];
	$description = $device_single_data['description'];
	$long_description = $device_single_data['long_description'];

	$main_img = '';
	if(trim($device_single_data['device_header_img'])!="") {
		$main_img = '<img class="image" src="'.SITE_URL.'images/device/'.$device_single_data['device_header_img'].'" alt="'.$device_single_data['device_title'].'">';
	}

	//Header section
	include("include/header.php");
} else {
	$description = $active_page_data['content'];
	if($active_page_data['image']) {
		$main_img = '<img class="image" src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'">';
	}
}

//Fetching data from model
require_once('models/model.php');

/*$brand_data_list = get_device_brands_data_list($device_id, $devices_id);
if(count($brand_data_list)>1) { ?>
<section id="services">
	<div class="container clearfix center">
		<div class="clear"></div>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3>Select <strong>your brand</strong></h3>
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
					<a href="<?=SITE_URL.$brand_data['device_sef_url'].'/'.$brand_data['brand_sef_url']?>">
						<?php
						if($brand_data['brand_img']) {
							echo '<img loading="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['brand_img'].'" alt="'.$brand_data['title'].'">';
						} ?>
						<h4><?=$brand_data['title']?></h4>
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
	if($description) { ?>
		<section class="content">
			<div class="container clearfix">
			<?php
			if($sub_title!="" || $description!="") { ?>
				<div class="heading-block topmargin-sm bottommargin-sm center">
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
	}
} else {*/
	//Get data from models/model.php, get_model_data_list function
	$model_data_list = get_model_data_list($device_id, $devices_id, $cat_id);
	$model_num_of_rows = count($model_data_list);
	if($model_num_of_rows>0) { ?>
		<section id="content">
			<div class="container clearfix center">
			
				<?php
				//START for confirm message
				$confirm_message = getConfirmMessage()['msg'];
				echo $confirm_message;
				//END for confirm message ?>
				
				<div class="clear"></div>
				<div class="heading-block topmargin-sm bottommargin-sm center">
					<h3><?=$model_list_page_title?></h3>
					<span class="divcenter"><?=$model_list_page_sub_title?></span>
				</div>
		
				<div id="portfolio" class="portfolio grid-container clearfix">
		
				<?php
				foreach($model_data_list as $model_list) {
					$models_text = $model_list['models'];
					$models_text = ($models_text?" - ".$models_text:"");
					
					//$storage_list = json_decode($model_list['storage']); ?>
					
					<article class="portfolio-item pf-media pf-icons">
						<div class="inner">
							<?php
							if($model_list['model_img']) {
								//$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_list['model_img'].'&h=144';
								$md_img_path = SITE_URL.'images/mobile/'.$model_list['model_img']; ?>
								<div class="portfolio-image">
									<a href="<?=SITE_URL.$model_details_page_slug.$model_list['sef_url']?>">
										<img loading="lazy" src="<?=$md_img_path?>" alt="<?=$model_list['title'].$models_text?>">
									</a>
									<div class="portfolio-overlay">
										<?php /*?><a href="<?=SITE_URL.'images/mobile/'.$model_list['model_img']?>" class="left-icon" data-lightbox="image" title="<?=$model_list['title'].$models_text?>"><i class="icon-line-plus"></i></a><?php */?>
										<a href="<?=SITE_URL.$model_details_page_slug.$model_list['sef_url']?>" class="center-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
							<?php
							} ?>
							<div class="portfolio-desc">
								<h3><a href="<?=SITE_URL.$model_details_page_slug.$model_list['sef_url']?>"><?=$model_list['title']?></a></h3>
							</div>
						</div>
					</article>
				<?php
				}
	
				//START missing product section & quote request email...
				/*if($show_missing_model_section=='1') {
					if(trim($device_single_data['missing_product_url'])!="") { ?>
						<article class="portfolio-item pf-media pf-icons">
							<div class="portfolio-image">
								<a href="<?=$device_single_data['missing_product_url']?>">
									<img loading="lazy" src="<?=SITE_URL?>images/iphone-missing.png" alt="I don't see my Device">
								</a>
								<div class="portfolio-overlay">
									<a href="<?=SITE_URL?>images/iphone-missing.png" class="left-icon" data-lightbox="image" title="I don't see my Device"><i class="icon-line-plus"></i></a>
									<a href="<?=$device_single_data['missing_product_url']?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
								</div>
							</div>
							<div class="portfolio-desc">
								<h3><a href="<?=$device_single_data['missing_product_url']?>">I don't see my Device</a></h3>
								<span>&nbsp;</span>
							</div>
						</article>
					<?php
					} else { ?>
						<article class="portfolio-item pf-media pf-icons">
							<div class="portfolio-image">
								<a href="#" data-toggle="modal" data-target="#MissingProduct">
									<img loading="lazy" src="<?=SITE_URL?>images/iphone-missing.png" alt="I don't see my Device">
								</a>
								<div class="portfolio-overlay">
									<a href="<?=SITE_URL?>images/iphone-missing.png" class="left-icon" data-lightbox="image" title="I don't see my Device"><i class="icon-line-plus"></i></a>
									<a href="#" class="right-icon" data-toggle="modal" data-target="#MissingProduct"><i class="icon-line-ellipsis"></i></a>
								</div>
							</div>
							<div class="portfolio-desc">
								<h3><a href="#" data-toggle="modal" data-target="#MissingProduct">I don't see my Device</a></h3>
								<span>&nbsp;</span>
							</div>
						</article>
					<?php
					}
				}  //END missing product section & quote request email...*/ ?>
			  </div>
			  
			<?php
			//START missing product section & quote request email...
			if($show_missing_model_section=='1') { ?>
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
		if($description) { ?>
			<section class="content">
				<div class="container clearfix">
				<?php
				if($sub_title!="" || $description!="") { ?>
					<div class="heading-block topmargin-sm bottommargin-sm center">
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

		<!--START for review section-->
		<?php
		if($display_on_model_page == '1') {
		  //Get review list
		  $review_list_data = get_review_list_data_random();
		  if(!empty($review_list_data)) { ?>
			<div class="container clearfix">
				<div class="fslider testimonial testimonial-full bottommargin topmargin-sm nobottompadding" data-animation="fade" data-arrows="false">
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
		<!--END for review section-->
	<?php
	} else { ?>
		<div class="container topmargin-sm bottommargin clearfix">
			<div class="clear"></div>
			
			<div class="promo promo-center">
				<h3><i class="icon-warning-sign text-danger"></i> <?=$item_not_available_text?></h3>
			</div>
	
			<?php
			//START missing product section & quote request email...
			if($show_missing_model_section=='1') { ?>
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
//} ?>

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
