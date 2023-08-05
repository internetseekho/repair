<?php
$meta_title = "Make an appointment";
$meta_desc = "Make an appointment";
$meta_keywords = "Make an appointment";

$repair_option = '2';
if($repair_option == '1') {
	include("views/repair/repair1.php");
} elseif($repair_option == '2') {
	include("views/repair/repair2.php");
}