<?php 
$file_name="appt_ticket_status";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable appt_ticket_status data
$appt_q=mysqli_query($db,'SELECT * FROM appt_ticket_status WHERE id="'.$id.'"');
$appt_ticket_status_data=mysqli_fetch_assoc($appt_q);

//Template file
require_once("views/status/edit_appt_ticket_status.php");

//Footer section
require_once("include/footer.php"); ?>
