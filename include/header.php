<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <!-- Document Title
	============================================= -->
    <meta name="keywords" content="<?=$meta_keywords?>" />
    <meta name="description" content="<?=$meta_desc?>" />
    <title><?=$meta_title?></title>
    <?php
	if(isset($meta_canonical_url) && $meta_canonical_url!="") {
		echo '<link href="'.$meta_canonical_url.'" rel="canonical" />';
	} ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <!-- Stylesheets
	============================================= -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=SITE_URL?>css/style.css" type="text/css" />

    <!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
    <?php /*?>
    <link rel="stylesheet" type="text/css" href="<?=SITE_URL?>include/rs-plugin/css/settings.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_URL?>include/rs-plugin/css/layers.css">
    <link rel="stylesheet" type="text/css" href="<?=SITE_URL?>include/rs-plugin/css/navigation.css"><?php */?>

    <link rel="icon" href="<?=SITE_URL?>images/favicon.ico" type="image/x-icon" />

    <?php /*?><style>
    .revo-slider-emphasis-text {
        font-size: 58px;
        font-weight: 700;
        letter-spacing: 1px;
        font-family: 'Raleway', sans-serif;
        padding: 15px 20px;
        border-top: 2px solid #FFF;
        border-bottom: 2px solid #FFF;
    }

    .revo-slider-desc-text {
        font-size: 20px;
        font-family: 'Lato', sans-serif;
        width: 650px;
        text-align: center;
        line-height: 1.5;
    }

    .revo-slider-caps-text {
        font-size: 16px;
        font-weight: 400;
        letter-spacing: 3px;
        font-family: 'Raleway', sans-serif;
    }

    .tp-video-play-button {
        display: none !important;
    }

    .tp-caption {
        white-space: nowrap;
    }
    </style><?php */
	?>
    <style>
    .topbar {
        display: flex;
        justify-content: space-around;
        align-items: center;
        position: fixed;
        top: 0;
        width: 100%;
        height:8vh;
        z-index: 99 !important;
        background: #ffffff;
        padding: 0 70px;
        border-bottom: 1px solid lightgray;
    }

    .topbar img {
        width: 25%;
    }

    .topbar button {
        padding: 5px 30px;
        background: #ff148b;
        border: none;
        border-radius: 3px;
        outline: none;
        font-size: 20px;
        color: #ffffff;
    }
    .bottom-logo{
        max-width: 80% !important;
        margin-top: -20px;
    }
    </style>
    <script src="<?=SITE_URL?>js/jquery.js"></script>
    <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

    <?php
	echo $custom_js_code;
	require_once("include/custom_js.php"); ?>
    <!-- start Gist JS code-->
    <script>
    (function(d, h, w) {
        var gist = w.gist = w.gist || [];
        gist.methods = ['trackPageView', 'identify', 'track', 'setAppId'];
        gist.factory = function(t) {
            return function() {
                var e = Array.prototype.slice.call(arguments);
                e.unshift(t);
                gist.push(e);
                return gist;
            }
        };
        for (var i = 0; i < gist.methods.length; i++) {
            var c = gist.methods[i];
            gist[c] = gist.factory(c)
        }
        s = d.createElement('script'), s.src = "https://widget.getgist.com", s.async = !0, e = d
            .getElementsByTagName(h)[0], e.appendChild(s), s.addEventListener('load', function(e) {}, !1), gist
            .setAppId("zmafcg9f"), gist.trackPageView()
    })(document, 'head', window);
    </script>
    <!-- end Gist JS code-->
</head>
<style>
    .newsletter{
        display: none !important;
    }
#top-bar {
    display: none !important;
}

#logo img {
    margin-top: 10px !important;
}
.dropdown-toggle{
	background: #ffffff !important;
	color: #290a38 !important;
}
.dropdown-menu.show{
	transform: translate3d(20px, 50px, 0px) !important;
}
.dropdown-item{
	font-size: 15px;
}
#header{
    height: 9vh;
    position: relative !important;
    margin-top: 7vh;
	background: #ffffff !important;
    border-bottom: 1px solid lightgray;
    box-shadow: none !important;
	z-index: 0 !important;
    padding: 0 30px;
}
.widget>h4{
	color: gray !important;
}
.input-group{
	height: 6vh;
}
#email{
	height: 6vh;
}
/* #header.sticky-header:not(.static-sticky),
#header.sticky-header:not(.static-sticky) #header-wrap,
#header.sticky-header:not(.static-sticky):not(.sticky-style-2):not(.sticky-style-3) #logo img {
    height: 80px;
} */

/* #header.sticky-header:not(.static-sticky) #primary-menu>ul>li>a {
    padding-top: 30px;
} */

#head-graphics {
    display: none;
}

.brand .clients-grid li a:hover {
    background-color: #ffffff;
    border: 2px solid #66cbee;
}
.sf-js-enabled li{
    margin: 0 50px;
}
.widget img{
    cursor: pointer !important;
}
.widget svg{
    margin: 0 10px;
}
#footer h4{
    color: #ff148b !important;
}
#footer a{
    color: #ffffff !important;
}
.bottommargin-sm p{
    color: #ff148b !important;
    font-size: 20px !important;
}
#copyrights{
    color: #ffffff;
}
</style>

<body class="stretched no-transition">
    <?php
	echo $after_body_js_code;
	if($newslettter_section == '1' && ($url_first_param=="" || $url_first_param=="offers")) {
		echo '<button class="button newsletter" type="button" data-toggle="modal" data-target="#NewsLetter"><i class="fa fa-caret-down"></i>Newsletter</button>';
	}
	
	//START for confirm message
	if(isset($active_page_data['slug']) && $active_page_data['slug'] == "home") {
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
	} //END for confirm message ?>

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Top Bar
		============================================= -->
        <div id="top-bar" class="d-none d-md-block">

            <div class="container clearfix">

                <div class="col_half nobottommargin">
                    <p class="nobottommargin"><strong><i class="icon-call"></i></strong> <a
                            href="tel:<?=$site_phone?>"><?=$site_phone?></a> | <strong><i
                                class="icon-line-clock"></i></strong> <?=$header_service_hours_text?></p>
                </div>

                <div class="col_half col_last fright nobottommargin">

                    <!-- Top Links
					============================================= -->
                    <div class="top-links">
                        <?php
						if($is_act_top_right_menu == '1') { ?>
                        <ul>
                            <?php
							$topright_menu_list = get_menu_list('top_right');
							foreach($topright_menu_list as $topright_menu_data) {
								$is_open_new_window = $topright_menu_data['is_open_new_window'];
								if($topright_menu_data['page_id']>0) {
									$menu_url = $topright_menu_data['p_url'];
									//$is_custom_url = $topright_menu_data['p_is_custom_url'];
								} else {
									$menu_url = $topright_menu_data['url'];
								}
								$is_custom_url = $topright_menu_data['is_custom_url'];
								$menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
								$is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
								
								$menu_fa_icon = "";
								if($topright_menu_data['css_menu_fa_icon']) {
									$menu_fa_icon = '&nbsp;<i class="'.$topright_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
								} ?>
                            <li>
                                <a class="myaccount <?=$topright_menu_data['css_menu_class']?>" href="<?=$menu_url?>"
                                    <?=$is_open_new_window?>><?=$topright_menu_data['menu_name'].$menu_fa_icon?></a>
                                <?php
									if(count($topright_menu_data['submenu'])>0) {
										$topright_submenu_list = $topright_menu_data['submenu']; ?>
                                <ul>
                                    <?php
										if(isset($_SESSION['user_id']) && $_SESSION['user_id']>0) { ?>
                                    <li><a href="<?=SITE_URL?>account?orders"><?=$orders_btn_text?></a></li>
                                    <li><a href="<?=SITE_URL?>account?profile"><?=$profile_btn_text?></a></li>
                                    <li><a href="<?=SITE_URL?>controllers/logout.php"><i class="fa fa-sign-out"></i>
                                            <?=$logout_btn_text?></a></li>
                                    <?php
										} else { ?>
                                    <li><a href="<?=$login_link?>"><i class="fa fa-sign-in"></i>
                                            <?=$signin_btn_text?></a></li>
                                    <li><a href="<?=$signup_link?>"><?=$signup_btn_text?></a></li>
                                    <?php
										}
										foreach($topright_submenu_list as $topright_submenu_data) {
											$s_is_open_new_window = $topright_submenu_data['is_open_new_window'];
											if($topright_submenu_data['page_id']>0) {
												//$s_is_custom_url = $topright_submenu_data['p_is_custom_url'];
												$s_menu_url = $topright_submenu_data['p_url'];
											} else {
												$s_menu_url = $topright_submenu_data['url'];
											}
											$s_is_custom_url = $topright_submenu_data['is_custom_url'];
											$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
											$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
										
											$submenu_fa_icon = "";
											if($topright_submenu_data['css_menu_fa_icon']) {
												$submenu_fa_icon = '&nbsp;<i class="'.$topright_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
											} ?>
                                    <li><a href="<?=$s_menu_url?>" class="<?=$topright_submenu_data['css_menu_class']?>"
                                            <?=$s_is_open_new_window?>><?=$topright_submenu_data['menu_name'].$submenu_fa_icon?></a>
                                    </li>
                                    <?php
										} ?>
                                </ul>
                                <?php
								} ?>
                            </li>
                            <?php
							} ?>
                            <li>
                                <a href="#"><i class="icon-user-alt"></i></a>
                                <ul>
                                    <?php
									if(isset($_SESSION['user_id']) && $_SESSION['user_id']>0) { ?>
                                    <li><a href="<?=SITE_URL?>account?orders"><?=$orders_btn_text?></a></li>
                                    <li><a href="<?=SITE_URL?>account?profile"><?=$profile_btn_text?></a></li>
                                    <li><a href="<?=SITE_URL?>controllers/logout.php"><i class="icon-line2-logout"></i>
                                            <?=$logout_btn_text?></a></li>
                                    <?php
									} else { ?>
                                    <li><a href="<?=$login_link?>"><i class="icon-signin"></i> <?=$signin_btn_text?></a>
                                    </li>
                                    <li><a href="<?=$signup_link?>"><i class="icon-user-plus"></i>
                                            <?=$signup_btn_text?></a></li>
                                    <?php
									} ?>
                                </ul>
                            </li>
                        </ul>
                        <?php
						} ?>
                    </div><!-- .top-links end -->
                </div>
            </div>
        </div><!-- #top-bar end -->
        <!-- New-top-bar Start -->
        <div class="topbar">
            <div class="logo">
            <img src="images/top-logo.png" alt="">
            </div>
            <div class="logsis d-flex">
                <div class="dropdown">
                    <button class="dropdown-toggle" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        USA
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Alabama</a>
                        <a class="dropdown-item" href="#">Alaska</a>
                        <a class="dropdown-item" href="#">Colorado</a>
                        <a class="dropdown-item" href="#">California</a>
                        <a class="dropdown-item" href="#">New Jersey</a>
                        <a class="dropdown-item" href="#">New Mexico</a>
                        <a class="dropdown-item" href="#">New York</a>
                        <a class="dropdown-item" href="#">North Carolina</a>
                        <a class="dropdown-item" href="#">Texas</a>
                        <a class="dropdown-item" href="#">Washington</a>
                    </div>
                </div>
                <button class="ml-3">Login</button>
            </div>
        </div>
        <!-- New-top-bar end -->

        <!-- Header
		============================================= -->
        <header id="header">
                <!-- <div id="primary-menu-trigger"><i class="icon-reorder"></i></div> -->
                    <div class="row" style="display: flex;justify-content: center;align-items: center;">
                        <div id="top-search-col" class="col-m-12">
                            <!-- Primary Navigation
							============================================= -->
                            <nav id="primary-menu">
                                <?php
								if($is_act_header_menu == '1') { ?>
                                <ul>
                                    <?php
									$header_menu_list = get_menu_list('header');
									foreach($header_menu_list as $header_menu_data) {
										$is_open_new_window = $header_menu_data['is_open_new_window'];
										if($header_menu_data['page_id']>0) {
											$menu_url = $header_menu_data['p_url'];
											//$is_custom_url = $header_menu_data['p_is_custom_url'];
										} else {
											$menu_url = $header_menu_data['url'];
										}
										$is_custom_url = $header_menu_data['is_custom_url'];
										$menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
										$is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
										
										$menu_fa_icon = "";
										if($header_menu_data['css_menu_fa_icon']) {
											$menu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
										} ?>
                                    <?php /*?><li
                                        class="<?=(($header_menu_data['brand_id']>0 && $header_menu_data['devices_in_submenu']=='1') || $header_menu_data['cats_in_menu']=='1' || $header_menu_data['brands_in_menu']=='1'?' mega-menu':'').($header_menu_data['id']==$active_page_data['menu_id'] || $header_menu_data['id']==$active_page_data['parent_menu_id'] || $header_menu_data['brand_id']==$device_single_data_resp['device_single_data']['brand_id']?' current':'')?>">
                                        <?php */?>
                                    <li
                                        class="<?=(($header_menu_data['brand_id']>0 && $header_menu_data['devices_in_submenu']=='1') || $header_menu_data['cats_in_menu']=='1' || $header_menu_data['brands_in_menu']=='1'?' ':'').((isset($active_page_data['menu_id']) && $header_menu_data['id']==$active_page_data['menu_id']) || (isset($active_page_data['parent_menu_id']) && $header_menu_data['id']==$active_page_data['parent_menu_id']) || (isset($device_single_data_resp['device_single_data']['brand_id']) && $header_menu_data['brand_id']==$device_single_data_resp['device_single_data']['brand_id'])?' current':'')?>">
                                        <a href="<?=$menu_url?>" class="<?=$header_menu_data['css_menu_class']?>"
                                            <?=$is_open_new_window?>>
                                            <div><?=$header_menu_data['menu_name'].$menu_fa_icon?></div>
                                        </a>
                                        <?php
											//START for show categories as a Submenu
											if($header_menu_data['cats_in_menu']=='1') {
												$menu_cat_data_list = get_menu_cats_data_list();
												$num_of_menu_cat = count($menu_cat_data_list);
												if($num_of_menu_cat>0) {
													echo '<ul class="sub-menu brand-sub-menu">';
													foreach($menu_cat_data_list as $menu_cat_data) {
														echo '<li '.($menu_cat_data['id']==$url_second_param?'class="current"':'').'><a href="'.SITE_URL.$menu_cat_data['sef_url'].'">'.$menu_cat_data['title'].'</a>';
													}
													echo '</ul>';
												}
											} //END for show categories as a Submenu

											//START for show brands, devices & models as a Submenu
											elseif($header_menu_data['brands_in_menu']=='1') {
												$menu_brand_data_list = get_menu_brand_data_list();
												$num_of_menu_brand = count($menu_brand_data_list);
												if($num_of_menu_brand>0) {
													echo '<ul class="sub-menu brand-sub-menu">';
													foreach($menu_brand_data_list as $menu_brand_data) {
														$menu_device_data_list = get_menu_device_data_list($menu_brand_data['id']);
														$num_of_menu_device = count($menu_device_data_list);
														if($num_of_menu_device>0) {
															echo '<li '.($menu_brand_data['id']==$url_second_param?'class="current"':'').'><a href="'.SITE_URL.$menu_brand_data['sef_url'].'"><div>'.$menu_brand_data['title'].'</div></a>';
																echo '<ul class="brand-device-menu">';
																foreach($menu_device_data_list as $menu_device_data) {
																	$browse_model_params = $url_second_param.$url_third_param;
																	$menu_model_data_list = get_menu_model_data_list($menu_device_data['id']);
																	$num_of_menu_model = count($menu_model_data_list);
																	if($num_of_menu_model>0) {
																		echo '<li '.($menu_device_data['sef_url']==$url_first_param?'class="current"':'').'><a href="'.SITE_URL.$menu_device_data['sef_url'].'">'.$menu_device_data['title'].'</a>';
																			echo '<ul class="brand-model-menu">';
																			foreach($menu_model_data_list as $menu_model_data) {
																				$models_text = $menu_model_data['models'];
																				$models_text = ($models_text?" - ".$models_text:"");
																			
																				echo '<li '.($browse_model_params==$menu_model_data['sef_url']?'class="current"':'').'><a href="'.SITE_URL.$menu_model_data['sef_url'].'">'.$menu_model_data['title'].$models_text.'</a></li>';
																			}
																			echo '</ul>';
																	}
																	echo '</li>';
																}
																echo '</ul>';
														}
													}
													echo '</ul>';
												}
											} //END for show brands, devices & models as a Submenu
											
											//START for show devices & models as a Submenu
											elseif($header_menu_data['devices_in_menu']=='1') {
												$menu_device_data_list = get_menu_device_data_list(0,$header_menu_data['fltr_devices_in_menu']);
												$num_of_menu_device = count($menu_device_data_list);
												if($num_of_menu_device>0) {
													echo '<ul class="sub-menu device-menu">';
													foreach($menu_device_data_list as $menu_device_data) {
														echo '<li '.($menu_device_data['sef_url']==$url_first_param?'class="current"':'').'><a href="'.SITE_URL.$menu_device_data['sef_url'].'">'.$menu_device_data['title'].'</a>';
														$browse_model_params = $url_second_param.$url_third_param;
														$menu_model_data_list = get_menu_model_data_list($menu_device_data['id']);
														$num_of_menu_model = count($menu_model_data_list);
														if($num_of_menu_model>0) {
															echo '<ul class="brand-menu">';
															foreach($menu_model_data_list as $menu_model_data) {
																$models_text = $menu_model_data['models'];
																$models_text = ($models_text?" - ".$models_text:"");
															
																echo '<li '.($browse_model_params==$menu_model_data['sef_url']?'class="current"':'').'><a href="'.SITE_URL.$menu_model_data['sef_url'].'">'.$menu_model_data['title'].$models_text.'</a></li>';
															}
															echo '</ul>';
														}
														echo '</li>';
													}
													echo '</ul>';
												}
											} //END for show devices & models as a Submenu
											else {
												//START for show devices & models as a Submenu choosen from brand dropdown checkboxes
												if($header_menu_data['brand_id']>0 && $header_menu_data['devices_in_submenu']=='1') {
													$menu_device_data_list = get_menu_device_data_list($header_menu_data['brand_id']);
													$num_of_menu_device = count($menu_device_data_list);
													if($num_of_menu_device>0) {
														echo '<ul class="sub-menu device-menu">';
														foreach($menu_device_data_list as $menu_device_data) {
															echo '<li '.($menu_device_data['sef_url']==$url_first_param?'class="current"':'').'><a href="'.SITE_URL.$menu_device_data['sef_url'].'">'.$menu_device_data['title'].'</a>';
															if($header_menu_data['models_in_menu']=='1') {
																$browse_model_params = $url_second_param.$url_third_param;
																$menu_model_data_list = get_menu_model_data_list($menu_device_data['id']);
																$num_of_menu_model = count($menu_model_data_list);
																if($num_of_menu_model>0) {
																	echo '<ul class="brand-menu">';
																	foreach($menu_model_data_list as $menu_model_data) {
																		$models_text = $menu_model_data['models'];
																		$models_text = ($models_text?" - ".$models_text:"");
																	
																		echo '<li '.($browse_model_params==$menu_model_data['sef_url']?'class="current"':'').'><a href="'.SITE_URL.$menu_model_data['device_sef_url'].'/'.$menu_model_data['sef_url'].'">'.$menu_model_data['title'].$models_text.'</a></li>';
																	}
																	echo '</ul>';
																}
															}
															echo '</li>';
														}
														echo '</ul>';
													}
												} //END for show devices & models as a Submenu choosen from brand dropdown checkboxes
											}
											
											if(count($header_menu_data['submenu'])>0) {
												$header_submenu_list = $header_menu_data['submenu']; ?>
                                        <ul class="sub-menu">
                                            <?php
													foreach($header_submenu_list as $header_submenu_data) {
														$s_is_open_new_window = $header_submenu_data['is_open_new_window'];
														if($header_submenu_data['page_id']>0) {
															//$s_is_custom_url = $header_submenu_data['p_is_custom_url'];
															$s_menu_url = $header_submenu_data['p_url'];
														} else {
															$s_menu_url = $header_submenu_data['url'];
														}
														$s_is_custom_url = $header_submenu_data['is_custom_url'];
														$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
														$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
														
														$submenu_fa_icon = "";
														if($header_menu_data['css_menu_fa_icon']) {
															$submenu_fa_icon = '&nbsp;<i class="'.$header_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
														} ?>
                                            <li
                                                <?=(isset($active_page_data['menu_id']) && $header_submenu_data['id']==$active_page_data['menu_id']?'class="current"':'')?>>
                                                <a href="<?=$s_menu_url?>"
                                                    class="<?=$header_submenu_data['css_menu_class']?>"
                                                    <?=$s_is_open_new_window?>><?=$header_submenu_data['menu_name'].$submenu_fa_icon?></a>
                                            </li>
                                            <?php
													} ?>
                                        </ul>
                                        <?php
											} ?>
                                    </li>
                                    <?php
									}
									
									if(!empty($h_menu_list)) {
										foreach($h_menu_list as $pl_key=>$pl_data) {
											$sef_url = $pl_data['url']; ?>
                                    <li
                                        class="<?php if($sef_url==$url_first_param){echo 'active';} echo ' '.($pl_data['menu_align']==''||$pl_data['menu_align']=='left'?'left':'right')?>">
                                        <a <?=($pl_data['is_open_new_window']=='1' ?'target="_blank"':'')?>
                                            class="<?=($pl_data['css_menu_class']!='' ?$pl_data['css_menu_class']:'item')?>"
                                            href="<?=($pl_data['is_custom_url']=='1'?$sef_url:SITE_URL.$sef_url)?>"><?=$pl_data['menu_name']?>
                                            <?php
													if($pl_data['css_menu_fa_icon']) {
														echo '&nbsp;<i class="'.$pl_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
													} ?>
                                        </a>
                                    </li>
                                    <?php
										}
									} ?>
                                </ul>
                                <?php
								} ?>

                                <!-- Top Search
								============================================= -->
                                <div id="top-search">
                                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i
                                            class="icon-line-cross"></i></a>
                                    <form action="<?=SITE_URL?>search" method="get">
                                        <input type="text" name="search" id="srch_list_of_model"
                                            class="form-control srch_list_of_model" value=""
                                            placeholder="<?=$searchbox_placeholder_text?>">
                                    </form>
                                </div><!-- #top-search end -->

                            </nav><!-- #primary-menu end -->
                        </div>
                    </div>
        </header><!-- #header end -->

        <?php
		if($newslettter_section == '1') { ?>
        <div class="editAddress-modal modal fade newsletterPopup" id="NewsLetter" tabindex="-1" role="dialog"
            aria-labelledby="NewsLetterLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!--<div class="modal-header">
						<h4 class="modal-title" id="NewsLetterLabel"></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>-->
                    <div class="modal-body">
                        <form class="mb-0" method="post" action="<?=SITE_URL?>controllers/newsletter.php"
                            id="newsletter">
                            <div class="row">
                                <div class="col-md-5">
                                    <img class="privy-element privy-image-element lazy"
                                        src="<?=SITE_URL?>images/newsletter_main_img.webp">
                                </div>
                                <div class="col-md-7">
                                    <h2><strong><?=$newsletter_popup_title?></strong></h2>
                                    <h3 class="mt-0 mb-3"><?=$newsletter_popup_sub_title?></h3>
                                    <div class="borderbox lightpink newsletter_fields">
                                        <div class="form-group">
                                            <input type="text" name="first_name" id="first_name"
                                                placeholder="First Name" class="sm-form-control"
                                                value="<?=$user_first_name?>" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                                class="sm-form-control" value="<?=$user_last_name?>" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" placeholder="Email"
                                                class="sm-form-control" value="<?=$user_email?>" required />
                                        </div>

                                        <?php
										if($contact_form_captcha == '1') { ?>
                                        <div class="form-group site-gcaptcha clearfix">
                                            <div id="nl_g_form_gcaptcha"
                                                style="transform:scale(0.8);transform-origin:0;-webkit-transform:scale(0.8);transform:scale(0.8);-webkit-transform-origin:0 0;transform-origin:0 0;">
                                            </div>
                                            <input type="hidden" id="nl_g_captcha_token" name="nl_g_captcha_token"
                                                value="" />
                                        </div>
                                        <?php
										}
										
										if($newsletter_form_captcha == '1') { ?>
                                        <script>
                                        var CaptchaCallback = function() {
                                            if (jQuery('#nl_g_form_gcaptcha').length) {
                                                grecaptcha.render('nl_g_form_gcaptcha', {
                                                    'sitekey': '<?=$captcha_key?>',
                                                    'callback': onNlSubmitForm,
                                                });
                                            }
                                        };

                                        var onNlSubmitForm = function(response) {
                                            if (response.length == 0) {
                                                jQuery("#nl_g_captcha_token").val('');
                                            } else {
                                                jQuery("#nl_g_captcha_token").val('yes');
                                            }
                                        };
                                        </script>
                                        <?php
										} ?>

                                        <div class="form-group">
                                            <button type="submit" class="button button-3d nomargin">Submit</button>
                                            <input type="hidden" name="newsletter" id="newsletter" />
                                        </div>
                                    </div>
                                    <div class="borderbox lightpink resp_newsletter" style="display:none;">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-secondary close_newsletter_popup"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p class="mb-0 text-muted"><small><?=$newsletter_popup_desc?></small></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
		} ?>