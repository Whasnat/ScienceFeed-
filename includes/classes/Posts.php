<?php 
	class Posts {
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
	}
?>

