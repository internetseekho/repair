<?php
$csrf_token = generateFormToken('get_quote');

//Url encode for embed map
$business_address = trim(urlencode($company_name.' '.$company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode));

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
		//END for confirm message

		if($is_show_title && $show_title == '1') { ?>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$page_title?></h3>
		</div>
		<?php
		} ?>

		<div class="form-row">
			<div class="form-group col-md-4">
				<label><?=$request_quote_brand_title?></label>
				<select class="sm-form-control" name="quote_make" id="quote_make" onchange="getQuoteDevice(this.value);" required="required">
				  <option value="">-- Select --</option>
				  <?php
				  $quote_mk_list_array = autocomplete_data_search();
				  $quote_mk_list = $quote_mk_list_array['quote_mk_list'];
				  foreach($quote_mk_list as $quote_mk_key=>$quote_mk_data) { ?>
					 <option value="<?=$quote_mk_key?>"><?=$quote_mk_data?></option>
				  <?php
				  } ?>
				</select>
			</div>
			<div class="form-group col-md-4">
				<label><?=$request_quote_device_title?></label>
				<select class="sm-form-control add-quote-device2" name="quote_device" id="quote_device2" onchange="getQuoteModel(this.value);" required="required">
				   <option value="">-- Select --</option>
				</select>
			</div>
			<div class="form-group col-md-4">
				<label><?=$request_quote_model_title?></label>
				<select class="sm-form-control add-quote-model2" name="quote_model" id="quote_model2" required="required" onchange="getModelDetails(this.value);">
				   <option value="">-- Select --</option>
				</select>
			</div>
			<input type="hidden" name="location_id" id="location_id" value="0" />
		</div>
		<div id="quote_model_details"></div>
	</div>
</section>

<script>
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