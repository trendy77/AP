<?php 
// gets ID only
$term_list = wp_get_post_terms($post->ID, 'coursecat', array("fields" => "ids"));
$term->id = $term_list[0];

// gets all term info
$term_list_test = get_the_terms( $post->ID, 'coursecat' );
print_r( $term_list_test );


$post_thumbnail_id = get_post_thumbnail_id( $post_object->ID ); 
echo $post_thumbnail_id;
$postimage = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
?>
<img src="<?php echo $postimage[0]; ?>" width="<?php echo $postimage[1]; ?>" height="<?php echo $postimage[2]; ?>">