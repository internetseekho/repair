<?php
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");
check_admin_staff_auth("ajax");

$response = array();

$post = $_REQUEST['post_data'];
$type = $post['type'];
$ids = $post['ids'];

if(!empty($ids) && $type == "remove") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;
		$query=mysqli_query($db,'DELETE FROM invoice WHERE id="'.$id_v.'"');
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
		
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something went wrong.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
}

echo json_encode($response);
exit;
?>