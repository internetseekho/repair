<?php
$custom_phpjs_path = "assets/js/custom/settings.php"; ?>

<script type="text/javascript">
function check_form(a){
	var order_prefix = a.order_prefix.value.trim();
	var order_completed_prefix = a.order_completed_prefix.value.trim();
	var letters = /^[A-Za-z0-9]+$/;
	if(!order_prefix.match(letters) && order_prefix!="") {
		alert('Order prefix must be alpha-numeric characters.');
		return false;
	} else if(!order_completed_prefix.match(letters) && order_completed_prefix!="") {
		alert('Booking order completed URL prefix must be alpha-numeric characters.');
		return false;
	}
}

function change_disc_type(val) {
	if(val == "percentage") {
		jQuery(".payment_per_val_showhide").show();
	} else {
		jQuery(".payment_per_val_showhide").hide();
	}
}

function chg_payment_mode(type) {
	if(type=="test") {
		$(".showhide_payment_test_fields").show();
		$(".showhide_payment_live_fields").hide();
	} else if(type=="live") {
		$(".showhide_payment_test_fields").hide();
		$(".showhide_payment_live_fields").show();
	} else {
		$(".showhide_payment_test_fields").hide();
		$(".showhide_payment_live_fields").hide();
	}
}
</script>

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

	<!-- BEGIN: Left Aside -->
	<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

		<!-- BEGIN: Aside Menu -->
		<?php
		include("include/admin_menu.php"); ?>
		<!-- END: Aside Menu -->
	</div>

	<!-- END: Left Aside -->
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title m-subheader__title--separator"><?=$heading_title?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="#" class="m-nav__link">
								<span class="m-nav__link-text"><?=$heading_title?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
			<div class="row">
				<div class="col-lg-12">

					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										<?=$heading_title?>
									</h3>
								</div>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="m-form m-form--fit m-form--label-align-right" action="controllers/general_settings.php" method="post" enctype="multipart/form-data">
							<div class="m-portlet__body <?=$m_portlet_body_padding_top.$m_portlet_body_padding_bottom?>">
								<div class="m-form__content">
									<?php include('confirm_message.php'); ?>
								</div>
								
								<?php
								if($type == "general") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="admin_panel_name">Admin Panel Name</label>
										<input type="text" class="form-control m-input m-input--square" id="admin_panel_name" value="<?=$general_setting_data['admin_panel_name']?>" name="admin_panel_name">
									</div>
									<div class="col-lg-6">
										<label for="site_name">Site Name</label>
										<input type="text" class="form-control m-input m-input--square" id="site_name" value="<?=$general_setting_data['site_name']?>" name="site_name">
									</div>
								</div>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								<div class="form-group m-form__group row clearfix">
									<div class="col-lg-3">
									  <div class="custom-file">
										<input type="file" class="custom-file-input" id="logo" name="logo" onChange="checkFile(this);" accept="image/*">
										<label class="custom-file-label" for="logo">Website Logo</label>
									  </div>
									
										<!-- <label for="logo">Website Logo</label>
										<input type="file" class="form-control m-input m-input--square" id="logo" name="logo" onChange="checkFile(this);" accept="image/*"> -->
										<?php 
										if($general_setting_data['logo']!="") { ?>
											<img class="m--margin-top-10 img-container" src="../images/<?=$general_setting_data['logo'].'?token='.$unique_id?>" width="150">
											<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeImage('<?=$general_setting_data['id']?>','r_logo_id')"><i class="la la-trash"></i> Remove</a>
										<?php 
										} ?>
									</div>
								
									<div class="col-lg-3">
                  						<div class="custom-file">
											<label class="custom-file-label" for="app_logo">Mobile App Logo</label>
											<input type="file" class="custom-file-input" id="app_logo" name="app_logo" onChange="checkImage(this);" accept="image/*">
										</div>
										<?php 
										if($general_setting_data['app_logo']!="") { ?>
											<img class="m--margin-top-10 img-container" src="../images/<?=$general_setting_data['app_logo'].'?token='.$unique_id?>" width="150">
											<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeImage('<?=$general_setting_data['id']?>','r_app_logo_id')"><i class="la la-trash"></i> Remove</a>
										<?php 
                    					} ?>
									</div>
								
									<div class="col-lg-3">
                  						<div class="custom-file">
											<label class="custom-file-label" for="invoice_logo">Invoice Logo</label>
											<input type="file" class="custom-file-input" id="invoice_logo" name="invoice_logo" onChange="checkImage(this);" accept="image/*">
										</div>
										<?php 
										if($general_setting_data['invoice_logo']!="") { ?>
											<img class="m--margin-top-10 img-container" src="../images/<?=$general_setting_data['invoice_logo'].'?token='.$unique_id?>" width="150">
											<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeImage('<?=$general_setting_data['id']?>','r_i_logo_id')"><i class="la la-trash"></i> Remove</a>
										<?php 
                    					} ?>
									</div>
									
									<div class="col-lg-3">
                  						<div class="custom-file">
											<label class="custom-file-label" for="favicon_icon">Favicon</label>
											<input type="file" class="custom-file-input" id="favicon_icon" name="favicon_icon" onChange="checkFaviconIcon(this);" accept="image/*">
										</div>
										<?php 
										if($general_setting_data['favicon_icon']!="") { ?>
											<img class="m--margin-top-10 img-container" src="../images/<?=$general_setting_data['favicon_icon'].'?token='.$unique_id?>" width="150">
											<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeImage('<?=$general_setting_data['id']?>','r_f_icon_id')"><i class="la la-trash"></i> Remove</a>
										<?php 
										} ?>
									</div>
									
									<div class="col-lg-3">
                  						<div class="custom-file">
											<label class="custom-file-label" for="app_logo">Admin Logo</label>
											<input type="file" class="custom-file-input" id="admin_logo" name="admin_logo" onChange="checkImage(this);" accept="image/*">
										</div>
										<?php
										if($general_setting_data['admin_logo']!="") { ?>
											<img class="m--margin-top-10 img-container" src="../images/<?=$general_setting_data['admin_logo'].'?token='.$unique_id?>" width="150">
											<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeImage('<?=$general_setting_data['id']?>','r_admin_logo_id')"><i class="la la-trash"></i> Remove</a>
										<?php 
                   						} ?>
									</div>
								</div>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="website">Website</label>
										<input type="text" class="form-control m-input m-input--square" id="website" value="<?=$general_setting_data['website']?>" name="website">
									</div>
									<div class="col-lg-4">
										<label for="phone">Phone</label>
										<input type="tel" class="form-control m-input m-input--square" id="phone" value="<?=$general_setting_data['phone']?>"  name="phone">
									</div>
									<div class="col-lg-4">
										<label for="email">Email</label>
										<input type="text" class="form-control m-input m-input--square" id="email" value="<?=$general_setting_data['email']?>"  name="email">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="copyright">Copyright</label>
										<input type="text" class="form-control m-input m-input--square" id="copyright" value="<?=$general_setting_data['copyright']?>" name="copyright">
										<span class="m-form__help">Constant Tag For Current Year {$year}</span>
									</div>
									<div class="col-lg-6">
										<label for="map_key">Map Key</label>
										<input type="text" class="form-control m-input m-input--square" id="map_key" value="<?=$general_setting_data['map_key']?>" name="map_key">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="timezone">Timezone</label>
										<select id="timezone" name="timezone" class="form-control">
										<?php
										$timezone_list = time_zonelist();
										if(!empty($timezone_list)) {
											foreach($timezone_list as $timezone_data) {
												$selected="";
												if($general_setting_data['timezone']==$timezone_data['value']) {
													$selected='selected="selected"';
												} ?>
												<option value="<?=$timezone_data['value']?>" <?=$selected?> ><?=$timezone_data['display']?></option>
											<?php 
											} 
										}?>
										</select>
										<span class="m-form__help"><strong>Default TIME ZONE saved in Database is UTC.</strong></span>
									</div>
									
									<div class="col-lg-4">
										<label for="copyright">Time Format</label>
										<select class="form-control m-input m-input--square" id="time_format" name="time_format">
											<option value="">Select Time Format</option>
											<option value="12_hour" <?php if($general_setting_data['time_format']=='12_hour'){echo 'selected="selected"';}?>>12 hour</option>
											<option value="24_hour" <?php if($general_setting_data['time_format']=='24_hour'){echo 'selected="selected"';}?>>24 hour</option>
										 </select>
									</div>
									<div class="col-lg-4">
										<label for="map_key">Date Format</label>
										<select class="form-control m-input m-input--square" id="date_format" name="date_format">
											<?php
											$date_format_list = get_date_format_list();
											foreach($date_format_list as $date_format_data) { ?>
												<option value="<?=$date_format_data['value']?>" <?php if($general_setting_data['date_format']==$date_format_data['value']){echo 'selected="selected"';}?>><?=$date_format_data['display']?></option>
											<?php
											} ?>

											  <?php /*?><option value="m/d/Y" <?php if($general_setting_data['date_format']=='m/d/Y'){echo 'selected="selected"';}?>>m/d/Y ex. <?=date("m/d/Y")?></option>
											  <option value="d-m-Y" <?php if($general_setting_data['date_format']=='d-m-Y'){echo 'selected="selected"';}?>>d-m-Y ex. <?=date("d-m-Y")?></option>
											  <option value="M/d/Y" <?php if($general_setting_data['date_format']=='M/d/Y'){echo 'selected="selected"';}?>>M/d/Y ex. <?=date("M/d/Y")?></option>
											  <option value="d-M-Y" <?php if($general_setting_data['date_format']=='d-M-Y'){echo 'selected="selected"';}?>>d-M-Y ex. <?=date("d-M-Y")?></option>
											  <option value="m/d/y" <?php if($general_setting_data['date_format']=='m/d/y'){echo 'selected="selected"';}?>>m/d/y ex. <?=date("m/d/y")?></option>
											  <option value="d-m-y" <?php if($general_setting_data['date_format']=='d-m-y'){echo 'selected="selected"';}?>>d-m-y ex. <?=date("d-m-y")?></option>
											  <option value="M/d/y" <?php if($general_setting_data['date_format']=='M/d/y'){echo 'selected="selected"';}?>>M/d/y ex. <?=date("M/d/y")?></option>
											  <option value="d-M-y" <?php if($general_setting_data['date_format']=='d-M-y'){echo 'selected="selected"';}?>>d-M-y ex. <?=date("d-M-y")?></option><?php */?>
										</select>
									</div>
								</div>
								
								
					
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="top_seller_limit">Top Seller Limit</label>
										<input type="number" class="form-control m-input m-input--square" id="top_seller_limit" value="<?=$general_setting_data['top_seller_limit']?>" name="top_seller_limit">
									</div>
									<div class="col-lg-4">
										<label for="page_list_limit">Page List Limit</label>
										<select class="form-control select2 m_select2" name="page_list_limit" id="page_list_limit">
											<option value=""> - Select - </option>								
											<option value="5" <?php if($page_list_limit=='5'){echo 'selected="selected"';}?>>5</option>
											<option value="10" <?php if($page_list_limit=='10'){echo 'selected="selected"';}?>>10</option>
											<option value="15" <?php if($page_list_limit=='15'){echo 'selected="selected"';}?>>15</option>
											<option value="20" <?php if($page_list_limit=='20'){echo 'selected="selected"';}?>>20</option>
											<option value="25" <?php if($page_list_limit=='25'){echo 'selected="selected"';}?>>25</option>
											<option value="50" <?php if($page_list_limit=='50'){echo 'selected="selected"';}?>>50</option>
											<option value="100" <?php if($page_list_limit=='100'){echo 'selected="selected"';}?>>100</option>
											<option value="200" <?php if($page_list_limit=='200'){echo 'selected="selected"';}?>>200</option>
											<option value="500" <?php if($page_list_limit=='500'){echo 'selected="selected"';}?>>500</option>
										</select>
									</div>
									<div class="col-lg-4">
									<label for="currency">Currency</label>
									<select class="form-control select2 m_select2" name="currency" id="currency">
										<option value=""> - Select - </option>									  
									   <option value="AFN,؋" <?php if($currency[0]=='AFN'){echo 'selected="selected"';}?>>AFN(؋)</option>
									   <option value="ALL,Lek" <?php if($currency[0]=='ALL'){echo 'selected="selected"';}?>>ALL(Lek)</option>
									   <option value="USD,$" <?php if($currency[0]=='USD'){echo 'selected="selected"';}?>>USD($)</option>
									   <option value="EUR,€" <?php if($currency[0]=='EUR'){echo 'selected="selected"';}?>>EUR(€)</option>
									   <option value="AOA,Kz" <?php if($currency[0]=='AOA'){echo 'selected="selected"';}?>>AOA(Kz)</option>
									   <option value="XCD,$" <?php if($currency[0]=='XCD'){echo 'selected="selected"';}?>>XCD($)</option>
									   <option value="ARS,$" <?php if($currency[0]=='ARS'){echo 'selected="selected"';}?>>ARS($)</option>
									   <option value="AWG,ƒ" <?php if($currency[0]=='AWG'){echo 'selected="selected"';}?>>AWG(ƒ)</option>
									   <option value="AUD,$" <?php if($currency[0]=='AUD'){echo 'selected="selected"';}?>>AUD($)</option>
									   <option value="AZN,ман" <?php if($currency[0]=='AZN'){echo 'selected="selected"';}?>>AZN(ман)</option>
									   <option value="BSD,$" <?php if($currency[0]=='BSD'){echo 'selected="selected"';}?>>BSD($)</option>
									   <option value="BBD,$" <?php if($currency[0]=='BBD'){echo 'selected="selected"';}?>>BBD($)</option>
									   <option value="BYR,p." <?php if($currency[0]=='BYR'){echo 'selected="selected"';}?>>BYR(p.)</option>
									   <option value="BZD,BZ$" <?php if($currency[0]=='BZD'){echo 'selected="selected"';}?>>BZD(BZ$)</option>
									   <option value="BMD,$" <?php if($currency[0]=='BMD'){echo 'selected="selected"';}?>>BMD($)</option>
									   <option value="BOB,$b" <?php if($currency[0]=='BOB'){echo 'selected="selected"';}?>>BOB($b)</option>
									   <option value="BAM,KM" <?php if($currency[0]=='BAM'){echo 'selected="selected"';}?>>BAM(KM)</option>
									   <option value="BWP,P" <?php if($currency[0]=='BWP'){echo 'selected="selected"';}?>>BWP(P)</option>
									   <option value="NOK,kr" <?php if($currency[0]=='NOK'){echo 'selected="selected"';}?>>NOK(kr)</option>
									   <option value="BRL,R$" <?php if($currency[0]=='BRL'){echo 'selected="selected"';}?>>BRL(R$)</option>
									   <option value="BND,$" <?php if($currency[0]=='BND'){echo 'selected="selected"';}?>>BND($)</option>
									   <option value="BGN,лв" <?php if($currency[0]=='BGN'){echo 'selected="selected"';}?>>BGN(лв)</option>
									   <option value="KHR,៛" <?php if($currency[0]=='KHR'){echo 'selected="selected"';}?>>KHR(៛)</option>
									   <option value="XAF,FCF" <?php if($currency[0]=='XAF'){echo 'selected="selected"';}?>>XAF(FCF)</option>
									   <option value="CAD,$" <?php if($currency[0]=='CAD'){echo 'selected="selected"';}?>>CAD($)</option>
									   <option value="KYD,$" <?php if($currency[0]=='KYD'){echo 'selected="selected"';}?>>KYD($)</option>
									   <option value="CNY,¥" <?php if($currency[0]=='CNY'){echo 'selected="selected"';}?>>CNY(¥)</option>
									   <option value="COP,$" <?php if($currency[0]=='COP'){echo 'selected="selected"';}?>>COP($)</option>
									   <option value="NZD,$" <?php if($currency[0]=='NZD'){echo 'selected="selected"';}?>>NZD($)</option>
									   <option value="CRC,₡" <?php if($currency[0]=='CRC'){echo 'selected="selected"';}?>>CRC(₡)</option>
									   <option value="HRK,kn" <?php if($currency[0]=='HRK'){echo 'selected="selected"';}?>>HRK(kn)</option>
									   <option value="CUP,₱" <?php if($currency[0]=='CUP'){echo 'selected="selected"';}?>>CUP(₱)</option>
									   <option value="CZK,KĿ" <?php if($currency[0]=='CZK'){echo 'selected="selected"';}?>>CZK(KĿ)</option>
									   <option value="DKK,kr" <?php if($currency[0]=='DKK'){echo 'selected="selected"';}?>>DKK(kr)</option>
									   <option value="DOP,RD$" <?php if($currency[0]=='DOP'){echo 'selected="selected"';}?>>DOP(RD$)</option>
									   <option value="EGP,£" <?php if($currency[0]=='EGP'){echo 'selected="selected"';}?>>EGP(£)</option>
									   <option value="SVC,$" <?php if($currency[0]=='SVC'){echo 'selected="selected"';}?>>SVC($)</option>
									   <option value="ERN,Nfk" <?php if($currency[0]=='ERN'){echo 'selected="selected"';}?>>ERN(Nfk)</option>
									   <option value="EEK,kr" <?php if($currency[0]=='EEK'){echo 'selected="selected"';}?>>EEK(kr)</option>
									   <option value="FKP,£" <?php if($currency[0]=='FKP'){echo 'selected="selected"';}?>>FKP(£)</option>
									   <option value="FJD,$" <?php if($currency[0]=='FJD'){echo 'selected="selected"';}?>>FJD($)</option>
									   <option value="GMD,D" <?php if($currency[0]=='GMD'){echo 'selected="selected"';}?>>GMD(D)</option>
									   <option value="GHC,¢" <?php if($currency[0]=='GHC'){echo 'selected="selected"';}?>>GHC(¢)</option>
									   <option value="GIP,£" <?php if($currency[0]=='GIP'){echo 'selected="selected"';}?>>GIP(£)</option>
									   <option value="GTQ,Q" <?php if($currency[0]=='GTQ'){echo 'selected="selected"';}?>>GTQ(Q)</option>
									   <option value="GYD,$" <?php if($currency[0]=='GYD'){echo 'selected="selected"';}?>>GYD($)</option>
									   <option value="HTG,G" <?php if($currency[0]=='HTG'){echo 'selected="selected"';}?>>HTG(G)</option>
									   <option value="HNL,L" <?php if($currency[0]=='HNL'){echo 'selected="selected"';}?>>HNL(L)</option>
									   <option value="HKD,$" <?php if($currency[0]=='HKD'){echo 'selected="selected"';}?>>HKD($)</option>
									   <option value="HUF,Ft" <?php if($currency[0]=='HUF'){echo 'selected="selected"';}?>>HUF(Ft)</option>
									   <option value="ISK,kr" <?php if($currency[0]=='ISK'){echo 'selected="selected"';}?>>ISK(kr)</option>
									   <option value="INR,₹" <?php if($currency[0]=='INR'){echo 'selected="selected"';}?>>INR(₹)</option>
									   <option value="IDR,Rp" <?php if($currency[0]=='IDR'){echo 'selected="selected"';}?>>IDR(Rp)</option>
									   <option value="IRR,﷼" <?php if($currency[0]=='IRR'){echo 'selected="selected"';}?>>IRR(﷼)</option>
									   <option value="ILS,₪" <?php if($currency[0]=='ILS'){echo 'selected="selected"';}?>>ILS(₪)</option>
									   <option value="JMD,$" <?php if($currency[0]=='JMD'){echo 'selected="selected"';}?>>JMD($)</option>
									   <option value="JPY,¥" <?php if($currency[0]=='JPY'){echo 'selected="selected"';}?>>JPY(¥)</option>
									   <option value="KZT,лв" <?php if($currency[0]=='KZT'){echo 'selected="selected"';}?>>KZT(лв)</option>
									   <option value="KGS,лв" <?php if($currency[0]=='KGS'){echo 'selected="selected"';}?>>KGS(лв)</option>
									   <option value="LAK,₭" <?php if($currency[0]=='LAK'){echo 'selected="selected"';}?>>LAK(₭)</option>
									   <option value="LVL,Ls" <?php if($currency[0]=='LVL'){echo 'selected="selected"';}?>>LVL(Ls)</option>
									   <option value="LBP,£" <?php if($currency[0]=='LBP'){echo 'selected="selected"';}?>>LBP(£)</option>
									   <option value="LSL,L" <?php if($currency[0]=='LSL'){echo 'selected="selected"';}?>>LSL(L)</option>
									   <option value="LRD,$" <?php if($currency[0]=='LRD'){echo 'selected="selected"';}?>>LRD($)</option>
									   <option value="CHF,CHF" <?php if($currency[0]=='CHF'){echo 'selected="selected"';}?>>CHF(CHF)</option>
									   <option value="LTL,Lt" <?php if($currency[0]=='LTL'){echo 'selected="selected"';}?>>LTL(Lt)</option>
									   <option value="MOP,MOP" <?php if($currency[0]=='MOP'){echo 'selected="selected"';}?>>MOP(MOP)</option>
									   <option value="MKD,ден" <?php if($currency[0]=='MKD'){echo 'selected="selected"';}?>>MKD(ден)</option>
									   <option value="MWK,MK" <?php if($currency[0]=='MWK'){echo 'selected="selected"';}?>>MWK(MK)</option>
									   <option value="MYR,RM" <?php if($currency[0]=='MYR'){echo 'selected="selected"';}?>>MYR(RM)</option>
									   <option value="MVR,Rf" <?php if($currency[0]=='MVR'){echo 'selected="selected"';}?>>MVR(Rf)</option>
									   <option value="MRO,UM" <?php if($currency[0]=='MRO'){echo 'selected="selected"';}?>>MRO(UM)</option>
									   <option value="MUR,₨" <?php if($currency[0]=='MUR'){echo 'selected="selected"';}?>>MUR(₨)</option>
									   <option value="MXN,$" <?php if($currency[0]=='MXN'){echo 'selected="selected"';}?>>MXN($)</option>
									   <option value="MNT,₮" <?php if($currency[0]=='MNT'){echo 'selected="selected"';}?>>MNT(₮)</option>
									   <option value="MZN,MT" <?php if($currency[0]=='MZN'){echo 'selected="selected"';}?>>MZN(MT)</option>
									   <option value="MMK,K" <?php if($currency[0]=='MMK'){echo 'selected="selected"';}?>>MMK(K)</option>
									   <option value="NAD,$" <?php if($currency[0]=='NAD'){echo 'selected="selected"';}?>>NAD($)</option>
									   <option value="NPR,₨" <?php if($currency[0]=='NPR'){echo 'selected="selected"';}?>>NPR(₨)</option>
									   <option value="ANG,ƒ" <?php if($currency[0]=='ANG'){echo 'selected="selected"';}?>>ANG(ƒ)</option>
									   <option value="NIO,C$" <?php if($currency[0]=='NIO'){echo 'selected="selected"';}?>>NIO(C$)</option>
									   <option value="NGN,₦" <?php if($currency[0]=='NGN'){echo 'selected="selected"';}?>>NGN(₦)</option>
									   <option value="KPW,₩" <?php if($currency[0]=='KPW'){echo 'selected="selected"';}?>>KPW(₩)</option>
									   <option value="OMR,﷼" <?php if($currency[0]=='OMR'){echo 'selected="selected"';}?>>OMR(﷼)</option>
									   <option value="PKR,₨" <?php if($currency[0]=='PKR'){echo 'selected="selected"';}?>>PKR(₨)</option>
									   <option value="PAB,B/." <?php if($currency[0]=='PAB'){echo 'selected="selected"';}?>>PAB(B/.)</option>
									   <option value="PYG,Gs" <?php if($currency[0]=='PYG'){echo 'selected="selected"';}?>>PYG(Gs)</option>
									   <option value="PEN,S/." <?php if($currency[0]=='PEN'){echo 'selected="selected"';}?>>PEN(S/.)</option>
									   <option value="PHP,Php" <?php if($currency[0]=='PHP'){echo 'selected="selected"';}?>>PHP(Php)</option>
									   <option value="PLN,zł" <?php if($currency[0]=='PLN'){echo 'selected="selected"';}?>>PLN(zł)</option>
									   <option value="QAR,﷼" <?php if($currency[0]=='QAR'){echo 'selected="selected"';}?>>QAR(﷼)</option>
									   <option value="RON,lei" <?php if($currency[0]=='RON'){echo 'selected="selected"';}?>>RON(lei)</option>
									   <option value="RUB,руб" <?php if($currency[0]=='RUB'){echo 'selected="selected"';}?>>RUB(руб)</option>
									   <option value="SHP,£" <?php if($currency[0]=='SHP'){echo 'selected="selected"';}?>>SHP(£)</option>
									   <option value="WST,WS$" <?php if($currency[0]=='WST'){echo 'selected="selected"';}?>>WST(WS$)</option>
									   <option value="STD,Db" <?php if($currency[0]=='STD'){echo 'selected="selected"';}?>>STD(Db)</option>
									   <option value="SAR,﷼" <?php if($currency[0]=='SAR'){echo 'selected="selected"';}?>>SAR(﷼)</option>
									   <option value="RSD,Дин" <?php if($currency[0]=='RSD'){echo 'selected="selected"';}?>>RSD(Дин)</option>
									   <option value="SCR,₨" <?php if($currency[0]=='SCR'){echo 'selected="selected"';}?>>SCR(₨)</option>
									   <option value="SLL,Le" <?php if($currency[0]=='SLL'){echo 'selected="selected"';}?>>SLL(Le)</option>
									   <option value="SGD,$" <?php if($currency[0]=='SGD'){echo 'selected="selected"';}?>>SGD($)</option>
									   <option value="SKK,Sk" <?php if($currency[0]=='SKK'){echo 'selected="selected"';}?>>SKK(Sk)</option>
									   <option value="SBD,$" <?php if($currency[0]=='SBD'){echo 'selected="selected"';}?>>SBD($)</option>
									   <option value="SOS,S" <?php if($currency[0]=='SOS'){echo 'selected="selected"';}?>>SOS(S)</option>
									   <option value="ZAR,R" <?php if($currency[0]=='ZAR'){echo 'selected="selected"';}?>>ZAR(R)</option>
									   <option value="GBP,£" <?php if($currency[0]=='GBP'){echo 'selected="selected"';}?>>GBP(£)</option>
									   <option value="KRW,₩" <?php if($currency[0]=='KRW'){echo 'selected="selected"';}?>>KRW(₩)</option>
									   <option value="LKR,₨" <?php if($currency[0]=='LKR'){echo 'selected="selected"';}?>>LKR(₨)</option>
									   <option value="SRD,$" <?php if($currency[0]=='SRD'){echo 'selected="selected"';}?>>SRD($)</option>
									   <option value="SEK,kr" <?php if($currency[0]=='SEK'){echo 'selected="selected"';}?>>SEK(kr)</option>
									   <option value="SYP,£" <?php if($currency[0]=='SYP'){echo 'selected="selected"';}?>>SYP(£)</option>
									   <option value="TWD,NT$" <?php if($currency[0]=='TWD'){echo 'selected="selected"';}?>>TWD(NT$)</option>
									   <option value="THB,฿" <?php if($currency[0]=='THB'){echo 'selected="selected"';}?>>THB(฿)</option>
									   <option value="TOP,T$" <?php if($currency[0]=='TOP'){echo 'selected="selected"';}?>>TOP(T$)</option>
									   <option value="TTD,TT$" <?php if($currency[0]=='TTD'){echo 'selected="selected"';}?>>TTD(TT$)</option>
									   <option value="TRY,YTL" <?php if($currency[0]=='TRY'){echo 'selected="selected"';}?>>TRY(YTL)</option>
									   <option value="TMM,m" <?php if($currency[0]=='TMM'){echo 'selected="selected"';}?>>TMM(m)</option>
									   <option value="UAH,₴" <?php if($currency[0]=='UAH'){echo 'selected="selected"';}?>>UAH(₴)</option>
									   <option value="UYU,$U" <?php if($currency[0]=='UYU'){echo 'selected="selected"';}?>>UYU($U)</option>
									   <option value="UZS,лв" <?php if($currency[0]=='UZS'){echo 'selected="selected"';}?>>UZS(лв)</option>
									   <option value="VUV,Vt" <?php if($currency[0]=='VUV'){echo 'selected="selected"';}?>>VUV(Vt)</option>
									   <option value="VEF,Bs" <?php if($currency[0]=='VEF'){echo 'selected="selected"';}?>>VEF(Bs)</option>
									   <option value="VND,₫" <?php if($currency[0]=='VND'){echo 'selected="selected"';}?>>VND(₫)</option>
									   <option value="YER,﷼" <?php if($currency[0]=='YER'){echo 'selected="selected"';}?>>YER(﷼)</option>
									   <option value="ZMK,ZK" <?php if($currency[0]=='ZMK'){echo 'selected="selected"';}?>>ZMK(ZK)</option>
									   <option value="ZWD,Z$" <?php if($currency[0]=='ZWD'){echo 'selected="selected"';}?>>ZWD(Z$)</option>
									   <?php /*?><option value="KWD,د.ك" <?php if($currency[0]=='KWD'){echo 'selected="selected"';}?>>KWD(د.ك)</option><?php */?>
									   <option value="KWD,KWD" <?php if($currency[0]=='KWD'){echo 'selected="selected"';}?>>KWD(KWD)</option>
									   <option value="AED,د.إ" <?php if($currency[0]=='AED'){echo 'selected="selected"';}?>>AED(د.إ)</option>
									</select>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label>Display currency</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="disp_currency" name="disp_currency" value="prefix" <?=($general_setting_data['disp_currency']=="prefix"||$general_setting_data['disp_currency']==""?'checked="checked"':'')?>> Prefix
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="disp_currency" name="disp_currency" value="postfix" <?=($general_setting_data['disp_currency']=="postfix"?'checked="checked"':'')?>> Postfix
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<label>Promocode Section</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="promocode_section_on" name="promocode_section" value="1" <?php if($general_setting_data['promocode_section']=='1'){echo 'checked="checked"';}?>> Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="promocode_section_off" name="promocode_section" value="0" <?php if($general_setting_data['promocode_section']=='0'){echo 'checked="checked"';}?>> No
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<label>Newsletter Section</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[newslettter_section]" value="1" <?=($other_settings['newslettter_section']=='1'||$other_settings['newslettter_section']==''?'checked="checked"':'')?>> Show
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[newslettter_section]" value="0" <?=($other_settings['newslettter_section']=='0'?'checked="checked"':'')?>> Hide
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label>Display full review Or number of words to show</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="full_review_or_number_of_words_full" name="other_settings[full_review_or_number_of_words]" value="full_review" <?=($other_settings['full_review_or_number_of_words']=='full_review'||$other_settings['full_review_or_number_of_words']==''?'checked="checked"':'')?>> Full Review
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="full_review_or_number_of_words_limited" name="other_settings[full_review_or_number_of_words]" value="limited_words" <?=($other_settings['full_review_or_number_of_words']=='limited_words'?'checked="checked"':'')?>> Limited words only
												<span></span>
											</label>
										</div>
										<div class="row review_limited_words_showhide" <?=($other_settings['full_review_or_number_of_words']=='limited_words'?'style="margin-top:5px;display:block;"':'style="margin-top:5px;display:none;"')?>>
										<div class="col-lg-6">
											<label for="review_limited_words">Enter limited words:</label>
											<input type="number" class="form-control m-input m-input--square" id="review_limited_words" value="<?=$other_settings['review_limited_words']?>" name="other_settings[review_limited_words]">
										</div>
										</div>
									</div>
									<div class="col-lg-3">
										<label>Offline / Maintenance Mode</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[maintainance_mode]" value="1" <?=($other_settings['maintainance_mode']=='1'||$other_settings['maintainance_mode']==''?'checked="checked"':'')?>> On
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[maintainance_mode]" value="0" <?=($other_settings['maintainance_mode']=='0'?'checked="checked"':'')?>> Off
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-3">
										<label>Breadcrumbs</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[show_breadcrumbs]" value="1" <?=($other_settings['show_breadcrumbs']=='1'?'checked="checked"':'')?>> Show
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[show_breadcrumbs]" value="0" <?=($other_settings['show_breadcrumbs']=='0'||$other_settings['show_breadcrumbs']==''?'checked="checked"':'')?>> Hide
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label>Contractor Concept</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[contractor_concept]" value="1" <?=($other_settings['contractor_concept']=='1'||$other_settings['contractor_concept']==''?'checked="checked"':'')?>> Enable
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[contractor_concept]" value="0" <?=($other_settings['contractor_concept']=='0'?'checked="checked"':'')?>> Disable
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-6">
										<label>INSTANT REPAIR QUOTE</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[home_instant_repair_quote]" value="b_d_m" <?=($other_settings['home_instant_repair_quote']=='b_d_m'||$other_settings['home_instant_repair_quote']==''?'checked="checked"':'')?>> Brand/Device/Model
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[home_instant_repair_quote]" value="d_m" <?=($other_settings['home_instant_repair_quote']=='d_m'?'checked="checked"':'')?>> Device/Model
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								
								<div class="form-group m-form__group m--padding-bottom-5">
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input id="is_space_between_currency_symbol" type="checkbox" value="1" name="is_space_between_currency_symbol" <?php if($general_setting_data['is_space_between_currency_symbol']=="1"){echo 'checked="checked"';}?>> Keep space between currency symbol and amount
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group row m--padding-top-5">
									<div class="col-lg-4">
									<label for="thousand_separator">Thousand Separator</label>
									<input type="text" class="form-control m-input m-input--square" id="thousand_separator" value="<?=$general_setting_data['thousand_separator']?>" name="thousand_separator">
									</div>
									<div class="col-lg-4">
									<label for="decimal_separator">Decimal Separator</label>
									<input type="text" class="form-control m-input m-input--square" id="decimal_separator" value="<?=$general_setting_data['decimal_separator']?>" name="decimal_separator">
									</div>
									<div class="col-lg-4">
									<label for="decimal_number">Number of Decimals</label>
									<input type="number" class="form-control m-input m-input--square" id="decimal_number" value="<?=$general_setting_data['decimal_number']?>" name="decimal_number">
									</div>
								</div>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								
								<div class="m-form__group form-group row">
									<div class="col-lg-5">
										<label>Customer Signup Activation By Admin</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[signup_activation_by_admin]" value="1" <?=($other_settings['signup_activation_by_admin']=='1'||$other_settings['signup_activation_by_admin']==''?'checked="checked"':'')?>> Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[signup_activation_by_admin]" value="0" <?=($other_settings['signup_activation_by_admin']=='0'?'checked="checked"':'')?>> No
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-7">
										<label>Show Missing Model/Device/Brand Section</label>
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input type="checkbox" value="1" name="other_settings[show_missing_model_section]" <?php if($other_settings['show_missing_model_section']=="1"){echo 'checked="checked"';}?>> Model Page
												<span></span>
											</label>
											<label class="m-checkbox">
												<input type="checkbox" value="1" name="other_settings[show_missing_device_section]" <?php if($other_settings['show_missing_device_section']=="1"){echo 'checked="checked"';}?>> Device Page
												<span></span>
											</label>
											<label class="m-checkbox">
												<input type="checkbox" value="1" name="other_settings[show_missing_brand_section]" <?php if($other_settings['show_missing_brand_section']=="1"){echo 'checked="checked"';}?>> Brand Page
												<span></span>
											</label>
											<label class="m-checkbox">
												<input type="checkbox" value="1" name="other_settings[show_missing_category_section]" <?php if($other_settings['show_missing_category_section']=="1"){echo 'checked="checked"';}?>> Category Page
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								
								<div class="form-group m-form__group m--padding-bottom-5 row">
									<div class="col-lg-6">
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="is_ip_restriction" type="checkbox" value="1" name="is_ip_restriction" <?php if($general_setting_data['is_ip_restriction']=="1"){echo 'checked="checked"';}?>> Restrict Access by IP
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="allow_sms_verify_of_admin_staff_login" type="checkbox" value="1" name="allow_sms_verify_of_admin_staff_login" <?php if($general_setting_data['allow_sms_verify_of_admin_staff_login']=="1"){echo 'checked="checked"';}?>> Allow SMS Verify Of Admin/Staff Login
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group allowed_ip m--padding-top-5" <?php if($general_setting_data['is_ip_restriction']=="1"){echo 'style="display:block;"';} else {echo 'style="display:none;"';}?>>
									<label for="allowed_ip">Allowed IPs</label>
									<textarea class="form-control m-input m-input--square" name="allowed_ip" rows="3"><?=$general_setting_data['allowed_ip']?></textarea>
									<span class="m-form__help">
										IPs with comma seperated<br />
										Verify Your IP already added otherwise you can not access CRM: <?=USER_IP?>
									</span>
								</div>
								<div class="m-separator m-separator--dash m-separator--sm"></div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="header_service_hours_text">Service Hours Text (Header)</label>
										<textarea class="form-control m-input m-input--square" name="header_service_hours_text" rows="3"><?=$general_setting_data['header_service_hours_text']?></textarea>
									</div>
									<div class="col-lg-6">
										<label for="custom_js_code">JS code &#60;head&#62; just after opening of tag</label>
										<textarea class="form-control m-input m-input--square" name="custom_js_code" rows="3"><?=$general_setting_data['custom_js_code']?></textarea>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="header_service_hours_text">JS code &#60;body&#62; just after opening of tag</label>
										<textarea class="form-control m-input m-input--square" name="after_body_js_code" rows="5"><?=$general_setting_data['after_body_js_code']?></textarea>
									</div>
									<div class="col-lg-6">
										<label for="custom_js_code">JS code &#60;&#47;body&#62; just before close of tag</label>
										<textarea class="form-control m-input m-input--square" name="before_body_js_code" rows="5"><?=$general_setting_data['before_body_js_code']?></textarea>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="order_receipt_terms">Terms & Conditions of order receipt</label>
									<textarea class="description" name="order_receipt_terms" rows="5"><?=$general_setting_data['order_receipt_terms']?></textarea>
								</div>
								
								<?php
								$robots_txt = file_get_contents('../robots.txt'); ?>
								<div class="form-group m-form__group">
									<label for="robots_txt">robots.txt</label>
									<textarea class="form-control m-input m-input--square" name="robots_txt" rows="10"><?=$robots_txt?></textarea>
								</div>
								
								<?php
								}
								elseif($type == "appointment") {
								$inc   = 60 * 60;
								$start = (strtotime('01:00'));
								$end   = (strtotime('24:00')); ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="order_prefix">Order Prefix</label>
										<input type="text" class="form-control m-input m-input--square" id="order_prefix" value="<?=$general_setting_data['order_prefix']?>" name="order_prefix" maxlength="5">
									</div>
									<div class="col-lg-6">
										<label for="order_completed_prefix">Booking Order Completed URL Prefix</label>
										<input type="text" class="form-control m-input m-input--square" id="order_completed_prefix" value="<?=$general_setting_data['order_completed_prefix']?>" name="order_completed_prefix" maxlength="5">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label>Location Options On Repair Form</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="other_settings[location_option_bring_to_shop]" <?php if($other_settings['location_option_bring_to_shop']=='1'){echo 'checked="checked"';}?>>
											Bring To Shop<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="other_settings[location_option_come_for_you]" <?php if($other_settings['location_option_come_for_you']=='1'){echo 'checked="checked"';}?>>
											We Come For You<span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="other_settings[location_option_ship_device]" <?php if($other_settings['location_option_ship_device']=='1'){echo 'checked="checked"';}?>>
											Ship Your Device<span></span>
										</label>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<div class="col-lg-4">
									<label for="appt_start_time">Appt. Start Time</label>
									<select class="form-control select2 m_select2" name="appt_start_time" id="appt_start_time">
										<option value=""> - Select - </option>
										<?php
										$saved_start_time=$general_setting_data['appt_start_time'];
										for($i = $start; $i <= $end; $i += $inc) {
											$start_appt_time=date("g:i a", $i);
											if($saved_start_time==$start_appt_time)
												$isSelected="selected";
											else
												$isSelected="";
											echo '<option value="'.$start_appt_time.'" '.$isSelected.'>'.$start_appt_time.'</option>';
										} ?>
									</select>
									</div>
									<div class="col-lg-4">
									<label for="appt_end_time">Appt. End Time</label>
									<select class="form-control select2 m_select2" name="appt_end_time" id="appt_end_time">
										<option value=""> - Select - </option>
										<?php
										$saved_start_time=$general_setting_data['appt_end_time'];
										for($i = $start; $i <= $end; $i += $inc) {
											$start_appt_time=date("g:i a", $i);
											if($saved_start_time==$start_appt_time)
												$isSelected="selected";
											else
												$isSelected="";
											echo '<option value="'.$start_appt_time.'" '.$isSelected.'>'.$start_appt_time.'</option>';
										} ?>
									</select>
									</div>
									<div class="col-lg-4">
									<label for="appt_time_interval">Appt. Time Interval (Minute)</label>
									<select class="form-control select2 m_select2" name="appt_time_interval" id="appt_time_interval">
										<option value=""> - Select - </option>
										<?php
										$saved_time_interval=$general_setting_data['appt_time_interval'];
										for($i = 5; $i <= 60; $i += 5) {
											if($saved_time_interval==$i)
												$isSelected="selected";
											else
												$isSelected="";
											echo '<option value="'.$i.'" '.$isSelected.'>'.$i.'</option>';
										} ?>
									</select>
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="allowed_num_of_booking_per_time_slot">Set number of booking allowed per time slot</label>
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="allowed_num_of_booking_per_time_slot" type="checkbox" value="1" name="allowed_num_of_booking_per_time_slot" <?php if($general_setting_data['allowed_num_of_booking_per_time_slot']=="1"){echo 'checked="checked"';}?>>
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-6">
										<label>Online Booking Hide Price</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="other_settings[online_booking_hide_price]" value="1" <?=($other_settings['online_booking_hide_price']=='1'||$other_settings['online_booking_hide_price']==''?'checked="checked"':'')?>> Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="other_settings[online_booking_hide_price]" value="0" <?=($other_settings['online_booking_hide_price']=='0'?'checked="checked"':'')?>> No
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group booking_allowed_per_time_slot" <?php if($general_setting_data['allowed_num_of_booking_per_time_slot']=="1"){echo 'style="display:block;"';} else {echo 'style="display:none;"';}?>>
									<label for="num_of_booking_per_time_slot">Enter number of booking per time slot</label>
									<input type="number" class="form-control m-input m-input--square" name="num_of_booking_per_time_slot" value="<?=$general_setting_data['num_of_booking_per_time_slot']?>">
								</div>
								
								<div class="form-group m-form__group">
									<label>Choose Days to Block</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input id="appt_week_days_block0" type="checkbox" value="1" name="appt_week_days_block[day_0]" <?php if($appt_week_days_block['day_0']=='1'){echo 'checked="checked"';}?>>
											Sun<span></span>
										</label>
										<label class="m-checkbox">
											<input id="appt_week_days_block1" type="checkbox" value="1" name="appt_week_days_block[day_1]" <?php if($appt_week_days_block['day_1']=='1'){echo 'checked="checked"';}?>>
											Mo<span></span>
										</label>
										<label class="m-checkbox">
											<input id="appt_week_days_block2" type="checkbox" value="1" name="appt_week_days_block[day_2]" <?php if($appt_week_days_block['day_2']=='1'){echo 'checked="checked"';}?>>
											Tu<span></span>
										</label>
										<label class="m-checkbox">
											<input id="appt_week_days_block3" type="checkbox" value="1" name="appt_week_days_block[day_3]" <?php if($appt_week_days_block['day_3']=='1'){echo 'checked="checked"';}?>>
											We<span></span>
										</label>
										<label class="m-checkbox">
											<input id="appt_week_days_block4" type="checkbox" value="1" name="appt_week_days_block[day_4]" <?php if($appt_week_days_block['day_4']=='1'){echo 'checked="checked"';}?>>
											Th<span></span>
										</label>
										<label class="m-checkbox">
											<input id="appt_week_days_block5" type="checkbox" value="1" name="appt_week_days_block[day_5]" <?php if($appt_week_days_block['day_5']=='1'){echo 'checked="checked"';}?>>
											Fr<span></span>
										</label>
										<label class="m-checkbox">
											<input id="appt_week_days_block6" type="checkbox" value="1" name="appt_week_days_block[day_6]" <?php if($appt_week_days_block['day_6']=='1'){echo 'checked="checked"';}?>>
											Sa<span></span>
										</label>
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="appt_special_dates_block">Choose Special Dates To Block</label>
									<input type="text" class="form-control m-input m-input--square multidate" id="appt_special_dates_block" value="<?=$general_setting_data['appt_special_dates_block']?>" name="appt_special_dates_block">
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="google_client_id">Google Client ID (Calendar API)</label>
										<input type="text" class="form-control m-input m-input--square" id="google_calendar_client_id" value="<?=$general_setting_data['google_calendar_client_id']?>" name="google_calendar_client_id">
									</div>
									<div class="col-lg-4">
										<label for="google_client_secret">Google Client Secret (Calendar API)</label>
										<input type="text" class="form-control m-input m-input--square" id="google_calendar_client_secret" value="<?=$general_setting_data['google_calendar_client_secret']?>" name="google_calendar_client_secret">
									</div>
									<div class="col-lg-4">
										<label for="order_completed_prefix">Google Redirect URL (Calendar API)</label>
										<input type="text" class="form-control m-input m-input--square" value="<?=SITE_URL?>admin/social/oauth2callback.php" name="google_auth_url" disabled="disabled">
										<span class="m-form__help">Copy this url and paste it to your Redirect URL in console.cloud.google.com.</span>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Google Calendar API</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" id="google_cal_api" name="google_cal_api" value="1" <?=($general_setting_data['google_cal_api']=='1'?'checked="checked"':'')?>> Yes
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" id="google_cal_api" name="google_cal_api" value="0" <?=($general_setting_data['google_cal_api']=='0'||$general_setting_data['google_cal_api']==''?'checked="checked"':'')?>> No
											<span></span>
										</label>
									</div>
									<?php
									if($general_setting_data['is_google_cal_auth'] == '1') {
										$google_cal_auth_info = json_decode($general_setting_data['google_cal_auth_info']);
										echo '<a href="'.SITE_URL.'admin/social/index.php?UnAuthorize=yes" onclick="return confirm(\'Are you sure you want to unauthorize?\');">UnAuthorize ('.$google_cal_auth_info->auth_email.')</a>';
									} else {
										echo '<a href="'.SITE_URL.'admin/social/index.php">Authorize</a>';
									} ?>
								</div>
								<?php
								}
								elseif($type == "company") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
									<label for="company_name">Company Name</label>
									<input type="text" class="form-control m-input m-input--square" id="company_name" value="<?=$general_setting_data['company_name']?>" name="company_name">
									</div>
									<div class="col-lg-6">
									<label for="company_phone">Phone</label>
									<input type="text" class="form-control m-input m-input--square" id="company_phone" value="<?=$general_setting_data['company_phone']?>" name="company_phone">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="company_address">Address</label>
									<input type="text" class="form-control m-input m-input--square" id="company_address" value="<?=$general_setting_data['company_address']?>" name="company_address">
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-3">
										<label for="company_city">City</label>
										<input type="text" class="form-control m-input m-input--square" id="company_city" value="<?=$general_setting_data['company_city']?>" name="company_city">
									</div>
									<div class="col-lg-3">
										<label for="company_state">State</label>
										<input type="text" class="form-control m-input m-input--square" id="company_state" value="<?=$general_setting_data['company_state']?>" name="company_state">
									</div>
									<div class="col-lg-3">
										<label for="company_country">Country</label>
										<input type="text" class="form-control m-input m-input--square" id="company_country" value="<?=$general_setting_data['company_country']?>" name="company_country">
									</div>
									<div class="col-lg-3">
										<label for="company_zipcode">Zipcode</label>
										<input type="text" class="form-control m-input m-input--square" id="company_zipcode" value="<?=$general_setting_data['company_zipcode']?>" name="company_zipcode">
									</div>
								</div>
								<?php
								}
								elseif($type == "email") {
								$is_smtp_mailter = 'style="display:none;"';
								$is_emailapi_mailter = 'style="display:none;"';
								if($general_setting_data['mailer_type']=='smtp') {
									$is_smtp_mailter = '';
								}
								if($general_setting_data['mailer_type']=='sendgrid') {
									$is_emailapi_mailter = '';
								} ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
									<label for="company_name">From Name</label>
									<input type="text" class="form-control m-input m-input--square" id="from_name" value="<?=$general_setting_data['from_name']?>" name="from_name">
									</div>
									<div class="col-lg-6">
									<label for="company_phone">From Email</label>
									<input type="text" class="form-control m-input m-input--square" id="from_email" value="<?=$general_setting_data['from_email']?>" name="from_email">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="company_address">Mailer</label>
									<select class="form-control m-input" name="mailer_type" id="mailer_type" onchange="chg_mailer_type(this.value);">									  
										<option value="mail" <?php if($general_setting_data['mailer_type']=='mail'||$general_setting_data['mailer_type']==''){echo 'selected="selected"';}?>>PHP Mail</option>
										<option value="smtp" <?php if($general_setting_data['mailer_type']=='smtp'){echo 'selected="selected"';}?>>SMTP</option>
										<option value="sendgrid" <?php if($general_setting_data['mailer_type']=='sendgrid'){echo 'selected="selected"';}?>>SendGrid</option>
									</select>
								</div>
								
								<div class="form-group m-form__group row showhide_smtp_fields" <?=$is_smtp_mailter?>>
									<div class="col-lg-4">
										<label for="company_city">SMTP Host</label>
										<input type="text" class="form-control m-input m-input--square" id="smtp_host" value="<?=$general_setting_data['smtp_host']?>" name="smtp_host">
									</div>
									<div class="col-lg-4">
										<label for="company_state">SMTP Port</label>
										<input type="text" class="form-control m-input m-input--square" id="smtp_port" value="<?=$general_setting_data['smtp_port']?>" name="smtp_port">
									</div>
									<div class="col-lg-4">
										<label for="company_country">SMTP Security</label>
										<select class="form-control m-input" name="smtp_security" id="smtp_security">									  
											<option value="none" <?php if($general_setting_data['smtp_security']=='none'){echo 'selected="selected"';}?>>None</option>
											<option value="ssl" <?php if($general_setting_data['smtp_security']=='ssl'){echo 'selected="selected"';}?>>SSL/TLS</option>
										</select>
									</div>
								</div>
								<div class="form-group m-form__group row showhide_smtp_fields" <?=$is_smtp_mailter?>>
									<div class="col-lg-6">
										<label for="company_city">SMTP Username</label>
										<input type="text" class="form-control m-input m-input--square" id="smtp_username" value="<?=$general_setting_data['smtp_username']?>" name="smtp_username">
									</div>
									<div class="col-lg-6">
										<label for="company_state">SMTP Password</label>
										<input type="text" class="form-control m-input m-input--square" id="smtp_password" value="<?=$general_setting_data['smtp_password']?>" name="smtp_password">
									</div>
								</div>
								<div class="form-group m-form__group showhide_emailapi_fields" <?=$is_emailapi_mailter?>>
									<label for="company_city">API Key</label>
									<input type="text" class="form-control m-input m-input--square" id="email_api_key" value="<?=$general_setting_data['email_api_key']?>" name="email_api_key">
								</div>
								<?php
								}
								elseif($type == "socials") { ?>
								<div class="form-group m-form__group m--padding-bottom-5">
									<h4 class="m-section__heading">Socials Link</h4>
								</div>
								<?php
								$social_list_array = array('facebook','twitter','linkedin','foursquare','pinterest','flickr','youtube','google_plus','vimeo','instagram','yelp');
								foreach($social_list_array as $social_key => $social_val) { ?>
								<div class="form-group m-form__group row m--padding-top-5">
									<div class="col-lg-4">
										<label for="company_name"><?=ucwords(str_replace("_"," ",$social_val))?></label>
										<input type="text" class="form-control m-input m-input--square" value="<?=$other_settings[$social_val.'_social_link']?>"  name="other_settings[<?=$social_val?>_social_link]">
									</div>
									<div class="col-lg-4">
										<label for="company_phone">Fa Icon</label>
										<input type="text" class="form-control m-input m-input--square" value="<?=$other_settings[$social_val.'_social_link_icon']?>"  name="other_settings[<?=$social_val?>_social_link_icon]">
									</div>
									<div class="col-lg-4">
										<label>&nbsp;</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input id="<?=$social_val?>_link_status" type="checkbox" value="1" name="other_settings[<?=$social_val?>_social_link_status]" <?php if($other_settings[$social_val.'_social_link_status']=='1'){echo 'checked="checked"';}?>>
													<span></span>
												</label>
											</span>
										</div>
								
										<?php /*?><div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="<?=$social_val?>_link_status_on" name="other_settings[<?=$social_val?>_social_link_status]" value="1" <?php if($other_settings[$social_val.'_social_link_status']=='1'){echo 'checked="checked"';}?>> Publish
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="<?=$social_val?>_link_status_off" name="other_settings[<?=$social_val?>_social_link_status]" value="0" <?php if($other_settings[$social_val.'_social_link_status']==''||$other_settings[$social_val.'_link_status']=='0'){echo 'checked="checked"';}?>> Unpublish
												<span></span>
											</label>
										</div><?php */?>
									</div>
								</div>
								<?php
								} ?>
								
								<div class="form-group m-form__group m--padding-bottom-5">
									<h4 class="m-section__heading">Social Login Settings</h4>
								</div>
								<div class="form-group m-form__group row m--padding-top-5">
									<div class="col-lg-6">
										<label for="company_address">Social Login</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="show_social_login_on" name="social_login" value="1" <?php if($general_setting_data['social_login']=='1'){echo 'checked="checked"';}?>> Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="show_social_login_off" name="social_login" value="0" <?php if($general_setting_data['social_login']=='0'){echo 'checked="checked"';}?>> No
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-6">
										<label for="company_address">Social Login Option</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="social_login_option" name="social_login_option" value="g_f" <?=($general_setting_data['social_login_option']=="g_f"||$general_setting_data['social_login_option']==""?'checked="checked"':'')?>> Google & Facebook
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="social_login_option" name="social_login_option" value="g" <?=($general_setting_data['social_login_option']=="g"?'checked="checked"':'')?>> Google
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="social_login_option" name="social_login_option" value="f" <?=($general_setting_data['social_login_option']=="f"?'checked="checked"':'')?>> Facebook
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group">
									<label for="company_city">Website URL</label>
									<input type="text" class="form-control m-input m-input--square" value="<?=SITE_URL?>" disabled="disabled">
								</div>
								<div class="m-separator m-separator--line m-separator--sm"></div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="company_city">Google Client ID</label>
										<input type="text" class="form-control m-input m-input--square" id="google_client_id" value="<?=$general_setting_data['google_client_id']?>" name="google_client_id">
									</div>
									<div class="col-lg-6">
										<label for="company_city">Google Client Secret</label>
										<input type="text" class="form-control m-input m-input--square" id="google_client_secret" value="<?=$general_setting_data['google_client_secret']?>" name="google_client_secret">
									</div>
								</div>
								<div class="form-group m-form__group">
									<label for="company_city">Google Redirect URL</label>
									<input type="text" class="form-control m-input m-input--square" value="<?=SITE_URL?>social/social.php?google" disabled="disabled">
									<span class="m-form__help">Copy this url and paste it to your Redirect URL in console.cloud.google.com.</span>
								</div>
								<div class="m-separator m-separator--line m-separator--sm"></div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="company_city">Facebook App ID</label>
										<input type="text" class="form-control m-input m-input--square" id="fb_app_id" value="<?=$general_setting_data['fb_app_id']?>" name="fb_app_id">
									</div>
									<div class="col-lg-6">
										<label for="company_city">Facebook App Secret</label>
										<input type="text" class="form-control m-input m-input--square" id="fb_app_secret" value="<?=$general_setting_data['fb_app_secret']?>" name="fb_app_secret">
									</div>
								</div>
								<div class="form-group m-form__group">
									<label for="company_city">Facebook Valid OAuth Redirect URI</label>
									<input type="text" class="form-control m-input m-input--square" value="<?=SITE_URL?>social/success-fb.php?only_data_from_fb=1" disabled="disabled">
									<span class="m-form__help">Copy this url and paste it to your Valid OAuth Redirect URI in developers.facebook.com.</span>
								</div>
								<?php
								}
								elseif($type == "sms") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label>SMS Sending Status</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input id="sms_sending_status" type="checkbox" value="1" name="sms_sending_status" <?=($general_setting_data['sms_sending_status']=='1'?'checked="checked"':'')?>> <span></span>
												</label>
											</span>
										</div>
	
										<?php /*?><label>SMS Sending Status</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="sms_sending_status_on" name="sms_sending_status" value="1" <?=($general_setting_data['sms_sending_status']=='1'?'checked="checked"':'')?>> ON
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="sms_sending_status_off" name="sms_sending_status" value="0" <?=(intval($general_setting_data['sms_sending_status'])=='0'?'checked="checked"':'')?>> OFF
												<span></span>
											</label>
										</div><?php */?>
									</div>
									<div class="col-lg-4">
										<label for="input">Twilio Account SID</label>
										<input type="text" class="form-control m-input m-input--square" id="twilio_ac_sid" value="<?=$general_setting_data['twilio_ac_sid']?>" name="twilio_ac_sid">
									</div>
									<div class="col-lg-4">
										<label for="input">Twilio Account Auth Token</label>
										<input type="text" class="form-control m-input m-input--square" id="twilio_ac_token" value="<?=$general_setting_data['twilio_ac_token']?>" name="twilio_ac_token">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="input">Twilio IPM Service SID</label>
										<input type="text" class="form-control m-input m-input--square" id="twilio_ipm_service_sid" value="<?=$general_setting_data['twilio_ipm_service_sid']?>" name="twilio_ipm_service_sid">
									</div>
									<div class="col-lg-4">
										<label for="input">Twilio API Key</label>
										<input type="text" class="form-control m-input m-input--square" id="twilio_api_key" value="<?=$general_setting_data['twilio_api_key']?>" name="twilio_api_key">
									</div>
									<div class="col-lg-4">
										<label for="input">Twilio API Secret</label>
										<input type="text" class="form-control m-input m-input--square" id="twilio_api_secret" value="<?=$general_setting_data['twilio_api_secret']?>" name="twilio_api_secret">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="input">Twilio Long Code</label>
										<input type="number" class="form-control m-input m-input--square" id="twilio_long_code" value="<?=$general_setting_data['twilio_long_code']?>" name="twilio_long_code">
									</div>
									<div class="col-lg-6">
										<label for="input">Customer Phone Country Code</label>
										<input type="number" class="form-control m-input m-input--square" id="user_phone_country_code" value="<?=$general_setting_data['user_phone_country_code']?>" name="user_phone_country_code">
									</div>
								</div>
								<?php
								}
								elseif($type == "blog") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="input">Excerpt Length (number of words)</label>
										<input type="number" class="form-control m-input m-input--square" id="blog_rm_words_limit" value="<?=$general_setting_data['blog_rm_words_limit']?>" name="blog_rm_words_limit">
									</div>
									<div class="col-lg-4">
										<label for="company_address">Display Recent Post</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="1" <?=($general_setting_data['blog_recent_posts']=='1'||$general_setting_data['blog_recent_posts']==""?'checked="checked"':'')?>> Show
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="0" <?=($general_setting_data['blog_recent_posts']=='0'?'checked="checked"':'')?>> Hide
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<label for="company_address">Display Categories</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="blog_categories" name="blog_categories" value="1" <?=($general_setting_data['blog_categories']=='1'||$general_setting_data['blog_categories']==""?'checked="checked"':'')?>> Show
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="blog_categories" name="blog_categories" value="0" <?=($general_setting_data['blog_categories']=='0'?'checked="checked"':'')?>> Hide
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<?php
								}
								elseif($type == "captcha") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="company_name">Captcha Key</label>
										<input type="text" class="form-control m-input m-input--square" name="captcha_settings[captcha_key]" value="<?=$captcha_settings['captcha_key']?>">
									</div>
									<div class="col-lg-6">
										<label for="company_phone">Captcha Secret</label>
										<input type="text" class="form-control m-input m-input--square" name="captcha_settings[captcha_secret]" value="<?=$captcha_settings['captcha_secret']?>">
									</div>
								</div>
								
								<div class="form-group m-form__group">
									<label for="input">Captcha Form Settings</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[contact_form]" <?php if($captcha_settings['contact_form']=="1"){echo 'checked="checked"';}?>>
											Contact Us Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[write_review_form]" <?php if($captcha_settings['write_review_form']=="1"){echo 'checked="checked"';}?>>
											Write A Review Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[bulk_order_form]" <?php if($captcha_settings['bulk_order_form']=="1"){echo 'checked="checked"';}?>>
											Bulk Order Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[affiliate_form]" <?php if($captcha_settings['affiliate_form']=="1"){echo 'checked="checked"';}?>>
											Affiliate Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[appt_form]" <?php if($captcha_settings['appt_form']=="1"){echo 'checked="checked"';}?>>
											Appt. Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[login_form]" <?php if($captcha_settings['login_form']=="1"){echo 'checked="checked"';}?>>
											Login Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[signup_form]" <?php if($captcha_settings['signup_form']=="1"){echo 'checked="checked"';}?>>
											Signup Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[contractor_form]" <?php if($captcha_settings['contractor_form']=="1"){echo 'checked="checked"';}?>>
											Contractor Form <span></span>
										</label>
										
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[order_track_form]" <?php if($captcha_settings['order_track_form']=="1"){echo 'checked="checked"';}?>>
											Order Track Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[newsletter_form]" <?php if($captcha_settings['newsletter_form']=="1"){echo 'checked="checked"';}?>>
											Newsletter Form <span></span>
										</label>
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="captcha_settings[missing_product_form]" <?php if($captcha_settings['missing_product_form']=="1"){echo 'checked="checked"';}?>>
											Missing Product Form <span></span>
										</label>
									</div>
								</div>
								<?php
								}
								elseif($type == "homepage") { ?>
								<div class="form-group m-form__group">
									<label for="home_slider">Process Works & Slider</label>
									<textarea class="description" name="home_slider" rows="5"><?=$general_setting_data['home_slider']?></textarea>
								</div>
								
								<?php
								}
								elseif($type == "sitemap") { ?>
								<div class="form-group m-form__group">
									<label for="xml_file">Upload Sitemap(XML) File</label>
									<input type="file" class="form-control m-input m-input--square" id="xml_file" name="xml_file" onChange="checkFileXml(this)">
									<?php
									$sitemap_url = "../sitemap.xml";
									if(file_exists($sitemap_url)) { ?>
										<a class="btn btn-sm btn-danger m--margin-top-10" href="javascript:void(0);" onclick="removeXmlFile()"><i class="la la-trash"></i> Remove</a>
									<?php 
									} ?>
								</div>
								<?php
								}
								elseif($type == "ticket") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="published">Notification New Ticket Created:</label>
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="new_ticket_email" type="checkbox" value="email" name="ticket_settings[new_ticket_email]" <?php if($ticket_settings['new_ticket_email']=="email"){echo 'checked="checked"';}?>>
												Email <span></span>
											</label>
											<label class="m-checkbox">
												<input id="new_ticket_push" type="checkbox" value="push" name="ticket_settings[new_ticket_push]" <?php if($ticket_settings['new_ticket_push']=="push"){echo 'checked="checked"';}?>>
												Push <span></span>	
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<label for="published">Notification Ticket Status Change:</label>
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="change_ticket_status_email" type="checkbox" value="email" name="ticket_settings[change_ticket_status_email]" <?php if($ticket_settings['change_ticket_status_email']=="email"){echo 'checked="checked"';}?>>
												Email <span></span>
											</label>
											<label class="m-checkbox">
												<input id="change_ticket_status_push" type="checkbox" value="push" name="ticket_settings[change_ticket_status_push]" <?php if($ticket_settings['change_ticket_status_push']=="push"){echo 'checked="checked"';}?>>
												Push <span></span>	
											</label>
										</div>
									</div>
								</div>
								<?php
								}
								elseif($type == "menutype") { ?>
								<div class="form-group m-form__group">
									<div class="col-lg-6">
										<label for="published">Top Right Menu:</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input type="checkbox" name="other_settings[top_right_menu]" value="1" <?=($other_settings['top_right_menu']=='1'||$other_settings['top_right_menu']==''?'checked="checked"':'')?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group">
									<div class="col-lg-6">
										<label for="published">Header Menu:</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input type="checkbox" name="other_settings[header_menu]" value="1" <?=($other_settings['header_menu']=='1'||$other_settings['header_menu']==''?'checked="checked"':'')?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group">
									<div class="col-lg-6">
										<label for="published">Footer Menu Column1:</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input type="checkbox" name="other_settings[footer_menu_column1]" value="1" <?=($other_settings['footer_menu_column1']=='1'||$other_settings['footer_menu_column1']==''?'checked="checked"':'')?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
									<div class="col-lg-6">
										<input type="text" class="form-control m-input m-input--square" name="other_settings[footer_menu_column1_title]" value="<?=$other_settings['footer_menu_column1_title']?>" placeholder="Enter menu title">
									</div>
								</div>
								<div class="form-group m-form__group">
									<div class="col-lg-6">
										<label for="published">Footer Menu Column2:</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input type="checkbox" name="other_settings[footer_menu_column2]" value="1" <?=($other_settings['footer_menu_column2']=='1'||$other_settings['footer_menu_column2']==''?'checked="checked"':'')?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
									<div class="col-lg-6">
										<input type="text" class="form-control m-input m-input--square" name="other_settings[footer_menu_column2_title]" value="<?=$other_settings['footer_menu_column2_title']?>" placeholder="Enter menu title">
									</div>
								</div>
								<div class="form-group m-form__group">
									<div class="col-lg-6">
										<label for="published">Footer Menu Column3:</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input type="checkbox" name="other_settings[footer_menu_column3]" value="1" <?=($other_settings['footer_menu_column3']=='1'||$other_settings['footer_menu_column3']==''?'checked="checked"':'')?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
									<div class="col-lg-6">
										<input type="text" class="form-control m-input m-input--square" name="other_settings[footer_menu_column3_title]" value="<?=$other_settings['footer_menu_column3_title']?>" placeholder="Enter menu title">
									</div>
								</div>
								<div class="form-group m-form__group">
									<div class="col-lg-6">
										<label for="published">Copyright Menu:</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input type="checkbox" name="other_settings[copyright_menu]" value="1" <?=($other_settings['copyright_menu']=='1'||$other_settings['copyright_menu']==''?'checked="checked"':'')?>>
													<span></span>
												</label>
											</span>
										</div>
									</div>
								</div>
								<?php
								}
								elseif($type == "payment_method") { ?>
								<div class="payment_method_wrapper">
									<?php
									foreach($payment_method_array as $payment_method_key=>$payment_method_val) { ?>
									<div class="form-group m-form__group row">
										<div class="col-lg-8">
											<div class="row">
												<div class="col-md-6">
													<div class="m-form__group--inline">
														<div class="m-form__control">
															<input class="form-control m-input" name="payment_method[]" value="<?=$payment_method_val?>" maxlength="50">
														</div>
													</div>
													<div class="d-md-none m--margin-bottom-10"></div>
												</div>
												<div class="col-md-2">
													<div class="remove_payment_method btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
														<span>
															<i class="la la-trash-o"></i>
															<span>Delete</span>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									} ?>
								</div>
								<div class="m-form__group form-group row">
									<div class="col-lg-4">
										<div class="add_payment_method btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
											<span>
												<i class="la la-plus"></i>
												<span>Add</span>
											</span>
										</div>
									</div>
								</div>
								<?php
								}
								elseif($type == "payment_status") { ?>
								<div class="payment_status_wrapper">
									<?php
									foreach($payment_status_array as $payment_status_key=>$payment_status_val) { ?>
									<div class="form-group m-form__group row">
										<div class="col-lg-8">
											<div class="row">
												<div class="col-md-6">
													<div class="m-form__group--inline">
														<div class="m-form__control">
															<input class="form-control m-input" name="payment_status[]" value="<?=$payment_status_val?>" maxlength="50">
														</div>
													</div>
													<div class="d-md-none m--margin-bottom-10"></div>
												</div>
												<div class="col-md-2">
													<div class="remove_payment_status btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
														<span>
															<i class="la la-trash-o"></i>
															<span>Delete</span>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									} ?>
								</div>
								<div class="m-form__group form-group row">
									<div class="col-lg-4">
										<div class="add_payment_status btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
											<span>
												<i class="la la-plus"></i>
												<span>Add</span>
											</span>
										</div>
									</div>
								</div>
								<?php
								}
								elseif($type == "recently_ordered") { ?>
								<div class="form-group m-form__group row">
									<div class="col-md-4">
										<label for="display_recently_ordered">Display Recently Ordered</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input id="display_recently_ordered" type="checkbox" value="1" name="recently_ordered_settings[display_recently_ordered]" <?php if($recently_ordered_settings['display_recently_ordered']=="1"){echo 'checked="checked"';}?>> <span></span>
												</label>
											</span>
										</div>
										
										<?php /*?><div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="display_recently_ordered" type="checkbox" value="1" name="recently_ordered_settings[display_recently_ordered]" <?php if($recently_ordered_settings['display_recently_ordered']=="1"){echo 'checked="checked"';}?>> Display Recently Ordered <span></span>
											</label>
										</div><?php */?>
									</div>
									<div class="col-md-4">
										<label for="recently_ordered_limit">Number of Recent Ordered Model to Show</label>
										<input type="number" class="form-control m-input m-input--square" id="recently_ordered_limit" value="<?=$recently_ordered_settings['recently_ordered_limit']?>" name="recently_ordered_settings[recently_ordered_limit]">
									</div>
								</div>
								<?php
								}
								elseif($type == "testimonial") { ?>
								<div class="form-group m-form__group">
									<label for="recently_ordered_settings">Display Random Testimonial Settings</label>
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input id="display_on_model_detail" type="checkbox" value="1" name="testimonial_settings[display_on_model_detail]" <?php if($testimonial_settings['display_on_model_detail']=="1"){echo 'checked="checked"';}?>>
											Display On Model Detail <span></span>
										</label>
										<label class="m-checkbox">
											<input id="display_on_device_page" type="checkbox" value="1" name="testimonial_settings[display_on_device_page]" <?php if($testimonial_settings['display_on_device_page']=="1"){echo 'checked="checked"';}?>>
											Display On Device Page <span></span>
										</label>
										<label class="m-checkbox">
											<input id="display_on_model_page" type="checkbox" value="1" name="testimonial_settings[display_on_model_page]" <?php if($testimonial_settings['display_on_model_page']=="1"){echo 'checked="checked"';}?>>
											Display On Models Page <span></span>
										</label>
									</div>
								</div>
								<?php
								}
								elseif($type == "shipping_api") { ?>
								<div class="form-group m-form__group row">
									<div class="col-lg-4">
										<label for="shipping_api">Shipping API</label>
										<select class="form-control select2 m_select2" name="shipping_api" id="shipping_api">
											<option value=""> - Select - </option>							
											<option value="royal_mail" <?php if($general_setting_data['shipping_api']=='royal_mail'){echo 'selected="selected"';}?>>Royal Mail</option>
											<option value="easypost" <?php if($general_setting_data['shipping_api']=='easypost'){echo 'selected="selected"';}?>>Easy Post</option>
											<option value="postage_paid" <?php if($general_setting_data['shipping_api']=='postage_paid'){echo 'selected="selected"';}?>>Postage Paid</option>
										</select>
									</div>
									<div class="col-lg-4">
										<label for="shipment_generated_by_cust">Allow Shipment Generated to Customer</label>
										<div>
											<span class="m-switch m-switch--icon m-switch--primary">
												<label>
													<input id="shipment_generated_by_cust" type="checkbox" value="1" name="shipment_generated_by_cust" <?php if($general_setting_data['shipment_generated_by_cust']=='1'){echo 'checked="checked"';}?>> <span></span>
												</label>
											</span>
										</div>
									</div>
									<div class="col-lg-4">
										<label for="shipping_api_key">Shipping API Key</label>
										<input type="text" class="form-control m-input m-input--square" id="shipping_api_key" value="<?=$general_setting_data['shipping_api_key']?>" name="shipping_api_key">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="input">Default Carrier Account</label>
										<div class="m-checkbox-inline">
											<label class="m-radio">
												<input type="radio" id="default_carrier_account1" name="default_carrier_account" value="usps" <?=($general_setting_data['default_carrier_account']=="usps"||$general_setting_data['default_carrier_account']==""?'checked="checked"':'')?>>
												USPS <span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="default_carrier_account2" name="default_carrier_account" value="ups" <?=($general_setting_data['default_carrier_account']=="ups"?'checked="checked"':'')?>>
												UPS <span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="default_carrier_account3" name="default_carrier_account" value="fedex" <?=($general_setting_data['default_carrier_account']=="fedex"?'checked="checked"':'')?>>
												FedEx <span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="default_carrier_account4" name="default_carrier_account" value="dhl" <?=($general_setting_data['default_carrier_account']=="dhl"?'checked="checked"':'')?>>
												DHL <span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="default_carrier_account5" name="default_carrier_account" value="other" <?=($general_setting_data['default_carrier_account']=="other"?'checked="checked"':'')?>>
												Other <span></span>
											</label>
										</div>
									</div>
									<div class="col-lg-6">
										<label for="carrier_account_id">Carrier Account ID</label>
										<input type="text" class="form-control m-input m-input--square" id="carrier_account_id" value="<?=$general_setting_data['carrier_account_id']?>" name="carrier_account_id">
									</div>
								</div>
								
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="shipping_parcel_length">Shipping Parcel Length</label>
										<input type="text" class="form-control m-input m-input--square" id="shipping_parcel_length" value="<?=$general_setting_data['shipping_parcel_length']?>" name="shipping_parcel_length" placeholder="20.2">
									</div>
									<div class="col-lg-6">
										<label for="shipping_parcel_width">Shipping Parcel Width</label>
										<input type="text" class="form-control m-input m-input--square" id="shipping_parcel_width" value="<?=$general_setting_data['shipping_parcel_width']?>" name="shipping_parcel_width" placeholder="10.9">
									</div>
								</div>
								<div class="form-group m-form__group row">
									<div class="col-lg-6">
										<label for="shipping_parcel_height">Shipping Parcel Height</label>
										<input type="text" class="form-control m-input m-input--square" id="shipping_parcel_height" value="<?=$general_setting_data['shipping_parcel_height']?>" name="shipping_parcel_height" placeholder="5">
									</div>
									<div class="col-lg-6">
										<label for="shipping_parcel_weight">Shipping Parcel Weight</label>
										<input type="text" class="form-control m-input m-input--square" id="shipping_parcel_weight" value="<?=$general_setting_data['shipping_parcel_weight']?>" name="shipping_parcel_weight" placeholder="65.9">
									</div>
								</div>
								<?php
								}
								elseif($type == "model_fields") { ?>
								<div class="m-form__group form-group">
									<label>Text Field :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[text_field_of_model_fields]" value="1" <?=($other_settings['text_field_of_model_fields']=='1'||$other_settings['text_field_of_model_fields']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[text_field_of_model_fields]" value="0" <?=($other_settings['text_field_of_model_fields']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Text Area :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[text_area_of_model_fields]" value="1" <?=($other_settings['text_area_of_model_fields']=='1'||$other_settings['text_area_of_model_fields']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[text_area_of_model_fields]" value="0" <?=($other_settings['text_area_of_model_fields']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Calender/Date :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[calendar_of_model_fields]" value="1" <?=($other_settings['calendar_of_model_fields']=='1'||$other_settings['calendar_of_model_fields']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[calendar_of_model_fields]" value="0" <?=($other_settings['calendar_of_model_fields']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>File Upload :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[file_upload_of_model_fields]" value="1" <?=($other_settings['file_upload_of_model_fields']=='1'||$other_settings['file_upload_of_model_fields']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[file_upload_of_model_fields]" value="0" <?=($other_settings['file_upload_of_model_fields']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Tooltips :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[tooltips_of_model_fields]" value="1" <?=($other_settings['tooltips_of_model_fields']=='1'||$other_settings['tooltips_of_model_fields']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[tooltips_of_model_fields]" value="0" <?=($other_settings['tooltips_of_model_fields']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Icons :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[icons_of_model_fields]" value="1" <?=($other_settings['icons_of_model_fields']=='1'||$other_settings['icons_of_model_fields']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[icons_of_model_fields]" value="0" <?=($other_settings['icons_of_model_fields']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
									
								<div class="m-form__group form-group">
									<label>Repair Questions:</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[repair_questions_expanded_or_expand_collapse]" value="expanded" <?=($other_settings['repair_questions_expanded_or_expand_collapse']=='expanded'||$other_settings['repair_questions_expanded_or_expand_collapse']==''?'checked="checked"':'')?>> Expanded
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[repair_questions_expanded_or_expand_collapse]" value="expand_collapse" <?=($other_settings['repair_questions_expanded_or_expand_collapse']=='expand_collapse'?'checked="checked"':'')?>> Expand/Collapse
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[repair_questions_expanded_or_expand_collapse]" value="multiple_steps" <?=($other_settings['repair_questions_expanded_or_expand_collapse']=='multiple_steps'?'checked="checked"':'')?>> Multiple Steps
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Select Fields As Box OR Add/Remove Button:</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[select_fields_as_box_or_add_remove_button]" value="box" <?=($other_settings['select_fields_as_box_or_add_remove_button']=='box'||$other_settings['select_fields_as_box_or_add_remove_button']==''?'checked="checked"':'')?>> Box
											<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[select_fields_as_box_or_add_remove_button]" value="a_r_btn" <?=($other_settings['select_fields_as_box_or_add_remove_button']=='a_r_btn'?'checked="checked"':'')?>> Add/Remove Button
											<span></span>
										</label>
									</div>
								</div>

								<div class="m-form__group form-group">
									<div class="m-checkbox-inline">
										<label class="m-checkbox">
											<input type="checkbox" value="1" name="other_settings[show_repair_item_price]" <?php if($other_settings['show_repair_item_price']=="1"){echo 'checked="checked"';}?>> Show Repair Item Price
											<span></span>
										</label>
									</div>
								</div>
								
								<div class="m-form__group form-group">
									<label>Fault Prices :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[show_fault_prices]" value="1" <?=($other_settings['show_fault_prices']=='1'||$other_settings['show_fault_prices']==''?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[show_fault_prices]" value="0" <?=($other_settings['show_fault_prices']=='0'?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
								<?php
								}
								
                                elseif($type == "payment") { ?>
								<div class="m-form__group form-group">
									<label>Payment :</label>
									<div class="m-radio-inline">
										<label class="m-radio">
											<input type="radio" name="other_settings[cust_payment_option]" value="1" <?=($other_settings['cust_payment_option']=='1'?'checked="checked"':'')?>>
											Enable<span></span>
										</label>
										<label class="m-radio">
											<input type="radio" name="other_settings[cust_payment_option]" value="0" <?=($other_settings['cust_payment_option']=='0'||$other_settings['cust_payment_option']==''?'checked="checked"':'')?>>
											Disable<span></span>
										</label>
									</div>
								</div>
                                
                                <div class="form-group m-form__group">
                                    <label>Payment Type</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            <input type="radio" id="payment_type_on" name="other_settings[cust_payment_type]" value="full" onchange="change_disc_type(this.value);" <?php if($other_settings['cust_payment_type']=='full'){echo 'checked="checked"';}?>>
                                            Full
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" id="payment_type_off" name="other_settings[cust_payment_type]" value="percentage" onchange="change_disc_type(this.value);" <?php if($other_settings['cust_payment_type']=='percentage'){echo 'checked="checked"';}?>>
                                            Percentage
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group m-form__group payment_per_val_showhide" <?php if($other_settings['cust_payment_type']=='percentage'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
                                    <input type="number" class="form-control m-input" id="cust_payment_per_val" name="other_settings[cust_payment_per_val]" placeholder="Enter percentage" value="<?=$other_settings['cust_payment_per_val']?>">
                                </div>
                                
                                <div class="form-group m-form__group">
                                    <label for="payment_mode">API Mode</label>
                                    <select class="form-control m-input" name="other_settings[payment_mode]" id="payment_mode" onchange="chg_payment_mode(this.value);">									  
                                        <option value="test" <?php if($other_settings['payment_mode']=='test'||$other_settings['payment_mode']==''){echo 'selected="selected"';}?>>Test</option>
                                        <option value="live" <?php if($other_settings['payment_mode']=='live'){echo 'selected="selected"';}?>>Live</option>
                                    </select>
                                </div>
                                
                                <?php
                                $is_payment_test = 'style="display:none;"';
                                $is_payment_live = 'style="display:none;"';
                                if($other_settings['payment_mode']=='test'||$other_settings['payment_mode']=='') {
                                    $is_payment_test = 'style="display:block;"';
                                }
                                if($other_settings['payment_mode']=='live') {
                                    $is_payment_live = 'style="display:block;"';
                                } ?>
                                <div class="form-group m-form__group showhide_payment_test_fields" <?=$is_payment_test?>>
                                    <label for="stripe_test_publishable_key">Publishable key</label>
                                    <input type="text" class="form-control m-input" id="stripe_test_publishable_key" value="<?=$other_settings['stripe_test_publishable_key']?>" name="other_settings[stripe_test_publishable_key]">
                                </div>
                                <div class="form-group m-form__group showhide_payment_test_fields" <?=$is_payment_test?>>
                                    <label for="stripe_test_secret_key">Secret key</label>
                                    <input type="text" class="form-control m-input" id="stripe_test_secret_key" value="<?=$other_settings['stripe_test_secret_key']?>" name="other_settings[stripe_test_secret_key]">
                                </div>
                                
                                <div class="form-group m-form__group showhide_payment_live_fields" <?=$is_payment_live?>>
                                    <label for="stripe_live_publishable_key">Publishable key</label>
                                    <input type="text" class="form-control m-input" id="stripe_live_publishable_key" value="<?=$other_settings['stripe_live_publishable_key']?>" name="other_settings[stripe_live_publishable_key]">
                                </div>
                                <div class="form-group m-form__group showhide_payment_live_fields" <?=$is_payment_live?>>
                                    <label for="stripe_live_secret_key">Secret key</label>
                                    <input type="text" class="form-control m-input" id="stripe_live_secret_key" value="<?=$other_settings['stripe_live_secret_key']?>" name="other_settings[stripe_live_secret_key]">
                                </div>
								<?php
								} ?>
							</div>
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions">
									<button id="m_form_submit" type="submit" class="btn btn-primary" name="general_setting">Submit</button>
									<!--<a href="#" class="btn btn-secondary">Back</a>-->
								</div>
							</div>
							<input type="hidden" name="req_type" value="<?=$type?>" />
						</form>
						<!--end::Form-->
					</div>
					<!--end::Portlet-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Body -->
