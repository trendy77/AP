<?php
require_once ( '/home/ckww/AP/IXRlib.php' );

class autoTPost
{
	/**
	 * config
	private $_user;
    private $_pass;
    private $_url;
	private $_imgMaxWidth;
	private $_imgMaxHeight;
	private $_path;
	 */

	const DELIMITER = '|';
	/**
	 * internals
	 */
	private $_client;
	private $_title;
	private $_content;
	private $_tags;
	private $_categories;
	private $_excerpt;
	private $_postData = array();
	/**
	 * Creates a client instance for XML-RPC requests and sets the post's
	 * initial content.
	 * @param string $htmlString	Sets the post's initial content.
	 * @param string $identifier	Fetches the correct set of config data.
	 	public function __construct($identifier)
	{
	    $config = parse_ini_file('config.ini', true);
	    if (!isset($config[$identifier])) {
	        exit("could not find identifier '$identifier'");
	    }
	    $config = $config[$identifier];
	    $this->_user = $config['user'];
	    $this->_pass = $config['pass'];
	    $this->_url = $config['url'];
	    $this->_author = $config['max_width'];
		$this->_imgMaxHeight = $config['max_height'];
		$this->_path = $config['path'];
		}
	 * Creates a new post.
	 * The post itself remains empty, since we may have to replace html markup.
	 * @return int The inserted post's ID.
	 */
	 public function createPostnImg($title,$keywords,$category,$post_excerpt,$body, $image)
	{
		// Gather post data.
$my_post = array(
    'post_title'    => $title,
    'post_content'  => $body,
<<<<<<< .merge_file_a11116
=======
	'post_type' => 'post',
>>>>>>> .merge_file_a06056
     'post_excerpt'  => $post_excerpt,
	 'post_status'   => 'publish',
    'post_author'   => 1,
    'post_category' => array( $category )
	);
 
<<<<<<< .merge_file_a11116
	$post_id = wp_insert_post( $my_post, $wp_error );
	
	wp_set_post_tags( $post_id, $keywords, 'true' )
=======
	$post_id = wp_insert_post( $my_post,'true' );
	
	wp_set_post_tags( $post_id, $keywords, 'true' );
>>>>>>> .merge_file_a06056
	
	//wp_set_post_categories( $post_id, $_categories, 'true' );
	return ($post_id);
}

	public function createPost($title,$keywords,$category,$post_excerpt,$body)
	{
	//	$customfields=array('key'=>'sourceFeed', 'value'=>$source); // Custom field
		$title = htmlentities($title,ENT_NOQUOTES,$encoding);
		$keywords = htmlentities($keywords,ENT_NOQUOTES,$encoding); 
		$post_excerpt = htmlentities($post_excerpt,ENT_NOQUOTES,$encoding); 
		$content = array(
             'title'=>$title,
             'description'=>$body,
             'mt_allow_comments'=>0,
             'mt_allow_pings'=>0, 
             'post_type'=>'post',
             'mt_keywords'=>$keywords,
             'categories'=>array($category),
			// 'custom_fields' => array($customfields),
             'date_created_gmt' => $date
          );
//$params = array(1,$user,$pass,$content,true); // set true if you need to publish post, set false if you need set your post as draft
<<<<<<< .merge_file_a11116
		$data = $wp_insert_post($content, $wp_error);
	} catch (Exception $e){
		var_dump ( $e->getMessage ());
		}
=======
		$data = $wp_insert_post($content, 'true');
	
>>>>>>> .merge_file_a06056
		return ($data);
	}

	public function saveImage($imgurl)
	{
		//add time to the current filename
$name = basename($imgurl);
list($txt, $ext) = explode(".", $name);
$name = $txt.time();
$name = $name.".".$ext;
//check if the files are only image / document
if($ext == "jpg" or $ext == "png" or $ext == "gif" or $ext == "doc" or $ext == "docx" or $ext == "pdf"){
//here is the actual code to get the file from the url and save it to the uploads folder
//get the file from the url using file_get_contents and put it into the folder using file_put_contents
$upload = file_put_contents($path."/wp-contents/uploads/".$name,file_get_contents($imgurl));
//check success
if($upload){
uploadAttachImage($upload, $data);
} else {
	echo "error";
}
}
}
	
	public function uploadAttachImage($image, $postId)
	{
	// $filename should be the path to a file in the upload directory.
$filename = $image;
// The ID of the post this attachment is for.
$parent_post_id = $postId;
// Check the type of file. We'll use this as the 'post_mime_type'.
$filetype = wp_check_filetype( basename( $filename ), null );
// Get the path to the upload directory.
$wp_upload_dir = wp_upload_dir();
// Prepare an array of post data for the attachment.
$attachment = array(
	'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
	'post_mime_type' => $filetype['type'],
	'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	'post_content'   => '',
	'post_status'    => 'inherit'
);
// Insert the attachment.
$attach_id = wp_insert_attachment( $attachment, $filename, $postId );
// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
require_once( $url.'/wp-admin/includes/image.php' );
// Generate the metadata for the attachment, and update the database record.
$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
wp_update_attachment_metadata( $attach_id, $attach_data );
set_post_thumbnail( $postId, $attach_id );
return ($attach_id);
	}
	
	public function replaceImageMarkup($body)
	{
		$pattern = '<img src="([^"]+)" alt="([^"]+)" (title="([^"]+)" )?/>';
		$pattern = self::DELIMITER . $pattern . self::DELIMITER;
		$matches = preg_replace_callback(
			$pattern,
			"autoTPost::_replaceImages",
			$body
		);
		
	}
	/**
	 * @param array $matches	Contains complete match (index 0) first submatch
	 * 	(image source, index 1) and second submat(image title, index 2)
	 * @return string $output	The updated output.
	 */
	private function _replaceImages($matches)
	{
		$path = $matches[1];
		$title = $matches[2];
		// read picture data
		if (!file_exists($path))
			$this->_displayError('checking file', "File $path does not exist!");
		if (!$filestream = file_get_contents($path))
			$this->_displayError('checking file', "Could not get contents");
		// set variables
		$fileMeta = $this->_extractFilenameData($path);
		$filename = $fileMeta['basename'] . $fileMeta['extension'];
		$sizeData = getimagesize($path);
		$type = $sizeData['mime'];
		$width = $sizeData[0];
		$height = $sizeData[1];
		// adjust dimensions if necessary
		$sizeAppend = "";
		if ($width > $this->_imgMaxWidth && $width >= $height) {
			$ratio = $this->_imgMaxWidth / $width;
			$width = $this->_imgMaxWidth;
			$height = floor($height * $ratio);
			$sizeAppend = "-{$width}x{$height}";
		} elseif ($height > $this->_imgMaxHeight && $width < $height) {
			$ratio = $this->_imgMaxHeight / $height;
			$height = $this->_imgMaxHeight;
			$width = floor($width * $ratio);
			$sizeAppend = "-{$width}x{$height}";
		}
	}
}