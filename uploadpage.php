<?php
	session_start();
	include 'database_connection.php';
	if ($_SESSION['loggedin']){
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
		else if (isset($_POST['upload_button'])){
			$user_id = $_SESSION['user_id'];
			$filename = $user_id . "_" . $_FILES['filechosen']['name'];
			$caption = $_POST['caption'];
			if (move_uploaded_file($_FILES['filechosen']['tmp_name'], "posts/" . $filename)){
				$query = "INSERT INTO posts (user_id, filename, caption) 
						  VALUES ('$user_id', '$filename', '$caption')";
				$result = mysqli_query($conn, $query);
				if ($result){
					header("location: profilepage.php");
				}
			}
			else{
				echo "
					<script>
						alert('There is a problem uploading your photo.');
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
		<body  style="background-color: #fafafa; background-image: url('images/bg.jpg'); background-size: cover; background-attachment: fixed;">
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
							<a class="nav-link" href="#"><h5>Upload</h5></a>
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
			<br/><br/><br/><br/><br/><br/><br/>
			<div class="container" style="background-color: rgba(255,255,255,0.5); border: white double 7px; ">
				<div class="row">
					<div class="col" style="background-color: rgba(255,255,255);">
						<br/>
						<img src="images/upload_icon.png" width="100" height="100"><span style="font-size:45px;"> Post a Picture </span>
						<br/>
						<hr style="height: 2px; background-color: #e0e0e0;">
						<br/>
						<form method="post" enctype="multipart/form-data">
							<input type="file" name="filechosen" value="Choose file"><br/><br/>
							<input type="text" name="caption" placeholder="Post caption" style="width: 300px; height: 70px;"><br/><br/>
							<input type="submit" name="upload_button" value="Upload">
						</form>
						<br/><br/><br/><br/><br/>
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