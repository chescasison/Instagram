<?php
	session_start();
	if ($_SESSION['loggedin']){
		include 'database_connection.php';
		$_SESSION['found_user_id'] = $_GET['id'];
		$found_id = $_SESSION['found_user_id'];
		
		if (isset($_POST['search_button'])){
			if (!empty($_POST['searchbox'])){
				$search_item = mysqli_real_escape_string($conn, $_POST['searchbox']);
				$_SESSION['search_item'] = $search_item;
				header("location: searchpage.php");
			}
		}
		else if (isset($_POST['logout_button'])){
			$_SESSION['loggedin'] = false;
			session_unset();
			session_destroy();
			header("location: index.php");
		}
		
		if (isset($_POST['follow_button'])){
			
			$current_user = $_SESSION['user_id'];
			$found_id = $_SESSION['found_user_id'];
			$query = "INSERT INTO users_relationship
					  (user_who_follow, user_being_followed)
					  VALUES ($current_user,$found_id)";
			$result = mysqli_query($conn, $query);
			if ($result){
				echo "
					<script>
						alert('Followed user.');
					</script>
				";
			}
		}
?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<title> Instagram </title>
			<meta charset="utf-8">
			<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		</head>
		<body  style="background-color: #fafafa; background-image: url('images/bg.jpg'); background-attachment: fixed; background-size: cover;">
<!----------------------------------------------- N A V I G A T I O N---------------------------------------------------->
			<div class="container-fluid" style="background-color: white; position: fixed; overflow: hidden; top:0; z-index:10;">
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
								<input type="submit" name="logout_button" value="Log out" style="height: 35px; background-color: transparent"> &nbsp;&nbsp;&nbsp;&nbsp;
								<br/>
								<br/>
							</form>
						  </li>
						</ul>
					</div>
				</div>
			</div>
<!----------------------------------------------------- B O D Y ---------------------------------------------------------->
			<br/>
			<div class="container" style="margin-top: 8%;">
				<div class="row" style="background-color: white; ">
					<?php
						include 'database_connection.php';
						$found_user_id = $_SESSION['found_user_id'];
						// FOUND USER BASIC INFO
						$query = "SELECT * FROM users
						  WHERE user_id = '$found_user_id'";
						$result = mysqli_query($conn, $query);
						$row = mysqli_fetch_array($result);
						$firstname = $row['firstname'];
						$middlename = $row['middlename'];
						$lastname = $row['lastname'];
						$email = $row['email'];
						$username = $row['username'];
						$profile_picture = $row['profile_picture'];
						
						// NUMBER OF POSTS
						$query = "SELECT * FROM posts
									WHERE user_id = $found_id";
						$result = mysqli_query($conn, $query);
						$posts = mysqli_num_rows($result);
						
						// NUMBER OF FOLLOWERS
						$query = "SELECT * FROM users_relationship
									WHERE user_being_followed = $found_id";
						$result = mysqli_query($conn, $query);
						$followers = mysqli_num_rows($result);
						
						// NUMBER OF FOLLOWING
						$query = "SELECT * FROM users_relationship
									WHERE user_who_follow = $found_id";
						$result = mysqli_query($conn, $query);
						$following = mysqli_num_rows($result);
						$found_id = $_SESSION['found_user_id'];
						$userfollows = false;
						
						//Checks if currently logged in follows the user or account is public
						$usercurr = $_SESSION['user_id'];
						
						$query = "SELECT * FROM users
						  WHERE user_id = $found_id";
						$result = mysqli_query($conn, $query);
						$row = mysqli_fetch_array($result);
						$privacy = $row['privacy'];
						
						$query = "SELECT * FROM users_relationship WHERE user_who_follow = $usercurr 
								  AND user_being_followed = $found_id";
						$result = mysqli_query($conn, $query);
						$rowcount = mysqli_num_rows($result);
						
						if ($rowcount == 1){
							$userfollows = true;
						}
						
						echo "
						<div class='col-3' style='background-color: white;'>
							<br/>
							<img src = 'profilepictures/" . $profile_picture."' width = '255' height = '250' style='border-radius: 50%;'> 
							<br/>
							<br/>
						</div>
						<div class='col-9'>
							<div class='container-fluid'>
								<div class='row'>
									<div class='col-5'>
										<br/>
										<br/>
										<br/>
										<h2> $username </h2>
										<h5> $firstname $middlename $lastname </h5>
										<h5> $email </h5>
										<br/>
										";
										if (!$userfollows){
											echo "
											<form method='post' action=''>
												<input type='submit' name='follow_button' value='Follow User'>
											</form>";
										}
									echo "
									</div>
									<div class='col-7'>
										<div class='container-fluid'>
											<div class='row'>
												<div class='col-4'>
													<br/><br/><br/>
													<h1> $posts </h1>
													<h5> POSTS </h5>
												</div>
												<div class='col-4'>
													<br/><br/><br/>
													<h1> $followers </h1>
													<h5> FOLLOWERS </h5>
												</div>
												<div class='col-4'>
													<br/><br/><br/>
													<h1> $following </h1>
													<h5> FOLLOWING </h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						";
					?>
				</div>
				<div class="row" >
					<div class="col-12" style="height: 25px; background-color: transparent;">
					</div>
				</div>
					<?php
						include "database_connection.php";
						if ($privacy == "public" or $userfollows){
							// NUMBER OF POSTS AND FILENAMES
							$query = "SELECT * FROM posts
										WHERE user_id = $found_id
										ORDER BY Time DESC";
							$result = mysqli_query($conn, $query);
							$posts = mysqli_num_rows($result);
							
							echo "<div class='row' style='background-color: white;'>";
							while($row = mysqli_fetch_array($result)){
								$filename = $row['filename'];
								echo "
									<div class='col-4' style='border: white solid 20px;'>
										<center>
										<img src='posts/$filename' height='300' width='328'>
										</center>	
									</div>
								";
							}
						}
						else {
							echo "<div class='row' style='background-color: white;'>
									<div class='col-4' style='border: white solid 20px;'>
									</div>
									<div class='col-4' style='border: white solid 20px;'>
										<center>
											<h5> User Account is private. </h5>
										</center>
									</div>
									<div class='col-4' style='border: white solid 20px;'>
									</div>
								</div>
							";
						}
					?>
			</div>
		</body>
	</html>
<?php
	}
	else {
		header("location: index.php");
	}
?>