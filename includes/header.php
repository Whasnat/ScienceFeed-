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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="assets/js/boorstrap.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/css/boorstrap.css">
</head>
<body>