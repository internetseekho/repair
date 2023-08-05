<?php
//Fetching data from model
require_once('models/repair_price.php');

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
		
		<?php
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
		//END for confirm message ?>
		
		<form method="get">
			<div class="form-row justify-content-center">
				<div class="form-group col-md-3">
					<!--<label>Select Brand</label>-->
					<select class="form-control" id="m_form_brand" name="brand_id" onchange="getFaultDevice(this.value);" required>
						<option value="">- Brand -</option>
						<?php
						while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
							<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$post['brand_id']){echo 'selected';}?> ><?=$brands_list['title']?></option>
						<?php
						} ?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<!--<label>Select Device</label>-->
					<select class="form-control" id="m_form_device" name="device_id" onchange="getFaultModel(this.value);">
						<option value="">- Device -</option>
						<?php
						if($devices_q) {
							while($devices_list=mysqli_fetch_assoc($devices_q)) { ?>
								<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$post['device_id']){echo 'selected';}?> ><?=$devices_list['title']?></option>
							<?php
							}
						} ?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<!--<label>Select Model</label>-->
					<select class="form-control" id="m_form_model" name="model_id">
						<option value="">- Model -</option>
						<?php
						if($mobile_q) {
							while($model_list=mysqli_fetch_assoc($mobile_q)) {
								$models_text = $model_list['models'];
								$models_text = ($models_text?" - ".$models_text:""); ?>
								<option value="<?=$model_list['id']?>"  <?php if($model_list['id']==$post['model_id']){echo 'selected';}?> ><?=$model_list['title'].$models_text?></option>
							<?php
							}
						} ?>
					</select>
				</div>
				<div class="form-group search-buttons col-md-3">
					<button type="submit" class="button button-width-form-control nomargin"><?=$filter_btn_text?> <i class="icon-search"></i></button>
					<?php
					$repair_price_link = SITE_URL.get_inbuild_page_url('repair-price');
					if($post['brand_id'] || $post['device_id'] || $post['model_id']) {
						echo '<a href="'.$repair_price_link.'" class="button button-danger button-width-form-control nomargin">'.$clear_btn_text.' <i class="icon-remove"></i></a>';
					} ?>
				</div>
			</div>
			
			<?php
			$quote_csrf_token = generateFormToken('get_quote'); ?>
			<input type="hidden" name="csrf_token" value="<?=$quote_csrf_token?>">
		</form>	
		
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th>Category</th>
					<th>Brand</th>
					<th>Device</th>
					<th>Model</th>
					<th>Fault</th>
					<th>Regular Price</th>
					<th>Sale Price</th>
					<th>On Offer</th>
				</tr>
				
				<?php 
				if(!empty($fault_list)) {
					foreach($fault_list as $fault_data) { ?>
						<tr>
							<td><?=$fault_data['cat_title']?></td>
							<td><?=$fault_data['brand_title']?></td>
							<td><?=$fault_data['device_title']?></td>
							<td><?=$fault_data['title']?></td>
							<td><?=$fault_data['fault_name']?></td>
							<td><?=$fault_data['regular_price_display']?$fault_data['regular_price_display']:'-'?></td>
							<td><?=$fault_data['sale_price_display']?$fault_data['sale_price_display']:'-'?></td>
							<td><?=($fault_data['is_on_offer']=='1')?'<span class="badge badge-success">Yes</span>':'<span class="badge badge-danger">No</span>'?></td>
						</tr>
					<?php 
					}
				} else {
					echo '<tr><td colspan="8" align="center">No Data Found</td></tr>';
				} ?>
			</table>
		</div>
		
	</div>
</section>

<script type="text/javascript">
function getFaultDevice(val)
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
						$('#m_form_device').html(data);
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
	else{
		$('#m_form_device').html('<option value="">Please Choose</option>');
	}
}

function getFaultModel(val)
{
	var device_id = val.trim();
	if(device_id) {
		var brand_id = jQuery("#m_form_brand").val().trim();
		post_data = "device_id="+device_id+"&brand_id="+brand_id+"&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model2.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#m_form_model').html(data);
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
	else{
		$('#m_form_model').html('<option value="">Please Choose</option>');
	}
}
</script>