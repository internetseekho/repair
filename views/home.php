<link rel="stylesheet" href="<?=SITE_URL?>css/home-testimonials.css" type="text/css" />

<?php
//Static slider
// include 'static_slider.php';

//For home slider
$home_slider_data = get_home_page_data('','slider');
if(count($home_slider_data)>0) {
	$section_color=($home_slider_data['section_color']!=""?$home_slider_data['section_color'].'-bg':'');

	$items_data_array = json_decode($home_slider_data['items'],true);
	if(!empty($items_data_array)) {
		array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array); ?>
		<div class="home-slide">
			<?php
			foreach($items_data_array as $items_data) { ?>
			<div id="slideshow" class="<?=$section_color?>" style="background-image: url('images/section/<?php echo $items_data['item_image'] ?>')">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="block showcase-text">
								<div class="slider-item">
									<div class="row">
										<div class="col-md-12 d-flex align-items-center">
											<div class="clearfix text-center w-100">
												<?php
												if($items_data['use_title_as_button'] == '1' && $items_data['item_title'] != '') {
													echo '<h1 class="mb-0 pb-2"><a href="'.$items_data['button_url'].'"><span>'.$items_data['item_title'].'</span> <i class="icon-angle-right"></i></a></h1>';
												} elseif($items_data['item_title'] != '') {
													echo '<h1 class="mb-0 pb-2">'.$items_data['item_title'].'</h1>';
												}
												if($items_data['item_sub_title']) {
													echo '<h3 class="pb-2">'.$items_data['item_sub_title'].'</h3>';
												} ?>
												<a href="<?=$items_data['button_url']?>" class="btn btn-lg px-5 rounded-pill btn-outline-light text-uppercase"><strong><?=$book_repair_btn_text?></strong></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		} ?>
		</div>			
	<?php
	}
}

$home_page_settings_list = get_home_page_data();
foreach($home_page_settings_list as $home_page_settings_data) {
	$home_page_settings_data['sub_title'] = str_replace("<p><br></p>","",$home_page_settings_data['sub_title']);
	$home_page_settings_data['intro_text'] = str_replace("<p><br></p>","",$home_page_settings_data['intro_text']);
	$home_page_settings_data['description'] = str_replace("<p><br></p>","",$home_page_settings_data['description']);

	$section_color=($home_page_settings_data['section_color']!=""?$home_page_settings_data['section_color'].'-bg':'');
	$section_bg_image = '';
	$section_bg_style_image = '';
	if($home_page_settings_data['section_image']) {
		$section_bg_image = "images/section/".$home_page_settings_data['section_image'];
		$section_bg_style_image = "style=\"background:url('$section_bg_image') no-repeat 0 0;\"";
	}
	
	$number_of_item_show = 0;
	$number_of_item_show = $home_page_settings_data['number_of_item_show'];
	
	$display_popular_devices_only = 0;
	$display_popular_devices_only = $home_page_settings_data['display_popular_devices_only'];
	
	if($home_page_settings_data['section_name'] == "how_it_works") {
		$items_data_array = json_decode($home_page_settings_data['items'],true);
		if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
			<section class="<?=$section_color?> pb-5 mb-5" <?=$section_bg_style_image?>>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="block how-to-work text-center">
								<div class="heading-block topmargin-lg bottommargin-sm center">
								<?php
								if ($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') {
									echo '<h3>' . lastwordstrongorspan($home_page_settings_data['title'], 'strong') . '</h3>';
								}
								if ($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') {
									echo '<span class="divcenter">' . $home_page_settings_data['sub_title'] . '</span>';
								}
								if ($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') {
									echo '<span class="divcenter">' . $home_page_settings_data['intro_text'] . '</span>';
								}
								if ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') {
									echo $home_page_settings_data['description'];
								} ?>
								</div>
								<?php
								if(!empty($items_data_array)) { ?>
								<div class="row">
									<?php
									array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
									foreach($items_data_array as $items_data) {
										$item_fa_item = "";
										$item_icon_type = $items_data['item_icon_type'];
										if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
											$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
										} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
											$item_fa_item = '<img loading="lazy" src="images/section/'.$items_data['item_image'].'" class="img-fluid" alt="">';
										} ?>
										<div class="col-md-4">
											<div class="feature-box fbox-center fbox-light fbox-effect">
											<?php
											if($item_fa_item) {
												echo '<div class="fbox-icon"><a href="#">'.$item_fa_item.'</a></div>';
											}
											if($items_data['item_title']) {
												echo '<h3>'.$items_data['item_title'].'</h3>';
											}
											if($items_data['item_description']) {
												echo '<p>'.$items_data['item_description'].'</p>';
											} ?>
											</div>
										</div>
									<?php
									} ?>
								</div>
								<?php
								} ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "top_devices") {
		//Get data from admin/include/functions.php, get_device_data_list function
		$device_data_list = get_popular_device_data();
		$num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
			<section id="device-category-sec" class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<div class="wrap">
					<?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h2>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h2>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
					
					<div class="block block-category">
						<ul>
							<?php
							foreach($device_data_list as $device_data) { ?>
								<li>
									<a href="<?=$device_data['sef_url']?>">
										<div class="image">
											<?php
											if($device_data['device_icon']) {
												$device_icon_path = SITE_URL.'images/device/'.$device_data['device_icon']; ?>
												<img class="lazy" src="<?=$device_icon_path?>" alt="<?=$device_data['title']?>">
											<?php
											} ?>
										</div>
										<span><?=$device_data['title']?></span>
									</a>
								</li>
							<?php
							} ?>
						</ul>
					</div>
				</div>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "categories") {
	  //Get data from admin/include/functions.php, get_category_data_list function
	  $category_data_list = get_category_data_list();
	  $num_of_category = count($category_data_list);
	  if($num_of_category>0) { ?>
		<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
		<!-- border-bottom -->
			<div class="section brand nobg m-0 py-5">
				<div class="container clearfix center">
					<div class="clear"></div>
					<div class="heading-block topmargin-sm bottommargin-sm center">
						<?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
					</div>
					<ul class="clients-grid grid-5 nobottommargin clearfix">
					<?php
					foreach($category_data_list as $category_data) { ?>
						<li>
							<a href="<?=SITE_URL.$category_details_page_slug.$category_data['sef_url']?>" class="d-flex align-items-center">
								<div class="inner mx-auto">
									<?php
									if($category_data['image']) {
										echo '<img class="lazy" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$category_data['title'].'">';
									} ?>
									<h4><?=$category_data['title']?></h4>
								</div>
							</a>
						</li>
					<?php
					} ?>
					</ul>
				</div>
			</div>
		</section>
	  <?php
	  }
	}
	elseif($home_page_settings_data['section_name'] == "devices") {
	    //Fetching devices
	    //Get data from admin/include/functions.php, get_device_data_list function
	    $device_data_list = get_device_data_list('',$display_popular_devices_only);
	    $num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
			<section id="services" class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<a name="device-section"></a>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-block topmargin-lg bottommargin-sm center">
								<?php
								if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
									echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
								}
								if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
									echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
								}
								if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
									echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
								}
								if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
									echo $home_page_settings_data['description'];
								} ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<ul class="clients-grid grid-4 bottommargin-sm clearfix">
							<?php
							foreach($device_data_list as $device_data) { ?>
								<li class="center">
									<a href="<?=$device_data['sef_url']?>">
										<?php
										if($device_data['device_img']) {
											//$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=144';
											$device_img_path = SITE_URL.'images/device/'.$device_data['device_img']; ?>
											<img class="lazy" src="<?=$device_img_path?>" alt="<?=$device_data['title']?>">
										<?php
										} ?>
										<h4><?=$device_data['title']?></h4>
									</a>
								</li>
							<?php
							} ?>
							</ul>
						</div>
					</div>
				</div>
			</section>
	  <?php
	  }
	}
	elseif($home_page_settings_data['section_name'] == "models") {
		//Get data from admin/include/functions.php, get_top_seller_data_list function
		$top_seller_data_list = get_top_seller_data_list($top_seller_limit);
		$num_of_top_seller = count($top_seller_data_list);
		if($top_seller_limit>0 && $num_of_top_seller>0) { ?>
			<section id="model" class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-block topmargin-lg bottommargin-sm center">
								<?php
								if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
									echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
								}
								if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
									echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
								}
								if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
									echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
								}
								if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
									echo $home_page_settings_data['description'];
								} ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<ul class="clients-grid grid-4 bottommargin-sm clearfix">
								<?php
								$ts_i=1;
								foreach($top_seller_data_list as $top_seller_data) {
									$num_of_top_seller = $ts_i;
									if($num_of_top_seller<=$top_seller_limit) {
										$top_seller_md_url = SITE_URL.$top_seller_data['model_sef_url']; ?>
										<li class="center">
											<a href="<?=$top_seller_md_url?>">
												<?php
												if($top_seller_data['model_img']) {
													//$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$top_seller_data['model_img'].'&h=178';
													$md_img_path = SITE_URL.'images/mobile/'.$top_seller_data['model_img']; ?>
													<img class="lazy" src="<?=$md_img_path?>" alt="<?=$top_seller_data['model_title']?>">
												<?php
												} ?>
												<h4><?=$top_seller_data['model_title']?></h4>
											</a>
										</li>
								  <?php
								  }
								  $ts_i = $ts_i+1;
								} ?>
							</ul>
						</div>
					</div>
				</div>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "brands") {
		//Get data from admin/include/functions.php, get_brand_data function
		$brand_data_list = get_brand_data();
		$num_of_brand = count($brand_data_list);
		if($num_of_brand>0) { ?>
			<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<div class="section brand nobg m-0 py-5">
					<div class="container clearfix center">
						<div class="clear"></div>
						<div class="heading-block topmargin-sm bottommargin-sm center">
							<?php
							if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
								echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
							}
							if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
								echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
							}
							if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
								echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
							}
							if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
								echo $home_page_settings_data['description'];
							} ?>
						</div>
						<ul class="clients-grid grid-5 nobottommargin clearfix">
						<?php
						foreach($brand_data_list as $brand_data) {
							//$brand_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/brand/'.$brand_data['image'].'&h=54'; ?>
							<li>
								<a href="<?=SITE_URL.$brand_data['sef_url']?>" class="d-flex align-items-center">
									<div class="inner mx-auto">
										<?php
										if($brand_data['image']) {
											echo '<img class="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'">';
										} ?>
										<h4><?=$brand_data['title']?></h4>
									</div>
								</a>
							</li>
						<?php
						} ?>
						</ul>
					</div>
				</div>
			</section>
		<?php
		} //END for brand section
	}
	elseif($home_page_settings_data['section_name'] == "why_choose_us") {
		$items_data_array = json_decode($home_page_settings_data['items'],true);
		if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
			<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<a name="why-choose-us"></a>
				<div class="container clearfix">
					<div class="clear"></div>
					<div class="heading-block topmargin-lg bottommargin-sm center">
						<?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
					</div>

					<?php
					array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
					foreach($items_data_array as $ik=>$items_data) {
						$item_fa_item = "";
						$item_icon_type = $items_data['item_icon_type'];
						if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
							$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
						} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
							$item_fa_item = '<img class="lazy" src="images/section/'.$items_data['item_image'].'">';
						}
						
						$row_last_col_cls = "";
						if($ik%3==0) {
							$row_last_col_cls = " col_last";
						} ?>

						<div class="col_one_third <?=$row_last_col_cls?>">
							<div class="feature-box fbox-center fbox-light fbox-effect">
								<div class="fbox-icon">
								  <?php
								  if($item_fa_item) {
									echo '<a href="#">'.$item_fa_item.'</a>';
								  } ?>
								</div>
								<?php
								if($items_data['item_title']) {
									echo '<h3>'.$items_data['item_title'].'</h3>';
								}
								if($items_data['item_description']) {
									echo '<p>'.$items_data['item_description'].'</p>';
								} ?>
							</div>
						</div>
					<?php
					} ?>
				</div>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "get_instant_repair_cost") { ?>
		<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="container clearfix">
				<a name="request_quote"></a>
				<div class="clear"></div>
				<div class="heading-block topmargin-sm bottommargin-sm center">
					<?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
				</div>
	
				<form action="controllers/home.php" method="post" id="instant_repair_cost_form">
					<div class="form-row">
						<?php
						if($home_instant_repair_quote == "b_d_m") {
							$quote_mk_list_array = autocomplete_data_search();
							$quote_mk_list = $quote_mk_list_array['quote_mk_list']; ?>
							<div class="form-group col-md-4">
								<label><?=$request_quote_brand_title?></label>
								<select class="form-control" name="quote_make" id="quote_make" onchange="getQuoteDevice(this.value);">
								  <option value="">-- Select --</option>
								  <?php
								  if(!empty($quote_mk_list)) {
									  foreach($quote_mk_list as $quote_mk_key=>$quote_mk_data) { ?>
										  <option value="<?=$quote_mk_key?>"><?=$quote_mk_data?></option>
									  <?php
									  }
								  } ?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label><?=$request_quote_device_title?></label>
								<select class="form-control add-quote-device" name="quote_device" id="quote_device" onchange="getQuoteModel(this.value);">
									<option value="">-- Select --</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label><?=$request_quote_model_title?></label>
								<select class="form-control add-quote-model" name="quote_model" id="quote_model">
									<option value="">-- Select --</option>
								</select>
							</div>
						<?php
						} else {
							$device_data_list = get_device_data_list(); ?>
							<div class="form-group col-md-6">
								<label><?=$request_quote_device_title?></label>
								<select class="form-control add-quote-device" name="quote_device" id="quote_device" onchange="getQuoteModel(this.value);">
									<option value="">-- Select --</option>
									<?php
									if(!empty($device_data_list)) {
										foreach($device_data_list as $device_data) {
											echo '<option value="'.$device_data['id'].'">'.$device_data['title'].'</option>';
										}
									} ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label><?=$request_quote_model_title?></label>
								<select class="form-control add-quote-model" name="quote_model" id="quote_model">
									<option value="">-- Select --</option>
								</select>
							</div>
						<?php
						} ?>
					</div>
				
					<div class="col-md-12 center">
						<button type="submit" class="button" name="submit_quote" id="submit_quote"><?=$request_instant_quote_sbmt_btn_text?></button>
					</div>
					<?php
					$quote_csrf_token = generateFormToken('get_quote'); ?>
					<input type="hidden" name="csrf_token" value="<?=$quote_csrf_token?>">
				</form>	
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "get_a_quote") { ?>
		<section class="section parallax dark notoppadding nobottommargin nobottomborder skrollable skrollable-between <?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="container clearfix">
				<div class="clear"></div>
				<div class="heading-block topmargin-lg bottommargin-sm center">
					<?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
				</div>

				<form action="controllers/contact.php" method="post" id="contact_form">
					<div class="form-row">
						<div class="col-md-4">
							<label for="name"><?=$name_field_title?> <small>*</small></label>
							<input type="text" name="name" id="name" value="<?=$user_full_name?>" class="sm-form-control required" />
						</div>
						<div class="col-md-4">
							<label for="email"><?=$email_field_title?> <small>*</small></label>
							<input type="text" name="email" id="email" value="<?=$user_email?>" class="sm-form-control required" />
						</div>
						<div class="col-md-4">
							<label for="cell_phone"><?=$phone_field_title?> <small>*</small></label>
							<input type="tel" id="cell_phone" name="cell_phone" class="sm-form-control required" value="<?=$user_phone?>">
							<input type="hidden" name="phone" id="phone" />
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 topmargin-sm">
							<label for="message"><?=$message_field_title?> <small>*</small></label>
							<textarea name="message" id="message" class="required sm-form-control" rows="6" cols="30"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 topmargin-sm">
							<button class="button button-3d nomargin" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit"><?=$request_quote_sbmt_btn_text?></button>
							<input type="hidden" name="submit_form" id="submit_form" />
						</div>
					</div>
					
					<input type="hidden" name="mode" id="mode" value="home_page"/>
					<?php
					$csrf_token = generateFormToken('home_page'); ?>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				</form>
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "newsletter") {
		if($newslettter_section == '1') { ?>
		  <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="container-fluid">
			  <div class="row justify-content-center">
					<div class="col-md-7 col-lg-8">
						<div class="block newsletter">
						<h3 class="feature-title">More features coming soon...</h3>
						<p>Enroll for the software updates to receive intime communication about the new features that will make your order management and freight management process easier and more productive.</p>
						</div>
					</div>
					<div class="col-md-5 col-lg-4">
						<div class="block newsletter text-right">
							<form action="<?=SITE_URL?>controllers/newsletter.php" method="post" id="newsletter_form" class="form-inline">
								<div class="form-group">
									<input type="email" name="ftr_signup_email" id="ftr_signup_email" placeholder="yourmail@mail.com" class="form-control text-left border-bottom border-top-0 border-right-0 border-left-0 center">
									<button type="button" class="btn btn-clear" id="clk_ftr_signup_btn"><i class="fab fa-telegram-plane"></i></button>
								</div>
								<?php
								$newsletter_csrf_token = generateFormToken('newsletter'); ?>
								<input type="hidden" name="csrf_token" value="<?=$newsletter_csrf_token?>">
							</form>
						</div>
					</div>
			  </div>
			</div>
		  </section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "reviews") {
		//Get review list
		$review_list_data = get_review_list_data(1,$number_of_item_show);
		if(!empty($review_list_data)) { ?>
			<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<div style="background-size:cover;" class="section mt-0 nobottommargin nobottompadding nobottomborder <?=$section_color?>" <?=$section_bg_style_image?>>
					<div class="container clearfix">
						<div class="clear"></div>
						<div class="heading-block topmargin-sm bottommargin-sm center">
							<?php
							if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
								echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
							}
							if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
								echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
							}
							if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
								echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
							}
							if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
								echo $home_page_settings_data['description'];
							} ?>
						</div>

						<div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget clearfix" data-margin="0" data-pagi="true" data-loop="false" data-center="false" data-autoplay="5000" data-items-sm="1" data-items-md="2" data-items-xl="3">
							<?php
							$rev_read_more_arr = array();
							foreach($review_list_data as $key => $review_data) { ?>
							<div class="oc-item">
								<div class="testimonial">
									<div class="testi-image">
										<a href="#">
										<?php
										if($review_data['photo']) {
											echo '<img class="lazy" src="'.SITE_URL.'images/review/'.$review_data['photo'].'" alt="'.$review_data['name'].'">';							} else {
											echo '<img class="lazy" src="images/placeholder_avatar.jpg" alt="Review Avatar">';
										} ?>
										</a>
									</div>
									<div class="testi-content">
										<?php
										if($full_review_or_number_of_words == "full_review" || $review_limited_words == '0') {
											echo '<p>'.$review_data['content'].'</p>';
										} else {
											$rev_content = '';
											$rev_con_words = str_word_count($review_data['content']);
											$rev_content = limit_words($review_data['content'],$review_limited_words);
											if($rev_con_words>$review_limited_words) {
												$rev_content .= ' <a href="javascript;" data-toggle="modal" data-target="#reviewModal'.$review_data['id'].'">Read More</a>';
												$rev_read_more_arr[] = array('id'=>$review_data['id'],'name'=>$review_data['name'],'content'=>$review_data['content'],'country'=>$review_data['country'],'state'=>$review_data['state'],'city'=>$review_data['city']);
											}
											echo '<p>'.$rev_content.'</p>';
										} ?>
										<div class="testi-meta">
											<?=$review_data['name']?>
											<span><?=($review_data['country']?$review_data['country'].', ':'').$review_data['state'].', '.$review_data['city']?></span>
										</div>
									</div>
								</div>
							</div>
							<?php
							} ?>
						</div>
						<div class="heading-block nobottomborder center pt-4 <?php /*?>topmargin-sm<?php */?>notopmargin">
							<a href="<?=$reviews_link?>" class="button"><?=$view_all_review_btn_text?> <i class="icon-circle-arrow-right"></i></a>
						</div>
					</div>
				</div>

				<?php
				if(!empty($rev_read_more_arr)) {
					foreach($rev_read_more_arr as $rev_read_more_data) { ?>
						<div class="modal fade" id="reviewModal<?=$rev_read_more_data['id']?>" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel<?=$rev_read_more_data['id']?>" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="reviewModalLabel<?=$rev_read_more_data['id']?>"><?=$rev_read_more_data['name']?> (<small><?=($rev_read_more_data['country']?$rev_read_more_data['country'].', ':'').$rev_read_more_data['state'].', '.$rev_read_more_data['city']?></small>)</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?=$rev_read_more_data['content']?>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
				} ?>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "services") {
		$service_data_list = get_service_data_list($number_of_item_show);
		if(count($service_data_list)>0) { ?>
			<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
				<div class="container clearfix">
					<div class="clear"></div>
					<div class="heading-block topmargin-lg bottommargin-sm center">
						<?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
					</div>

					<?php
					$sn = 0;
					foreach($service_data_list as $service_data) {
						$row_col_last = false;
						$sn = $sn+1;
						if($sn%3==0) {
							$row_col_last = true;
						} ?>
						<div class="col_one_third <?=($row_col_last == '1'?'col_last':'')?>">
							<div class="feature-box fbox-center fbox-light fbox-plain">
								<?php
								if($service_data['image']) {
									$srvc_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/service/'.$service_data['image'].'&h=178'; ?>
									<div class="fbox-icon">
										<img class="lazy" src="<?=$srvc_img_path?>" alt="<?=$service_data['title']?>" />
									</div>
								<?php
								} ?>
								<h3><?=$service_data['title']?></h3>
								<p><?=$service_data['description']?></p>
							</div>
						</div>
					<?php
					} ?>
					<div class="clearfix"></div>
					<div class="heading-block nobottomborder center mt-1">
						<a href="<?=$services_link?>" class="button"><?=$view_all_review_btn_text?> <i class="icon-circle-arrow-right"></i></a>
					</div>
				</div>
			</section>
		<?php
		}
	} else { ?>
		<section class="<?=$section_color?>" <?=$section_bg_style_image?>>
			<!-- <div class="container clearfix"> -->
				<div class="clear"></div>
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1'
					|| $home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1'
					|| $home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { ?>
				<div class="heading-block topmargin-lg bottommargin-sm center">
					<?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					} ?>
				</div>
				<?php
				}

				if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
					echo $home_page_settings_data['description'];
				} ?>
			<!-- </div> -->
		</section>
	<?php
	}
} ?>

<script>
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
	
		$('#contact_form').bootstrapValidator({
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
				message: {
					validators: {
						notEmpty: {
							message: '<?=$validation_message_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

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
		
		$('#instant_repair_cost_form').bootstrapValidator({
			fields: {
				quote_make: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_sel_make_msg_text?>'
						}
					}
				},
				quote_device: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_sel_device_msg_text?>'
						}
					}
				},
				quote_model: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: '<?=$validation_sel_model_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#instant_repair_cost_form').data('bootstrapValidator').resetForm();

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

function getQuoteDevice(val)
{
	var brand_id = val.trim();
	if(brand_id) {
		post_data = "brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_device.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						console.log(data);
						$('#quote_device').html(data);
						//$('.add-quote-device').selectpicker('refresh');

						$('#quote_model').html('<option value="">Please Choose</option>');
						//$('.add-quote-model').selectpicker('refresh');
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}

function getQuoteModel(val)
{
	var device_id = val.trim();
	if(device_id) {
		<?php

		if($home_instant_repair_quote == "b_d_m") {
			echo 'var brand_id = jQuery("#quote_make").val().trim();';
		} else {
			echo 'var brand_id = 0;';
		} ?>
		post_data = "device_id="+device_id+"&brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						console.log(data);
						$('#quote_model').html(data);
						//$('.add-quote-model').selectpicker('refresh');
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}

function getWhatWrongDevice(val)
{
	var brand_id = val.trim();
	if(brand_id) {
		post_data = "brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_device.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#quote_device2').html(data);
						//$('.add-quote-device2').selectpicker('refresh');

						$('#quote_model2').html('<option value="">Please Choose</option>');
						//$('.add-quote-model2').selectpicker('refresh');
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}

function getWhatWrongModel(val)
{
	var device_id = val.trim();
	if(device_id) {
		var brand_id = jQuery("#quote_make2").val().trim();
		post_data = "device_id="+device_id+"&brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model2.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#quote_model2').html(data);
						//$('.add-quote-model2').selectpicker('refresh');
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}

function getModelDetails(val)
{
	var model_id = val.trim();
	if(model_id) {
		post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model_details.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#quote_model_details').html(data);
						//$('.add-quote-model').selectpicker('refresh');
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}
</script>
