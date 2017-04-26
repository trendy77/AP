<?php
require_once ( 'IXRlib.php' );

class autoTPost
{
	/**
	 * config
	 */
	private $_user;
    private $_pass;
    private $_url;
	private $_imgMaxWidth;
	private $_imgMaxHeight;
	private $_path;

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
	 */
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
	/**
	 * Creates a new post.
	 * The post itself remains empty, since we may have to replace html markup.
	 * @return int The inserted post's ID.
	 */
	public function createPostnImg($title,$keywords,$category,$post_excerpt,$body, $image)
	{
		$user = $this->_user;
		$pass = $this->_pass;
		$url = $this->_url."/xmlrpc.php";
		$path = $this->_path;
		$XmlRpc_result = null;
		$XmlRpc_client = new IXR_Client ($url);
		$date = new IXR_Date(strtotime('now') ); // writing publish date
		$encoding='UTF-8';
		//$customfields=array('key'=>'sourceFeed', 'value'=>$source); // Custom field
		$title = htmlentities($title,ENT_NOQUOTES,$encoding);
		$keywords = htmlentities($keywords,ENT_NOQUOTES,$encoding); 
		$post_excerpt = htmlentities($post_excerpt,ENT_NOQUOTES,$encoding); 
		$content = array(
             'title'=>$title,
             'description'=>$body,
             'mt_allow_comments'=>0, // 1 to allow comments
             'mt_allow_pings'=>0, // 1 to allow trackbacks
             'post_type'=>'post',
             'mt_keywords'=>$keywords,
             'categories'=>array($category),
		//	 'custom_fields' => array($customfields),
             'date_created_gmt' => $date
          );
		// Gather post data.
$my_post = array(
    'post_title'    => 'My post',
    'post_content'  => 'This is my post.',
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_category' => array( 8,39 )
);
 
$post_id = wp_insert_post( $my_post, $wp_error );
	return ($post_id);
	}
/*	
	public function createPost($title,$keywords,$category,$post_excerpt,$body)
	{
		$user = $this->_user;
		$pass = $this->_pass;
		$url = $this->_url."/xmlrpc.php";
		$XmlRpc_result = null;
		$XmlRpc_client = new IXR_Client ($url);
		$date = new IXR_Date(strtotime('now') ); // writing publish date
		$encoding='UTF-8';
	//	$customfields=array('key'=>'sourceFeed', 'value'=>$source); // Custom field
		$title = htmlentities($title,ENT_NOQUOTES,$encoding);
		$keywords = htmlentities($keywords,ENT_NOQUOTES,$encoding); 
		$post_excerpt = htmlentities($post_excerpt,ENT_NOQUOTES,$encoding); 
		$content = array(
             'title'=>$title,
             'description'=>$body,
             'mt_allow_comments'=>0, // 1 to allow comments
             'mt_allow_pings'=>0, // 1 to allow trackbacks
             'post_type'=>'post',
             'mt_keywords'=>$keywords,
             'categories'=>array($category),
			// 'custom_fields' => array($customfields),
             'date_created_gmt' => $date
          );
		$params = array(1,$user,$pass,$content,true); // set true if you need to publish post, set false if you need set your post as draft
			try{
			$XmlRpc_result = $XmlRpc_client->query(
			'metaWeblog.newPost',$params
		);
		$data = $XmlRpc_client->getResponse();
		}
		catch (Exception $e){
		var_dump ( $e->getMessage ());
		}
		return ($data);
	}
	*/
	public function saveImage($imgurl)
	{
		//add time to the current filename
$name = basename($imgurl);
list($txt, $ext) = explode(".", $name);
$name = $txt.time();
$name = $name.".".$ext;
	$user = $this->_user;
	$pass = $this->_pass;
	$url = $this->_url;
	$path = $this->_path;
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
$url = $this->_url;
$path = $this->_path;
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
		/* upload picture
		$user = $this->_user;
		$pass = $this->_pass;
		$data = array(
			'name' => $filename,
			'type' => $type,
			'bits' => new IXR_Base64($filestream)
		);
		if (!$this->_client->query('wp.uploadFile', 1, $user, $pass, $data))
			$this->_displayError("uploading photo $path");
		$response = $this->_client->getResponse();
		$imageID = $response['id'];
		$imageUrl = $response['url'];
		$fileMeta = $this->_extractFilenameData($imageUrl); // necessary for building image-URL
		// add title and other data
		$data = array(
			'post_title' => $title,
			'post_excerpt' => $title,
			'post_content' => $title
		);
		if (!$this->_client->query('wp.editPost', 1, $user, $pass, $imageID, $data))
			$this->_displayError("editing photo $path");
		// prepare output
		$titleEscaped = htmlspecialchars($title);
		$srcFinal = $fileMeta['basepath'] . $fileMeta['basename'] . $sizeAppend . $fileMeta['extension'];
		$output = "[caption id='attachment_$imageID' align='aligncenter' width='$width']";
		$output.= "<a href='$imageUrl'>";
		$output.= "<img class='wp-image-$imageID' title='$titleEscaped' src='$srcFinal' alt='$titleEscaped' width='$width' height='$height' />";
		$output.= "</a> {$title}[/caption]";
		return $output;
	}
	**
	 * Returns an image's file' basepath, basename and extension.
	 * @param string $path	The image's path.
	 * @return array		Contains basepath, basename and extension.
	 */
	private function _extractFilenameData($path)
	{
		if ($indexOfLastSlash = strrpos($path, '/')) {
			$filename = substr($path, $indexOfLastSlash + 1);
			$basepath = substr($path, 0, $indexOfLastSlash + 1);
		} else {
			$filename = $path;
			$basepath = '';
		}
		$indexOfLastDot = strrpos($filename, '.');
		$basename = substr($filename, 0, $indexOfLastDot);
		$extension = substr($filename, $indexOfLastDot);
		return array(
			'basepath' => $basepath,
			'basename' => $basename,
			'extension' => $extension
		);
	}
	/**
	 * Adds taxonomy items as metadata.
	 *
	 * @param string $key
	 * @param array $data
	 */
	private function _addTaxonomyItems($key, $data)
	{
		if (isset($this->_postData['terms_names']))
			$this->_postData['terms_names'][$key] = $data;
		else
			$this->_postData['terms_names'] = array($key => $data);
	}
	/**
	 * Displays error message and quits execution.
	 *
	 * @param string $position	Position where error occured.
	 * @param string $msg		The message to display.
	 */
	private function _displayError($position, $msg = '')
	{
		if (empty($msg)) {
			$code = $this->_client->getErrorCode();
			$msg = $this->_client->getErrorMessage();
		} else
			$code = '666';
		echo "Position: $position<br />";
		exit("An error occurred - $code: $msg");
	}
}