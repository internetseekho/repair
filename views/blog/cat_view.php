<?php
//Url param
$cat_url = trim($url_second_param);

//Header section
include("include/header.php");

//Get data from model
include("models/blog/blog.php"); ?>

<section id="content">
	<div class="container clearfix">
		<?php
		//Get blog list data based on respective cat
		get_blog_list_based_on_cat($cat_url, $blog_rm_words_limit,$page_list_limit); ?>
	</div>
</section>