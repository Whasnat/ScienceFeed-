<?php 
include ("../../config/config.php");
include ("../classes/User.php");
include ("../classes/Posts.php");

$limit = 10;		//Set limit to show 10 posts at a time
$posts = new Posts($con, $_REQUEST['user_logged_in']);
$posts-> loadPostsHome($_REQUEST, $limit);
?>