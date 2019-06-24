<?php 
	
	if (isset($_POST['login_btn'])) {  // If Login Button pressed
		$email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL); //Sanitize Email Adress
		$SESSION['login_email'] = ""; //Store email in session variable
		$password = md5($_POST['login_password']); //Get Password

		$check_database_query = mysqli_query($con,"SELECT * FROM user_information WHERE email_ = '$email' AND password = '$password'"); // Search the Entire table for Email and Password
		$check_login_query = mysqli_num_rows($check_database_query);

		if ($check_login_query == 1) {
			$row = mysqli_fetch_array($check_database_query); //Store Database data in to $row array
			$username = $row['username'];		//Access the username colum 
			$SESSION['username'] = $username;	//Store username in Session Variable

			header("Location: index.php");
		}
	}
 ?>