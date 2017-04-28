<?php 
global $number;

function makePosting(){
	echo 'startmakePosting number' . $number;
$resp=	wpapgpap_authon($number);
	if (is_numeric($resp)){
			repeat();	
			echo 'success' ;echo $number ;
			// SUCK ON THAT TURING!
		} else {
			// eat a dick Turing
			return 'error';
				}
		}
	
function wpapgpap_authon()
{
require_once '/home/$USER/AP/vendor/autoload.php';
include_once 'tPost.php';
include_once '/home/$USER/AP/base.php';
define('APPLICATION_NAME', 'WP-AP');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', '/home/$USER/AP/tpausecret.json');
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

    $authUrl = $client->createAuthUrl();
   
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

$service = new Google_Service_Sheets($client);
$spreadsheetId ="1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw";
if (!isset($number)) {
$number= 5; 
} else {
echo 'numbersheet @' . $number;
}

$range = 'Sheet1!A'.$number. ':H' . $number;
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
 	$identifier = $row[6];
 	$keywords=$row[7];
	}
	echo 'title' . $title;
	echo 'sourceUrl' . $source;
	echo 'source' . $source;
	echo 'category' . $category;
 	echo 'image' . $image;
 	echo '$identifier' . $identifier;
		if ($keywords == null){
			$keywords = get_hashTags($source);
			echo $keywords;
			} 
			$post_excerpt=strip_tags($row[1]);	
			// for testing purposes
			//echo $post_excerpt."\n";
		$obj= new autoTpost($identifier);
		$obj->replaceImageMarkup($body);
	$resp = $obj->createPost($title,$keywords,$category,$post_excerpt,$body);
		 return $resp;
		}
		
 function repeat() {
echo $number;      
	     $number++;
    return $number;
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