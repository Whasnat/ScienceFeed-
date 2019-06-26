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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="assets/js/register.js"></script>
		
		
	</head>
	<body>
		<!--If error occurs during Registration, Show Register Section-->
		<?php
			if (isset($_POST['reg_btn'])) {
				echo '
				<script>
					$(document).ready(function(){
						$("#login_section").hide();
						$("#register_section").show();
					});
				</script>';
			}
			
		 ?>

		<div class="wrapper">
			<div class="login_box">
				<!--Header-->
				<div class="login_header">
					<h1><strong>Science Feed</strong></h1>
						Login or Register
				</div>
				<!--Login Section-->
				<div id="login_section">
					<form action="register.php" method="POST">
						<input type="email" name="login_email" placeholder="Enter Email" value="<?php  
						if (isset($SESSION['login_email'])){
							echo $SESSION['login_email'];
						}?>" required> 	 <!--Show Email in Email Box if there is an error-->
						<br>
						<?php if (in_array("<span style='color: #ff3838'>Incorrect Email or Password</span><br>", $error_array)) {
							echo "<span style='color: #ff3838'>Incorrect Email or Password</span><br>";
						} ?>
						<input type="password" name="login_password" placeholder="Enter Password" >
						<br>
						<input type="submit" name="login_btn" value="Login">
						<br>
						<a href="#" id="signup">Need an Account? Register here!</a>
					</form>
					<br>
				</div>
				

				<!--Register Section-->
				<div id="register_section">
					<form action="register.php" method="POST">
						<!--First Name-->
						<input type="text" name="reg_fname" placeholder="First Name" value="<?php 
						if(isset($_SESSION['reg_fname'])){
							echo $_SESSION['reg_fname'];
						}?>" required>
						<br>
						<?php if (in_array("<span style='color: #ff3838'>Your First name must be between 2 to 30 charachters</span><br>", $error_array)) {
							echo "<span style='color: #ff3838'>Your First name must be between 2 to 30 charachters</span><br>";
						} ?>

						<!--Last Name-->
						<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
						if(isset($_SESSION['reg_lname'])){
							echo $_SESSION['reg_lname']; }
						?>" required>
						<br>
						<?php if (in_array("<span style='color: #ff3838'>Your Last name must be between 2 to 30 charachters</span><br>", $error_array)) {
							echo "<span style='color: #ff3838'>Your Last name must be between 2 to 30 charachters</span><br>";
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
							if (in_array("<span style='color: #ff3838'>Email already in use</span><br>", $error_array)) {
							echo "<span style='color: #ff3838'>Email already in use</span><br>";
							}elseif (in_array("<span style='color: #ff3838'>Invalid Email Address</span><br>", $error_array)) {
								echo "<span style='color: #ff3838'>Invalid Email Address</span><br>";
							}elseif (in_array("<span style='color: #ff3838'>Emails Don't match</span><br>", $error_array)) {
								echo "<span style='color: #ff3838'>Emails Don't match</span><br>";
						} ?>

						<!--Password-->
						<input type="password" name="reg_pass" placeholder="Password" required>
						<br>
						<?php 
							if (in_array("<span style='color: #ff3838'>Passwords do not match</span><br>", $error_array)) {
								echo "<span style='color: #ff3838'>Passwords do not match</span><br>";
							}elseif (in_array("<span style='color: #ff3838'>Password can only contain numbers & letters</span><br>", $error_array)) {
								echo "<span style='color: #ff3838'>Password can only contain numbers & letters</span><br>";
							}elseif (in_array("<span style='color: #ff3838'>Your password should be between 5 to 30 charachters</span><br>", $error_array)) {
								echo "<span style='color: #ff3838'>Your password should be between 5 to 30 charachters</span><br>";
						}?>
						<!--Confirm Password-->
						<input type="password" name="reg_pass2" placeholder="Confirm Password" required>
						<br>
						

						<input type="submit" name="reg_btn" value="Register" >
						<br>
						
						<?php if (in_array("<span style='color: #44bd32'>Congratulations! You're registration was Successful</span><br>", $error_array)) {
								echo "<span style='color: #44bd32'><strong>Congratulations! You're registration was Successful<strong></span><br>";
						} ?>
						<a href="#" id="signin">Already have an account? Sign in here!</a>
					</form>
				</div>
				
			</div>

		</div>
	</body>
</html>