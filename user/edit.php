<?php
	include "connection.php";
	include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<style type="text/css">
		.form-control
		{
			width:250px;
			height: 38px;
		}
		.form1
		{
			margin:0 540px;
		}
		label
		{
			color: white;
		}

	</style>
</head>
<body style="background-color: #004528;">

	<h2 style="text-align: center;color: #fff;">Edit Information</h2>
	<?php
		
		$sql = "SELECT * FROM user WHERE username='$_SESSION[login_user]'";
		$result = mysqli_query($db,$sql) or die (mysql_error());

		while ($row = mysqli_fetch_assoc($result)) 
		{
			$first=$row['firstname'];
			$last=$row['lastname'];
			$username=$row['username'];
			$email=$row['email'];
			$mblno=$row['mblnumber'];
			$pword=$row['password'];
		}

	?>

	<div class="profile_info" style="text-align: center;">
		<span style="color: white;">Welcome,</span>	
		<h4 style="color: white;"><?php echo $_SESSION['login_user']; ?></h4>
	</div><br><br>
	
	<div class="form1">
		<form action="" method="post" enctype="multipart/form-data">

		<label><h4><b>Profile Picture: </b></h4></label>
		<input class="form-control" type="file" name="file">

		<label><h4><b>First Name: </b></h4></label>
		<input class="form-control" type="text" name="first" value="<?php echo $first; ?>">

		<label><h4><b>Last Name: </b></h4></label>
		<input class="form-control" type="text" name="last" value="<?php echo $last; ?>">

		<label><h4><b>Username: </b></h4></label>
		<input class="form-control" type="text" name="username" value="<?php echo $username; ?>">

		<label><h4><b>Password: </b></h4></label>
		<input class="form-control" type="text" name="password" value="<?php echo $pword; ?>">

		<label><h4><b>Email: </b></h4></label>
		<input class="form-control" type="text" name="email" value="<?php echo $email; ?>">

		<label><h4><b>Contact No: </b></h4></label>
		<input class="form-control" type="text" name="contact" value="<?php echo $mblno; ?>">

		<br>
		<div style="padding-left: 100px;">
			<button class="btn btn-default" type="submit" name="submit">save</button></div>
	</form>
</div>
	<?php 

		if(isset($_POST['submit']))
		{
			$pic = $_FILES['file']['name'];
			if($pic != "")
			{
				move_uploaded_file($_FILES['file']['tmp_name'],"images/".$pic);
			}
			else
			{
				$pic = $_SESSION['pic']; // Keep old picture if none selected
			}

			$first=$_POST['first'];
			$last=$_POST['last'];
			$username=$_POST['username'];
			$email=$_POST['email'];
			$mblno=$_POST['contact'];
			$pword=$_POST['password'];

			$sql1= "UPDATE user SET pic='$pic', firstname='$first', lastname='$last', username='$username', 
			email='$email', mblnumber='$mblno', password='$pword' WHERE username='".$_SESSION['login_user']."';";

			if(mysqli_query($db,$sql1))
			{
				$_SESSION['login_user'] = $username;
				$_SESSION['pic'] = $pic;
				?>
					<script type="text/javascript">
						alert("Saved Successfully.");
						window.location="profile.php";
					</script>
				<?php
			}
		}
 	?>
</body>
</html>

