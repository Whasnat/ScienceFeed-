<?php

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
					 array_push($error_array, "<span style='color: #ff3838'>Email already in use</span><br>");
				}

			}else{
				array_push($error_array,"<span style='color: #ff3838'>Invalid Email Address</span><br>");
			}
		}else{
			array_push($error_array, "<span style='color: #ff3838'>Emails Don't match</span><br>");
		}
 		/*---------------------------------------------------------------------------------------------------------------*/


		/************************************
		* This Block Validates the Password * 
		*************************************/
		if ($password != $password2) {
			array_push($error_array, "<span style='color: #ff3838'>Passwords do not match</span><br>");
		}else{
			//Checks if the Password caontain any Invalid charachters
			if (preg_match('/[^A-Za-z0-9]/', $password)) {
			 	array_push($error_array,"<span style='color: #ff3838'>Password can only contain numbers & letters</span><br>");
			}
		}
		 if (strlen($password)>30 || strlen($password)<5) {
		 	array_push($error_array, "<span style='color: #ff3838'>Your password should be between 5 to 30 charachters</span><br>");
		 }
		/*---------------------------------------------------------------------------------------------------------------*/

		/**************************************
		* This Block Validates the User names * 
		***************************************/
		if (strlen($fname) >30 || strlen($fname) <2) {
			array_push($error_array, "<span style='color: #ff3838'>Your First name must be between 2 to 30 charachters</span><br>");
		}elseif (strlen($lname) >30 || strlen($lname) <2) {
			array_push($error_array, "<span style='color: #ff3838'>Your Last name must be between 2 to 30 charachters</span><br>");
		}
		/*---------------------------------------------------------------------------------------------------------------*/


		/****************************
		* Adding Values to Database * 
		*****************************/

		if (empty($error_array)) {			//if there is no error
		 	$password = md5($password);		//Encrypt password into md5 

		 	//Genetrate a Username by joining/contatening First and last name
		 	$username = strtolower($fname . "_" . $lname);

		 	//check DB for maching usernames
		 	$check_username_query = mysqli_query($con, "SELECT username FROM user_information WHERE username = '$username'");


		 	/* If matching Username is found than add 1 to username and Check again
				check untill no match is found */
		 	$i=0;
		 	while (mysqli_num_rows($check_username_query) !=0 ) {
		 		$i++;
		 		$username = $username . $i;
		 		$check_username_query = mysqli_query($con, "SELECT username FROM user_information WHERE username = '$username'");
		 	}

		 	//Assign a default profile Photo to user
		 	$rand = rand(1,2);
		 	if($rand ==1){
		 		$profile_pic = "assets/images/profile_pics//default/d_1.png";
		 	}elseif ($rand ==2) {
		 		$profile_pic = "assets/images/profile_pics/default/d_2.png";
		 	}

		 	//Insert the values into Database
		 	$query = mysqli_query($con,"INSERT INTO user_information VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");

		 	//Registration Success message
		 	array_push($error_array, "<span style='color: #44bd32'>Congratulations! You're registration was Successful</span><br>"); 
		 

		 	//Clear the input fields after Successfull Registration
		 	$_SESSION['reg_fname'] = "";
		 	$_SESSION['reg_lname'] = "";
		 	$_SESSION['reg_email'] = "";
		 	$_SESSION['reg_email2'] = "";
		}
	}
?>