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
		
		body 
    {
  background-color: #1c1fcb;
  font-family: "Lato", sans-serif;
  transition: background-color .5s;
}

.sidenav 
{
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

.sidenav a 
{
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
	background-color: #f63517;
}

.equipment
{
    width: 400px;
    margin: 0px auto;
}
.form-control
{
  background-color: #080707;
  color: white;
  height: 40px;
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

                { 	
                    echo "<img class='img-circle profile_img' height=120 width=120 src='images/".$_SESSION['pic']."'>";
                    echo "</br></br>";

                    echo "Welcome ".$_SESSION['login_user']; 
                }
                ?>
            </div><br><br>

 <div class="h"> <a href="add.php">Add Equipments</a> </div> 
  <div class="h"> <a href="request.php">Equipment Request</a></div>
  <div class="h"> <a href="issue_info.php">Issue Information</a></div>
  <div class="h"><a href="expired.php">Expired List</a></div>
</div>

<div id="main">
  <span style="font-size:30px;cursor:pointer; color: black;" onclick="openNav()">&#9776; open</span>
  <div class="container" style="text-align: center;">
    <h2 style="color:black; font-family: Lucida Console; text-align: center"><b>Add New Equipments</b></h2>
    
    <form class="equipment" action="" method="post">
        
        <input type="text" name="name" class="form-control" placeholder="Equipment Name" required=""><br>
        <input type="text" name="category" class="form-control" placeholder="Category" required=""><br>
        <input type="text" name="quantity_available" class="form-control" placeholder="Available Quantity" required=""><br>
        <input type="text" name="rental_price_per_day" class="form-control" placeholder="Rental Price Per Day" required=""><br>

        <input type="text" name="item_condition" class="form-control" placeholder="Item Condition" required=""><br>
        <input type="text" name="status" class="form-control" placeholder="Status" required=""><br>

        <button style="text-align: center;" class="btn btn-default" type="submit" name="submit">ADD</button>
    </form>
  </div>
<?php
    if(isset($_POST['submit']))
{
    if(isset($_SESSION['login_user']))
    {
        $query = "INSERT INTO equipment 
        (name, category, quantity_available, rental_price_per_day, item_condition, status)
        VALUES 
        ('$_POST[name]', '$_POST[category]', '$_POST[quantity_available]', 
         '$_POST[rental_price_per_day]',
         '$_POST[item_condition]', '$_POST[status]')";

        $result = mysqli_query($db, $query);

        if($result)
        {
            echo "<script>alert('Equipment Added Successfully');</script>";
        }
        else
        {
            echo "<script>alert('Error: ".mysqli_error($db)."');</script>";
        }
    }
    else
    {
        echo "<script>alert('You need to login first');</script>";
    }
}
?>
</div>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
  document.getElementById("main").style.marginLeft = "300px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "#039e1a";
}
</script>

</body>
