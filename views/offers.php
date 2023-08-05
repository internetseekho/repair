<?php
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

<?php /*?><section id="slider" class="slider-element slider-parallax" style="background: url('images/slider/full/1.jpg'); background-size: cover;" data-height-xl="470" data-height-lg="400" data-height-md="400" data-height-sm="250" data-height-xs="200">
	<div class="slider-parallax-inner">
		<div class="container clearfix">
			<div class="vertical-middle center">
				<div class="heading-block nobottomborder center">
					<h1>
						<div class="text-rotater" data-separator="|" data-rotate="flipInX" data-speed="3500">
							<?=$offers_title?>
						</div>
					</h1>
					<h2>
						<div class="text-rotater" data-separator="|" data-rotate="flipInX" data-speed="4500">
							<?=$offers_sub_title?>
						</div>
					</h2>
					<h3>
						<div class="text-rotater" data-separator="|" data-rotate="flipInX" data-speed="5500">
							<?=$offers_desc?>
						</div>
					</h3>
				</div>
			</div>
		</div>
	</div>
</section><?php */?>

<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row grid-container" data-layout="masonry" style="overflow: visible">
			<?php
			$promocode_list = get_promocode_list('future');
			if(count($promocode_list) > 0) {
				foreach($promocode_list as $promocode_data) { ?>
					<div class="col-lg-4 mb-4">
						<div class="flip-card text-center top-to-bottom">
							<div class="flip-card-front bg-info dark" data-height-xl="200" style="background-image: url('<?=SITE_URL.'images/promocodes/'.$promocode_data['image']?>');">
								<div class="flip-card-inner">
									<div class="card nobg noborder text-center" >
										<div class="card-body">
											<h3 class="card-title">
												<?php
												if($promocode_data['discount_type']=="flat") {
													echo amount_fomat($promocode_data['discount']).' OFF';
												} elseif($promocode_data['discount_type']=="percentage") {
													echo $promocode_data['discount'].'% OFF';
												} ?>
											</h3>
											<h4>
												<?php
												if($promocode_data['never_expire'] == '1') {
													echo $offers_never_expire_text;
												} else {
													echo format_date($promocode_data['to_date']);
												} ?>
											</h4>
										</div>
									</div>
								</div>
							</div>
							<div class="flip-card-back" data-height-xl="200" >
								<div class="flip-card-inner">
									<p class="text-white"><?=$promocode_data['description']?></p>
									<button class="button button-small"><?=$promocode_data['promocode']?></button>
									<?php
									if($promocode_data['multiple_act_by_same_cust']=='1' && $promocode_data['multi_act_by_same_cust_qty']>0) {
										echo '<p class="text-white">'.$offers_limited_per_customer_text.'</p>';
									} else {
										echo '<span class="text-white">&nbsp;</span>';
									} ?>
									<a href="<?=SITE_URL?>brands" class="button button-border button-rounded button-fill fill-from-top button-amber"><span><?=$redeem_now_btn_text?></span></a>
								</div>
							</div>
						</div>
					</div>
				<?php 
				}
			} else { ?>
				<div class="col-md-12">
					<div class="block clearfix center">
						<h3>No offer found</h3>
					</div>
				</div>
			<?php
			} ?>
			</div>
			
			<div class="promo promo-border bottommargin topmargin-sm">
				<h3><?=$offers_deal_title?></h3>
				<span><?=$offers_deal_sub_title?></span>
				<a href="<?=SITE_URL?>brands" class="button button-xlarge button-rounded"><?=$offers_deal_btn_text?></a>
			</div>
			
		</div>
	</div>
</section>