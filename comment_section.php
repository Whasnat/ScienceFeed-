<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<?php 
		require 'config/config.php';	

		include("includes/classes/User.php");
		include("includes/classes/Posts.php");

		//See If user still Logged In
		if (isset($_SESSION['username'])){
			$user_logged_in = $_SESSION['username'];
			$user_detail_query = mysqli_query($con,"SELECT * FROM user_information WHERE username = '$user_logged_in '");
			$user = mysqli_fetch_array($user_detail_query);
		}
		else{
			header("Location: register.php");
		}

	?>

	<script>
		function toggle(){
			var element = document.getElementById("comment_section");
			if (element.style.display == "block")
				element.style.display = "none";
			else
				element.style.display = "block";
		}
	</script>


	<?php
		//get post_id 
		if (isset($_GET['post_id'])) {
			$post_id = $_GET['post_id'];
		}

		$user_query  = mysqli_query($con, "SELECT added_by, added_to FROM posts WHERE id = '$post_id'");
		$row = mysqli_fetch_array($user_query);
		$posted_to = $row['added_by'];

		//Insert post body into DB
		if (isset($_POST['postComment'.$post_id])) {
			$post_body = $_POST['post_body'];
			$post_body = mysqli_escape_string($con, $post_body);
			$date_time_current = date("Y-m-d H:i:s");
			if ($post_body == "") {
				echo '<script language="javascript">';
				echo 'alert("Nothing to post")';
				echo '</script>';
			}else{	
				$insert_into_db =  mysqli_query($con, "INSERT INTO comments VALUES('', '$post_body', '$user_logged_in', '$posted_to','$date_time_current','no','$post_id')");
				echo "<p>comment posted!</p>";
			}
			
		}
	 ?> 

	 <form action="comment_section.php?post_id=<?php echo $post_id; ?>" id="								comment_form" name="postComment<?php echo $post_id;?>" method="POST">
	 	<textarea  name="post_body"></textarea>
	 	<input type="submit" name="postComment<?php echo $post_id; ?>" value = "Comment">

	 </form>

</body>
</html>

<!--Load Comments here-->

<?php 
	$getComments = mysqli_query($con, "SELECT * FROM comments WHERE post_id = '$post_id'");
	$row = mysqli_num_rows($getComments);

	if ($row != 0) {
		
		while ($comment = mysqli_fetch_array($getComments)) {
			$comment_body = $comment['post_body'];
			$posted_to = $comment['posted_to'];
			$posted_by = $comment['posted_by'];
			$date_added = $comment['date_added'];

			//TimeFrame
			$date_time_current = date("Y-m-d H:i:s");
			$start_date_time = new DateTime($date_added);		//Time Posted
			$end_date_time = new DateTime($date_time_current);			//Current Time
			$interval = $start_date_time->diff($end_date_time);			//Interval between the 2 times

			
			//Year Old
			if ($interval-> y >= 1) {
				if ($interval-> y == 1) 
					$time_msg = $interval->y. " year age";
				else
					$time_msg = $interval->y. " years ago"; 
			}
			
			//month Old
			elseif ($interval-> m >=1) {

				if ($interval-> d == 0){
					$days = "ago";
				}elseif($interval-> d ==1){
					$days = $interval-> d. " day ago";
				}else{
					$days = $interval->d. " days ago";	
				}

				if ($interval-> m == 1) {
					$time_msg = $interval-> m . " month" . $days;
				}else{
					$time_msg = $interval-> m . " months" . $days;
				}
			}
			
			//Day Old
			elseif ($interval-> d >=1) {
				if ($interval-> d == 1)
					$time_msg = $interval-> d. " day ago";
				else
					$time_msg = $interval-> d." days ago";
				
			}
			//Hour Old 
			elseif ($interval-> h >=1) {
				if ($interval-> h == 1) {
					$time_msg = $interval-> h. " hour ago";
				}else{
					$time_msg = $interval-> h." hours ago";
				}
			}

			//Minute Old
			elseif ($interval-> i >= 1) {
				if ($interval-> i == 1) {
					$time_msg = $interval-> i. " minute ago";
				}else{
					$time_msg = $interval-> i." minutes ago";
				}
			}

			//Second Old
			else {
				if ($interval-> i<30){
					$time_msg = "just now";
				}
				elseif ($interval-> s == 1) {
					$time_msg = $interval-> s. " day ago";
				}else{
					$time_msg = $interval-> s." days ago";
				}						
			}

			$user_obj = new User($con, $posted_by);
		?>

		<div class="comment_section" >
			<a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePhoto()?>" style= "height: 20%; border-radius: 50%; float: left; margin:2px;"></a>
			<a href="<?php echo $posted_by?>" target="_parent" style= "padding-top: 10px;"><strong><?php echo $user_obj->getName();?></strong></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $time_msg. "<br>".$comment_body;?>
		</div>
		<br>

		<?php
		}
	}

 ?>