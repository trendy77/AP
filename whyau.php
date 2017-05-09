<?php
## tpau
require( $path . '/wp-load.php');
global $user_ID;

	$identifier= $_POST['identifier'];
	//require_once '/home/organ151/public_html/trendypublishing/try/newTPost.php';
		$config = parse_ini_file('config.ini', true);	
		
		if (!isset($identifier)){
		$config = $config[$identifier];
		}	
	
	// $user = $config['user'];
	 //   $pass = $config['pass'];
	    $url = $config['url'];
		$path = $config['path'];
		
		$title=$_POST['title'];
		$category=$_POST['categories'];
		$body=$_POST['content'];
		$tags=$_POST['tags'];
		$image=$_POST['image'];
		$source=$_POST['source'];
		
			$catIds = explode(",",$category);
			$zeeCat = array();
			
			foreach ($catIds as $cat) {
		    $idCat = get_category_by_slug($cat);
		    $zid = $idCat->term_id;
		    array_push($zeeCat, $zid);
			}	
		
		if (!isset($tags)) {
			$tags = get_hashTags($source);
			//	wp_set_post_tags( $post_id, $keywords, 'true' );
			}
				$excerpt=strip_tags($body);	
					$my_post = array(
						'post_title' => $title,
						'post_excerpt' => $excerpt,
						'post_content' => $body,
						'post_status' => 'publish',
						'post_author' => 1,
						'post_category' => $zeeCat,
						'post_type'  => 'post',
						'mt_keywords' => $tags
       					);
				//replaceImageMarkup($my_post);
				//setMetadata();
				
			echo $postId = wp_insert_post( $my_post );
			
			if (is_numeric($postId)){
			$file= $path . "/results.txt";
			$woohoo = $postId . '/n';
			
					file_put_contents($file, $woohoo, FILE_APPEND | LOCK_EX);
			
			} else {
				$file= $path . "/results.txt";
					$boo = 'epic fail/n' . $post_title;
					file_put_contents($file, $boo, FILE_APPEND | LOCK_EX);
			}
	
		}
			
			
			
			
	
	
	
	
	
	
	
	
	
function get_hashTags( $articleUrl ) {
	echo $tags = call_api( $articleUrl );
 }

function call_api($url){
$APPLICATION_ID = '4ecd9e16';
$APPLICATION_KEY='be54f0e53443501357865cbc055538aa';
  $ch = curl_init('https://api.aylien.com/api/v1/hashtags');
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'X-AYLIEN-TextAPI-Application-Key: ' . $APPLICATION_KEY,
    'X-AYLIEN-TextAPI-Application-ID: '. $APPLICATION_ID
  ));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
  $response = curl_exec($ch);
  return json_decode($response);
} 

?>