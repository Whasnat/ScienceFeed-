<?php 
require 'config/config.php';
require 'includes/form_handlers/login_handler.php';

if (isset($_SESSION['username'])){
	$user_logged_in = $_SESSION['username'];
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
	<script src="assets/js/boorstrap.js"></script>
	
	<!--CSS-->
	<link rel="stylesheet" type="text/css" href="assets/css/boorstrap.css">
	<script src="https://kit.fontawesome.com/f44ce8d2ea.js"></script>

	<!--<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/3.6.0/css/font-awesome.css" >-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	
</head>
<body>

	<div class="top_bar">
		<div class="logo">
			<a href="index.php"><strong>Science Feed</strong></a>
		</div>

		<nav>
			<a href="index.php">
				<i class="fas fa-home"></i>
			</a>
			<a href="#">
				<i class="fas fa-user-astronaut"></i>
			</a>
			<a href="#">
				<i class="fas fa-bell"></i>
			</a>
			<a href="#">
				<i class="fas fa-cog"></i>
			</a>
			<a href="#">
				<i class="fas fa-comment-alt"></i>
			</a>

		</nav>
	</div>

