<?php 
	include("includes/header.php");
	include("includes/classes/User.php");
	include("includes/classes/Posts.php");

	if (isset($_POST['update_status'])) {
		$post = new Posts($con, $user_logged_in);
		$post-> submitPost($_POST['post_text'], "none");
	}

	?>
		<!--The Left Side Profile Column-->
	 	<div class="user_detail column">
	 	 	<img src="<?php echo $user['profile_photo']?>">
	 		<br>
	 		<a href="<?php echo $user_logged_in;?>"><?php echo $user['first_name']. " ".$user['last_name'];?> </a>
		 	<br>

	 		<div class="user_detail_bottom">	 		
		 		<a href="<?php echo $user_logged_in;?>"><?php echo "Posts:".$user['num_posts']."<br>". "Likes:".$user['num_likes']; ?></a>
	 		</div>
	 	</div>
		<!--======================================================================================================-->
	 	

	 	<!--The Main Newsfeed Column-->
	 	<div class="newsfeed_column column">

	 		<!--Status update Section-->
	 		<form class="status_section" action="index.php" method="POST">
		 		<img src="<?php echo $user['profile_photo']?>">
		 		<textarea name="post_text" id="post_text" placeholder="What's on your mind?..."></textarea>
		 		<input type="submit" name="update_status" value="Post">
		 	</form>
		 	<br>

		 	<?php 
	 			$user_obj = new User($con, $user_logged_in);
	 			echo $user_obj->getName();  
		 	?> 

	 	</div>
		<!--=====================================================================================================-->


	</div>		<!--end of wrapper-->
</body>
</html> 