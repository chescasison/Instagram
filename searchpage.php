<?php
	session_start();
	include 'database_connection.php';
	if ($_SESSION['loggedin']){
		$user_id = $_SESSION['user_id'];
		$search_item1 = $_SESSION['search_item'];
		if (isset($_POST['search_button'])){
			if (!empty($_POST['searchbox'])){
				$search_item = mysqli_real_escape_string($conn, $_POST['searchbox']);
				$_SESSION['search_item'] = $search_item;
			}
		}
		else if (isset($_POST['logout_button'])){
			$_SESSION['loggedin'] = false;
			session_unset();
			session_destroy();
			header("location: index.php");
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
			<br/><br/><br/><br/><br/><br/><br/>
			<div class="container" style="background-color: rgba(255,255,255,0.5); border: white double 7px; ">
				<div class="row">
					<div class="col" style="background-color: rgba(255,255,255);">
						<br/>
						<img src="images/search_icon.png" width="100" height="100"><span style="font-size:45px;"> Search Results </span>
						<br/>
						<hr style="height: 2px; background-color: #e0e0e0;">
						<?php
							$user_id = $_SESSION['user_id'];
							echo "<h4> Search item: $search_item1 </h4><br/>";
							$query = "SELECT * FROM users where (firstname LIKE '%$search_item1%'
										OR middlename LIKE '%$search_item1%'
										OR lastname LIKE '%$search_item1%') AND user_id <> $user_id";
							$result = mysqli_query($conn, $query);
							$rowcount = mysqli_num_rows($result);
							
							if ($rowcount == 0){
								$display = "No results found.";
								echo "<h2> $display </h2>";
							}
							else{
								while ($row = mysqli_fetch_array($result)){
									$fullname = $row['firstname'] . " " . $row['middlename'] . " " .$row['lastname'];
									$id_of_user = $row['user_id'];
									$dp = $row['profile_picture'];
									echo "<img src = 'profilepictures/$dp' width = '50' height = '50' style='border-radius: 50%;'>";
									echo "<a href='otheraccount.php?id=".$id_of_user."'> $fullname <br/><br/>";
								}
								echo "</form>";
							}
						?>
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