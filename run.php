<?php 
$_SESSION['number'] = 5;

function wpapgpap_authon()
{
require_once '/home/ckww/AP/vendor/autoload.php';
include_once '/home/ckww/AP/base.php';
define('APPLICATION_NAME', 'WP-AP');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'tpausecret.json');

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
    echo "Open the following link in your browser:\n%s\n", $authUrl ;
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
  
$service = new Google_Service_Sheets($client);

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));
return $client;
}

//global $post;
function wpapgpap(){	

require_once 'home/ckww/AP/vendor/autoload.php';
include_once 'APost.php';

 $client = wpapgpap_authon();
$service = new Google_Service_Sheets($client);
$spreadsheetId ="1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw";

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));
if (!isset($_SESSION['number'])) {
echo 'numbersheet is not set' . $_SESSION['number'];
} else {
echo 'numbersheet is set @' . $_SESSION['number'];
}
$thesheet = $wpapgetoption['sheet'];
$range = 'Sheet1!A'.$_SESSION['number']. ':H' . $_SESSION['number'];
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
			echo $resp;
			return $resp;
			} else {
			// EPIC FAIL....
			echo 'fail';
			}
		echo $resp;
		return $resp;
		}
	}
}
 function repeat() {
      $number = $_SESSION['number'];
      $number++;
    $_SESSION['number'] = $number;
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
         // echo sprintf(" n %s", $val );
       // }
}

function call_api($url){
$APPLICATION_ID = '4ecd9e16';
$APPLICATION_KEY='be54f0e53443501357865cbc055538aa';
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