<?php

 /*
   Plugin Name: WP-AP AutoPoster
   Plugin URI: http://www.trendypublishing.com
   Description: This plugin automatically publishes posts from a google sheet to WP
   Version: 1.1
   Author: Dr. Trent D.A.Mos-Def Fisher, Esq. DFA
   Author URI: http://www.trendypublishing.com
   */

 
  // create a scheduled event (if it does not exist already)
function cronstarter_activation() {
	if( !wp_next_scheduled( 'mycronjob' ) ) {  
	   wp_schedule_event( time(), 'everyten', 'mycronjob' );  	}
}
  // unschedule event upon plugin deactivation
function cronstarter_deactivate() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('mycronjob');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'mycronjob');
} 
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');
  
add_action ('mycronjob', 'doAline'); 

// add custom interval
function cron_add_ten( $schedules ) {
	// Adds once every minute to the existing schedules.
    $schedules['everyten'] = array(
	    'interval' => 600,
	    'display' => __( 'Once Every Ten Minutes' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_ten' );
// and make sure it's called whenever WordPress loads
add_action('wp', 'cronstarter_activation');
  

  
require_once '/home/ckww/AP/vendor/autoload.php';
include_once 'tiPost.php';
include_once 'base.php';

$_SESSION['number'] = 5;

 function repeat() {
      $number = $_SESSION['number'];
      $number++;
    $_SESSION['number'] = $number;
 }
 

function getClient() {
define('APPLICATION_NAME', 'My Project');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'tpausecret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/sheets.googleapis.com-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));




  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    echof("Open the following link in your browser:\n%s\n", $authUrl);
    echo 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    echof("Credentials saved to %s\n", $credentialsPath);
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
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}


// THIS IS SET TO JUST RUN FOOTBALL SHEET URL = https://docs.google.com/spreadsheets/d/1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw/edit



function doAline()
{

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

$range = 'Sheet1!A'.$_SESSION['number'] + ':H' + $_SESSION['number'];
$spreadsheetId ="1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw";

$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (count($values) == 0) {
  echo "No data found.\n";
} else {
  foreach ($values as $row) {

	$title=$row[0];
	$body=$row[1];
	$source=$row[2];
	$category=$row[3].$row[4];
	$image=$row[5];
	$identifier = 'ckww';
	$keywords=$row[7];
	}
	if ($keywords == null){
	$keywords = get_hashTags($source);
// ADD TAGS
	} else {
	$post_excerpt=strip_tags($row[1]);	
// for testing purposes
			//echo $post_excerpt."\n";
		$obj= new autoTpost($identifier);
		$obj->replaceImageMarkup($body);
		if ($image != null){
		$resp= $obj->createPostnImg($title,$keywords,$category,$post_excerpt,$body,$image);
			}else{
		$resp=  $obj->createPost($title,$keywords,$category,$post_excerpt,$body);
		}
		if (is_numeric($resp)){
		// DELETE OR MOVE ROW....
		
		} else {
			// EPIC FAIL....
		
		}
	}
}
}

?>