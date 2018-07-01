<?php
	session_start();
	if ($_SESSION['loggedin']){
		include 'database_connection.php';
		$username = $_SESSION['username'];
		
		// USER BASIC INFO
		$query = "SELECT * FROM users
		  WHERE username = '$username'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		$user_id = $row['user_id'];
		$_SESSION['user_id'] = $user_id;
		$firstname = $row['firstname'];
		$middlename = $row['middlename'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		$username = $row['username'];
		$privacy = $row['privacy'];
		
		if (isset($_POST['search_button'])){
			if (!empty($_POST['searchbox'])){
				$_SESSION['search_item'] = $_POST['searchbox'];
				header("location: searchpage.php");
			}
		}
		else if (isset($_POST['logout_button'])){
			$_SESSION['loggedin'] = false;
			session_unset();
			session_destroy();
			header("location: index.php");
		}
		
		else if (isset($_POST['save_button'])){
			
			$user_id = $_SESSION['user_id'];
			if (!empty($_POST['privacy'])){
				$new_privacy = $_POST['privacy'];
				$query = "UPDATE users
						  SET privacy = '$new_privacy'
						  WHERE user_id = $user_id";
				$result = mysqli_query($conn, $query);
				if ($result){
					header("location: profilepage.php");
				}
			}
			if (!empty($_POST['fname'])){
				$new_fname = $_POST['fname'];
				$query = "UPDATE users
						  SET firstname = '$new_fname'
						  WHERE user_id = $user_id";
				$result = mysqli_query($conn, $query);
				if ($result){
					header("location: profilepage.php");
				}
			}
			if (!empty($_POST['mname'])){
				$new_mname = $_POST['mname'];
				$query = "UPDATE users
						  SET middlename = '$new_mname'
						  WHERE user_id = $user_id";
				$result = mysqli_query($conn, $query);
				if ($result){
					header("location: profilepage.php");
				}
			}
			if (!empty($_POST['lname'])){
				$new_lname = $_POST['lname'];
				$query = "UPDATE users
						  SET lastname = '$new_lname'
						  WHERE user_id = $user_id";
				$result = mysqli_query($conn, $query);
				if ($result){
					header("location: profilepage.php");
				}
			}
			if (!empty($_POST['email'])){
				$newemail = $_POST['email'];
				$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
				if (preg_match($regex, $newemail)){
					$query = "SELECT * FROM users
								WHERE  email = '$newemail'";
					$result = mysqli_query($conn, $query);
					$rowcount = mysqli_num_rows($result);
					if ($rowcount == 0){
						$query = "UPDATE users
						  SET email = '$newemail'
						  WHERE user_id = $user_id";
						$result = mysqli_query($conn, $query);
						if ($result){
							header("location: profilepage.php");
						}
					}
					else {
						echo "
							<script>
								alert('EMAIL IS ALREADY REGISTERED');
							</script>
						";
					}
				}
				else{
					echo "
							<script>
								alert('EMAIL IS NOT VALID');
							</script>
						";
				}
			}
			if (!empty($_POST['username'])){
				$new_username = $_POST['username'];
				$query = "SELECT * FROM users
						  WHERE  username = '$new_username'";
				$result = mysqli_query($conn, $query);
				$rowcount = mysqli_num_rows($result);
				
				if ($rowcount == 0){
					$query = "UPDATE users
							  SET username = '$new_username'
							  WHERE user_id = $user_id";
					$result = mysqli_query($conn, $query);
					if ($result){
						$_SESSION['username'] = $new_username;
						header("location: profilepage.php");
					}
				}
				else {
					echo "
							<script>
								alert('USERNAME UNAVAILABLE');
							</script>
						";
				}
			}
			if (!empty($_POST['password'])){
				if (!empty($_POST['rpassword'])){
					$newpass = $_POST['password'];
					$rpass = $_POST['rpassword'];
					
					if ($newpass == $rpass){
						$new_username = $_POST['username'];
						$query = "UPDATE users
								  SET password = '$newpass'
								  WHERE user_id = $user_id";
						$result = mysqli_query($conn, $query);
						if ($result){
							header("location: profilepage.php");
						}
					}
					else {
						echo "
							<script>
								alert('PASSWORD DOES NOT MATCH');
							</script>
						";
					}
				}
				else{
					echo "
						<script>
							alert('PLEASE RETYPE PASSWORD');
						</script>
					";
				}
			}
			
		}

		else if (isset($_POST['upload_button'])){
			$filename = $_SESSION['user_id'] . "_" .  $_FILES['imagechosen']['name'];
			if (move_uploaded_file($_FILES['imagechosen']['tmp_name'], "profilepictures/" . $filename)){
				$query = "UPDATE users
						  SET profile_picture = '$filename'
						  WHERE user_id = $user_id";
				$result = mysqli_query($conn, $query);
				if ($result){
					header("location: profilepage.php");
				}
			}
		}
?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<title> Instagram </title>
			<meta charset="utf-8">
			<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
			<style>
				.textfield{
					width: 350px;
				}
			</style>
		</head>
		<body  style="background-color: #fafafa; background-image: url('images/bg.jpg'); background-attachment: fixed; background-size: cover;">
<!----------------------------------------------- N A V I G A T I O N---------------------------------------------------->
			<div class="container-fluid" style="background-color: white; float: right; position: fixed; overflow: hidden; z-index:10; top:0">
				<div class="row">
					<div class="col">
						<img src="images/textpiclogo.png" width="280" height="80">
					</div>
					<div class="col">
						<ul class="nav justify-content-end">
						  <li class="nav-item">
							<form method="post">
								<br/>
								<input type="text" name="searchbox" placeholder="Search">
								<input type="submit" name="search_button" value="" style="width:30px; height: 28px; background-image: url('images/search_icon.png'); background-size: contain; background-repeat: no-repeat; margin-top: 2.5%;">
							</form>
						  </li>
						  <li class="nav-item">
							<br/>
							<a class="nav-link active" href="homepage.php"><h5>Home</h5></a>
						  </li>
						  <li class="nav-item">
							<br/>
							<a class="nav-link" href="profilepage.php"><h5>Profile</h5></a>
						  </li>
						  <li class="nav-item">
							<br/>
							<a class="nav-link" href="uploadpage.php"><h5>Upload</h5></a>
						  </li>
						  <li class="nav-item">
							<form method="post">
								<br/>
								<input type="submit" name="logout_button" value="Log out" style="height: 35px;"> &nbsp;&nbsp;&nbsp;&nbsp;
								<br/>
								<br/>
							</form>
						  </li>
						</ul>
					</div>
				</div>
			</div>
<!----------------------------------------------------- B O D Y ---------------------------------------------------------->
			<br/><br/><br/><br/><br/>
			<div class="container" style="background-color: rgba(255,255,255,0.5); border: white double 7px; ">
				<div class="row">
					<div class="col" style="background-color: rgba(255,255,255);">
						<br/>
						<img src="images/profile_icon.png" width="100" height="100"><span style="font-size:45px;"> Edit your Profile </span>
						<br/>
						<hr style="height: 2px; background-color: #e0e0e0;">
						<form method="post" enctype="multipart/form-data">
							<label> Change profile picture </label><br/>
							<input type="file" name="imagechosen" value="Choose file">
							<input type="submit" name="upload_button" value="Upload"><br><br>
							<?php
								if ($privacy == "public"){
									echo "
										<input type = 'radio' name = 'privacy' value='public' checked> Public Account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type = 'radio' name = 'privacy' value='private'> Private Account <br/><br/>
									";
								}
								else {
									echo "
										<input type = 'radio' name = 'privacy' value='public'> Public Account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type = 'radio' name = 'privacy' value='private' checked> Private Account <br/><br/>
									";
								}
							?>
							<input type = "text" class="textfield" name = "fname" placeholder="<?php echo"$firstname"?>"><br>
							<input type = "text" class="textfield" name = "mname" placeholder="<?php echo"$middlename"?>"><br>
							<input type = "text" class="textfield" name = "lname" placeholder="<?php echo"$lastname"?>"><br>
							<input type = "text" class="textfield" name = "email" placeholder="<?php echo"$email"?>"><br>
							<input type = "text" class="textfield" name = "username" placeholder="<?php echo"$username"?>"><br>
							<input type = "password" class="textfield" name = "password" placeholder="********"><br>
							<input type = "password" class="textfield" name = "rpassword" placeholder="********"><br>
							<br/>
							<input type = "submit" name = "save_button" value="Save Changes">
							<br/>
							<br/>
						</form>
					</div>
				</div>
			</div>
		</body>
	</html>
<?php
		
	}
	else {
		header("location: index.php");
	}
?>