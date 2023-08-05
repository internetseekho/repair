<?php
$csrf_token = generateFormToken('model_details');

//Url params
$req_model_id = $mobile_single_data_resp['model_data']['id'];

//Fetching data from model
require_once('models/model.php');

//Get data from models/model.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);

//$model_data = get_single_model_data_by_url($url_second_param);
$req_model_id = $model_data['id'];
$models_text = $model_data['models'];
$models_text1 = ($models_text?" - ".$models_text:"");

$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];
$meta_canonical_url = $model_data['meta_canonical_url'];

//Header section
include("include/header.php");

$device_data_list = get_device_data_list();
?>

<script src="<?=SITE_URL?>js/front.js"></script>

<form id="model_details_form" action="<?=SITE_URL?>controllers/model.php" method="post" enctype="multipart/form-data" onSubmit="return check_form_data();">
<section id="content">	
	<div class="container topmargin-sm clearfix">
		<?php
		if($model_data['heading_text']!="") { ?>
		<div class="heading-block bottommargin-sm center">
			<h3><?=$model_data['heading_text']?></h3>
		</div>
		<?php
		} ?>

		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="row pb-5">
					<div class="col-md-3">
						<div class="phone-image mt-0">
							<?php
							if($model_data['model_img']) {
								$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=144'; ?>
								<img data-animate="fadeInLeft" class="fadeInLeft animated" src="<?=SITE_URL.'images/mobile/'.$model_data['model_img']?>" alt="<?=$model_data['title'].$models_text1?>">
							<?php
							}
							echo '<h4 class="mt-1"><strong>'.$model_data['title'].$models_text1.'</strong></h4>';
							if($model_data['tooltip_device']!="" && $tooltips_of_model_fields == '1') { ?>
								<h4 class="mt-1"><a href="javascript:void();" data-toggle="modal" data-target="#DeviceHelp"><i class="icon-question-circle"></i></a></h4> 
							<?php
							} ?>
                            
                            <a href="javascript:void();" data-toggle="modal" data-target="#ChangeModel" class="btn btn-primary btn-block"><?=$change_model_btn_text?></a>
						</div>
					</div>
					<div class="col-md-9">
						<div class="row">
							<div class="col-4">
								<div class="custom-round-box active first">
									<div class="round-box">
										<i class="icon-mobile"></i>
									</div>
									<p><?=$model_detail_step1_text?></p>
								</div>
							</div>
							<div class="col-4">
								<div class="custom-round-box active center">
									<div class="round-box">
										<i class="icon-wrench"></i>
									</div>
									<p><?=$model_detail_step2_text?></p>
								</div>
							</div>
							<div class="col-4">
								<div class="custom-round-box last">
									<div class="round-box">
										<i class="icon-bookmark"></i>
									</div>
									<div class="clearfix"></div>
									<p><?=$model_detail_step3_text?></p>
								</div>
							</div>
						</div>
					</div>

					<!-- update -->

					<?php /*?><div class="row">
							<div class="col-md-12">
								<h4 class="mb-2 text-center text-md-left">Which device you are using?</h4>
								<div class="row">
									<div class="col-12 col-md-5">
										<div class="pb-2 p-md-0">
											<select class="form-control m-bootstrap-select" name="cng_device_id" id="cng_device_id" onchange="getModelListData();">
												<option value="">-- Select --</option>
												<?php
												if(!empty($device_data_list)) {
													foreach($device_data_list as $device_data) {
														echo '<option value="'.$device_data['id'].'" '.($model_data['device_id']==$device_data['id']?'selected="selected"':'').'>'.$device_data['title'].'</option>';
													}
												} ?>
											</select>
										</div>
									</div>
									<div class="col-12 col-md-5">
										<div class="pb-2 p-md-0">
											<select class="form-control m-bootstrap-select" name="cng_model_id" id="cng_model_id">
												<option value="">-- Select --</option>
											</select>
										</div>
									</div>
									<div class="col-12 col-md-2">
										<a href="javascript:void(0);" class="btn btn-primary btn-block cng_model_btn">Change</a>
									</div>
								</div>
							</div>
						</div><?php */?>
					<!--</div>
				</div>
				<div class="row">
					<div class="col-md-12">-->
						<div class="block" style="margin-top: 20px;">
							<?php /*?><div class="fancy-title title-bottom-border">
								<h2><?=$model_data['title'].$models_text1?></h2>
							</div><?php */?> 

							<?php
							function updatePrice($thisprice, $add_sub, $price_type, $total_price, $price) {
								if($price_type==0) {
									$temp_price = ($price*$thisprice)/100;
								} else {
									$temp_price = $thisprice;
								}
							
								if($add_sub=="+") {
									$total_price = $total_price + $temp_price;
								} else {
									$total_price = $total_price - $temp_price;
								}
								return $total_price;
							}

							$sql_pro = "SELECT * FROM mobile WHERE id = '".$req_model_id."'";
							$exe_pro = mysqli_query($db,$sql_pro);
							$row_pro = mysqli_fetch_assoc($exe_pro);
							$price = 0;//$row_pro['price'];
							$total_price = 0;//$row_pro['price'];

							if($repair_questions_expanded_or_expand_collapse == "expanded") {
								include("views/model_details/expanded_fields.php");
							} elseif($repair_questions_expanded_or_expand_collapse == "multiple_steps") {
								include("views/model_details/multiple_steps_fields.php");
							} else {
								include("views/model_details/expand_collapse_fields.php");
							} ?>
						</div>
						
					<!-- update -->
				</div>
			</div>
			<!-- <div class="col-md-4 col-lg-3">
				<div class="border" id="items_name"></div>
			</div> -->
		</div>
	</div>
</section>

<span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>
<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total_price?>"/>
<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
<input id="total_price_org" value="<?=$price?>" type="hidden" />
<input name="id" type="hidden" value="<?=$req_model_id?>" />
<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
</form>

<div class="editAddress-modal modal fade HelpPopup" id="DeviceHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel"><?=$device_info_popup_title?></h4>
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>
		<div class="modal-body">
			<?=$model_data['tooltip_device']?>
		</div>
		<div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
	</div>
  </div>
</div>

<div class="editAddress-modal modal fade HelpPopup" id="ChangeModel" tabindex="-1" role="dialog" aria-labelledby="ChangeModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="ChangeModelLabel"><?=$change_model_popup_title?></h4>
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>
		<div class="modal-body">
			<div class="row">
                <div class="col-md-12">
                    <h4 class="mb-2 text-center text-md-left"><?=$change_model_popup_fields_title?></h4>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="pb-2 p-md-0">
                                <select class="form-control m-bootstrap-select" name="cng_device_id" id="cng_device_id" onchange="getModelListData();">
                                    <option value="">-- Select --</option>
                                    <?php
                                    if(!empty($device_data_list)) {
                                        foreach($device_data_list as $device_data) {
                                            echo '<option value="'.$device_data['id'].'" '.($model_data['device_id']==$device_data['id']?'selected="selected"':'').'>'.$device_data['title'].'</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="pb-2 p-md-0">
                                <select class="form-control m-bootstrap-select" name="cng_model_id" id="cng_model_id">
                                    <option value="">-- Select --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <a href="javascript:void(0);" class="btn btn-primary btn-block cng_model_btn"><?=$change_model_popup_sbmt_btn_text?></a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
	</div>
  </div>
</div>

<?php
if($model_data['description']!="") { ?>
	<section class="content">
		<div class="container bottommargin-sm clearfix">
			<?=$model_data['description']?>
		</div>
	</section>
<?php
}

if($display_recently_ordered == '1') {
	//Fetching data from model
	require_once(CP_ROOT_PATH.'/models/recently_ordered.php');

	//Get model data list from models/recently_ordered.php, function get_recently_ordered_data_list
	$recently_ordered_data_list = get_recently_ordered_data_list($recently_ordered_limit);
	if(count($recently_ordered_data_list)>0) { ?>
		<section id="content">
			<div class="container clearfix topmargin-sm bottommargin-sm center">
				<div class="clear"></div>
				<div class="heading-block topmargin-sm bottommargin-sm center">
					<h3><?=$recent_repaired_models_title?></h3>
				</div>
			
				<div id="portfolio" class="portfolio grid-container clearfix">
					<?php
					foreach($recently_ordered_data_list as $recently_ordered_data) {
						$models_text = $recently_ordered_data['models'];
						$models_text = ($models_text?" - ".$models_text:""); ?>
						
						<article class="portfolio-item pf-media pf-icons">
							<?php
							if($recently_ordered_data['model_img']) {
								$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$recently_ordered_data['model_img'].'&h=144'; ?>
								<div class="portfolio-image">
									<a href="<?=SITE_URL.$recently_ordered_data['d_sef_url'].'/'.$recently_ordered_data['sef_url']?>">
										<img loading="lazy" src="<?=$md_img_path?>" alt="<?=$recently_ordered_data['title'].$models_text?>">
									</a>
									<div class="portfolio-overlay">
										<?php /*?><a href="<?=SITE_URL.$recently_ordered_data['d_sef_url'].'/'.$recently_ordered_data['sef_url']?>" class="left-icon" data-lightbox="image" title="<?=$recently_ordered_data['title'].$models_text?>"><i class="icon-line-plus"></i></a><?php */?>
										<a href="<?=SITE_URL.$model_details_page_slug.$recently_ordered_data['sef_url']?>" class="center-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
							<?php
							} ?>
							<div class="portfolio-desc">
								<h3><a href="<?=SITE_URL.$model_details_page_slug.$recently_ordered_data['sef_url']?>"><?=$recently_ordered_data['title']?></a></h3>
							</div>
						</article>
					<?php
					} ?>
				</div>
			</div>   
		</section>
	<?php
	}
}

//START for review section
if($display_on_model_detail == '1') {
  //Get review list
  $review_list_data = get_review_list_data_random();
  if(!empty($review_list_data)) { ?>
	<div class="container clearfix">
		<div class="fslider testimonial testimonial-full bottommargin-sm topmargin-sm nobottompadding" data-animation="fade" data-arrows="false">
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
} //END for review section ?>

<script>
function getModelListData()
{
	var brand_id = 0;
	var device_id = jQuery('#cng_device_id').val();
	if(device_id) {
		post_data = "device_id="+device_id+"&model_id=<?=$req_model_id?>&token=<?=get_unique_id_on_load()?>";
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/get_quote_model.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#cng_model_id').html(data);
					} else {
						alert('<?=$validation_something_went_wrong_msg_text?>');
						return false;
					}
				}
			});
		});
	}
}
getModelListData();

jQuery(document).ready(function($) {
	$(".cng_model_btn").click(function() {
		var device_id = $('#cng_device_id').val();
		var model_url = $('#cng_model_id').val();
		if(device_id == '') {
			$('#cng_device_id').focus();
			return false;
		} else if(model_url == '') {
			$('#cng_model_id').focus();
			return false;
		}
		window.location.href = model_url;
	});
});
</script>
