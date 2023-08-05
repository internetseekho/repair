<?php
//Get review list
$review_list_data = get_review_list_data(1);
$total_num_of_rev = count($review_list_data);

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
			<h2><?=$page_title?></h2>
			<a class="btn btn-primary" href="<?=SITE_URL?>write-a-review"><?=$write_review_btn_text?></a>
		</div>
		<?php
		}
		
  	    if($total_num_of_rev > 0) { ?>		
		<ul class="testimonials-grid grid-3 clearfix">
			<?php
			//$numOfCols = 3;
			//$rowCount = 0;
			$rev_read_more_arr = array();
			foreach($review_list_data as $key => $review_data) { ?>
			<li>
				<div class="testimonial">
					<div class="testi-image">
						<?php
						if($review_data['photo']) {
							echo '<a href="#"><img loading="lazy" src="'.SITE_URL.'images/review/'.$review_data['photo'].'"></a>';
						} else {
							echo '<a href="#"><img loading="lazy" src="images/placeholder_avatar.jpg"></a>';
						} ?>
					</div>
					<div class="testi-content">
						<?php
						if($full_review_or_number_of_words == "full_review" || $review_limited_words == '0') {
							echo '<p>'.$review_data['content'].'</p>';
						} else {
							$rev_content = '';
							$rev_con_words = str_word_count($review_data['content']);
							$rev_content = limit_words($review_data['content'],$review_limited_words);
							if($rev_con_words>$review_limited_words) {
								$rev_content .= ' <a href="javascript;" data-toggle="modal" data-target="#reviewModal'.$review_data['id'].'">'.$read_more_btn_text.'</a>';
								$rev_read_more_arr[] = array('id'=>$review_data['id'],'name'=>$review_data['name'],'content'=>$review_data['content'],'country'=>$review_data['country'],'state'=>$review_data['state'],'city'=>$review_data['city']);
							}
							echo '<p>'.$rev_content.'</p>';
						} ?>
						<div class="testi-meta">
							<?=$review_data['name']?>
							<span><?=($review_data['country']?$review_data['country'].', ':'').$review_data['state'].', '.$review_data['city']?></span>
						</div>
					</div>
				</div>
			</li>
			<?php
			//$rowCount++;
			//if($rowCount % $numOfCols == 0){echo '</div><div class="row">';}
			} ?>
		</ul>
		<?php
		} ?>
		<div class="row">
			<div class="col-md-12">
				<div class="text-center pb-4">
					<a class="btn btn-primary" href="<?=SITE_URL?>write-a-review"><?=$write_review_btn_text?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if(!empty($rev_read_more_arr)) {
	foreach($rev_read_more_arr as $rev_read_more_data) { ?>
		<div class="modal fade" id="reviewModal<?=$rev_read_more_data['id']?>" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel<?=$rev_read_more_data['id']?>" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="reviewModalLabel<?=$rev_read_more_data['id']?>"><?=$rev_read_more_data['name']?> (<small><?=($rev_read_more_data['country']?$rev_read_more_data['country'].', ':'').$rev_read_more_data['state'].', '.$rev_read_more_data['city']?></small>)</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?=$rev_read_more_data['content']?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
} ?>
