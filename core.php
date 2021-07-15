<?php
require __DIR__ . '/vendor/autoload.php'; 
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function setup_token()
{
    $client = new Google_Client();
    $client->setApplicationName('Set up token');
    $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $client->setAuthConfig(__DIR__ . '/cre.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            
            
            if( isset($_POST['access_token']) && !empty($_POST['access_token']) ){
                // echo $_POST['access_token'];
                $authCode = $_POST['access_token'];
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                
                // echo "Access Token: " . json_encode($accessToken);
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
                if (!file_exists(dirname($tokenPath))) {
                    mkdir(dirname($tokenPath), 0700, true);
                }
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));

            }else{
                echo "<div class='card text-center'>
                  <div class='card-header'>
                    <h4>Setup your API</h4>
                  </div>
                  <div class='card-body'>
                    <a href='".$authUrl."' class='btn btn-primary' target='_blank'>Click here to get your access code!</a>
                    <form action='' method='post'>
                      <div class='form-group'>
                      <label for='token'>Access Token:</label>
                      <input type='text' name='access_token' class='form-control text-center' placeholder='Enter access token' id='token'>
                      </div>
                      <div class='form-group'>
                      <input type='submit' class='btn btn-success' value='Submit Token'>
                      </div>
                    </form>
                  </div>
                </div>";
            }
            
        }
        // Save the token to a file.
        
    }
    return $client;
}

function display_data(){
	$client = new Google_Client();
    $client->setApplicationName('Set up token');
    $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $client->setAuthConfig(__DIR__ . '/cre.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            echo "<h1>Your token is expired!</h1>
            <a href='setup_token.php' target='_blank'>CLick here to refresh your token.</a>
            ";
            
        }
        // Save the token to a file.
        
    }
    return $client;
}
