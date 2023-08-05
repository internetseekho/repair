<?php
require(CP_ROOT_PATH.'/libraries/google-api-php-client/vendor/autoload.php');

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient($location_id)
{
	$redirect_uri = SITE_URL."admin/social/oauth2callback.php";

    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(CP_ROOT_PATH.'/libraries/google-api-php-client/client_secret.json');
	$client->setRedirectUri($redirect_uri);
    $client->setAccessType('offline');
	$client->setApprovalPrompt('force');

    // Load previously authorized credentials from a file.
	if($location_id > 0) {
		$cre_directory_path = CP_ROOT_PATH.'/libraries/google-api-php-client/credentials_'.$location_id.'.json';
	} else {
		$cre_directory_path = CP_ROOT_PATH.'/libraries/google-api-php-client/credentials.json';
	}

    $credentialsPath = expandHomeDirectory($cre_directory_path);
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));
		//$authCode = $google_cal_auth_code;

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

/*// Get the API client and construct the service object.
$client = getClient($location_id);
$service = new Google_Service_Calendar($client);*/
?>