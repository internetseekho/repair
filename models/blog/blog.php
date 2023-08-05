<?php
function get_recent_posts($blog_recent_posts) {
	if($blog_recent_posts) {
		global $db;

		$blog_url = get_inbuild_page_url('blog');
		$output = '';
		$stmt = mysqli_query($db,'SELECT postTitle, postSlug FROM blog_posts_seo WHERE status=1 ORDER BY postID DESC LIMIT 5');
		$num_of_recent_post = mysqli_num_rows($stmt);
		if($num_of_recent_post>0) {
		  $output .= '<div class="card bg-light"><div class="card-body"><h4 class="mb-3 d-block">Recent Posts</h4>';
		  $output .= '<ul class="iconlist mb-0">';
			  while($row = mysqli_fetch_assoc($stmt)) {
				$output .= '<li class="h6 pb-1"><i class="icon-line-circle-check"></i><a href="'.SITE_URL.$blog_url.'/'.$row['postSlug'].'">'.$row['postTitle'].'</a></li>';
			  }
		  $output .= '</ul></div></div>';
		}
		echo $output;
	}
}

function get_blog_categories($blog_categories) {
	if($blog_categories) {
		global $db;
		$output = '';
		$stmt = mysqli_query($db,'SELECT catTitle, catSlug FROM blog_cats WHERE status=1 ORDER BY catID DESC');
		$num_of_recent_post = mysqli_num_rows($stmt);
		if($num_of_recent_post>0) {
			$output .= '<div class="card bg-light mt-3"><div class="card-body"><h4 class="mb-3 d-block">Catgories</h4>';
			$output .= '<ul class="iconlist mb-0">';
				while($row = mysqli_fetch_assoc($stmt)){
					$output .= '<li class="h6 pb-1"><i class="icon-line-circle-check"></i><a href="'.SITE_URL.'category/'.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
				}
			$output .= '</ul></div></div>';
		}
		echo $output;
	}
}

function get_blog_list($page_list_limit, $blog_rm_words_limit, $page_url) {
	global $db;
	$output = '';
	try {
		$pages = new Paginator($page_list_limit,'p');
		$stmt = mysqli_query($db,'SELECT postID FROM blog_posts_seo');
		$pages->set_total(mysqli_num_rows($stmt));

		$stmt = mysqli_query($db,'SELECT postID, postTitle, postSlug, postCont, postDate, image FROM blog_posts_seo WHERE status=1 ORDER BY postID DESC '.$pages->get_limit());
		while($row = mysqli_fetch_assoc($stmt)) {
			$output .= '<div class="entry clearfix">';
				if($row['image']) {
					$output .= '<div class="entry-image"><a href="'.SITE_URL.'images/blog/'.$row['image'].'" data-lightbox="image"><img class="image_fade" src="'.SITE_URL.'images/blog/'.$row['image'].'" alt="'.$row['postTitle'].'"></a></div>';
				}
				$output .= '<div class="entry-title"><h2><a href="'.$page_url.'/'.$row['postSlug'].'">'.$row['postTitle'].'</a></h2></div>';
				$output .= '<ul class="entry-meta clearfix"><li>Posted on <i class="icon-calendar3"></i> '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';
					$stmt2 = mysqli_query($db,'SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = "'.$row['postID'].'"');
					$links = array();
					while($cat = mysqli_fetch_assoc($stmt2)){
						$links[] = "<a href='".SITE_URL."category/".$cat['catSlug']."'>".$cat['catTitle']."</a>";
					}
					$output .= implode(", ", $links);
				$output .= '</li></ul>';
				$output .= '<div class="entry-content">'.limit_words($row['postCont'],$blog_rm_words_limit).'</div>';
				$output .= '<a href="'.$page_url.'/'.$row['postSlug'].'" class="more-link">Read More</a>';
			$output .= '</div>';
		}
		$output .= $pages->page_links();
	} catch(Exception $e) {
		$output .= $e->getMessage();
	}
	echo $output;
}

function get_blog_details($blog_url) {
	if($blog_url) {
		global $db;
		$output = '';
		
		$stmt = mysqli_query($db,'SELECT postID, postTitle, postCont, postDate, image FROM blog_posts_seo WHERE postSlug = "'.$blog_url.'" AND status=1');
        $row = mysqli_fetch_assoc($stmt);

        //if post does not exists redirect user.
        if($row['postID'] == '') {
        	setRedirect(SITE_URL);
        	exit;
        }

		$output .= '<div class="postcontent nobottommargin clearfix"><div class="single-post nobottommargin"><div class="entry clearfix">';
			$output .= '<div class="entry-title"><h2>'.$row['postTitle'].'</h2></div>';
			$output .= '<ul class="entry-meta clearfix"><li>Posted on <i class="icon-calendar3"></i> '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';
				$stmt2 = mysqli_query($db,'SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = "'.$row['postID'].'"');
				$links = array();
				while($cat = mysqli_fetch_assoc($stmt2)){
					$links[] = "<a href='".SITE_URL."category/".$cat['catSlug']."'>".$cat['catTitle']."</a>";
				}
				$output .= implode(", ", $links);
			$output .= '</li></ul>';
			if($row['image']) {
				$output .= '<div class="entry-image"><a href="'.SITE_URL.'images/blog/'.$row['image'].'" data-lightbox="image"><img class="image_fade" src="'.SITE_URL.'images/blog/'.$row['image'].'" alt="'.$row['postTitle'].'"></a></div>';
			}
			$output .= '<div class="entry-content notopmargin">'.$row['postCont'].'</div>';
	   $output .= '</div></div></div>';
	   echo $output;
	}
}

function get_blog_list_based_on_cat($cat_url, $blog_rm_words_limit, $page_list_limit) {
	if($cat_url) {
		global $db;
		$output = '';
		
		$blog_url = get_inbuild_page_url('blog');
	
		$stmt = mysqli_query($db,'SELECT catID,catTitle FROM blog_cats WHERE catSlug = "'.$cat_url.'" AND status=1');
		$row = mysqli_fetch_assoc($stmt);
	
		//If post does not exists redirect user.
		if($row['catID'] == '') {
			setRedirect(SITE_URL);
			exit;
		}
		
		$output .= '<div class="heading-block topmargin-sm bottommargin-sm center">';
			$output .= '<h3>Blog <small><i class="icon-angle-double-right"></i> Posts in '.$row['catTitle'].'</small></h3>';
		$output .= '</div>';
		
		$output .= '<div id="posts" class="post-grid grid-container grid-3 clearfix" data-layout="fitRows">';
		try {
			$pages = new Paginator($page_list_limit,'p');
	
			$stmt = mysqli_query($db,'SELECT blog_posts_seo.postID FROM blog_posts_seo, blog_post_cats WHERE blog_posts_seo.postID = blog_post_cats.postID AND blog_post_cats.catID = "'.$row['catID'].'"');
		
			//Pass number of records to
			$pages->set_total(mysqli_num_rows($stmt));
		
			$stmt = mysqli_query($db,'
				SELECT
					blog_posts_seo.postID, blog_posts_seo.postTitle, blog_posts_seo.postSlug, blog_posts_seo.postCont, blog_posts_seo.postDate, blog_posts_seo.image
				FROM
					blog_posts_seo,
					blog_post_cats
				WHERE
					 blog_posts_seo.postID = blog_post_cats.postID
					 AND blog_post_cats.catID = "'.$row['catID'].'"
				ORDER BY
					postID DESC
				'.$pages->get_limit());

			while($row = mysqli_fetch_assoc($stmt)) {
				$output .= '<div class="entry clearfix">';
					if($row['image']) {
						$output .= '<div class="entry-image"><a href="'.SITE_URL.'images/blog/'.$row['image'].'" data-lightbox="image"><img class="image_fade" src="'.SITE_URL.'images/blog/'.$row['image'].'" alt="'.$row['postTitle'].'"></a></div>';
					}
					$output .= '<div class="entry-title"><h2><a href="'.$page_url.'/'.$row['postSlug'].'">'.$row['postTitle'].'</a></h2></div>';
					$output .= '<ul class="entry-meta clearfix"><li>Posted on <i class="icon-calendar3"></i> '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';
						$stmt2 = mysqli_query($db,'SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = "'.$row['postID'].'"');
						$links = array();
						while($cat = mysqli_fetch_assoc($stmt2)){
							$links[] = "<a href='".SITE_URL."category/".$cat['catSlug']."'>".$cat['catTitle']."</a>";
						}
						$output .= implode(", ", $links);
					$output .= '</li></ul>';
					$output .= '<div class="entry-content">'.limit_words($row['postCont'],$blog_rm_words_limit).'</div>';
					$output .= '<a href="'.SITE_URL.$blog_url.'/'.$row['postSlug'].'" class="more-link">Read More</a>';
				$output .= '</div>';
			}
			$output .= $pages->page_links('c-'.$_GET['id'].'&');
		} catch(Exception $e) {
			$output .= $e->getMessage();
		}
		$output .= '</div>';
		echo $output;
	}
}
