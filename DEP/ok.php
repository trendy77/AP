<?php
$url = plugins_url() . 'aaaAutoPost/vendor/autoload.php';
require_once(ABSPATH . 'wp-load.php');
require_once( $url );
//include_once 'tPost.php';
include_once 'base.php';

define('APPLICATION_NAME', 'My Project');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'tpausecret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/sheets.googleapis.com-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));

function getClient() {
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
    //echo("Open the following link in your browser:\n%s\n", $authUrl);
    echo 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));
    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    echof("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);
 if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}



// on install...
// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);
global $NUMBERSHEET;

function doAline($theline){
global $NUMBERSHEET = $NUMBERSHEET +1; 

$range = 'Sheet1!A'.$NUMBERSHEET + ':H' + $NUMBERSHEET;

$response = $service->spreadsheets_values->get($theline, $range);
$values = $response->getValues();

if (count($values) == 0) {
  echo "No data found.\n";
} else {
  foreach ($values as $row) {

	$title=$row[0];
	$body=$row[1];
	$articleUrl=$row[2];
	$category=$row[3].$row[4];
	$image=$row[5];
	$identifier = $row[6];
	$keywords=$row[7];
	}
	if ($keywords == null){
		$keywords = get_hashTags($articleUrl);
// ADD TAGS
	} 
	else {
	$post_excerpt=strip_tags($row[1]);	
// for testing purposes
			//echo $post_excerpt."\n";
		$obj= new autoTpost($identifier);
		$obj->replaceImageMarkup($body);
			if ($image != null){
		$resp = echo $obj->createPostnImg($title,$keywords,$category,$post_excerpt,$body,$image);
		} else {
		$resp = echo $obj->createPost($title,$keywords,$category,$post_excerpt,$body);
		}
		if (is_numeric($resp)){
		// DELETE OR MOVE ROW....
		echo 'success!!!!';
		} else {
			// EPIC FAIL....
		echo 'fail';
		}
	}
}




function get_hashTags( $articleUrl ) {
  echo $keywords = call_api( $articleUrl );
   }

function call_api($url){
$APPLICATION_ID = '4ecd9e16';
$APPLICATION_KEY='be54f0e53443501357865cbc055538aa';
  $ch = curl_init('https://api.aylien.com/api/v1/hashtags');
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
?>