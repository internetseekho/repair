<?php 
$file_name="brand";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM brand ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($brand_data=mysqli_fetch_assoc($query)) {
		$data_list[] = array('id'=>$brand_data['id'],'title'=>$brand_data['title'],'image'=>$brand_data['image'],'ordering'=>$brand_data['ordering'],'status'=>$brand_data['published']);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/brand/brand.php");

//Footer section
require_once("include/footer.php"); ?>
