<?php
require_once("_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
require_once("controllers/common.php");

$response = array();

$post = $_REQUEST;
$contractor_id = $post['contractor_id'];
$appt_id = $post['appt_id'];
$comment=real_escape_string($post['comment']);
$c_status=$post['c_status'];
$date = date("Y-m-d H:i:s");

if($comment=="" && $c_status=="") {
	$response['message'] = "Please fill up mandatory fields.";
	$response['status'] = false;
} else {			
	if($appt_id!="" && $comment!="") {
		$c_query = mysqli_query($db,"INSERT INTO comments(`appt_id`, `contractor_id`, `comment`, `appt_status`, `thread_type`, `date`) VALUES('".$appt_id."','".$contractor_id."','".$comment."','".$c_status."','contractor','".$date."')");
		if($c_query == '1') {
			$response['message'] = "You have successfully send";
			$response['status'] = true;
			$response['is_comment'] = "yes";
			$response['comments'] = $comment;
			$response['date'] = date("m/d/y h:i:s a",strtotime($date));
			
			if($c_status>0) {
				mysqli_query($db,"UPDATE appointments SET `status`='".$c_status."' WHERE appt_id='".$appt_id."'");

				$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE id='".$c_status."'");
				$appointment_status_data = mysqli_fetch_assoc($appt_status_query);
				$response['status_id'] = $appointment_status_data['id'];
				$response['status_name'] = ($appointment_status_data['name']!=""?$appointment_status_data['name']:'');
			} else {
				$response['status_id'] = '';
				$response['status_name'] = '';
			}
		} else {
			$response['message'] = "Something went wrong!!!";
			$response['status'] = false;
		}
	}
}

echo json_encode($response);
exit;
?>