<?php
#- all   v80.2 beta
include 'tPost.php';
$identifier = $_POST['identifier'];
$title=$_POST['post_title'];// your post title
$keywords=$_POST['tags'];$category=$_POST['categories'];
$post_excerpt=$_POST['post_excerpt'];$body=$_POST['post_content'];

$obj= new autoTpost($identifier);
$obj->replaceImageMarkup($body);
echo $obj->createPost($title,$keywords,$category,$post_excerpt,$body);
?>