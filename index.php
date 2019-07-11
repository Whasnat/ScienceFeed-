<?php 
	include("includes/header.php");
	include("includes/classes/User.php");
	include("includes/classes/Posts.php");

	//See If user still Logged In
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
	 	


	 	<!--The status_update Column-->
	 	<div class="post_column column">
	 		<!--Status update Section-->
	 		<form class="status_section" action="index.php" method="POST">
		 		<img src="<?php echo $user['profile_photo']?>">
		 		<textarea name="post_text" id="post_text" placeholder="What's on your mind?..."></textarea>
		 		<input type="submit" name="update_status" value="Post">
		 	</form>
		 	<br>


	 	</div>
		<!--=====================================================================================================-->

		<!--Status feed Column-->
		<div class="status_view column">
			<div class="posts_section"></div>
			<img id="loading"	src="assets/images/icons/loading.gif">
		</div>

	<script>
		var user_logged_in = '<?php echo $user_logged_in; ?>';

		$(document).ready(function(){
			$('#loading').show();//show loading icon

			//Loads the First posts in the resting Window
			$.ajax({
				url: "includes/handlers/ajax_load_posts.php",	//Sends Request to show posts
				type: "POST",
				data: "page=1&user_logged_in=" + user_logged_in,	
				cache: false, 	

				success: function(data){			
					$('#loading').hide;			//if succeed hide the loading icon
					$('.posts_section').html(data); 	//show Posts
				} 
			});
			//***************************************************//



			$(window).scroll(function() {
				var height = $('.posts_section').height();		//Div Containing posts
				var scroll_top = $(this).scrollTop(); 
				var page = $('.posts_section').find('.nextPage').val();
				var no_morePosts = $('.posts_section').find('.no_morePosts').val();
				

				//If posts run out in a page load more posts
				if ((document.body.scrollHeight == document.body.scroll_top + window.innerHeight) && no_morePosts == 'false') {	

					$('#loading').show();		//Show the Loading icon 


					var ajaxReq = $.ajax({					//repeat the process in requesting Posts

						url: "includes/handlers/ajax_load_posts.php",
						type: "POST",
						data: "page=" + page + "&user_logged_in=" + user_logged_in,
						cache: false,

						success: function(response){
							$('.posts_section').find('.nextPage').remove();
							$('.posts_section').find('.no_morePosts').remove();
 	
							$('#loading').hide();
							$('.posts_section').append(response);
						}
					});
				} //End If

				return false;

			}); // End of (window).scroll(function() 

		});

	</script>
	</div>		<!--end of wrapper-->
</body>
</html> 