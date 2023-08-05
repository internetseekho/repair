<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

$response = array();

$post = $_REQUEST;
$email = real_escape_string($post['email']);
$password = real_escape_string($post['password']);
$token=real_escape_string($post['token']);
if($email=="" || $password=="") {
	$response['message'] = "Please fill up mandatory fields.";
	$response['status'] = false;
} else {
	if($token!="") {
		$ck_q = mysqli_query($db,"SELECT * FROM admin WHERE email='".$email."' AND password='".md5($password)."' AND unauthorized_token='".$token."' AND type='super_admin'");
		$admin_user_data = mysqli_fetch_assoc($ck_q);		
		if(!empty($admin_user_data)) {
			$saved_allowed_ip = $general_setting_data['allowed_ip'];
			if($saved_allowed_ip!="") {
				$allowed_ip = $saved_allowed_ip.','.USER_IP;
			} else {
				$allowed_ip = USER_IP;
			}
			
			$g_query = mysqli_query($db,"UPDATE general_setting SET `allowed_ip`='".$allowed_ip."' WHERE id='1'");
			if($g_query == '1') {
				$_SESSION['admin_username'] = $admin_user_data['username'];
				$_SESSION['is_admin'] = 1;
				$_SESSION['admin_id']=$admin_user_data['id'];
				$_SESSION['admin_type']=$admin_user_data['type'];
				
				$response['message'] = "You have successfully verified.";
				$response['status'] = true;
				$response['token_status'] = 'verified';
			} else {
				$response['message'] = "Something went wrong!!!";
				$response['status'] = false;
				$response['token_status'] = '';
			}
		} else {
			$response['message'] = "Please enter correct token";
			$response['status'] = false;
			$response['token_status'] = '';
		}
	} else {
		$ck_q = mysqli_query($db,"SELECT * FROM admin WHERE email='".$email."' AND password='".md5($password)."' AND type='super_admin'");
		$admin_user_data = mysqli_fetch_assoc($ck_q);		
		if(!empty($admin_user_data)) {
			$unauthorized_token = md5(date("YmdHis").uniqid());
			$c_query = mysqli_query($db,"UPDATE admin SET `unauthorized_token`='".$unauthorized_token."' WHERE id='".$admin_user_data['id']."'");
			if($c_query == '1') {
				$subject = "Token received from unauthorized page";
				$body = '<!DOCTYPE html><html><body>
				<h4 align="left">Hello Admin</h4>
				<p>Please see below is your token from unauthorized page</p>
					<table>
						<tr>
							<th>Token: </th><td>'.$unauthorized_token.'</td>
						</tr>
					</table>
					<br><strong>Regards</strong>
				</body></html>';
				send_email($email, $subject, $body, FROM_NAME, FROM_EMAIL);
				
				$response['message'] = "Access token successfully send to your registered email. please verify";
				$response['status'] = true;
				$response['token_status'] = '';
			} else {
				$response['message'] = "Something went wrong!!!";
				$response['status'] = false;
				$response['token_status'] = '';
			}
		} else {
			$response['message'] = "Please enter correct details";
			$response['status'] = false;
			$response['token_status'] = '';
		}
	}
}

echo json_encode($response);
exit;
?>