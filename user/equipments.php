<?php
  include "connection.php";
  include "navbar.php";
?>


<!DOCTYPE html>
<html>
<head>
	<title>Equipments</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">
		.srch
		{
			padding-left: 900px;

		}
		
		body {
  font-family: "Lato", sans-serif;
  transition: background-color .5s;
}

.sidenav {
  height: 100%;
  margin-top: 50px;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #222;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: white;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.img-circle
{
	margin-left: 20px;
}
.h:hover
{
	color:white;
	width: 300px;
	height: 50px;
	background-color: #00544c;
}

	</style>

</head>
<body>
	<!--_________________sidenav_______________-->
	
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  			<div style="color: white; margin-left: 60px; font-size: 20px;">

                <?php
                if(isset($_SESSION['login_user']))

                { 	echo "<img class='img-circle profile_img' height=120 width=120 src='images/".$_SESSION['pic']."'>";
                    echo "</br></br>";

                    echo "Welcome ".$_SESSION['login_user']; 
                }
                ?>
            </div><br><br>

 
  <div class="h"> <a href="equipments.php">Equipments</a></div>
  <div class="h"> <a href="request.php">Equipment Request</a></div>
  <div class="h"> <a href="issue_info.php">Issue Information</a></div>
  <div class="h"><a href="expired.php">Expired List</a></div>
</div>

<div id="main">
  
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
  document.getElementById("main").style.marginLeft = "300px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}
</script>
	<!--___________________search bar________________________-->

	<div class="srch">
		<form class="navbar-form" method="post" name="form1">
			<label for="category">Choose a Category:</label>
			<select name="category" id="category" class="form-control">
				<option value="Cricket">Cricket</option>
				<option value="Football">Football</option>
				<option value="Badminton">Badminton</option>
				<option value="Table Tennis">Table Tennis</option>
				<option value="Basketball">Basketball</option>
			</select>
			<input class="form-control" type="text" name="search" placeholder="Search Equipments.." required="">
			<button style="background-color: #6db6b9e6;" type="submit" name="submit" class="btn btn-default">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</form>
	</div>
	<!--___________________request equipment__________________-->
	<div class="srch">
		<form class="navbar-form" method="post" name="form1">
			
				<input class="form-control" type="text" name="equipment_id" placeholder="Enter Equipment ID" required="">
				<button style="background-color: #6db6b9e6;" type="submit" name="submit1" class="btn btn-default">Request
				</button>
		</form>
	</div>


	<h2>Recommended Equipments</h2>
	<?php
		$rec=mysqli_query($db,"SELECT equipment.equipment_id, equipment.name, equipment.category, 
		equipment.rental_price_per_day, 
		COUNT(issue_eqp.equipment_id) 
		AS borrow_count FROM equipment JOIN issue_eqp ON equipment.equipment_id 
		= issue_eqp.equipment_id GROUP BY equipment.equipment_id ORDER BY borrow_count DESC LIMIT 3;");

		if(mysqli_num_rows($rec) > 0)
		{
			echo "<div style='display:flex; justify-content:space-around; padding-bottom: 20px;'>";
			while($r_row=mysqli_fetch_assoc($rec))
			{
				echo "<div style='background-color:#6db6b9e6; color:black; padding:15px; border-radius:10px; width:30%; text-align:center; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);'>";
				echo "<h3>" . $r_row['name'] . "</h3>";
				echo "<p>Category: " . $r_row['category'] . "</p>";
				echo "<p>Price/Day: " . $r_row['rental_price_per_day'] . "</p>";
				echo "<p style='font-size: 12px; color: #444;'>Times Requested: " . $r_row['borrow_count'] . "</p>";
				echo "</div>";
			}
			echo "</div>";
		}
	?>

	<br>
	<h2>List Of Equipments</h2>
	<?php

		if(isset($_POST['submit']))
		{
			
			$q=mysqli_query($db,"SELECT * from equipment 
			where name like '%$_POST[search]%' 
			AND category = '$_POST[category]'");

			if(mysqli_num_rows($q)==0)
			{
				echo "Sorry! No equipment found. Try searching again.";
			}
			else
			{
		echo "<table class='table table-bordered table-hover' >";
			echo "<tr style='background-color: #6db6b9e6;'>";
				//Table header
				echo "<th>"; echo "ID"; echo "</th>";
                echo "<th>"; echo "Equipment Name"; echo "</th>";
                echo "<th>"; echo "Category"; echo "</th>";
                echo "<th>"; echo "Quantity"; echo "</th>";
                echo "<th>"; echo "Price/Day"; echo "</th>";
                echo "<th>"; echo "Condition"; echo "</th>";
                echo "<th>"; echo "Status"; echo "</th>";
                echo "</tr>";	

			while($row=mysqli_fetch_assoc($q))
			{
				echo "<tr>";
                    echo "<td>"; echo $row['equipment_id']; echo "</td>";
                    echo "<td>"; echo $row['name']; echo "</td>";
                    echo "<td>"; echo $row['category']; echo "</td>";
                    echo "<td>"; echo $row['quantity_available']; echo "</td>";
                    echo "<td>"; echo $row['rental_price_per_day']; echo "</td>";
                    echo "<td>"; echo $row['item_condition']; echo "</td>";
                    echo "<td>"; echo $row['status']; echo "</td>";
                    echo "</tr>";
			}
		echo "</table>";
			}
		}
			/*if button is not pressed.*/
		else
		{
			$res=mysqli_query($db, "SELECT * FROM equipment ORDER BY
            equipment. name ASC;");
                echo "<table class='table table-bordered table-hover'>";
                echo "<tr style='background-color: #f05b20;'>";
                echo "<th>"; echo "ID"; echo "</th>";
                echo "<th>"; echo "Equipment Name"; echo "</th>";
                echo "<th>"; echo "Category"; echo "</th>";
                echo "<th>"; echo "Quantity"; echo "</th>";
                echo "<th>"; echo "Price/Day"; echo "</th>";
                echo "<th>"; echo "Condition"; echo "</th>";
                echo "<th>"; echo "Status"; echo "</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($res))
                {
                    echo "<tr>";
                    echo "<td>"; echo $row['equipment_id']; echo "</td>";
                    echo "<td>"; echo $row['name']; echo "</td>";
                    echo "<td>"; echo $row['category']; echo "</td>";
                    echo "<td>"; echo $row['quantity_available']; echo "</td>";
                    echo "<td>"; echo $row['rental_price_per_day']; echo "</td>";
                    echo "<td>"; echo $row['item_condition']; echo "</td>";
                    echo "<td>"; echo $row['status']; echo "</td>";
                    echo "</tr>";
                }
		echo "</table>";
		}

		if(isset($_POST['submit1']))
		{
			if(isset($_SESSION['login_user']))
			{
				// First check if the equipment ID exists
				$check_eq = mysqli_query($db, "SELECT * FROM equipment WHERE equipment_id='$_POST[equipment_id]'");
				if(mysqli_num_rows($check_eq) > 0)
				{
					$sql = "INSERT INTO issue_eqp (username, equipment_id, approve, issue, `return`) Values('$_SESSION[login_user]', '$_POST[equipment_id]', '', '', '');";
					if(mysqli_query($db, $sql))
					{
						?>
						<script type="text/javascript">
							alert("Request sent successfully.");
							window.location="request.php"
						</script>
						<?php
					}
					else
					{
						echo "<script>alert('Error: ".mysqli_error($db)."');</script>";
					}
				}
				else
				{
					echo "<script>alert('Error: Equipment ID does not exist.');</script>";
				}
			}
			else
			{
				?>
					<script type="text/javascript">
						alert("You must login to Request an equipment");
					</script>
				<?php
			}
		}

	?>
</div>
</body>
</html>