<?php

require_once '/home/organ151/Scripts/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=/organ151/.credentials/MAYoAuth-4770763c0fae.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();

$service = new Google_Service_Sheets($client);
	$sheetId = '1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4';
		
		$spreadsheetId =get_option('sheetId', $sheetoption);  
			if (!isset($spreadsheetId)){
	$sheetId = '1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4';		
			} 
		$getline=file_get_contents('line.txt',NULL,NULL,0,4) 
		if (!isset($getline)){
		$getline=2;
		}
		$range = 'LIVE!A'.$getline. ':H' . $getline;
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
 		$my_post = array(
						'post_title' => $title,
						'post_content' => $body,
						'post_status' => 'publish',
						'post_author' => 1,
						'post_category' => array ($catIds)
						);
	echo $postId = wp_insert_post( $my_post );
			if (is_numeric($postId)){
			$file="results.txt";
			$woohoo = '/n'.$postId;
			$getline=$getline++;
		file_put_contents($file, $woohoo, FILE_APPEND | LOCK_EX);
		 file_put_contents("line.txt",$getline);
    	} else {
			$file='results.txt';
			$boo = '/n'.$postId . $post_title;
			file_put_contents($file, $boo, FILE_APPEND | LOCK_EX);
			}
	}

$data = array(
        'post_title'    => 'title',
        'post_content'  => 'body',
        'post_status'   => 'publish',
        'post_date'     =>  strtotime('now'),
        'post_author'   => '1',
        'post_type'     => 'post',
        'post_category' => array(['category'])
    );

$response = wp_remote_post( $url, array(
    'body'    => $data,
    'headers' => array(
        'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
    ),
) );
if ( is_wp_error( $response ) ) {
    $error_message = $response->get_error_message();
    echo "Something went wrong: $error_message";
} else {
    echo 'Response:<pre>';
    print_r( $response );
    echo '</pre>';
}


	
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
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