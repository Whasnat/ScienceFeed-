<?php 
$con = mysqli_connect("localhost", "root","","sciencefeed"); //connection variables

if (mysqli_connect_errno()){
	echo "failed to connect to database: ".mysqli_connect_errno();
}
 

// Declaring variables to prevent Errors
$fname = ""; //First Name
$lname = ""; //Last Name
$em = ""; //Email
$em2 = ""; //Email 2
$password = ""; //Password
$password2 = ""; //password 2
$date = "";	//dateTime
$error_array = ""; //Error messages are stored here
	
	if (isset($_POST['reg_btn'])) {

		//Register form Values, formating
		$fname = strip_tags($_POST['reg_fname']); // Remove any Unwanted tags from name
		$fname = str_replace(' ', '', $fname);
		$fname = ucfirst(strtolower($fname));

		$lname = strip_tags($_POST['reg_lname']); // Remove any Unwanted tags from name
		$lname = str_replace(' ', '', $lname);
		$lname = ucfirst(strtolower($lname));

		$em = strip_tags($_POST['reg_email']); // Remove any Unwanted tags from name
		$em = str_replace(' ', '', $em);
		$em = ucfirst(strtolower($em));

		$em2 = strip_tags($_POST['reg_fname']); // Remove any Unwanted tags from name
		$em2 = str_replace(' ', '', $em2);
		$em2 = ucfirst(strtolower($em2));

		$password = strip_tags($_POST['reg_pass']); // Remove any Unwanted tags from name
		$password2 = strip_tags($POST['reg_pass2']);

		$date = date("Y-m-d");
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