<?php 
$file_name="categories";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM blog_cats ORDER BY catTitle DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($category_data=mysqli_fetch_assoc($query)) {
		$data_list[] = array('id'=>$category_data['catID'],'title'=>$category_data['catTitle'],'status'=>$category_data['status'],'slug'=>$category_data['catSlug']);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/blog/categories.php");

//Footer section
require_once("include/footer.php"); ?>
