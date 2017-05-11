
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
	