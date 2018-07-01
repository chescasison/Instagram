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
			
			input{
				width: 250px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col">
					<br/>
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
						<h5> Welcome to</h5>
						<img src = "images/textpiclogo.png" height="80" width="300">
						<br/>
						<br/>
						<input type = "text" name = "fname" placeholder="First name"><br>
						<input type = "text" name = "mname" placeholder="Middle name">
						<input type = "text" name = "lname" placeholder="Last name"><br>
						<input type = "text" name = "email" placeholder="Email"><br>
						<input type = "text" name = "username" placeholder="Username"><br>
						<input type = "password" name = "password" placeholder="Password"><br>
						<input type = "password" name = "rpassword" placeholder="Re-type password"><br>
<?php
	session_start();
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
			
			$username = @$_POST['username'];
			$email = @$_POST['email'];
			$fname = @$_POST['fname'];
			$lname = @$_POST['lname'];
			$mname = @$_POST['mname'];
			$password = @$_POST['password'];
			$rpassword = @$_POST['rpassword'];
	// ===================== VALIDATION ======================
			
			$filled = true;
			$wrongPattern = false;
			$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		if (isset($_POST['submit_button'])){
			
			if (empty($_POST['username']))
				$filled = false;
			if (empty($_POST['password']))
				$filled = false;
			if (empty($_POST['rpassword']))
				$filled = false;
			if (empty($_POST['fname']))
				$filled = false;
			if (empty($_POST['lname']))
				$filled = false;
			if (empty($_POST['mname']))
				$filled = false;
			if (empty($_POST['email'])){
				$filled = false;
			}
			if (!preg_match($regex, $email)){
				$filled = false;
				$wrongPattern = true;
			}
			
			if ($filled){ //REGISTRATION COMPLETE
				
				if (!$wrongPattern){
					if ($password == $rpassword){
						$query = "SELECT * FROM users
									WHERE  username = '$username'";
						$result = mysqli_query($conn, $query);
						$rowcount = mysqli_num_rows($result);
						
						if ($rowcount < 1){
							
							$query = "SELECT * FROM users
									WHERE  email = '$email'";
							$result = mysqli_query($conn, $query);
							$rowcount = mysqli_num_rows($result);
							if ($rowcount == 0){
								//$password = md5($password);
								$profile_picture = "profile_icon.png";
								$query = "INSERT INTO users
										(username, email, firstname, lastname, middlename, password, profile_picture)
										VALUES ('$username', '$email', '$fname', '$lname',
												'$mname', '$password', '$profile_picture')";
								
								$result = mysqli_query($conn, $query);
								
								if ($result){
									echo "SUCCESSFULLY REGISTERED!";
									$_SESSION['username'] = $username;
									$_SESSION['loggedin'] = true;
									header("location: homepage.php");
								}
								else {
									$error = mysqli_error($conn);
									echo "
										<script>
											alert('$error');
										</script>
									";
								}
							}
							else {
								echo "
									<span style='color: red;'> Email already registered. </span>
								";
							}
						}
						else {
							echo "
								<span style='color: red;'> Username unavailable. </span>
							";
						}
					}
					else {
						echo "
							<span style='color: red;'> Password does not match. </span>
						";
					}
				}
				else{
					echo "
					<span style='color: red;'> Invalid email. </span>
				";
				}
			}
			else {
				echo "
					<span style='color: red;'> Fill up all fields. </span>
				";
			}
			
		}
	}
?>						<br/>
						<br/>
						<input type = "submit" name = "submit_button" value="Sign Up">
						<br/>
						<br/>
						<a href="index.php"> Already have an account? </a>
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