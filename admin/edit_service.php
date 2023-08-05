<?php 
$file_name="service";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable service data
$q=mysqli_query($db,'SELECT * FROM services WHERE id="'.$id.'"');
$service_data=mysqli_fetch_assoc($q);

//Template file
require_once("views/service/edit_service.php");

//Footer section
require_once("include/footer.php"); ?>
