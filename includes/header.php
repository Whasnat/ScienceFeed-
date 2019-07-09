<?php 
require 'config/config.php';
require 'includes/form_handlers/login_handler.php';

if (isset($_SESSION['username'])){
	$user_logged_in = $_SESSION['username'];
	$user_detail_query = mysqli_query($con,"SELECT * FROM user_information WHERE username = '$user_logged_in '");
	$user = mysqli_fetch_array($user_detail_query);
}
else{
	header("Location: register.php");
}

?>

<html>
<head>
	<title>ScienceFeed</title>
	<!--Javascript-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.js"></script>
	<script src="https://kit.fontawesome.com/f44ce8d2ea.js"></script>
	
	<!--CSS-->
	<link rel="stylesheet" type="text/css" href="assets/css/boorstrap.css">
	
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	
</head>
<body>

	<div class="top_bar">
		<!--Logo-->
		<div class="logo">
			<a href="index.php"><strong>Science Feed</strong></a>
		</div>

		<!--Nevigation-->
		<nav >
			<a href="index.php">
				<i class="fas fa-home"></i>
			</a>
			<a href="<?php echo $user_logged_in;?>">
				<i class="fas fa-user-astronaut"></i>
			</a>
			<a href="#">
				<i class="fas fa-bell"></i>
			</a>
			<a href="#">
				<i class="fas fa-comment-alt"></i>
			</a>
			<a href="#">
				<i class="fas fa-cog"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i  id= "logout" class="fas fa-sign-out-alt"></i>
			</a>
		</nav>	
	</div>
	
	<div class="wrapper">			<!--Index Wrapper-->

