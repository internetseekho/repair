<?php
//Get data from model
include("models/blog/blog.php"); ?>

<section id="content">
	<div class="container topmargin-sm clearfix">
		<?php
		//Get blog details based on slug of blog
		get_blog_details($blog_url);
		
		if($blog_recent_posts == '1' || $blog_categories == '1') { ?>
		<div class="sidebar nobottommargin col_last clearfix">
			<div class="sidebar-widgets-wrap">
			  <div class="widget clearfix">
				<?php
				//Get recent posts
				get_recent_posts($blog_recent_posts);
				  
				//Get Catgories
				get_blog_categories($blog_categories); ?>
	
				<?php /*?><div class="tabs nobottommargin clearfix" id="sidebar-tabs">
				  <ul class="tab-nav clearfix">
					<li><a href="#tabs-1">Popular</a></li>
					<li><a href="#tabs-2">Recent</a></li>
				  </ul>
				  <div class="tab-container">
					<div class="tab-content clearfix" id="tabs-1">
					  <div id="popular-post-list-sidebar">
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/magazine/small/3.jpg" alt=""></a> </div>
						  <div class="entry-c">
							<div class="entry-title">
							  <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
							</div>
							<ul class="entry-meta">
							  <li><i class="icon-comments-alt"></i> 35 Comments</li>
							</ul>
						  </div>
						</div>
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/magazine/small/2.jpg" alt=""></a> </div>
						  <div class="entry-c">
							<div class="entry-title">
							  <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
							</div>
							<ul class="entry-meta">
							  <li><i class="icon-comments-alt"></i> 24 Comments</li>
							</ul>
						  </div>
						</div>
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/magazine/small/1.jpg" alt=""></a> </div>
						  <div class="entry-c">
							<div class="entry-title">
							  <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
							</div>
							<ul class="entry-meta">
							  <li><i class="icon-comments-alt"></i> 19 Comments</li>
							</ul>
						  </div>
						</div>
					  </div>
					</div>
					<div class="tab-content clearfix" id="tabs-2">
					  <div id="recent-post-list-sidebar">
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/magazine/small/1.jpg" alt=""></a> </div>
						  <div class="entry-c">
							<div class="entry-title">
							  <h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
							</div>
							<ul class="entry-meta">
							  <li>10th July 2014</li>
							</ul>
						  </div>
						</div>
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/magazine/small/2.jpg" alt=""></a> </div>
						  <div class="entry-c">
							<div class="entry-title">
							  <h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
							</div>
							<ul class="entry-meta">
							  <li>10th July 2014</li>
							</ul>
						  </div>
						</div>
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/magazine/small/3.jpg" alt=""></a> </div>
						  <div class="entry-c">
							<div class="entry-title">
							  <h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
							</div>
							<ul class="entry-meta">
							  <li>10th July 2014</li>
							</ul>
						  </div>
						</div>
					  </div>
					</div>
					<div class="tab-content clearfix" id="tabs-3">
					  <div id="recent-post-list-sidebar">
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/icons/avatar.jpg" alt=""></a> </div>
						  <div class="entry-c"> <strong>John Doe:</strong> Veritatis recusandae sunt repellat distinctio... </div>
						</div>
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/icons/avatar.jpg" alt=""></a> </div>
						  <div class="entry-c"> <strong>Mary Jane:</strong> Possimus libero, earum officia architecto maiores.... </div>
						</div>
						<div class="spost clearfix">
						  <div class="entry-image"> <a href="#" class="nobg"><img class="rounded-circle" src="images/icons/avatar.jpg" alt=""></a> </div>
						  <div class="entry-c"> <strong>Site Admin:</strong> Deleniti magni labore laboriosam odio... </div>
						</div>
					  </div>
					</div>
				  </div>
				</div><?php */?>
				
			  </div>
			</div>
		</div>
		<?php
		} ?>
	</div>
</section>
