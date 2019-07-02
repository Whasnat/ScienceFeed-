<?php 
	include("includes/header.php");
	?>
		<!--The Left Side Profile Column-->
	 	<div class="user_detail column">
	 	 	<img src="<?php echo $user['profile_photo']?>">
	 		<br>
	 		<a href="#"><?php echo $user['first_name']. " ".$user['last_name'];?> </a>
		 	<br>

	 		<div class="user_detail_bottom">	 		
		 		<a href="#"><?php echo "Posts:".$user['num_posts']."<br>". "Likes:".$user['num_likes']; ?></a>
	 		</div>
	 	</div>
		<!--======================================================================================================-->
	 	

	 	<!--The Main Newsfeed Column-->
	 	<div class="newsfeed_column column">

	 		<!--Status update Section-->
	 		<form class="status_section">
		 		<img src="<?php echo $user['profile_photo']?>">
		 		<input type="text" name="status_input" placeholder="What's on your mind?" value="<?php ?>">
		 		<input type="submit" name="update_status" value="Update">
		 	</form>

	 	</div>
		<!--=====================================================================================================-->
	</div>		<!--end of wrapper-->
</body>
</html> 