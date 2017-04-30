<?php
 /*
   Plugin Name: aaaAutoPoster
   Plugin URI: http://www.trendypublishing.com
   Description: This plugin automatically publishes posts from a google sheet to WP
   Version: 1.1
   Author: Dr. Trent D.A.Mos-Def Fisher, Esq. DFA
   Author URI: http://www.trendypublishing.com
   */

add_filter( 'cron_schedules', 'cron_add_ten' );
  
function cronstarter_activation() {
  if( !wp_next_scheduled( 'mycronjob' ) ) {  
     wp_schedule_event( time(), 'everyten', 'mycronjob' );    }
}
function cronstarter_deactivate() { 
    $timestamp = wp_next_scheduled ('mycronjob');
    wp_unschedule_event ($timestamp, 'mycronjob');
} 
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');
// add custom interval
function cron_add_ten( $schedules ) {
  // Adds once every minute to the existing schedules.
    $schedules['everyten'] = array(
      'interval' => 600,
      'display' => __( 'Once Every Ten Minutes' )
    );
    return $schedules;
}



$url = plugins_url() . '/aaaAutoPost/vendor/autoload.php';
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
//require_once( $parse_uri[0] . 'wp-load.php' );
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

function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

function doAline() {
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
  $service = new Google_Service_Sheets($client);
  $spreadsheetId =get_option('sheetId', $sheetoption);  
  if (!isset($spreadsheetId){
  $spreadsheetId ="1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw";
} }
    $getline = file_get_contents('line.txt', NULL, NULL, 0, 4) 
    if (!isset($getline){
      $getline=5;
    }
$range = 'Sheet1!A'.$getline. ':H' . $getline;
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
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
		$catIds = array();
		foreach ($category as $cat) {
		    $idObj = get_category_by_slug($cat);
		    $zid = $idObj->term_id;
		    array_push($catIds, $zid);
		  }	
			if ($keywords == null){
			 $keywords = get_hashTags($articleUrl);
			 } 
	       	$post_excerpt=strip_tags($row[1]);	
if(isset$_POST['do']){

  echo post_title;
}
 		$my_post = array(
						'post_title' => $title,
						'post_content' => $body,
						'post_status' => 'publish',
						'post_author' => 1,
						'post_category' => $catIds
				);
		$postId = wp_insert_post( $my_post );
			if (is_numeric($postId)){
			$file = "results.txt";
			$woohoo = '/n'.$postId;
			$getline=$getline++;
		echo file_put_contents($file, $woohoo, FILE_APPEND | LOCK_EX);
		echo file_put_contents("line.txt",$getline);
    	} else {
			$file = 'results.txt';
			$boo = '/n'.$postId . $post_title;
			echo file_put_contents($file, $boo, FILE_APPEND | LOCK_EX);
			}
	}



function wpap_gmail_menu()
{
  //icon display on side title plugin in leftside
    $icon_url= plugin_dir_url( __FILE__ )."/images/googleplusicone.png";
  add_menu_page('Autopost', 'Autopost', 'activate_plugins', 'autoposter', 'wpapgpap_authon',$icon_url);
  
}
add_action('admin_menu', 'wpap_gmail_menu');

function wpapgpap_authon()
{
  if($_POST['sheetId']!="" ) 
  {
    $sheetoption = $_POST['sheetId'];
    update_option('sheetId', $sheetoption);  
  }
  if($_POST['do']!="" ) 
  {
    if($_POST['do']=="yes")         
    {     
      doAline();
  }
}
?>
<div id="googleboxes">
  
    <h2>WP-AP Auto Poster</h2>
    <div>
        <form action="admin.php?page=autopposter" method="post" name="authform" id="authform">
        <table class="form-table" width="100%">
          <tr valign="top">
            <th scope="row">Want to do a line? type 'yes' click submit!:</th>
            <td><input type="text" name="do" class="googleforminput" id="do" value="<?php echo $wpap['do']; ?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row">sheetId:</th>
            <td><input type="text" name="sheetId" class="googleforminput" id="sheetId" value="<?php echo $wpapgetoption['sheetId']; ?>" /></td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" name="submitauth"  class="button-primary extbutton" value="Do IT!" />
        </p>
      </form>
    </div>
    
</div>
</div>
</div>
<?php
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