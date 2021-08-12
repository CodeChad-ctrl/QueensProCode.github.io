<?php
	// Start the session variables and security of the webpage
	include('../student_level/dbh.php');
	session_start();
	
	// lock and key
	if (!isset($_SESSION['tutor_id'])) {
	    header('Location: ../student_level/login_page.php');
	    
	    
	}
	
	
	
	
	
	
	// Get the customers profile picture
	$userid = $_SESSION['tutor_id'];
	
	// Get the contet id using the GET super
	
	
	
	
	
	
	
	// Create a location Var that can be used do that the form tags can be used correctly
	
	
	
	
	
	
	
	
	
	?>
<!DOCTYPE html>
<html lang="en">
	<link rel="stylesheet" href="css.calender/style.css"/>
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://kit.fontawesome.com/2d3dbf3534.js" crossorigin="anonymous"></script>
	<script defer src= "js.calendar/tutor_module.js"></script>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> Account Settings </title>
	</head>
	<!-- ////////////////////////////////////////////////////GET STUDENT DETAILS ////////////////////////////////////////////////////////////////////////// -->
	<?php
		$student_details = "SELECT * FROM tutor_details WHERE tutor_id = '$userid'";
		$get = $conn->query($student_details);
		
		while ($row=$get->fetch_assoc()) {
		  $fname = $row['tutor_first_name'];
		  $lname = $row['tutor_second_name'];
		
		  $target_file = $row['imgpath'];
		
		}
		$file = "images/$target_file";
		?>
	<div  class="sidebar">
		<ul>
			<li class="active"> <a href="tutor_home.php "> <span class="material-icons"> home </span></a> </li>
			<li> <a href="tutor_module.php"> <span class="material-icons"> auto_stories</span></a> </li>
			<li> <a href="tutor_calender.php"> <span class="material-icons">  class </span>  </a> </li>
			<li> <a href="view_students.php"> <span class="material-icons">  people </span></a> </li>
			<li> <a href="tutor_account_settings.php"> <span class="material-icons">  settings </span>  </a> </li>
			<li><a href="tutor_log_out.php"> <span class="material-icons"> logout </span></a></li>
		</ul>
	</div>
	<div class="page-title">
		<h4> Account Settings </h4>
	</div>
	<div class="container">
		<div class="container2">
			<div class="container2">
				</head>
				<body>
					<h2 style="text-align:center"> Change Profile Picture </h2>
					<div class="card">
						<img src="$target_file" style="width:100%">
						<?php 
							echo "<h1> $fname $lname </h1>";
							
							?>
						<p>
							<button>
						<form action="tutor_account_settings.php" method="post" enctype="multipart/form-data">
						<input type="file" name="fileToUpload" id="fileToUpload">
						<input type="submit" value="Upload file" name="submit">
						</form></button></p>
					</div>
					?>
			</div>
		</div>
	</div>
	<style>
	.card {
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	max-width: 300px;
	margin: auto;
	text-align: center;
	font-family: arial;
	}
	.title {
	color: grey;
	font-size: 18px;
	}
	button {
	border: none;
	outline: 0;
	display: inline-block;
	padding: 8px;
	color: white;
	background-color: #000;
	text-align: center;
	cursor: pointer;
	width: 100%;
	font-size: 18px;
	}
	a {
	text-decoration: none;
	font-size: 22px;
	color: black;
	}
	button:hover, a:hover {
	opacity: 0.7;
	}
	</style>
	</body>
</html>