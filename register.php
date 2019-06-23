<?php 
$con = mysqli_connect("localhost", "root","","sciencefeed"); //connection variables

//Connection Error Message
if (mysqli_connect_errno()){
	echo "failed to connect to database: ".mysqli_connect_errno();
}


// Declaring variables to prevent Errors
$fname = "";	//First Name
$lname = "";	//Last Name
$em = "";	//Email
$em2 = "";	//Email 2
$password = "";	//Password
$password2 = "";	//password 2
$date = "";	//dateTime
$error_array = "";	//Error messages are stored here

	// On Submit clickListener
	if (isset($_POST['reg_btn'])) {

		//Register form Values, formating
		$fname = strip_tags($_POST['reg_fname']); 	//	Remove any Unwanted tags from First name
		$fname = str_replace(' ', '', $fname); 	  	//	Replace any white spaces 
		$fname = ucfirst(strtolower($fname));		//	Set first charechter to Upper case

		$lname = strip_tags($_POST['reg_lname']);	// Remove any Unwanted tags from Last name
		$lname = str_replace(' ', '', $lname);		//	Replace any white spaces 
		$lname = ucfirst(strtolower($lname));		//	Set first charechter to Upper case

		$em = strip_tags($_POST['reg_email']);	// Remove any Unwanted tags from Email
		$em = str_replace(' ', '', $em);		//	Replace any white spaces 
		$em = ucfirst(strtolower($em));			//	Set first charechter to Upper case

		$em2 = strip_tags($_POST['reg_email2']);	// Remove any Unwanted tags from Email 2
		$em2 = str_replace(' ', '', $em2);			//	Replace any white spaces 
		$em2 = ucfirst(strtolower($em2));			//	Set first charechter to Upper case

		$password = strip_tags($_POST['reg_pass']);		// Remove any Unwanted tags from Password
		$password2 = strip_tags($_POST['reg_pass2']);	// Remove any Unwanted tags from Password 2

		$date = date("Y-m-d");		//Date of registration



		/**************************************
		*This Block Checks if the Emails match*
		***************************************/
		if ($em == $em2) {

			//Check if the email is in correct formate
			if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
				$em = filter_var($em, FILTER_VALIDATE_EMAIL);

				//Check if email already exists in the DB
				//finds match for email in DB *(connection Var, SELECT Column FROM table where Column = "")*
				$em_check = mysqli_query($con, "SELECT email_ FROM user_information WHERE email_ = '$em'"); 

				//count the numbers of rows returned
				$num_rows = mysqli_num_rows($em_check);
				if ($num_rows > 0) {
					echo "Email already in use";
				}else{
					echo "Congratulations! you've successfully joined Science Feed";
				}
			}else{
				echo"Invalid Email Address";
			}
		}else{
			echo "Emails Don't match";
		}


		/***************************************
		 *This Block Checks if the Emails match* 
		****************************************/
		if ($password == $password2) {

			//$password = filter_var($password, FILTER_VALIDATE_PASSWORD);

		}else{
			echo "Passwords Do not match";
		}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<form action="register.php" method="POST">

		<input type="text" name="reg_fname" placeholder="First Name" required>
		<br>
		<input type="text" name="reg_lname" placeholder="Last Name" required>
		<br>
		<input type="email" name="reg_email" placeholder="Email" required>
		<br>
		<input type="text" name="reg_email2" placeholder="Confirm Email" required>
		<br>
		<input type="password" name="reg_pass" placeholder="Password" required>
		<br>
		<input type="password" name="reg_pass2" placeholder="Confirm Password" required>
		<br>
		<input type="submit" name="reg_btn" value="Register"> 


	</form>
</body>
</html>