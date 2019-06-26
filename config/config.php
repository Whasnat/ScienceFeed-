<?php 
session_start(); //Start Buffering
$con = mysqli_connect("localhost", "root","","sciencefeed"); 	//connection variables
$time = date_default_timezone_set("Asia/Dhaka");				
if (mysqli_connect_errno()){
	echo "failed to connect to database: ".mysqli_connect_errno();
}
?>