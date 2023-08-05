<?php
//Fetching data from model
require_once('models/page.php');

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
}

if($active_page_data['cats_in_menu'] == '1') {
	//Get data from admin/include/functions.php, get_brand_data function
	$cat_data_list = get_category_data_list();
	$num_of_cat = count($cat_data_list);
	if($num_of_cat>0) { ?>

		<div class="section brand nobg m-0 py-5">
			<div class="container clearfix center">
				<div class="clear"></div>
				<?php
				if(($is_show_title && $show_title == '1') || $active_page_data['content']) { ?>
					<div class="heading-block topmargin-sm bottommargin-sm center">
						<?php
						if($is_show_title && $show_title == '1') {
							echo '<h3>'.$page_title.'</h3>';
						}
						if($active_page_data['content']) {
							echo '<span class="divcenter">'.$active_page_data['content'].'</span>';
						} ?>
					</div>
				<?php
				}
				
				//START for confirm message
				$confirm_message = getConfirmMessage()['msg'];
				echo $confirm_message;
				//END for confirm message ?>
			
				<ul class="clients-grid grid-4 nobottommargin clearfix">
				<?php
				foreach($cat_data_list as $cat_data) { ?>
					<li>
						<a href="<?=SITE_URL.$category_details_page_slug.$cat_data['sef_url']?>" class="d-flex align-items-center">
							<div class="inner mx-auto">
								<?php
								if($cat_data['image']) {
									echo '<img loading="lazy" src="'.SITE_URL.'images/categories/'.$cat_data['image'].'" alt="'.$cat_data['title'].'">';
								} ?>
								<h4><?=$cat_data['title']?></h4>
							</div>
						</a>
					</li>
				<?php
				} ?>
				</ul>
			
				<?php /*?><ul class="clients-grid grid-4 bottommargin-sm clearfix">
					<?php
					foreach($cat_data_list as $cat_data) { ?>
						<li>
							<a href="<?=SITE_URL.$cat_data['sef_url']?>">
								<?php
								if($cat_data['image']) {
									echo '<img loading="lazy" src="'.SITE_URL.'images/categories/'.$cat_data['image'].'" alt="'.$cat_data['title'].'">';
								} ?>
								<h4><?=$cat_data['title']?></h4>
							</a>
						</li>
					<?php
					} ?>
				</ul><?php */?>
				
				<?php /*?><div id="oc-portfolio-cats" class="owl-carousel portfolio-carousel carousel-widget" data-margin="20" data-nav="true" data-pagi="false" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
					<?php
					foreach($cat_data_list as $cat_data) { ?>
						<div class="oc-item">
							<div class="iportfolio">
								<?php
								if($cat_data['image']) {
									$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/categories/'.$cat_data['image'].'&h=178'; ?>
									<div class="portfolio-image">
										<a href="<?=SITE_URL.$cat_data['sef_url']?>">
											<img loading="lazy" src="<?=$md_img_path?>" alt="<?=$cat_data['title']?>">
										</a>
									</div>
								<?php
								} ?>
								<div class="portfolio-desc">
									<h3><a href="<?=SITE_URL.$cat_data['sef_url']?>"><?=$cat_data['title']?></a></h3>
								</div>
							</div>
						</div>
					<?php
					} ?>
				</div><?php */?>
				
				<?php
				//START missing product section & quote request email...
				if($show_missing_category_section=='1') { ?>
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
		/*if($active_page_data['content']!="") { ?>
			<section class="content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<article>
								<?php
								if($active_page_data['show_title'] == '1') {
									echo '<h1 class="h2"><strong>'.$active_page_data['title'].'</strong></h1>';
								} ?>
								<?=$active_page_data['content']?>
							</article>
						</div>
					</div>
				</div>
			</section>
		<?php
		}*/
	} else { ?>
		<div class="container topmargin-sm bottommargin-sm clearfix">
			<div class="clear"></div>
			
			<div class="promo promo-center">
				<h3><i class="icon-warning-sign text-danger"></i> <?=$item_not_available_text?></h3>
			</div>

			<?php
			//START missing product section & quote request email...
			if($show_missing_category_section=='1') { ?>
			<div class="promo promo-border bottommargin topmargin-sm">
				<h3><?=$missing_product_box_title?></h3>
				<span><?=$missing_product_box_sub_title?></span>
				<a href="#" class="button button-xlarge button-rounded" data-toggle="modal" data-target="#MissingProduct"><?=$missing_product_box_btn_text?></a>
			</div>
			<?php
			} //END missing product section & quote request email... ?>

		</div>
	<?php
	}
}
elseif($active_page_data['brands_in_menu'] == '1') {
	//Get data from admin/include/functions.php, get_brand_data function
	$brand_data_list = get_brand_data();
	$num_of_brand = count($brand_data_list);
	if($num_of_brand>0) { ?>
		
		<div class="section brand nobg m-0 py-5">
			<div class="container clearfix center">
				<div class="clear"></div>
				<?php
				if(($is_show_title && $show_title == '1') || $active_page_data['content']) { ?>
					<div class="heading-block topmargin-sm bottommargin-sm center">
						<?php
						if($is_show_title && $show_title == '1') {
							echo '<h3>'.$page_title.'</h3>';
						}
						if($active_page_data['content']) {
							echo '<span class="divcenter">'.$active_page_data['content'].'</span>';
						} ?>
					</div>
				<?php
				}
				
				//START for confirm message
				$confirm_message = getConfirmMessage()['msg'];
				echo $confirm_message;
				//END for confirm message ?>
			
				<ul class="clients-grid grid-5 nobottommargin clearfix">
				<?php
				foreach($brand_data_list as $brand_data) {
					//$brand_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/brand/'.$brand_data['image'].'&h=54'; ?>
					<li>
						<a href="<?=SITE_URL.$brand_data['sef_url']?>" class="d-flex align-items-center">
							<div class="inner mx-auto">
								<?php
								if($brand_data['image']) {
									echo '<img loading="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'">';
								} ?>
								<h4><?=$brand_data['title']?></h4>
							</div>
						</a>
					</li>
				<?php
				} ?>
				</ul>
						
				<?php /*?><ul class="clients-grid grid-4 bottommargin-sm clearfix">
					<?php
					foreach($brand_data_list as $brand_data) { ?>
						<li>
							<a href="<?=SITE_URL.$brand_data['sef_url']?>">
								<?php
								if($brand_data['image']) {
									echo '<img loading="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'">';
								} ?>
								<h4><?=$brand_data['title']?></h4>
							</a>
						</li>
					<?php
					} ?>
				</ul><?php */?>
			
				<?php
				//START missing product section & quote request email...
				if($show_missing_brand_section=='1') { ?>
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
		/*if($active_page_data['content']!="") { ?>
			<section class="content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<article>
								<?php
								if($active_page_data['show_title'] == '1') {
									echo '<h1 class="h2"><strong>'.$active_page_data['title'].'</strong></h1>';
								} ?>
								<?=$active_page_data['content']?>
							</article>
						</div>
					</div>
				</div>
			</section>
		<?php
		}*/
	} else { ?>
		<div class="container topmargin-sm bottommargin-sm clearfix">
			<div class="clear"></div>
			
			<div class="promo promo-center">
				<h3><i class="icon-warning-sign text-danger"></i> <?=$item_not_available_text?></h3>
			</div>

			<?php
			//START missing product section & quote request email...
			if($show_missing_category_section=='1') { ?>
			<div class="promo promo-border bottommargin topmargin-sm">
				<h3><?=$missing_product_box_title?></h3>
				<span><?=$missing_product_box_sub_title?></span>
				<a href="#" class="button button-xlarge button-rounded" data-toggle="modal" data-target="#MissingProduct"><?=$missing_product_box_btn_text?></a>
			</div>
			<?php
			} //END missing product section & quote request email... ?>

		</div>
	<?php
	}
} elseif($active_page_data['devices_in_menu'] == '1') {
	//Get data from admin/include/functions.php, get_device_data_list function
	$device_data_list = get_device_data_list($active_page_data['fltr_devices_in_menu']);
	$num_of_device = count($device_data_list);
	if($num_of_device>0) { ?>
		
		<div class="section brand nobg m-0 py-5">
			<div class="container clearfix center">
				<div class="clear"></div>
			<?php
			if($active_page_data['show_title'] == '1' || $active_page_data['content']) { ?>
				<div class="heading-block topmargin-sm bottommargin-sm center">
					<?php
					if($active_page_data['show_title'] == '1') {
						echo '<h3>'.$active_page_data['title'].'</h3>';
					}
					if($active_page_data['content']) {
						echo '<span class="divcenter">'.$active_page_data['content'].'</span>';
					} ?>
				</div>
			<?php
			}
			
			//START for confirm message
			$confirm_message = getConfirmMessage()['msg'];
			echo $confirm_message;
			//END for confirm message ?>
			
			<ul class="clients-grid grid-5 nobottommargin clearfix">
				<?php
				foreach($device_data_list as $device_data) { ?>
					<li>
						<a href="<?=SITE_URL.$device_data['sef_url']?>" class="d-flex align-items-center">
							<div class="inner mx-auto">
							<?php
							if($device_data['device_img']) {
								echo '<img loading="lazy" src="'.SITE_URL.'images/device/'.$device_data['device_img'].'" alt="'.$device_data['title'].'">';
							} ?>
							<h4><?=$device_data['title']?></h4>
						</div>
						</a>
					</li>
				<?php
				} ?>
			</ul>
			
			<?php /*?><div id="oc-portfolio" class="owl-carousel portfolio-carousel carousel-widget" data-margin="20" data-nav="true" data-pagi="false" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
				<?php
				foreach($device_data_list as $device_data) { ?>
				<div class="oc-item">
					<div class="iportfolio">
						<?php
						if($device_data['device_img']) {
							//$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=144';
							$device_img_path = SITE_URL.'images/device/'.$device_data['device_img']; ?>
							<div class="portfolio-image">
								<a href="<?=$device_data['sef_url']?>">
									<img loading="lazy" src="<?=$device_img_path?>" alt="<?=$device_data['title']?>">
								</a>
							</div>
						<?php
						} ?>
						<div class="portfolio-desc">
							<h3><a href="<?=$device_data['sef_url']?>"><?=$device_data['title']?></a></h3>
						</div>
					</div>
				</div>
				<?php
				} ?>
			</div><?php */?>

			<?php
			//START missing product section & quote request email...
			if($show_missing_category_section=='1') { ?>
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
	} else { ?>
		<div class="container topmargin-sm bottommargin-sm clearfix">
			<div class="clear"></div>
			
			<div class="promo promo-center">
				<h3><i class="icon-warning-sign text-danger"></i> <?=$item_not_available_text?></h3>
			</div>

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
	<?php
	}
} else {
	$pg_content = $active_page_data['content'];
	preg_match_all("/\[models](.*?)\[\/models\]/is", $pg_content, $matches);
	if($matches[0]>0) { ?>
	<section class="content <?=(!$is_show_title?'py-5':'')?>">
		<div class="container clearfix center">
			<?php
			if($is_show_title && $show_title == '1') { ?>
			<div class="heading-block topmargin-sm bottommargin-sm center">
				<h2><?=$page_title?></h2>
			</div>
			<?php
			} /*?>
			<div class="row">
				<div class="col-md-12">
				<?php*/
				foreach($matches[0] as $shortcode_name) {
					$ids_from_short_code = '';
					$ids_from_short_code = str_replace(array('[models]','[/models]'),array('',''),$shortcode_name);
				
					//Get data from functions.php, get_shortcode_model_data_list function
					$model_data_list = get_shortcode_model_data_list($ids_from_short_code);
				
					$shortcode_based_models  = '';
					//$shortcode_based_models .= '<section class="items-phone">';
					$shortcode_based_models .= '<div id="portfolio" class="portfolio grid-container clearfix">';
					  //$shortcode_based_models .= '<div class="col-md-12">';
				
						$model_num_of_rows = count($model_data_list);
						if($model_num_of_rows>0) {
							foreach($model_data_list as $model_list) {
								$device_single_data = get_device_single_data_by_id($model_list['device_id']);
								
								$models_text = $model_list['models'];
								$models_text = ($models_text?" - ".$models_text:"");
								
								$shortcode_based_models .= '<article class="portfolio-item pf-media pf-icons">';
									$shortcode_based_models .= '<div class="inner">';
										if($model_list['model_img']) {
											$md_img_path = SITE_URL.'images/mobile/'.$model_list['model_img'];
											$shortcode_based_models .= '<div class="portfolio-image">';
												$shortcode_based_models .= '<a href="'.SITE_URL.$model_list['sef_url'].'">';
													$shortcode_based_models .= '<img loading="lazy" src="'.$md_img_path.'" alt="'.$model_list['title'].$models_text.'">';
												$shortcode_based_models .= '</a>';
												$shortcode_based_models .= '<div class="portfolio-overlay">';
													$shortcode_based_models .= '<a href="'.SITE_URL.$model_list['sef_url'].'" class="center-icon"><i class="icon-line-ellipsis"></i></a>';
												$shortcode_based_models .= '</div>';
											$shortcode_based_models .= '</div>';
										}
										$shortcode_based_models .= '<div class="portfolio-desc">';
											$shortcode_based_models .= '<h3><a href="'.SITE_URL.$model_list['sef_url'].'">'.$model_list['device_title'].$models_text.'</a></h3>';
											$shortcode_based_models .= '<span>'.$model_list['title'].'</span>';
										$shortcode_based_models .= '</div>';
									$shortcode_based_models .= '</div>';
								$shortcode_based_models .= '</article>';
								
								/*//$shortcode_based_models .= '<div class="col-md-4">';
								  //$shortcode_based_models .= '<div class="item clearfix">';
									$shortcode_based_models .= '<a class="item text-center" href="'.$device_single_data['d_sef_url'].'/'.$model_list['sef_url'].'">';
									$shortcode_based_models .= '<div class="item-inner">';
									  //$shortcode_based_models .= '<div class="row">';
										if($model_list['model_img']) {
										$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_list['model_img'].'&h=144';
										//$shortcode_based_models .= '<div class="col-md-5">';
										  $shortcode_based_models .= '<div class="item-image">';
											$shortcode_based_models .= '<img loading="lazy" src="'.SITE_URL.'images/mobile/'.$model_list['model_img'].'" alt="'.$model_list['title'].$models_text.'">';
										  $shortcode_based_models .= '</div>';
										//$shortcode_based_models .= '</div>';
										}
										
										//$shortcode_based_models .= '<div class="col-md-7">';
										  $shortcode_based_models .= '<div class="h4"><strong>'.$model_list['device_title'].'</strong></div>';
										  $shortcode_based_models .= '<p>'.$model_list['title'].$models_text.'</p>';
										//$shortcode_based_models .= '</div>';
										
									  //$shortcode_based_models .= '</div>';
									$shortcode_based_models .= '</div>';
									$shortcode_based_models .= '</a>';
								  //$shortcode_based_models .= '</div>';
								//$shortcode_based_models .= '</div>';*/
							}
						}
					  //$shortcode_based_models .= '</div>';
					  //$shortcode_based_models .= '<div class="row"></div>';
					$shortcode_based_models .= '</div>';
					//$shortcode_based_models .= '</section>';
				
					$pg_content = str_replace($shortcode_name,$shortcode_based_models,$pg_content);
				}
				echo $pg_content;
				?>
				<?php /*?></div>
			</div><?php */?>
		</div>
	</section>
	<?php
	} else { ?>
	<section class="content">
		<div class="container clearfix">
			<div class="heading-block topmargin-sm bottommargin-sm center">
				<h2><?=$active_page_data['title']?></h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$active_page_data['content']?>
				</div>
			</div>
		</div>
	</section>
	<?php
	}
}

if($active_page_data['cats_in_menu'] == '1' || $active_page_data['brands_in_menu'] == '1' || $active_page_data['devices_in_menu'] == '1') {
?>
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
<?php
} ?>
