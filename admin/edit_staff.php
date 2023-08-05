<?php 
$file_name="staff";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

$locations_query=mysqli_query($db,"SELECT * FROM locations WHERE published='1'");
$staff_groups_query=mysqli_query($db,"SELECT * FROM staff_groups WHERE status='1'");

//Fetch signle editable admin data
$admin_q=mysqli_query($db,'SELECT * FROM admin WHERE id="'.$id.'"');
$admin_data=mysqli_fetch_assoc($admin_q);

//Template file
require_once("views/staff/edit_staff.php");

//Footer section
require_once("include/footer.php"); ?>
