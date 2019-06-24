<?php 
session_start();
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
$error_array = array();	//Error messages are stored in this Array

	// On Submit clickListener
	if (isset($_POST['reg_btn'])) {

		//Register form Values, formating & Session var
		$fname = strip_tags($_POST['reg_fname']); 	//	Remove any Unwanted tags from First name
		$fname = str_replace(' ', '', $fname); 	  	//	Replace any white spaces 
		$fname = ucfirst(strtolower($fname));		//	Set first charechter to Upper case
		$_SESSION['reg_fname'] = $fname;			// Stores First name into Session Var

		$lname = strip_tags($_POST['reg_lname']);	// Remove any Unwanted tags from Last name
		$lname = str_replace(' ', '', $lname);		//	Replace any white spaces 
		$lname = ucfirst(strtolower($lname));		//	Set first charechter to Upper case
		$_SESSION['reg_lname'] = $lname;			// Stores Last name into Session Var

		$em = strip_tags($_POST['reg_email']);	// Remove any Unwanted tags from Email
		$em = str_replace(' ', '', $em);		//	Replace any white spaces 
		$em = ucfirst(strtolower($em));			//	Set first charechter to Upper case
		$_SESSION['reg_email'] = $em;			// Stores email into Session Var

		$em2 = strip_tags($_POST['reg_email2']);	// Remove any Unwanted tags from Email 2
		$em2 = str_replace(' ', '', $em2);			//	Replace any white spaces 
		$em2 = ucfirst(strtolower($em2));			//	Set first charechter to Upper case
		$_SESSION['reg_email2'] = $em2;				// Stores email 2 into Session Var

		$password = strip_tags($_POST['reg_pass']);		// Remove any Unwanted tags from Password
		$password2 = strip_tags($_POST['reg_pass2']);	// Remove any Unwanted tags from Password 2

		$date = date("Y-m-d");		//Date of registration



		/*****************************************
		* This Block Validates the Email address *
		******************************************/
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
					 array_push($error_array, "Email already in use<br>");
				}

			}else{
				array_push($error_array,"Invalid Email Address<br>");
			}
		}else{
			array_push($error_array, "Emails Don't match<br>");
		}
 		/*---------------------------------------------------------------------------------------------------------------*/


		/************************************
		* This Block Validates the Password * 
		*************************************/
		if ($password != $password2) {
			array_push($error_array, "Passwords do not match<br>");
		}else{
			//Checks if the Password caontain any Invalid charachters
			if (preg_match('/[^A-Za-z0-9]/', $password)) {
			 	array_push($error_array,"Password can only contain numbers & letters<br>");
			}
		}
		 if (strlen($password)>30 || strlen($password)<5) {
		 	array_push($error_array, "Your password should be between 5 to 30 charachters<br>");
		 }
		/*---------------------------------------------------------------------------------------------------------------*/

		/**************************************
		* This Block Validates the User names * 
		***************************************/
		if (strlen($fname) >30 || strlen($fname) <2) {
			array_push($error_array, "Your First name must be between 2 to 30 charachters<br>");
		}elseif (strlen($lname) >30 || strlen($lname) <2) {
			array_push($error_array, "Your Last name must be between 2 to 30 charachters<br>");
		}
		/*---------------------------------------------------------------------------------------------------------------*/


		/****************************
		* Adding Values to Database * 
		*****************************/

		 if (empty($error_array)) {			//if there is no error
		 	$password = md5($password);		//Encrypt password into md5 

		 	//Genetrate a Username by joining/contatening First and last name
		 	$username = strtolower($fname . "." . $lname);

		 	//check DB for maching usernames
		 	$check_username_query = mysqli_query($con, "SELECT username FROM user_information WHERE username = '$username'");


		 	/* If matching Username is found than add 1 to username and Check again
				check untill no match is found */
		 	$i=0;
		 	while (mysqli_num_rows($check_username_query) !=0 ) {
		 		$i++;
		 		$username = $username . "_" . $i;
		 		$check_username_query = mysqli_query($con, "SELECT username FROM user_information WHERE username = '$username'");
		 	}

		 	//Assign a default profile Photo to user
		 	$rand = rand(1,2);
		 	if($rand ==1){
		 		$profile_pic = "assets/images/profile_pics/default_male.png";
		 	}elseif ($rand ==2) {
		 		$profile_pic = "assets/images/profile_pics/default_female.png";
		 	}

		 	$query = mysqli_query($con,"INSERT INTO user_information VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','yes',',')");

		 }

	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<form action="register.php" method="POST" class="register-box">
		<!--First Name-->
		<input type="text" name="reg_fname" placeholder="First Name" value="<?php 
		if(isset($_SESSION['reg_fname'])){
			echo $_SESSION['reg_fname'];
		}?>" required>
		<br>
		<?php if (in_array("Your First name must be between 2 to 30 charachters<br>", $error_array)) {
			echo "Your First name must be between 2 to 30 charachters<br>";
		} ?>

		<!--Last Name-->
		<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
		if(isset($_SESSION['reg_lname'])){
			echo $_SESSION['reg_lname']; }
		?>" required>
		<br>
		<?php if (in_array("Your Last name must be between 2 to 30 charachters<br>", $error_array)) {
			echo "Your Last name must be between 2 to 30 charachters<br>";
		} ?>

		<!--Email-->
		<input type="email" name="reg_email" placeholder="Email" value="<?php 
		if(isset($_SESSION['reg_email'])){
			echo $_SESSION['reg_email']; }
		?>" required>
		<br>
		<!--Confirm Email-->
		<input type="text" name="reg_email2" placeholder="Confirm Email" value="<?php 
		if(isset($_SESSION['reg_email'])){
			echo $_SESSION['reg_email']; }
		?>" required>
		<br>
		<?php 
			if (in_array("Email already in use<br>", $error_array)) {
			echo "Email already in use<br>";
			}elseif (in_array("Invalid Email Address<br>", $error_array)) {
				echo "Invalid Email Address<br>";
			}elseif (in_array("Emails Don't match<br>", $error_array)) {
				echo "Emails Don't match<br>";
			} ?>

		<!--Password-->
		<input type="password" name="reg_pass" placeholder="Password" required>
		<br>
		<!--Confirm Password-->
		<input type="password" name="reg_pass2" placeholder="Confirm Password" required>
		<br>
		<?php 
			if (in_array("Passwords do not match<br>", $error_array)) {
				echo "Passwords do not match<br>";
			}elseif (in_array("Password can only contain numbers & letters<br>", $error_array)) {
				echo "Password can only contain numbers & letters<br>";
			}elseif (in_array("Your password should be between 5 to 30 charachters<br>", $error_array)) {
				echo "Your password should be between 5 to 30 charachters<br>";
			}?>

		<input type="submit" name="reg_btn" value="Register"> 


	</form>
</body>
</html>