<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$sql_cus_fld = "select id from custom_fields where custom_group_id in (".$post['d_id'].")";
	$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
	$no_of_fields = mysqli_num_rows($exe_cus_fld);
	if($no_of_fields>0){
		while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)){
			$sql_cus_opt = "delete from custom_options where field_id = '".$row_cus_fld['id']."'";
			$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
		}
	   $query= mysqli_query($db,"delete from custom_fields where custom_group_id in (".$post['d_id'].")");
	}
	$query= mysqli_query($db,"delete from custom_group where id in (".$post['d_id'].")");	
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'custom_fields.php');
} else {
	setRedirect(ADMIN_URL.'custom_fields.php');
}
exit();
?>