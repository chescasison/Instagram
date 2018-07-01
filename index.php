<?php
	session_unset();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Instagram </title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<style>
			body{
				background-image: url("images/bg.jpg");
				background-size: cover;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col">
					<br/>
					<br/>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
				</div>
				<div class="col-4" style="background-color: rgb(255,255,255);">
					<center>
					<form method="post">
						<br/>
						<br/>
						<img src="images/instagramLogo.png" height="200px" width="250px">
						<br/>
						<br/>
						<br/>
						<input type="text" name="username" placeholder="username">
						<br/>
						<br/>
						<input type="password" name="password" placeholder="********">
						<br/>
						<br/>

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
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
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
					echo "<span style='color: red;'> Username or password is incorrect </span>";
				}
						
			}
			else {
				echo "Complete fields first!";
			}
		}
	}
?>
						<br/>
						<br/>
						<input type="submit" name="login_button" value="Sign in">
						<br/>
						<br/>
						<a href="registration.php"> New to Instagram? </a>
						<br/>
						<br/>
						<br/>
					</form>
					</center>
				</div>
				<div class="col-4">
				</div>
			</div>
		</div>
	</body>
</html>