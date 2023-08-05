<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM appt_ticket_status WHERE id="'.$post['d_id'].'" AND type!="fixed"');
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'appt_ticket_status.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$query=mysqli_query($db,'DELETE FROM appt_ticket_status WHERE id="'.$id_v.'" AND type!="fixed"');
			
			$status_q=mysqli_query($db,'SELECT * FROM appt_ticket_status WHERE id="'.$id_v.'" AND type="fixed"');
			$status_data=mysqli_fetch_assoc($status_q);
			if(empty($status_data)) {
				$removed_idd[] = $id_v;
			}
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'appt_ticket_status.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE appt_ticket_status SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";

		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'appt_ticket_status.php');
} elseif(isset($post['update'])) {
	$name=real_escape_string($post['name']);
	$color=real_escape_string($post['color']);
	$status = $post['status'];
	
	if($post['id']) {
		$query=mysqli_query($db,'UPDATE appt_ticket_status SET name="'.$name.'", color="'.$color.'", status="'.$status.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Status has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_appt_ticket_status.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO appt_ticket_status(name, color, status) values("'.$name.'","'.$color.'","'.$status.'")');
		if($query=="1") {
			$msg="Status has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'appt_ticket_status.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_appt_ticket_status.php');
		}
	}
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE appt_ticket_status SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'appt_ticket_status.php');
} else {
	setRedirect(ADMIN_URL.'appt_ticket_status.php');
}
exit();
?>