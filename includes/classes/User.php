<?php 
	class User {
		private $user, $con;

		public function __construct($con, $user){
			$this->con = $con;
			$user_details_query = mysqli_query($con, "SELECT * FROM user_information WHERE username = '$user'");
			$this->user = mysqli_fetch_array($user_details_query);
		}


		public function getUsername(){
			return $this->user['username'];
		}

		public function getNumPost(){
			$username = $this->user['username'];
			$query = mysqli_query($this->con, "SELECT num_posts From user_information WHERE username = '$username'");
			$row = mysqli_fetch_array($query);
			return $row['num_posts'];
		}

		public function getName(){
			$username = $this->user['username'];
			$query = mysqli_query($this->con, "SELECT first_name, last_name From user_information WHERE username = '$username'");
			$row = mysqli_fetch_array($query); 
			return $row['first_name']." " .$row['last_name'];
		
		}
		public function getProfilePhoto(){
			$username = $this->user['username'];
			$query = mysqli_query($this->con, "SELECT profile_photo From user_information WHERE username = '$username'");
			$row = mysqli_fetch_array($query); 
			return $row['profile_photo'];
		}

		public function isClosed(){
			$username = $this->user['username'];
			$query = mysqli_query($this->con, "SELECT user_active FROM user_information WHERE username = '$username'");
			$row = mysqli_fetch_array($query);

			if ($row['user_active'] == 'no'){			//if closed
				return true; 
			}else {	
				return false;
			}
			
		}

		public function isFriend($username_friend){
			$usernameF = ",".$username_friend.",";

			if ((strstr($this->user['friends_list'], $usernameF)) || $username_friend == $this->user['username']){
				return true;
			}
			else{
				return false;
			}


		}

	}
 ?>