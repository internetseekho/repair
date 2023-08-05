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

		$category_q=mysqli_query($db,'SELECT image FROM blog_posts_seo WHERE postID="'.$id_v.'"');
		$blog_data=mysqli_fetch_assoc($category_q);
		if($blog_data['image']!="")
			unlink('../../../images/blog/'.$blog_data['image']);

		$query=mysqli_query($db,'DELETE FROM blog_posts_seo WHERE postID="'.$id_v.'"');
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
} elseif(!empty($ids) && $type == "published") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;
		$query=mysqli_query($db,'UPDATE blog_posts_seo SET status=1 WHERE postID="'.$id_v.'"');
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully published.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully published.";
		
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something went wrong.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
} elseif(!empty($ids) && $type == "unpublished") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;
		$query=mysqli_query($db,'UPDATE blog_posts_seo SET status=0 WHERE postID="'.$id_v.'"');
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully unpublished.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully unpublished.";
		
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something went wrong.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
} elseif(!empty($ids) && $type == "order") {
	foreach($ids as $key => $ordering_data) {
		$exp_ordering_data = explode(":",$ordering_data);
		if($exp_ordering_data[0]>0 && $exp_ordering_data[1]>0) {
			$query = mysqli_query($db,"UPDATE blog_posts_seo SET ordering='".$exp_ordering_data[1]."' WHERE postID='".$exp_ordering_data[0]."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	}
}

echo json_encode($response);
exit;
?>