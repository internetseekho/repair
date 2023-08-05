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
}

//Get data from admin/include/functions.php, get_category_data_list function
$cat_data_list = get_category_data_list();
$num_of_cat = count($cat_data_list);
if($num_of_cat>0) { ?>
<section id="model" class="pt-4">
	<div class="container clearfix center">
		<div class="clear"></div>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$category_list_page_title?></h3>
		</div>
	
		<ul class="clients-grid grid-4 bottommargin-sm clearfix">
			<?php
			foreach($cat_data_list as $cat_data) { ?>
				<li>
					<a href="<?=SITE_URL.$category_details_page_slug.$cat_data['sef_url']?>">
						<?php
						if($cat_data['image']) {
							echo '<img loading="lazy" src="'.SITE_URL.'images/categories/'.$cat_data['image'].'" alt="'.$cat_data['title'].'">';
						} ?>
						<h4><?=$cat_data['title']?></h4>
					</a>
				</li>
			<?php
			} ?>
		</ul>
	</div>
</section>
<?php
}

/*//Get data from admin/include/functions.php, get_brand_data function
$brand_data_list = get_brand_data();
$num_of_brand = count($brand_data_list);
if($num_of_brand>0) { ?>
	<div class="container clearfix center">
		<div class="clear"></div>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$brand_list_page_title?></h3>
		</div>

		<ul class="clients-grid grid-4 bottommargin-sm clearfix">
			<?php
			foreach($brand_data_list as $brand_data) { ?>
				<li>
					<a href="<?=SITE_URL.'brand/'.$brand_data['sef_url']?>">
						<?php
						if($brand_data['image']) {
							echo '<img loading="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'">';
						} ?>
						<h4><?=$brand_data['title']?></h4>
					</a>
				</li>
			<?php
			} ?>
		</ul>
	</div>
<?php
}

//Get data from admin/include/functions.php, get_device_data_list function
$device_data_list = get_device_data_list($active_page_data['fltr_devices_in_menu']);
$num_of_device = count($device_data_list);
if($num_of_device>0) { ?>
	<div class="container clearfix center">
		<div class="clear"></div>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$device_list_page_title?></h3>
		</div>

		<ul class="clients-grid grid-4 bottommargin-sm clearfix">
			<?php
			foreach($device_data_list as $device_data) { ?>
				<li>
					<a href="<?=SITE_URL.$device_data['sef_url']?>">
						<?php
						if($device_data['device_img']) {
							echo '<img loading="lazy" src="'.SITE_URL.'images/device/'.$device_data['device_img'].'" alt="'.$device_data['title'].'">';
						} ?>
						<h4><?=$device_data['title']?></h4>
					</a>
				</li>
			<?php
			} ?>
		</ul>
	</div>
<?php
}*/ ?>

<?php
//Fetching devices
//Get data from admin/include/functions.php, get_device_data_list function
$device_data_list = get_device_data_list();
$num_of_device = count($device_data_list);
/*if($num_of_device>0) {  ?>
<section id="services">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-block topmargin-lg bottommargin-sm center">
					<h3><?=$device_list_page_title?></h3>
					<!--<span class="divcenter">Fixed in Minutes.</span>-->
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
							$device_img_path = SITE_URL.'images/device/'.$device_data['device_img']; ?>
							<img loading="lazy" src="<?=$device_img_path?>" alt="<?=$device_data['title']?>">
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
} */ ?>

<?php
//Get data from admin/include/functions.php, get_brand_data function
$brand_data_list = get_brand_data();
$num_of_brand = count($brand_data_list);
if($num_of_brand>0) { ?>
	<div class="section brand nobg m-0 border-bottom pb-5 pt-0">
		<div class="container clearfix center">
			<div class="clear"></div>
			<div class="heading-block topmargin-sm bottommargin-sm center">
				<h3><?=$brand_list_page_title?></h3>
				<!--<span class="divcenter">Need Help ?</span>-->
			</div>
			<ul class="clients-grid grid-5 nobottommargin clearfix">
			<?php
			foreach($brand_data_list as $brand_data) { ?>
				<li>
					<a href="<?=SITE_URL.$brand_data['sef_url']?>" style="opacity: 1;">
						<?php
						if($brand_data['image']) {
							echo '<img loading="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'">';
						} ?>
						<h4><?=$brand_data['title']?></h4>
					</a>
				</li>
			<?php
			} ?>
			</ul>
		</div>
	</div>
<?php
} ?>
