<?php
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "";
	
	//create connection
	$conn = mysqli_connect($servername, $username, $password);
	
	if (!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}
	else {
		mysqli_select_db($conn, "instagram");
		if (isset($_POST['login_button'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $username;
			
			$filled = true;
			
			if (empty($username))
				$filled = false;
			if (empty($password))
				$filled = false;
			
			if ($filled){
				$query = "SELECT * FROM users
						  WHERE username = '$username'
						  AND password = '$password'
				";
				
				$result = mysqli_query($conn, $query);
				$check1_res = mysqli_query($conn, $query);

				if (!$check1_res) {
					printf("Error: %s\n", mysqli_error($conn));
					exit();
				}
				
				$row = mysqli_num_rows($result);
				
				if($row == 1){
					$row = mysqli_fetch_array($result);
					$_SESSION['username'] = $username;
					$_SESSION['loggedin'] = true;
					header("location: homepage.php");
				}
				else {
					echo "Username or password is incorrect";
				}
						
			}
			else {
				echo "Complete fields first!";
			}
		}
	}
?>