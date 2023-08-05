<?php 
$file_name="device_categories";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM categories ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($category_data=mysqli_fetch_assoc($query)) {
		$data_list[] = array('id'=>$category_data['id'],'title'=>$category_data['title'],'image'=>$category_data['image'],'ordering'=>$category_data['ordering'],'status'=>$category_data['published']);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/categories/categories.php");

//Footer section
require_once("include/footer.php"); ?>
