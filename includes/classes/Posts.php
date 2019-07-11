<?php 
class Posts{
	private $user_obj, $con;
	
	public function __construct($con, $user){
		$this->con = $con;
		$this->user_obj = new User($con,$user);
	}

	public function submitPost($body, $added_to){

		$body = strip_tags($body);
		$body = mysqli_real_escape_string($this->con, $body);
		$check_empty = preg_replace('/\s+/', "", $body);

		if ($check_empty != "") {
			//Get the Date and Time of post
			$date_added = date("Y-m-d H:i:s");

			//Get Username
			$added_by = $this->user_obj->getUsername();	

			if ($added_by == $added_to) {
				$added_to = "none";
			}

			$query = mysqli_query($this->con, "INSERT INTO posts VALUES ('', '$body','$added_by','$added_to','$date_added','no','no','0')");
			$return_id = mysqli_insert_id($this->con);

			//Update Posts
			$num_post = $this->user_obj->getNumPost();
			$num_post++;
			$update_query = mysqli_query($this->con, "UPDATE user_information SET num_posts = '$num_post' WHERE username = '$added_by'");

	 	}
	}


	public function loadPostsHome($data, $limit){

		$page = $data['page'];
		$user_logged_in = $this->user_obj->getUsername();
		if ($page == 1)
			$start = 0;
		else
			$start = ($page - 1) * $limit;

		$str = ""; //String to return
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted = 'no' ORDER BY id DESC");


		if (mysqli_num_rows($data_query)> 0){

			$num_iteration = 0;
			$count_post_loaded = 1;
			while ($row = mysqli_fetch_array($data_query)){
				$id = $row['id'];
				$body = $row['body']; 
				$added_by = $row['added_by'];
				$date_time_added = $row['date_added'];
				
				//Include User if added From home
				if ($row['added_to'] == "none") {
					$added_to = "";
				}else{
					$added_to_obj = new User($this->con, $row['added_to']);
					$added_to_name = $added_to_obj->getName();
					$added_to = "to <a href='". $row['added_to']. "'>". $added_to_name ."</a>";
				}

				//Check if the User_by's account is closed
				$added_by_obj = new User($this->con, $added_by);
				if ($added_by_obj->isClosed()) {
					continue;		//if closed continue from "while"
				}

				//check If user is in friend arrray. only load posts from friends
				$user_logged_obj = new User ($this->con, $user_logged_in);
				if ($user_logged_obj->isFriend($added_by)) {
					
					//if the number iteration is lower than Start
					if ($num_iteration++ < $start)
						continue;

					//If 10 posts are loaded then Break out of loop
					if ($count_post_loaded > $limit){
						break;
					}
					else{
						$count_post_loaded++; 
					}


					//If the user is the the same show delete button
					if ($user_logged_in == $added_by) {
						echo $added_by;
						$delete_button = "<button class='delete_button btn-danger' id='button_post$id'>x</button>";
					}else{

						$delete_button = "";
					}

					//Get User Information 
					$user_detail_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_photo FROM user_information WHERE username = '$added_by'");
					$user_row = mysqli_fetch_array($user_detail_query);
					$first_name =	$user_row['first_name'];
					$last_name 	= 	$user_row['last_name'];
					$profile_photo =	$user_row['profile_photo'];
					
					?>



					<!--if comment is clicked change view-->
					<script>
						function toggle<?php echo $id;?>(){
							var target = $(event.target);
							if (!target.is("a")){

								var element = document.getElementById("toggleComment<?php echo $id;?>");
								if (element.style.display == "block")
									element.style.display = "none";
								else
									element.style.display = "block";
							}
							
						}
					</script>


					<?php
					//TimeFrame
					$date_time_current = date("Y-m-d H:i:s");
					$start_date_time = new DateTime($date_time_added);		//Time Posted
					$end_date_time = new DateTime($date_time_current);			//Current Time
					$interval = $start_date_time->diff($end_date_time);			//Interval between the 2 times

					
					//Year Old
					if ($interval-> y >= 1) {
						if ($interval-> y == 1) 
							$time_msg = $interval->y. " year age";
						else
							$time_msg = $interval->y. " years ago"; 
					}
					
					//month Old
					elseif ($interval-> m >=1) {

						if ($interval-> d == 0){
							$days = "ago";
						}elseif($interval-> d ==1){
							$days = $interval-> d. " day ago";
						}else{
							$days = $interval->d. " days ago";	
						}

						if ($interval-> m == 1) {
							$time_msg = $interval-> m . " month" . $days;
						}else{
							$time_msg = $interval-> m . " months" . $days;
						}
					}
					
					//Day Old
					elseif ($interval-> d >=1) {
						if ($interval-> d == 1)
							$time_msg = $interval-> d. " day ago";
						else
							$time_msg = $interval-> d." days ago";
						
					}
					//Hour Old 
					elseif ($interval-> h >=1) {
						if ($interval-> h == 1) {
							$time_msg = $interval-> h. " hour ago";
						}else{
							$time_msg = $interval-> h." hours ago";
						}
					}

					//Minute Old
					elseif ($interval-> i >= 1) {
						if ($interval-> i == 1) {
							$time_msg = $interval-> i. " minute ago";
						}else{
							$time_msg = $interval-> i." minutes ago";
						}
					}

					//Second Old
					else {
						if ($interval-> i<30){
							$time_msg = "just now";
						}
						elseif ($interval-> s == 1) {
							$time_msg = $interval-> s. " day ago";
						}else{
							$time_msg = $interval-> s." days ago";
						}						
					}
					$str .="<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_pro_photo'>
									<img src = '$profile_photo' height = '50'>
								</div>

								<div class = 'posted_by'>
									<a href='$added_by'> $first_name $last_name </a> $added_to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$time_msg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$delete_button
								</div>

								<div id='post_body'>
									<br>
								 	$body
								 	<br>
								</div>

								<div class='post_comment' id = 'toggleComment$id' style = 'display: none;'>
								<iframe src = 'comment_section.php?post_id=$id' id = 'commnet_iframe'></iframe>
								</div>

							</div>
							<hr>";		
					} 

			?>



			<!--Gets the DELETE Button ID and passes the Post ID to delete_post.php-->
			<script>
				$(document).ready(function(){
					$('#button_post<?php echo$id;?>').on('click',function(){
						bootbox.confirm({
						    message: "This is a confirm with custom button text and color! Do you like it?",
						    buttons: {
						        confirm: {
						            label: 'DELETE',
						            className: 'btn-success'
						        },
						        cancel: {
						            label: 'GO BACK',
						            className: 'btn-danger'
						        }
						    },
						    callback: function (result) {
						        $.post("includes/form_handlers/delete_post.php?post_id=<?php echo$id; ?>", {result:result});
						        	
						        if(result)
										location.reload();

						    }
						});	

					});
				});
			</script>



			<?php

			
			}	//end While loop
			

			//Ajax Load Posts
			if($count_post_loaded > $limit) 
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
							<input type='hidden' class='no_morePosts' value='false'>";
			else 
				$str .= "<input type='hidden' class='no_morePosts' value='true'><p style='text-align: centre;'> No more posts to show! </p>";
			
		}
		echo $str;
	}
}
?>