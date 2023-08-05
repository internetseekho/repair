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
//$client->setAuthConfig('../../libraries/google-api-php-client/client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

if($_GET['UnAuthorize'] == "yes") {
	if($location_id>0) {
		$credentialsPath = expandHomeDirectory('../../libraries/google-api-php-client/credentials_'.$location_id.'.json');
		unlink($credentialsPath);

		mysqli_query($db,"UPDATE locations SET is_google_cal_auth='0' WHERE id='".$location_id."'");
		$redirect_uri = SITE_URL.'admin/edit_location.php?id='.$location_id;
	} else {
		$credentialsPath = expandHomeDirectory('../../libraries/google-api-php-client/credentials.json');
		unlink($credentialsPath);

		mysqli_query($db,"UPDATE general_setting SET is_google_cal_auth='0' ORDER BY id DESC");
		$redirect_uri = SITE_URL.'admin/settings.php?type=appointment';
	}
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	exit();
} elseif(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
	$service = new Google_Service_Calendar($client);
	//Here we can add fetch event of API
} else {
	if($location_id>0) {
		$url_extra_params = '?location_id='.$location_id;
	}

	$redirect_uri = SITE_URL.'admin/social/oauth2callback.php'.$url_extra_params;
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