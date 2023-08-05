<?php 
$file_name="review";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM reviews ORDER BY id DESC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($review_data=mysqli_fetch_assoc($query)) {
		$review_data['date'] = format_date($review_data['date']).' '.format_time($review_data['date']);
		$review_data['content'] = '';
		$data_list[] = $review_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/review.php");

//Footer section
require_once("include/footer.php"); ?>