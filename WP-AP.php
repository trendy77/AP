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
	   wp_schedule_event( time(), 'daily', 'mycronjob' );  
	}
}
  // unschedule event upon plugin deactivation
function cronstarter_deactivate() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('mycronjob');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'mycronjob');
} 
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');
  
  
  
  
function wpap_googleplus_deactiveplugin()
{
	global $wpdb;
	
}
register_deactivation_hook( __FILE__, 'wpap_googleplus_deactiveplugin' );


//Drop Database Table
function wpap_googleplus_dropplugin()
{
	global $wpdb;
	delete_option('wpap_gpapoption');
	delete_option('wpap_gpapoptionstatus');
}
register_uninstall_hook( __FILE__, 'wpap_googleplus_dropplugin' );





// hook that function onto our scheduled event:
add_action ('mycronjob', 'wpapgpap'); 



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







function wpap_gmail_menu()
{
	//icon display on side title plugin in leftside
    $icon_url=WP_PLUGIN_URL."/google-plus-auto-poster/images/googleplusicone.png";
	add_menu_page('WPAP_Googlepost_Autopost', 'Google+Autopost', 'activate_plugins', 'wpapgpap_authontication', 'wpapgpap_authon',$icon_url);
	
}
add_action('admin_menu', 'wpap_gmail_menu');

function wpapgpap_authon()
{
	$wpapgetoption =get_option('wpap_gpapoption'); 	
	if(($_POST['username']!="" && $_POST['password']!="")) 
	{
		if($_POST['username']!="" && $_POST['password']!="")         
		{     
			require_once('googleplus.php');
		        
			//Option Value                                 
			if ( get_option( 'wpap_gpapoption' ) !== false  )   update_option( 'wpap_gpapoption' , $_POST );            else                                                add_option('wpap_gpapoption' , $_POST );       
			
			require_once('authontication.php'); 
		}
	}
	?>
<link href="<?php echo WP_PLUGIN_URL."/WP-AP/css/wpapgoogleplus.css"; ?>" rel="stylesheet" type="text/css" />
<div style="margin-top:20px;">
<?php 
$statusgpap =get_option( 'wpap_gpapoptionstatus');
		if($statusgpap=="success" && $msg=="")
		{
			?><div id="msg"><div class="success">Login Success</div></div><?php
		}
		if($statusgpap!="success" && $msg=="")
		{
			?><div id="msg"><div class="error">Incorrect Username/Password </div></div><?php
		}
?>
<div id="msg"><?php echo $msg; ?></div>
<div id="googleboxes">
  <div class="googleplusbody">
  <?php
  wp_enqueue_script("authvalidationjs", plugins_url( '/js/jquery.validate.js' , __FILE__ ), array("jquery"));
  wp_enqueue_script("authjs", plugins_url( '/js/authontication_check.js' , __FILE__ ), array("jquery"));
  ?>
    <h2>WP-AP Auto Poster</h2>
    <div>
      <form action="admin.php?page=wpapgpap_authontication" method="post" name="authform" id="authform">
        <table class="form-table" width="100%">
          <tr valign="top">
            <th scope="row">Email Address:</th>
            <td><input type="text" name="username" class="googleforminput" id="username" value="<?php echo $wpapgetoption['username']; ?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row">Password:</th>
            <td><input type="password" name="password" class="googleforminput" id="password" value="<?php echo $wpapgetoption['password']; ?>" /></td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" name="submitauth"  class="button-primary extbutton" value="Submit" />
        </p>
      </form>
    </div>
    <div style="font-size: 10px;">For business and communities page available on pro version at <a href="http://www.wpsuperplugin.com/download/google-auto-poster/" target="_blank">http://www.wpsuperplugin.com/</a></div>
  </div>
  <div class="notes">Enter Google Account Email Address and Password In Form</div>
</div>
</div>
<?php
}

global $NUMBERSHEET = 3;

global $post;

function wpapgpap()
{	
//require_once WP_PLUGIN_URL.'/vendor/autoload.php';
include_once 'APost.php';
//include_once 'base.php';
// If modifying these scopes, delete your previously saved credentials
// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);
//$NUMBERSHEET = 0;
// THIS IS SET TO JUST RUN FOOTBALL SHEET URL = https://docs.google.com/spreadsheets/d/1RnmnEB6tX_Ic6Gf6EWbJyIa9yZZ2lQwSQFz5UO1vQsw/edit

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));
$range = 'Sheet1!A'.$NUMBERSHEET. ':H' . $NUMBERSHEET;

$response = $service->spreadsheets_values->get($theline, $range);
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
	if ($keywords == null){
		$keywords = add_hashTags($source);
// ADD TAGS
	} 
	else {
	$post_excerpt=strip_tags($row[1]);	
// for testing purposes
			//echo $post_excerpt."\n";
		$obj= new autoTpost($identifier);
		$obj->replaceImageMarkup($body);
			if ($image != null){
		$resp = $obj->createPostnImg($title,$keywords,$category,$post_excerpt,$body,$image);
		} else {
		$resp = $obj->createPost($title,$keywords,$category,$post_excerpt,$body);
		}
		if (is_numeric($resp)){
		// DELETE OR MOVE ROW....
	
	global $NUMBERSHEET = $NUMBERSHEET +1;
		} else {
		// EPIC FAIL....
		//echo 'fail';
		}
	}
}
// at ~/.credentials/sheets.googleapis.com-php-quickstart.json


function getClient() {
require_once('googleplus.php');
define('APPLICATION_NAME', 'WP-AP');
define('CREDENTIALS_PATH', '~/.credentials/wp-ap.googleapis.json');
define('CLIENT_SECRET_PATH', 'faarkeffort.json');

 $client = new Google_Client();
 $client->setApplicationName(APPLICATION_NAME);
$client->setScopes(SCOPES);
$client->setAuthConfig(CLIENT_SECRET_PATH);
 $client->setAccessType('offline');
// Load previously authorized credentials from a file.
//  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  //if (file_exists($credentialsPath)) {
  // $accessToken = json_decode(file_get_contents($credentialsPath), true);
 // } else {  }
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









function googlepluspostfromwpap($pcontent,$images,$link,$domain,$title,$txt) 
{
	$new= '';
	$wpapownerid = "";
	$wpapbigcd = "";
	$titlereplce = array("\n", "\r");
	
	$pcontent =postmsgcheck($pcontent);
	
	if (isset($images) && trim($images) != "")
	{
		$img = getcurlpagex($images, "", false);
		if ($img["http_code"] == "200" && $img["content_type"] != "text/html")
		{
			$wpappostlink["imgType"] = urlencode($img["content_type"]);
		}
		else 
		{
			$images = "";
		}
	}
	$images = urlencode($images);
	$link = urlencode($link);
	$domain = urlencode($domain);
	$title = str_replace($titlereplce, " ", $title);
		$title = rawurlencode(addslashes($title));
	$txt = str_replace($titlereplce, " ", $txt);
		$txt = rawurlencode(addslashes($txt));
	
	
	$contents = getcurlpagex("https://plus.google.com/", "", false);
	$wpapfstart8 = stripos($contents["content"], "key: '2'");
	$wpapftmp8 = substr($contents["content"], $wpapfstart8 + strlen("key: '2'"));
	$wpapflen8 = stripos($wpapftmp8, "]");
	$new = substr($wpapftmp8, 0, $wpapflen8);
	
	$wpapfstart9 = stripos($new, "https://plus.google.com/");
	$wpapftmp9 = substr($new, $wpapfstart9 + strlen("https://plus.google.com/"));
	$wpapflen9 = stripos($wpapftmp9, "\"");
	$new = substr($wpapftmp9, 0, $wpapflen9);
	
	$wpapfstart19 = stripos($contents["content"], "csi.gstatic.com/csi\",\"");
	$wpapftmp19 = substr($contents["content"], $wpapfstart19 + strlen("csi.gstatic.com/csi\",\""));
	$wpapflen19 = stripos($wpapftmp19, "\",");
	$gpatvalue = substr($wpapftmp19, 0, $wpapflen19);
	if (!(isset($txt)))
	{
		$txt = "";
	}
	$txttxt = $txt;
	$txtStxt = str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $txttxt);
	$proOrCommTxt = "%5D%2C%5B%5B%5Bnull%2Cnull%2C1%5D%5D%2Cnull";
	$refPage = "https://plus.google.com/b/" . $new . "/";
	$gpp = "https://plus.google.com/_/sharebox/post/?spam=20&_reqid=1608303&rt=j";
	if (isset($link) && trim($link) != "")
	{
		$wpappostlinktitle = $title;
		$wpappostlinktext = $txt;
		$wpappostlinkdomain =$domain;
		$wpappostlinkimg =$images;
		$wpappostlinklink =$link;
		$wpapsprvl = linkwithmsgnew($pcontent,$new,$wpappostlinktitle,$wpappostlinktext,$wpappostlinkdomain,$wpappostlinkimg,$wpappostlinklink,$wpappostlinkimgType,$wpapownerid,$proOrCommTxt,$wpapbigcd,$gpatvalue);
	}
	$wpapsprvl = str_ireplace("+", "%20", $wpapsprvl);
	$wpapsprvl = str_ireplace(":", "%3A", $wpapsprvl);
	$contents = getcurlpagex($gpp, $refPage, false, $wpapsprvl);
	return print_r($contents, true);
}



function postToGplus(){
	global $wpdb;
	global $post;
	
	$my_postid = $post->ID;//This is page id or post id
	$gettype =get_post_type($my_postid);
	
	if($gettype=='post')
	{
		require_once('googleplus.php');
		$content_post = get_post($my_postid);
		$gpap_guid =$content_post->guid;
		$gpap_title =$content_post->post_title;
		$message = $content_post->post_content;
		$message = apply_filters('the_content', $message);
		$message = str_replace(']]>', ']]&gt;', $message);
		
		$statusgpap =get_option( 'wpap_gpapoptionstatus');
		if($statusgpap=="success")
		{
			require_once('authontication.php');
					
			//Login success then call if condition
			if (!$loginconnection)
			{
				// link with page title display
				$thumbnilcheck = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
				
				if($thumbnilcheck!="")
				{
					$contentsss = get_post_field('post_content', $my_postid);
					$images = $thumbnilcheck;
					$link = $gpap_guid;
					$domain = $domain;
					$title = $gpap_title;
					$txt = $txt;
					googlepluspostfromwpap($contentsss,$images,$link,$domain,$title,$txt);	
					
				}
				else
				{
					$link = $content_post->guid;
					$contentsss = get_post_field('post_content', $my_postid);
					wpapgetlinkandtitle($contentsss,$link);	
					 
				}
			}
		}
	}
}

?>