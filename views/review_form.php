<?php
$csrf_token = generateFormToken('review');

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
					<a class="btn btn-primary" href="<?=SITE_URL?>reviews"><?=$view_all_review_btn_text?></a>
				</div>
				<?php
				}
				
				if($active_page_data['content']) { ?>
					<div class="form-group">
						<?=$active_page_data['content']?>
					</div>
				<?php
				}
				
			    //START for confirm message
			    $confirm_message = getConfirmMessage()['msg'];
			    echo $confirm_message;
			    //END for confirm message ?>
			  
				<form action="controllers/review_form.php" class="phone-sell-form" method="post" id="review_form" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col-md-4">
							<input type="text" name="name" id="name" placeholder="<?=$name_field_placeholder_text?>" class="sm-form-control" value="<?=$user_full_name?>" />
						</div>
						<div class="form-group col-md-4">
							<input type="text" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" class="sm-form-control" value="<?=$user_email?>" />
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
						<div class="form-group col-md-3">
							<input type="text" name="state" id="state" placeholder="<?=$state_field_placeholder_text?>" class="sm-form-control" value="<?=$user_data['state']?>" />
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="city" id="city" placeholder="<?=$city_field_placeholder_text?>" class="sm-form-control" value="<?=$user_data['city']?>" />
						</div>
						<div class="form-group col-md-3">
							<select name="rating" id="rating" class="sm-form-control">
								<option value=""> - <?=$rating_star_field_title?> - </option>
								<?php
								for($si = 0.5; $si<= 5.0; $si=$si+0.5) { ?>
									<option value="<?=$si?>" <?php if($si == '4.5'){echo 'selected="selected"';}?>><?=$si?></option>
								<?php
								} ?>
							</select>
							<small class="help-block"><strong><?=$rating_star_field_desc?></strong></small>
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="title" id="title" placeholder="<?=$title_field_placeholder_text?>" class="sm-form-control" />
						</div>
						<div class="form-group col-md-12">
							<input type="file" class="sm-form-control" name="image" id="image">
						</div>
						<div class="form-group col-md-12">
							<textarea name="content" id="content" placeholder="<?=$content_field_placeholder_text?>" class="sm-form-control" rows="6" cols="30"></textarea>
						</div>
						
						<?php
						if($write_review_form_captcha == '1') { ?>
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
if($write_review_form_captcha == '1') { ?>
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
} ?>

(function( $ ) {
	$(function() {
		
		$(".choose-review-image").change(function(e) {
            var fileName = e.target.files[0].name;
			var file_ext = fileName.replace(/^.*\./,'');
			if(file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'png' || file_ext == 'gif') {
           		$(".review-image-name").html(fileName);
			} else {
				alert("Only jpg/jpeg/png/gif are allowed!");
				return false;
			}
        });
		
		$('#review_form').bootstrapValidator({
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
				rating: {
					validators: {
						notEmpty: {
							message: '<?=$validation_rating_star_msg_text?>'
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
							message: '<?=$validation_content_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#review_form').data('bootstrapValidator').resetForm();

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