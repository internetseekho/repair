<?php 
$file_name="device_categories";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

if($id<=0 && $prms_category_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_category_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable brand data
$get_q=mysqli_query($db,'SELECT * FROM categories WHERE id="'.$id.'"');
$category_data=mysqli_fetch_assoc($get_q);

//Template file
require_once("views/categories/edit_category.php");

//Footer section
require_once("include/footer.php"); ?>
