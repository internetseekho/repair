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

<section id="content" class="<?=(!$is_show_title?'py-5':'')?>">
	<div class="container clearfix">
		<?php
		if($is_show_title && $show_title == '1') { ?>
		<div class="clear"></div>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$page_title?></h3>
		</div>
		<?php
		}
		
		if($active_page_data['content']) { ?>
			<div class="form-group">
				<?=$active_page_data['content']?>
			</div>
		<?php
		}
		
		$service_data_list = get_service_data_list();
		if(count($service_data_list)>0) {
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
								<img loading="lazy" src="<?=$srvc_img_path?>" alt="<?=$service_data['title']?>" />
							</div>
						<?php
						} ?>
						<h3><?=$service_data['title']?></h3>
						<p><?=$service_data['description']?></p>
					</div>
				</div>
			<?php
			}
		} ?>
	</div>
</section>
