<?php
//Get data from model
include("models/blog/blog.php"); ?>

<section id="content">
	<div class="container clearfix">
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<h3><?=$active_page_data['title']?></h3>
		</div>
		
		<div id="posts" class="post-grid grid-container grid-3 clearfix" data-layout="fitRows">
			<?php
			//Get blog list data
			get_blog_list($page_list_limit, $blog_rm_words_limit, $page_url); ?>
		</div>
	</div>
</section>