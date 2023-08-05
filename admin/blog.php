<?php 
$file_name="blog";

//Header section
require_once("include/header.php");

//Fetch categories of respective blog
function get_categories_of_blog($postID) {
	global $db;
	$cats_name = '';
	$ci = 1;
	$cat_q = mysqli_query($db,'SELECT bpc.catID, c.catTitle FROM blog_post_cats AS bpc LEFT JOIN blog_cats AS c ON bpc.catID=c.catID WHERE bpc.postID = "'.$postID.'"');
	$cat_num_rows = mysqli_num_rows($cat_q);
	if($cat_num_rows>0) {
		while($category_data = mysqli_fetch_assoc($cat_q)) {
			$cats_name .= $category_data['catTitle'];
			if($ci==($cat_num_rows)) {
				$cats_name .= '';
			} else {
				$cats_name .= ', ';
			}
			$ci++;
		}
	}
	return $cats_name;
}

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM blog_posts_seo ORDER BY postID DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($blog_data=mysqli_fetch_assoc($query)) {
		$date = format_date($blog_data['postDate']).' '.format_time($blog_data['postDate']);
		$cats_name = get_categories_of_blog($blog_data['postID']);
		$data_list[] = array('id'=>$blog_data['postID'],'title'=>$blog_data['postTitle'],'status'=>$blog_data['status'],'date'=>$date,'cats_name'=>$cats_name);
	}
}
$json_data_list = json_encode($data_list);
						
//Template file
require_once("views/blog/blog.php");

//Footer section
require_once("include/footer.php"); ?>
