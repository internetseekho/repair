<?php 
$file_name="faqs_groups";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable faqs data
$appt_q=mysqli_query($db,'SELECT * FROM faqs_groups WHERE id="'.$id.'"');
$faq_data=mysqli_fetch_assoc($appt_q);

//Template file
require_once("views/faq/edit_faq_group.php");

//Footer section
require_once("include/footer.php"); ?>
