<?php
require_once("../../_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
require_once("../common.php");

if(isset($post['login'])) {
	$message=array();
	//Validation for if username entered or not
	if(isset($post['username']) && !empty($post['username'])){
		$username=real_escape_string($post['username']);
	} else {
		$message[]='Please enter username';
	}
	
	//Validation for if password entered or not
	if(isset($post['password']) && !empty($post['password'])){
		$password=real_escape_string($post['password']);
	} else {
		$message[]='Please enter password';
	}
	
	$error_msg = '';
	$countError=count($message);
	if($countError > 0){
		 for($i=0;$i<$countError;$i++){
			$error_msg .= $message[$i].'<br/>';
		 }
		 $_SESSION['error_msg']=$error_msg;
		 setRedirect(CONTRACTOR_URL.'index.php');
	} else {
		//Check if login details match or not
		$query="SELECT * FROM contractors WHERE email = '".$username."' AND password = '".md5($password)."'";
		$res=mysqli_query($db,$query);
		$checkUser=mysqli_num_rows($res);
		if($checkUser > 0) {
			$query=mysqli_query($db,"SELECT * FROM contractors WHERE email = '".$username."'");
			$user_data=mysqli_fetch_assoc($query);
			if($user_data['status'] == '0') {
				$error_msg='Your account is not activated so please contact with support team.';
				$_SESSION['error_msg']=$error_msg;
				setRedirect(CONTRACTOR_URL.'index.php');
			} else {
				$_SESSION['contractor_username'] = $username;
				$_SESSION['is_contractor'] = 1;
				$_SESSION['contractor_id']=$user_data['id'];
				//$_SESSION['admin_type']=$user_data['type'];
				setRedirect(CONTRACTOR_URL.'appointment.php');
			}
		} else {
			$error_msg='Please enter correct login details';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(CONTRACTOR_URL.'index.php');
		}
	}
} else {
	setRedirect(CONTRACTOR_URL.'index.php');
}
exit(); ?>
