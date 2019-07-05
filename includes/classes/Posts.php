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


		public function loadPostsHome(){
			$str = ""; //String to return
			$data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted = 'no' ORDER BY id DESC");

			while($row = mysqli_fetch_array($data)){
				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_time_added = $row['date_added'];

				//Include User if added From home
				if ($row['added_to'] == "none") {
					$added_to = "";
				}else{
					$added_obj = new User($con, $row['added_to']);
					$added_to_name = $added_to_obj->getName();
					$added_to = "to <a href='". $row['added_to']. "'>". $added_to_name ."</a>";
				}

				//Check if the User_by's account is closed
				$added_by_obj = new User($this->con, $added_by);
				if ($added_by_obj->isClosed()) {
					continue;		//if closed continue from "while"
				}

				//Get User Information 
				$user_detail_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_photo FROM user_information WHERE username = '$added_by'");
				$user_row = mysqli_fetch_array($user_detail_query);
				$first_name =	$user_row['first_name'];
				$last_name 	= 	$user_row['last_name'];
				$profile_photo =	$user_row['profile_photo'];



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
					if ($interval-> d == 1) {
						$time_msg = $interval-> d. " day ago";
					}else{
						$time_msg = $interval-> d." days ago";
					}
				}

				//Hour Old
				elseif ($interval-> h >=1) {
					if ($interval-> h == 1) {
						$time_msg = $interval-> h. " hour ago";
					}else{
						$time_msg = $interval-> h. " hours ago";
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


				//Display Post  **NOTE: "&nbsp" is used for none line_break spaces.**
				$str .= "<div class = 'status_post'  >

								<div class='post_pro_photo' style = 'color: #636e72; text-shadow: 0.5px 0.5px 0.5px #2d3436;' >
									<img src = '$profile_photo' height = '50'>
									
								</div >
									
								<div class = 'posted_by'>
									<a href='$added_by'> $first_name $last_name </a> $added_to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$time_msg

								</div>

								<div id='post_body' style = 'color: #000000;' font: 'sans-serif;' font-size: '14;' >
									<br>
								 	$body
								 	<br>	
								</div>
							</div>
							<hr>";
			}

			if ($str == "") {
				echo "No Posts to show";
			}else{
				echo $str;	
			}
					//return the String 
		}
	}
?>

