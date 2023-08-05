<?php 
$file_name="appointment_status";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable appointments_status data
$appt_q=mysqli_query($db,'SELECT * FROM appointments_status WHERE id="'.$id.'"');
$appointments_status_data=mysqli_fetch_assoc($appt_q);

//Template file
require_once("views/status/edit_appointment_status.php");

//Footer section
require_once("include/footer.php"); ?>
