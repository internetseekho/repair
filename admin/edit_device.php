<?php 
$file_name="device";

//Header section
require_once("include/header.php"); 

$id = $post['id'];

if($id<=0 && $prms_device_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_device_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable device data
$d_q=mysqli_query($db,'SELECT * FROM devices WHERE id="'.$id.'"');
$device_data=mysqli_fetch_assoc($d_q);

//Fetch list of published brand
//$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Template file
require_once("views/device/edit_device.php");

//Footer section
include("include/footer.php"); ?>
