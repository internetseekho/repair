<?php
require_once("../_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
require_once("common.php");

/*if(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM appointments WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
}*/

setRedirect(ADMIN_URL.'appointment.php');
exit();
?>
