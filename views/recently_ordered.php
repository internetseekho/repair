<?php
//Header section
include("include/header.php");

//Url param
$brand_id=$url_second_param;

//Fetching data from model
require_once('models/recently_ordered.php');

//Get model data list from models/recently_ordered.php, function get_recently_ordered_data_list
$model_data_list = get_recently_ordered_data_list($recently_ordered_limit);
$search_count = $model_data_list;
if($search_count>0) {
?>
	<section class="items-phone page">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="head text-center">
						<h1 class="h3"><?=$recently_ordered_title?></h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<?php
				foreach($model_data_list as $model_list) {
					$models_text = $model_list['models'];
					$models_text = ($models_text?" - ".$models_text:""); ?>
					<a class="item text-center" href="<?=SITE_URL.$model_list['d_sef_url'].'/'.$model_list['sef_url']?>">
						<div class="item-inner">
							<?php
							if($model_list['model_img']) { ?>
								<div class="item-image">
									<img loading="lazy" src="<?=SITE_URL.'images/mobile/'.$model_list['model_img']?>" alt="<?=$model_list['title'].$models_text?>">
								</div>
							<?php
							} ?>
							<div class="h4"><strong><?=$model_list['brand_title']?></strong></div>
							<p><?=$model_list['title'].$models_text?></p>
						</div>
					</a>
				<?php
				} ?>
				</div>
			</div>
		</div>
	</section>
<?php
} else { ?>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="head text-center clearfix">
            <h2 class="h2">Items not available</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} ?>
