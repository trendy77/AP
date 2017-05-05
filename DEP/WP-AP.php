<?php

 /*
   Plugin Name: WP-AP AutoPoster
   Plugin URI: http://www.trendypublishing.com
   Description: This plugin automatically publishes posts from a google sheet to WP
   Version: 1.1
   Author: Dr. Trent D.A.Mos-Def Fisher, Esq. DFA
   Author URI: http://www.trendypublishing.com
   */

add_filter( 'cron_schedules', 'cron_add_ten' );
// and make sure it's called whenever WordPress loads
add_action('wp', 'cronstarter_activation');
 
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
<<<<<<< .merge_file_a05292
 $_SESSION['number'];

 function repeat() {
      $number = $_SESSION['number'];
      $number++;
    $_SESSION['number'] = $number;
=======

 function repeat() {
      $number = $_GLOBAL['number'];
      $number++;
    $_GLOBAL['number'] = $number;
>>>>>>> .merge_file_a07116
 }

function wpapgpap_authon()
{
require_once '/home/ckww/AP/vendor/autoload.php';
include_once '/home/ckww/AP/base.php';
define('APPLICATION_NAME', 'WP-AP');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', '/home/ckww/AP/tpausecret.json');
<<<<<<< .merge_file_a05292

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
    //echo "Open the following link in your browser:\n%s\n";
	echo $authUrl ;
    echo 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
   
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  
$service = new Google_Service_Sheets($client);

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));
return $client;
}

function doAline($number){
	require_once '/home/ckww/AP/vendor/autoload.php';
include_once 'APost.php';
include_once '/home/ckww/AP/base.php';
 $client = wpapgpap_authon();
$service = new Google_Service_Sheets($client);
$spreadsheetId ="1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw";
=======

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
    //echo "Open the following link in your browser:\n%s\n";
	echo $authUrl ;
    echo 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
   
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  
$service = new Google_Service_Sheets($client);
>>>>>>> .merge_file_a07116

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));
<<<<<<< .merge_file_a05292
if (!isset($_SESSION['number'])) {
$number = 5;
} else {
echo 'numbersheet is set @' . $_SESSION['number'];
$number = $_SESSION['number'];
}
$thesheet = $wpapgetoption['sheet'];
$range = 'Sheet1!A'.$_SESSION['number']. ':H' . $_SESSION['number'];
=======
return $client;
}

function doAline(){
	require_once '/home/ckww/AP/vendor/autoload.php';
include_once '/home/ckww/AP/tPost.php';
include_once '/home/ckww/AP/base.php';
 $client = wpapgpap_authon();
$service = new Google_Service_Sheets($client);
$spreadsheetId ="1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw";

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));
if (!isset($_GLOBAL['number'])) {
$number = 5;
} else {
echo 'numbersheet is set @' . $_GLOBAL['number'];
$number = $_GLOBAL['number'];
}
$thesheet = $wpapgetoption['sheet'];
$range = 'Sheet1!A'.$_GLOBAL['number']. ':H' . $_GLOBAL['number'];
>>>>>>> .merge_file_a07116
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();
if (count($values) == 0) {
  echo "No data found.\n";
} else {
  foreach ($values as $row) {
	echo $title=$row[0];
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
	echo $post_excerpt;
// for testing purposes
			//echo $post_excerpt."\n";
		$obj= new autoTpost();
		$obj->replaceImageMarkup($body);
			if ($image != null){
		$resp = $obj->createPostnImg($title,$keywords,$category,$post_excerpt,$body,$image);
		} else {
		$resp = $obj->createPost($title,$keywords,$category,$post_excerpt,$body);
		}
			if (is_numeric($resp)){
			// DELETE OR MOVE ROW....
			repeat();
<<<<<<< .merge_file_a05292
			
			return $resp;
=======
				return $resp;
>>>>>>> .merge_file_a07116
			} else {
			// EPIC FAIL....
			echo 'fail';
			}
<<<<<<< .merge_file_a05292
	
		return $resp;
=======
>>>>>>> .merge_file_a07116
		}
	
	}
}

function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

function get_hashTags( $source ) {
  echo $keywords = call_api($source);
        //foreach($hashtags->hashtags as $val) {
         // echo secho(" n %s", $val );
       // }
}

function call_api($url){
$APPLICATION_ID = '4ecd9e16';
$APPLICATION_KEY='be54f0e53443501357865cbc055538aa';
  $ch = curl_init('https://api.aylien.com/api/v1/' . "hashtags");
  $ch = curl_init('https://api.aylien.com/api/v1/' . "hashtags");
  $ch = curl_init('https://api.aylien.com/api/v1/' . "hashtags");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'X-AYLIEN-TextAPI-Application-Key: ' . APPLICATION_KEY,
    'X-AYLIEN-TextAPI-Application-ID: '. APPLICATION_ID
  ));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
  $response = curl_exec($ch);
  return json_decode($response);
} 


<<<<<<< .merge_file_a05292
function wpap_gmail_menu()
{
	//icon display on side title plugin in leftside
    $icon_url=WP_PLUGIN_URL."/images/googleplusicone.png";
	add_menu_page('WPAP_Autopost', 'WP-Autopost', 'activate_plugins', 'wpapgpap_authontication', 'tester',$icon_url);
	}
add_action('admin_menu', 'wpap_gmail_menu');

function tester(){
	?>
<div id="googleboxes">
  <div class="googleplusbody">
    <h2>WP-AP Auto Poster</h2>
    <div>
      <form action="admin.php?page=wpapgpap_authontication" method="post" name="authform" id="authform">
        <table class="form-table" width="100%">
          <tr valign="top">
            <th scope="row">pick a line:</th>
            <td><input type="text" name="username" class="googleforminput" id="username" value="<?php echo $_SESSION['number'];?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row">Run a Line:</th>
            <td><input type="text" name="doAline" class="googleforminput" id="doLine" value="<?php $number = $_SESSION['number'] echo doAline($number);  ?>" /></td>
          </tr>
		  <tr valign="top">
            <th scope="row">SpreadsheetLine:</th>
            <td><input type="text" name="sheet" class="googleforminput" id="sheet" value="<?php echo $number; ?>" /></td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" name="submitauth"  class="button-primary extbutton" value="Submit" />
        </p>
      </form>
    </div>
=======
>>>>>>> .merge_file_a07116
