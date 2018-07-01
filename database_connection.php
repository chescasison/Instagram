<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	
	//create connection
	$conn = mysqli_connect($servername, $username, $password);
	
	//Check connection
	if (!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}
	else {
		mysqli_select_db($conn, "instagram");
	}
?>