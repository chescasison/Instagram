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
									
									echo "<h1> HERE error</h1>";
									$error = mysqli_error($conn);
									echo "
										<script>
											alert('$error');
										</script>
									";
								}
							}
							else {
								echo "Email already registered!";
							}
						}
						else {
							echo "Username not available!";
						}
					}
					else {
						echo "Password does not match!";
					}
				}
				else{
					echo "Incorrect email!";
				}
			}
			else {
				echo "COMPLETE ALL FIELDS FIRST";
			}
			
		}
	}
?>