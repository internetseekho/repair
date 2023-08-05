		<!-- Footer
		============================================= -->
		<footer id="footer" style="background-color: #FFF;">

			<div class="container">

				<!-- Footer Widgets
				============================================= -->
				<div class="footer-widgets-wrap border-bottom pb-3 clearfix">
					<div class="row clearfix">

						<div class="col-lg-7">
							<div class="row clearfix">
							  <?php
							  if($is_act_footer_menu_column1 == '1') { ?>
							  	<div class="col-md-4 col-lg-4 col-6 bottommargin-sm">
									<div class="widget widget_links app_landing_widget_link clearfix">
										<h4><?=$footer_menu_column1_title?></h4>
										<ul>
										  <?php
										  $footercolumn1_menu_list = get_menu_list('footer_column1');
										  foreach($footercolumn1_menu_list as $footercolumn1_menu_data) {
											  $is_open_new_window = $footercolumn1_menu_data['is_open_new_window'];
											  if($footercolumn1_menu_data['page_id']>0) {
												  $menu_url = $footercolumn1_menu_data['p_url'];
												  //$is_custom_url = $footercolumn1_menu_data['p_is_custom_url'];
											  } else {
												  $menu_url = $footercolumn1_menu_data['url'];
											  }
											  $is_custom_url = $footercolumn1_menu_data['is_custom_url'];
											  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
											  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
											  
											  $menu_fa_icon = "";
											  if($footercolumn1_menu_data['css_menu_fa_icon']) {
												  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn1_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
											  } ?>
											  <li <?=(count($footercolumn1_menu_data['submenu'])>0?'class="submenu"':'')?>>
												<a class="<?=$footercolumn1_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$footercolumn1_menu_data['menu_name'].$menu_fa_icon?></a>
												<?php
												if(count($footercolumn1_menu_data['submenu'])>0) {
													$footercolumn1_submenu_list = $footercolumn1_menu_data['submenu']; ?>
													<ul>
														<?php
														foreach($footercolumn1_submenu_list as $footercolumn1_submenu_data) {
															$s_is_open_new_window = $footercolumn1_submenu_data['is_open_new_window'];
															if($footercolumn1_submenu_data['page_id']>0) {
																//$s_is_custom_url = $footercolumn1_submenu_data['p_is_custom_url'];
																$s_menu_url = $footercolumn1_submenu_data['p_url'];
															} else {
																$s_menu_url = $footercolumn1_submenu_data['url'];
															}
															$s_is_custom_url = $footercolumn1_submenu_data['is_custom_url'];
															$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
															$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
															
															$submenu_fa_icon = "";
															if($footercolumn1_submenu_data['css_menu_fa_icon']) {
																$submenu_fa_icon = '&nbsp;<i class="'.$footercolumn1_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
															} ?>
															<li><a href="<?=$s_menu_url?>" class="<?=$footercolumn1_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn1_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
														<?php
														} ?>
													</ul>
												<?php
												} ?>
											  </li>
										  <?php
										  } ?>
										</ul>
								  </div>
							   </div>
							  <?php
							  }
							  
							  if($is_act_footer_menu_column2 == '1') { ?>
							  <div class="col-md-4 col-lg-4 col-6 bottommargin-sm">
									<div class="widget widget_links app_landing_widget_link clearfix">
								<h4><?=$footer_menu_column2_title?></h4>
								<ul>
								  <?php
								  $footercolumn2_menu_list = get_menu_list('footer_column2');
								  foreach($footercolumn2_menu_list as $footercolumn2_menu_data) {
									  $is_open_new_window = $footercolumn2_menu_data['is_open_new_window'];
									  if($footercolumn2_menu_data['page_id']>0) {
										  $menu_url = $footercolumn2_menu_data['p_url'];
										  //$is_custom_url = $footercolumn2_menu_data['p_is_custom_url'];
									  } else {
										  $menu_url = $footercolumn2_menu_data['url'];
									  }
									  $is_custom_url = $footercolumn2_menu_data['is_custom_url'];
									  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
									  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
									  
									  $menu_fa_icon = "";
									  if($footercolumn2_menu_data['css_menu_fa_icon']) {
										  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn2_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
									  } ?>
									  <li <?=(count($footercolumn2_menu_data['submenu'])>0?'class="submenu"':'')?>>
										<a class="<?=$footercolumn2_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$footercolumn2_menu_data['menu_name'].$menu_fa_icon?></a>
										<?php
										if(count($footercolumn2_menu_data['submenu'])>0) {
											$footercolumn2_submenu_list = $footercolumn2_menu_data['submenu']; ?>
											<ul>
												<?php
												foreach($footercolumn2_submenu_list as $footercolumn2_submenu_data) {
													$s_is_open_new_window = $footercolumn2_submenu_data['is_open_new_window'];
													if($footercolumn2_submenu_data['page_id']>0) {
														//$s_is_custom_url = $footercolumn2_submenu_data['p_is_custom_url'];
														$s_menu_url = $footercolumn2_submenu_data['p_url'];
													} else {
														$s_menu_url = $footercolumn2_submenu_data['url'];
													}
													$s_is_custom_url = $footercolumn2_submenu_data['is_custom_url'];
													$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
													$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
													
													$submenu_fa_icon = "";
													if($footercolumn2_submenu_data['css_menu_fa_icon']) {
														$submenu_fa_icon = '&nbsp;<i class="'.$footercolumn2_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
													} ?>
													<li><a href="<?=$s_menu_url?>" class="<?=$footercolumn2_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn2_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
												<?php
												} ?>
											</ul>
										<?php
										} ?>
									  </li>
								  <?php
								  } ?>
								</ul>
							  </div>
							  </div>
							  <?php
							  }
							  
							  if($is_act_footer_menu_column3 == '1') { ?>
							  <div class="col-md-4 col-lg-4 bottommargin-sm">
									<div class="widget widget_links app_landing_widget_link clearfix">
								<h4><?=$footer_menu_column3_title?></h4>
								<ul>
								  <?php
								  $footercolumn3_menu_list = get_menu_list('footer_column3');
								  foreach($footercolumn3_menu_list as $footercolumn3_menu_data) {
									  $is_open_new_window = $footercolumn3_menu_data['is_open_new_window'];
									  if($footercolumn3_menu_data['page_id']>0) {
										  $menu_url = $footercolumn3_menu_data['p_url'];
										  //$is_custom_url = $footercolumn3_menu_data['p_is_custom_url'];
									  } else {
										  $menu_url = $footercolumn3_menu_data['url'];
									  }
									  $is_custom_url = $footercolumn3_menu_data['is_custom_url'];
									  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
									  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
									  
									  $menu_fa_icon = "";
									  if($footercolumn3_menu_data['css_menu_fa_icon']) {
										  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn3_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
									  } ?>
									  <li <?=(count($footercolumn3_menu_data['submenu'])>0?'class="submenu"':'')?>>
										<a class="<?=$footercolumn3_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$footercolumn3_menu_data['menu_name'].$menu_fa_icon?></a>
										<?php
										if(count($footercolumn3_menu_data['submenu'])>0) {
											$footercolumn3_submenu_list = $footercolumn3_menu_data['submenu']; ?>
											<ul>
												<?php
												foreach($footercolumn3_submenu_list as $footercolumn3_submenu_data) {
													$s_is_open_new_window = $footercolumn3_submenu_data['is_open_new_window'];
													if($footercolumn3_submenu_data['page_id']>0) {
														//$s_is_custom_url = $footercolumn3_submenu_data['p_is_custom_url'];
														$s_menu_url = $footercolumn3_submenu_data['p_url'];
													} else {
														$s_menu_url = $footercolumn3_submenu_data['url'];
													}
													$s_is_custom_url = $footercolumn3_submenu_data['is_custom_url'];
													$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
													$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
													
													$submenu_fa_icon = "";
													if($footercolumn3_submenu_data['css_menu_fa_icon']) {
														$submenu_fa_icon = '&nbsp;<i class="'.$footercolumn3_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
													} ?>
													<li><a href="<?=$s_menu_url?>" class="<?=$footercolumn3_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn3_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
												<?php
												} ?>
											</ul>
										<?php
										} ?>
									  </li>
								  <?php
								  } ?>
								</ul>
							  </div>
							  </div>
							  <?php
							  } ?>
							</div>
						</div>

						<div class="col-lg-5">
							
							<div class="widget clearfix">
								<div class="row clearfix">
									<div class="col-lg-8 bottommargin-sm clearfix" style="color:#888;">
										<img src="<?=$logo_url?>" alt="<?=SITE_NAME?>" style="display:block;" class="bottommargin-sm bottom-logo lazy">
										<?php //START for socials link
										if($socials_link) { ?>
											<?=$socials_link?>
										<?php
										} //END for socials link ?>

									</div>
								</div>
							</div>
							
							<div class="widget notopmargin clearfix">
								<div class="row clearfix">
									<div class="col-lg-12 bottommargin-sm clearfix">
										<form id="footer_signup_form" action="<?=$signup_link?>" method="get" class="nobottommargin">
											<div class="input-group" style="max-width:400px;">
												<div class="input-group-prepend">
													<div class="input-group-text"><i class="icon-email2"></i></div>
												</div>
												<input type="email" name="email" id="email" class="form-control required email" placeholder="<?=$footer_newsletter_placeholder_text?>" required>
												<div class="input-group-append">
													<button class="btn btn-info" type="submit"><?=$signup_btn_text?></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							
						</div>

					

					</div>
				</div>

			</div>

			<!-- Copyrights
			============================================= -->
			<div id="copyrights" class="nobg">
				<div class="container clearfix">
					<div class="row">
						<div class="col-md-6">
							<?=($copyright?$copyright:'')?>
						</div>
						<div class="col-md-6">
						  <?php
						  if($is_act_copyright_menu == '1') { ?>
							  <div class="copyrights-menu copyright-links clearfix text-right">
								  <?php
								  $copyright_menu_list = get_menu_list('copyright_menu');
								  $cp_i = 0;
								  $cp_len = count($copyright_menu_list);
								  foreach($copyright_menu_list as $copyright_menu_data) {
									  $is_open_new_window = $copyright_menu_data['is_open_new_window'];
									  if($copyright_menu_data['page_id']>0) {
										  $menu_url = $copyright_menu_data['p_url'];
										  //$is_custom_url = $copyright_menu_data['p_is_custom_url'];
									  } else {
										  $menu_url = $copyright_menu_data['url'];
									  }
									  $is_custom_url = $copyright_menu_data['is_custom_url'];
									  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
									  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
									  
									  $menu_fa_icon = "";
									  if($copyright_menu_data['css_menu_fa_icon']) {
										  $menu_fa_icon = '&nbsp;<i class="'.$copyright_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
									  } ?>
										<a class="<?=$copyright_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$copyright_menu_data['menu_name'].$menu_fa_icon?></a> <?=(($cp_i == $cp_len - 1)?"":" /")?>
								  <?php
								  $cp_i++;
								  } ?>
							  </div>
						  <?php
						  } ?>
						</div>
					</div>
				</div>
			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->
		
	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script src="<?=SITE_URL?>js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="<?=SITE_URL?>js/functions.js"></script>

	<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
	<?php /*?><script src="<?=SITE_URL?>include/rs-plugin/js/jquery.themepunch.tools.min.js"></script> 
	<script src="<?=SITE_URL?>include/rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 
	
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.video.min.js"></script> 
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.slideanims.min.js"></script> 
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.actions.min.js"></script>
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js"></script>
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.kenburn.min.js"></script>
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.navigation.min.js"></script>
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.migration.min.js"></script>
	<script src="<?=SITE_URL?>include/rs-plugin/js/extensions/revolution.extension.parallax.min.js"></script> 
<?php */?>

	<!-- DatePicker JS -->
	<script src="<?=SITE_URL?>js/components/datepicker.js"></script>
	<script src="<?=SITE_URL?>js/jquery.autocomplete.min.js"></script>
	<script src="<?=SITE_URL?>js/intlTelInput.js"></script>
	<script src="<?=SITE_URL?>js/bootstrapvalidator.min.js"></script>
	<script src="<?=SITE_URL?>js/slick.min.js"></script>
	<script src="<?=SITE_URL?>js/jquery.matchHeight-min.js"></script>
	<?php /*?><script src="<?=SITE_URL?>js/jquery.lazy.min.js" type="text/javascript"></script><?php */?>
	
	<script>
	var tpj=jQuery;
	tpj.noConflict();
	
	tpj(document).ready(function() {

		tpj('.home-slide').on('init', function () {
			tpj('.home-slide').css('visibility', 'visible');
		});

		tpj('.home-slide').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			dots: true,
  			centerMode: true,
		});
	
		// var apiRevoSlider = tpj('#rev_slider_ishop').show().revolution(
		// {
		// 	sliderType:"standard",
		// 	jsFileLocation:"<?=SITE_URL?>include/rs-plugin/js/",
		// 	sliderLayout:"fullwidth",
		// 	dottedOverlay:"none",
		// 	delay:9000,
		// 	navigation: {},
		// 	responsiveLevels:[1200,992,768,480,320],
		// 	gridwidth:1140,
		// 	gridheight:500,
		// 	lazyType:"none",
		// 	shadow:0,
		// 	spinner:"off",
		// 	autoHeight:"off",
		// 	disableProgressBar:"on",
		// 	hideThumbsOnMobile:"off",
		// 	hideSliderAtLimit:0,
		// 	hideCaptionAtLimit:0,
		// 	hideAllCaptionAtLilmit:0,
		// 	debugMode:false,
		// 	fallbacks: {
		// 		simplifyAll:"off",
		// 		disableFocusListener:false,
		// 	},
		// 	navigation: {
		// 		keyboardNavigation:"off",
		// 		keyboard_direction: "horizontal",
		// 		mouseScrollNavigation:"off",
		// 		onHoverStop:"off",
		// 		touch:{
		// 			touchenabled:"on",
		// 			swipe_threshold: 75,
		// 			swipe_min_touches: 1,
		// 			swipe_direction: "horizontal",
		// 			drag_block_vertical: false
		// 		},
		// 		arrows: {
		// 			style: "ares",
		// 			enable: true,
		// 			hide_onmobile: false,
		// 			hide_onleave: false,
		// 			tmp: '<div class="tp-title-wrap">	<span class="tp-arr-titleholder">{{title}}</span> </div>',
		// 			left: {
		// 				h_align: "left",
		// 				v_align: "center",
		// 				h_offset: 10,
		// 				v_offset: 0
		// 			},
		// 			right: {
		// 				h_align: "right",
		// 				v_align: "center",
		// 				h_offset: 10,
		// 				v_offset: 0
		// 			}
		// 		}
		// 	}
		// });
	
		// apiRevoSlider.bind("revolution.slide.onloaded",function (e) {
		// 	SEMICOLON.slider.sliderParallaxDimensions();
		// });
		
		tpj('.srch_list_of_model').autocomplete({
			serviceUrl: '/ajax/get_autocomplete_data.php',
			onSelect: function(suggestion) {
				window.location.href = suggestion.url;
			},
			onHint: function (hint) {
				console.log("onHint");
			},
			onInvalidateSelection: function() {
				console.log("onInvalidateSelection");
			},
			onSearchStart: function(params) {
				console.log("onSearchStart");
			},
			onHide: function(container) {
				console.log("onHide");
			},
			onSearchComplete: function (query, suggestions) {
				console.log("onSearchComplete",suggestions);
			},
			//showNoSuggestionNotice: true,
			//noSuggestionNotice: "We didn't find any matching devices...",
		});
	}); 
	//ready
	
	tpj(document).ready(function($) {
	
		$('#footer_signup_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#footer_signup_form').data('bootstrapValidator').resetForm();

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

		//START for Newsletter form
		$('#newsletter').on('submit', function(e) {
			e.preventDefault();
			var post_data = $('#newsletter').serialize();
			$.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/newsletter.php",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success:function(data) {
					if(data!="") {
						var form_data = JSON.parse(data);
						if(form_data.status == true) {
							$('.resp_newsletter').prepend('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+form_data.msg+'</div>');
							$('.newsletter_fields').hide();
							$('.resp_newsletter').show();
						} else {
							alert(form_data.msg);
							return false;
						}
					}
				}
			});
		});
		
		$('.btn-close, .close_newsletter_popup').click(function() {
		  $('#NewsLetter').modal('hide');
		  $('.newsletter_fields').show();
		  $('.resp_newsletter').hide();
		  $(".newsletter_fields input[type=text]").val('');
		  $(".newsletter_fields input[type=email]").val('');
		});
		//END for Newsletter form

		//START for check booking available
		$('.repair_appt_date').datepicker({
			autoclose: true,
			startDate: "today",
			todayHighlight: true
		}).on('changeDate', function(e) {
			<?php
			if(isset($location_list) && count($location_list)<=0) {
				echo 'check_booking_available();';
			} else {
				echo 'getTimeSlotListByDate();';
			} ?>
		});
		$('.repair_time_slot').on('change', function(e) {
			check_booking_available();
		});
		//END for check booking available

		$('.datepicker').datepicker({autoclose:true});

		// setTimeout(function () {
			$('.portfolio-item .inner, .testimonial, .clients-grid li a').matchHeight();
		// }, 4000);


		<?php
		if($repair_questions_expanded_or_expand_collapse == "expanded") { ?>
		$('.model-details-panel .icon-remove-circle').show();
		$('.model-details-panel .icon-ok-circle').hide();
		$('.model-details-panel .acc_content').show();
		<?php
		} ?>
		
/*var loading = 'data:image/gif;base64,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IGVzdGFibGlzaGVkIGluIDxiPi9ob21lL2FqYXhsb2FkL3d3dy9saWJyYWlyaWVzL2NsYXNzLm15c3FsLnBocDwvYj4gb24gbGluZSA8Yj42ODwvYj48YnIgLz4KPGJyIC8+CjxiPldhcm5pbmc8L2I+OiAgbXlzcWxfcXVlcnkoKSBbPGEgaHJlZj0nZnVuY3Rpb24ubXlzcWwtcXVlcnknPmZ1bmN0aW9uLm15c3FsLXF1ZXJ5PC9hPl06IENhbid0IGNvbm5lY3QgdG8gbG9jYWwgTXlTUUwgc2VydmVyIHRocm91Z2ggc29ja2V0ICcvdmFyL3J1bi9teXNxbGQvbXlzcWxkLnNvY2snICgyKSBpbiA8Yj4vaG9tZS9hamF4bG9hZC93d3cvbGlicmFpcmllcy9jbGFzcy5teXNxbC5waHA8L2I+IG9uIGxpbmUgPGI+Njg8L2I+PGJyIC8+CjxiciAvPgo8Yj5XYXJuaW5nPC9iPjogIG15c3FsX3F1ZXJ5KCkgWzxhIGhyZWY9J2Z1bmN0aW9uLm15c3FsLXF1ZXJ5Jz5mdW5jdGlvbi5teXNxbC1xdWVyeTwvYT5dOiBBIGxpbmsgdG8gdGhlIHNlcnZlciBjb3VsZCBub3QgYmUgZXN0YWJsaXNoZWQgaW4gPGI+L2hvbWUvYWpheGxvYWQvd3d3L2xpYnJhaXJpZXMvY2xhc3MubXlzcWwucGhwPC9iPiBvbiBsaW5lIDxiPjY4PC9iPjxiciAvPgo8YnIgLz4KPGI+V2FybmluZzwvYj46ICBteXNxbF9xdWVyeSgpIFs8YSBocmVmPSdmdW5jdGlvbi5teXNxbC1xdWVyeSc+ZnVuY3Rpb24ubXlzcWwtcXVlcnk8L2E+XTogQ2FuJ3QgY29ubmVjdCB0byBsb2NhbCBNeVNRTCBzZXJ2ZXIgdGhyb3VnaCBzb2NrZXQgJy92YXIvcnVuL215c3FsZC9teXNxbGQuc29jaycgKDIpIGluIDxiPi9ob21lL2FqYXhsb2FkL3d3dy9saWJyYWlyaWVzL2NsYXNzLm15c3FsLnBocDwvYj4gb24gbGluZSA8Yj42ODwvYj48YnIgLz4KPGJyIC8+CjxiPldhcm5pbmc8L2I+OiAgbXlzcWxfcXVlcnkoKSBbPGEgaHJlZj0nZnVuY3Rpb24ubXlzcWwtcXVlcnknPmZ1bmN0aW9uLm15c3FsLXF1ZXJ5PC9hPl06IEEgbGluayB0byB0aGUgc2VydmVyIGNvdWxkIG5vdCBiZSBlc3RhYmxpc2hlZCBpbiA8Yj4vaG9tZS9hamF4bG9hZC93d3cvbGlicmFpcmllcy9jbGFzcy5teXNxbC5waHA8L2I+IG9uIGxpbmUgPGI+Njg8L2I+PGJyIC8+Cg==';

$('.lazy').Lazy({
	delay:2000,
	effect: 'show',
	effectTime: 1000,
	visibleOnly: true,
	defaultImage: loading,
});*/

	});
	</script>
</body>
</html>