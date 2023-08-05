<?php
$location_id = $_GET['location_id'];

require('../../libraries/google-api-php-client/vendor/autoload.php');

require_once("../_config/config.php");
require_once("../include/functions.php");

if($google_calendar_client_id == '' || $google_calendar_client_secret == '') {
	$msg='First please enter google client id & secret.';
	$_SESSION['error_msg']=$msg;
	if($location_id>0) {
		$redirect_uri = SITE_URL.'admin/edit_location.php?id='.$location_id;
	} else {
		$redirect_uri = SITE_URL.'admin/settings.php?type=appointment';
	}
	header('Location: ' . $redirect_uri);
	exit();
}

$client = new Google_Client();
$client->setApplicationName('Google Calendar');
$client->setClientId($google_calendar_client_id);
$client->setClientSecret($google_calendar_client_secret);
//$client->setAuthConfigFile('../../libraries/google-api-php-client/client_secret.json');
$client->setRedirectUri(SITE_URL.'admin/social/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

if($location_id) {
	$client->setState($location_id);
}

if(!isset($_GET['code'])) {
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
	$location_id = $_GET['state'];

	$client->authenticate($_GET['code']);
	$accessToken = $client->getAccessToken();

	if($accessToken['access_token']) {
		$q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$accessToken['access_token'];
		$json = file_get_contents($q);
		$userInfoArray = json_decode($json,true);
		$auth_email = $userInfoArray['email'];
		$auth_given_name = $userInfoArray['given_name'];
		$auth_family_name = $userInfoArray['family_name'];
		$google_cal_auth_info = json_encode(array('auth_email'=>$auth_email, 'auth_given_name'=>$auth_given_name, 'auth_family_name'=>$auth_family_name));
	}
	
	if($location_id > 0) {
		$cre_directory_path = '../../libraries/google-api-php-client/credentials_'.$location_id.'.json';
	} else {
		$cre_directory_path = '../../libraries/google-api-php-client/credentials.json';
	}
	
	$credentialsPath = expandHomeDirectory($cre_directory_path);
	/*if(file_exists($credentialsPath)) {
		$accessToken = json_decode(file_get_contents($credentialsPath), true);
	} else {*/
		//Store the credentials to disk.
		if(!file_exists(dirname($credentialsPath))) {
			mkdir(dirname($credentialsPath), 0700, true);
		}

		file_put_contents($credentialsPath, json_encode($accessToken));
		//printf("Credentials saved to %s\n", $credentialsPath);
	//}

	if($location_id > 0) {
		mysqli_query($db,"UPDATE locations SET is_google_cal_auth='1', google_cal_auth_info='".$google_cal_auth_info."' WHERE id='".$location_id."'");
		$redirect_uri = SITE_URL.'admin/edit_location.php?id='.$location_id;
	} else {
		mysqli_query($db,"UPDATE general_setting SET is_google_cal_auth='1', google_cal_auth_info='".$google_cal_auth_info."' ORDER BY id DESC");
		$redirect_uri = SITE_URL.'admin/settings.php?type=appointment';
	}
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

function expandHomeDirectory($path)
{
	$homeDirectory = getenv('HOME');
	if(empty($homeDirectory)) {
		$homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
	}
	return str_replace('~', realpath($homeDirectory), $path);
}
