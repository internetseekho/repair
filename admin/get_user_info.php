<?php
require_once("_config/config.php");
require_once("include/functions.php");

$response = array();

$post = $_REQUEST;
$user_id = $post['user_id'];	
if($user_id!="") {
	$query=mysqli_query($db,"SELECT * FROM users WHERE id='".$user_id."'");
	$user_data = mysqli_fetch_assoc($query);
	if(!empty($user_data)) {
		$response['message'] = "success";
		$response['status'] = true;
		$response['name'] = $user_data['name'];
		$response['email'] = $user_data['email'];
		$response['phone'] = $user_data['phone'];
		$response['address1'] = $user_data['address'];
		$response['address2'] = $user_data['address2'];
		$response['city'] = $user_data['city'];
		$response['state'] = $user_data['state'];
		$response['postcode'] = $user_data['postcode'];
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = false;
	}
} else {
	$response['message'] = "choosen blank from dropdown";
	$response['status'] = true;
	$response['name'] = '';
	$response['email'] = '';
	$response['phone'] = '';
	$response['address1'] = '';
	$response['address2'] = '';
	$response['city'] = '';
	$response['state'] = '';
	$response['postcode'] = '';
}

echo json_encode($response);
exit;
?>