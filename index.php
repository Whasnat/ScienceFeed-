<?php 
$con = mysqli_connect("localhost", "root","","sciencefeed"); //connection variables

if (mysqli_connect_errno()){
	echo "failed to connect to database: ".mysqli_connect_errno();
}

$query  = mysqli_query($con, "INSERT INTO info VALUES('2', 'Raihan','w.hasnat@gmail.com', '654321')");
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>ScienceFeed</title>
</head>
<body>
	<h1>Hello to Science Feed</h1>
</body>
</html>