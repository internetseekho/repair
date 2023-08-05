<?php
//Fetching data from model
require_once("models/branches.php");

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
		<?php
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
		//END for confirm message ?>

		<?php
		if($is_show_title && $show_title == '1') { ?>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$page_title?></h3>
		</div>
		<?php
		}

		if($active_page_data['content']) { ?>
			<div class="row pb-4">
				<div class="col-md-12">
					<?=$active_page_data['content']?>
				</div>
			</div>
		<?php
		} ?>
		
		<div class="tabs side-tabs tabs-bordered clearfix" id="tab-location">
			<ul class="tab-nav clearfix">
				<?php
                $l = 0;
                $first_location_nm_key = '';
                foreach($final_location_list as $location_nm_key => $location_data) {
                  $l = $l+1;
                  if($l == '1') {
                    $first_location_nm_key = $location_nm_key;
                  } ?>
                  <li <?php if($l == '1'){echo 'class="active"';}?>><a href="#menu<?=$location_nm_key?>" onClick="giveMap('<?=$location_nm_key?>');" ><?=$location_data[0]['city'].($location_data[0]['id'] == "corporate"?" (Corporate)":"")?></a></li>
                <?php
                } ?>
			</ul>
			<div class="tab-container">
				<?php
				$l2 = 0;
				foreach($final_location_list as $location_nm_key => $location_data) {
				  $l2 = $l2+1; ?>
				  <div id="menu<?=$location_nm_key?>" class="tab-content clearfix <?php if($l2 == '1'){echo 'active';}?>">
				  	<div class="row" style="margin:5px;">
						<div id="map<?=$location_nm_key?>" class="map2 col-12 clearfix" style="width:100%;height:400px;"></div>
					</div>
					<div class="row">
						<?php
						foreach($location_data as $location_sub_data) {
							$get_direction_adr = 'http://maps.google.com/maps?z=10&t=m&q=loc:'.$location_sub_data['lat'].'+'.$location_sub_data['lng']; ?>
							<div class="col-md-6">
								<div class="card p-3 bg-light mt-4">
									<div class="card-body">
										<h4 class="nomargin"><strong><?=$location_sub_data['name']?></strong></h4>
										<p><?=$location_sub_data['address'].'<br>'.$location_sub_data['city'].' '.$location_sub_data['state'].' '.$location_sub_data['country'].'<br>'.$location_sub_data['name'].' - '.$location_sub_data['zipcode']?></p>
										<?php
										if($location_sub_data['service_hours_info']) {
											echo '<h5 class="nobottommargin"><strong>Service Hours</strong></h5><div class="row bottommargin-sm">'.$location_sub_data['service_hours_info'].'</div>';
										} ?>
										<span>
										<?php
										if($location_sub_data['id'] != "corporate") { ?>
											<a href="javascript:void(0)" onClick="openApptFormModal('<?=$location_sub_data['id']?>');" class="button ml-0 mr-0"><i class="icon-calendar2"></i> <?=$book_appointment_title?></a>
										<?php
										} ?>
										<a target="_blank" class="button ml-0 mr-0 <?=($location_sub_data['id'] == "corporate"?"pull-left":"pull-right")?>" href="<?=$get_direction_adr?>"><i class="icon-map-marker1"></i> <?=$get_direction_btn_text?></a>
										</span>
									</div>
								</div>
							</div>
						<?php
						} ?>
					</div>
				  </div>
				<?php
				} ?>
			</div>
		</div>
	</div>
</section>

<div class="editAddress-modal modal fade HelpPopup" id="ApptFormModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel"><?=$make_appointment_popup_title?></h4>
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>
		<div class="modal-body">
			<div class="form-row">
				<div class="form-group col-md-12">
					<label><?=$request_quote_brand_title?></label>
					<select class="sm-form-control" name="quote_make" id="quote_make" onchange="getQuoteDevice(this.value);" required="required">
					  <option value="">-- Select --</option>
					  <?php
					  //$quote_mk_list = autocomplete_data_search()['quote_mk_list'];
					  $quote_mk_list_array = autocomplete_data_search();
					  $quote_mk_list = $quote_mk_list_array['quote_mk_list'];
					  foreach($quote_mk_list as $quote_mk_key=>$quote_mk_data) { ?>
					  	 <option value="<?=$quote_mk_key?>"><?=$quote_mk_data?></option>
					  <?php
					  } ?>
					</select>
				</div>
				<div class="form-group col-md-12">
					<label><?=$request_quote_device_title?></label>
					<select class="sm-form-control add-quote-device2" name="quote_device" id="quote_device2" onchange="getQuoteModel(this.value);" required="required">
					   <option value="">-- Select --</option>
					</select>
				</div>
				<div class="form-group col-md-12">
					<label><?=$request_quote_model_title?></label>
					<select class="sm-form-control add-quote-model2" name="quote_model" id="quote_model2" required="required" onchange="getModelDetails(this.value);">
					   <option value="">-- Select --</option>
					</select>
				</div>
				<input type="hidden" name="location_id" id="location_id" />
			</div>
			<div id="quote_model_details"></div>
		</div>
		<!--<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>-->
	</div>
  </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=$map_key?>"></script>
<script type="text/javascript">
var tpj=jQuery;

function giveMap(id) {
	var store_data = <?=rtrim($address_lit,',')?>;
	var locations=[];       
	tpj.each(store_data,function(lid,locs) {
		if(id==lid) {
			locations = locs;
		}
	}); 

	var map = new google.maps.Map(document.getElementById('map'+id), {
		zoom: 10,
		//center: new google.maps.LatLng(locations[0][4],locations[0][5]),
		//center: new google.maps.LatLng(<?=$company_lat?>, <?=$company_lng?>),
		center: new google.maps.LatLng(locations[0][1],locations[0][2]),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	var infowindow = new google.maps.InfoWindow();

	var marker, i;
	var geocoder =  new google.maps.Geocoder();
	for(i = 0; i < locations.length; i++) {
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map,
			//icon:'https://static.cars24.com/cars24/images/icons/google-map-icon.png',
		});

		google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
			return function () {
				infowindow.setContent(locations[i][0]);
				infowindow.open(map, marker);
			}
		})(marker, i));
	}
}
giveMap('<?=$first_location_nm_key?>');

function openApptFormModal(location_id) {
	tpj('#location_id').val(location_id);
	tpj('#ApptFormModel').modal('show');
}

function getQuoteDevice(val)
{
	var brand_id = val.trim();
	if(brand_id) {
		post_data = "brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		tpj(document).ready(function($){
			tpj.ajax({
				type: "POST",
				url:"ajax/get_quote_device.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						tpj('#quote_device2').html(data);
						tpj('#quote_model2').html('<option value="">-- Select --</option>');
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
		var brand_id = jQuery("#quote_make").val().trim();
		post_data = "device_id="+device_id+"&brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		tpj(document).ready(function($){
			tpj.ajax({
				type: "POST",
				url:"ajax/get_quote_model2.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						tpj('#quote_model2').html(data);
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
	var location_id = tpj('#location_id').val();
	if(model_id) {
		post_data = "model_id="+model_id+"&location_id="+location_id+"&token=<?=get_unique_id_on_load()?>";
		tpj(document).ready(function($){
			tpj.ajax({
				type: "POST",
				url:"ajax/get_quote_model_details.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						tpj('#quote_model_details').html(data);
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
