<?php
	session_start();
	if (@$_SESSION['loggedin']){
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
		include 'database_connection.php';
		$username = $_SESSION['username'];
		
		// FETCHING USER ID
		$query = "SELECT * FROM users
		  WHERE username = '$username'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		$user_id = $row['user_id'];
		$_SESSION['user_id'] = $user_id;
?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<title> Instagram </title>
			<meta charset="utf-8">
			<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
			<style>
				.container{
					width: 800px;
				}
				.content{
					margin-left: -1.9%;
				}
			</style>
		</head>
		<body  style="background-color: #f6f6f6; background-image: url('images/bg.jpg'); background-repeat: no-repeat; background-size: cover; background-attachment: fixed;">
		
<!----------------------------------------------- N A V I G A T I O N---------------------------------------------------->
			<div class="container-fluid" style="background-color: white; float: right; position: fixed; overflow: hidden; top:0; z-index:10;">
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
							<a class="nav-link active" href="#"><h5>Home</h5></a>
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
			<?php
				$query = "
					SELECT * FROM posts p JOIN users u ON p.user_id = u.user_id 
					WHERE p.user_id = $user_id OR p.user_id IN 
					(SELECT user_being_followed from users_relationship WHERE user_who_follow = $user_id) ORDER BY p.Time desc
				";
				$result = mysqli_query($conn, $query);
				
			?>
				<div class="container" style="margin-top: 50px; padding: 16px">
					<?php
					while ($row = mysqli_fetch_array($result)){
						$username = $row['username'];
						$dp = $row['profile_picture'];
						$user_id = $row['user_id'];
						$filename = $dp;
						$post = $row['filename'];
						$caption = $row['caption'];
						echo "
							<br/>
							<br/>
							<div class='row' style='background-color: white;'>
								<div class='col-12' >
									<br/>
									<img src='profilepictures/$filename' width='45' height='45'>
									$username
									<br/>
									<br/>
								</div>
							</div>
							<div class='row' style='background-color: white;'>
								<div class='col-12'>
									<center>
									<img src='posts/$post' class='content'  height='500' width='800'>
									<br/>
									<br/>
									<h3> $caption </h3>
									<img src='images/heart.png' height='25' width='50'>
									<img src='images/comment_icon.png' height='40' width='55'>
									<center>
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
	else{
		header("location: index.php");
	}
?>