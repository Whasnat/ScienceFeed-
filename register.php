<?php 
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
</head>
<body>

	<div class="wrapper">
		<div class="login_box">
			<!--Header-->
			<div class="login_header">
				<h1><strong>Science Feed</strong></h1>
					Login or Register
				
			</div>
			<!--Login Form-->
			<form action="register.php" method="POST">
				<input type="email" name="login_email" placeholder="Enter Email" value="<?php  
				if (isset($SESSION['login_email'])){
					echo $SESSION['login_email'];
				}?>" required> 	 <!--Show Email in Email Box if there is an error-->
				<br>
				<?php if (in_array("Incorrect Email or Password <br>", $error_array)) {
					echo "Incorrect Email or Password <br>";
				} ?>
				<input type="password" name="login_password" placeholder="Enter Password" >
				<br>
				<input type="submit" name="login_btn" value="Login">

			</form>
			<br>
			<!--Register Form-->
			<form action="register.php" method="POST">
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

				<input type="submit" name="reg_btn" value="Register" >
				<br>
				<?php if (in_array("<span style='color: #44bd32'>Congratulations! You're registration was Successful</span><br>", $error_array)) {
						echo "<span style='color: #44bd32'><strong>Congratulations! You're registration was Successful<strong></span><br>";
					} ?>
			</form>
		</div>

	</div>
</body>
</html>