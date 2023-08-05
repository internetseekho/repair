<?php
require_once("_config/config.php");
require_once("include/functions.php");

$response = array();

$post = $_REQUEST;
$contractor_id = $post['contractor_id'];	
if($contractor_id!="") {
	$query=mysqli_query($db,"SELECT * FROM contractors WHERE id='".$contractor_id."'");
	$contractor_data = mysqli_fetch_assoc($query);
	if(!empty($contractor_data)) {
		$response['message'] = "success";
		$response['status'] = true;
		$response['contractor_info'] = '<b>Name:</b> '.$contractor_data['name'].'<br><b>Email:</b> '.$contractor_data['email'].'<br><b>Phone:</b> '.$contractor_data['phone'];
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = false;
	}
}

echo json_encode($response);
exit;
?>