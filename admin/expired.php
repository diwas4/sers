<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Equipment Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">

		.srch
		{
			padding-left: 70%;

		}
		.form-control
		{
			width: 300px;
			height: 40px;
			background-color: black;
			color: white;
		}
		
		body {
			background-image: url("images/aa.jpg");
			background-repeat: no-repeat;
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
  padding-left: 15px;
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
.container
{
	height: 800px;
  width: 85%;
	background-color: black;
	opacity: .8;
	color: white;
  margin-top: -65px;
}
.scroll
{
  width: 100%;
  height: 400px;
  overflow: auto;
}
th,td
{
  width: 10%;
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
  <div class="container">
    
    <?php
      if(isset($_SESSION['login_user']))
      {
        ?>

      <div style="float: left; padding: 25px;">
      <form method="post" action="">
          <button name="submit2" type="submit" class="btn btn-default" style="background-color: #06861a; color: yellow;">RETURNED</button> 
                      &nbsp&nbsp
          <button name="submit3" type="submit" class="btn btn-default" style="background-color: red; color: yellow;">EXPIRED</button>
      </form>
      </div>

          <div class="srch" >
          <br>
          <form method="post" action="" name="form1">
            <input type="text" name="username" class="form-control" placeholder="Username" required=""><br>
            <input type="text" name="equipment_id" class="form-control" placeholder="Equipment ID" required=""><br>
            <button class="btn btn-default" name="submit" type="submit">Submit</button><br><br>
          </form>
        </div>
        <?php

        if(isset($_POST['submit']))
        {

          $var1='<p style="color:yellow; background-color:green;">RETURNED</p>';
          $res=mysqli_query($db,"SELECT * FROM `issue_eqp` where username='$_POST[username]' and equipment_id='$_POST[equipment_id]' and approve!='$var1';");
      
          while($row=mysqli_fetch_assoc($res))
          {
            $d= strtotime($row['return']);
            $c= strtotime(date("Y-m-d"));
            $diff= $c-$d;

            $day = 0;
            $fine = 0;
            if($diff>0)
            {
              $day= floor($diff/(60*60*24)); 
              $fine= $day*10;
            }
            
            $x= date("Y-m-d"); 
            if ($fine > 0) {
              mysqli_query($db,"INSERT INTO `fine` (`username`, `equipment_id`, `returned`, `day`, `fine`, `status`) VALUES ('$_POST[username]', '$_POST[equipment_id]', '$x', '$day', '$fine','not paid');");
            }
          }

          mysqli_query($db,"UPDATE issue_eqp SET approve='$var1' where username='$_POST[username]' and equipment_id='$_POST[equipment_id]' and approve!='$var1'");

          if(mysqli_affected_rows($db) > 0) {
            mysqli_query($db,"UPDATE equipment SET quantity_available = quantity_available+1 where equipment_id='$_POST[equipment_id]'");
          }
          
        }
      }
    
    $c=0;

      
         $ret='<p style="color:yellow; background-color:green;">RETURNED</p>';
         $exp='<p style="color:yellow; background-color:red;">EXPIRED</p>';
        
        if(isset($_POST['submit2']))
        {
          
        $sql="SELECT user.username,issue_eqpk.id,equipment.equipment_id,
        name,category,rental_price_per_day,
        approve,issue,issue_eqp.`return` FROM 
        user inner join issue_eqp ON user.username=issue_eqp.username 
        inner join equipment ON issue_eqp.equipment_id=equipment.equipment_id 
        WHERE issue_eqp.approve ='$ret' ORDER BY `issue_eqp`.`return` DESC";
        $res=mysqli_query($db,$sql);

        }
        else if(isset($_POST['submit3']))
        {
        $sql="SELECT user.username,issue_eqp.id,equipment.equipment_id,name,category,
        rental_price_per_day,approve,issue,issue_eqp.`return` FROM user 
        inner join issue_eqp ON user.username=issue_eqp.username 
        inner join equipment ON issue_eqp.equipment_id=equipment.equipment_id 
        WHERE issue_eqp.approve ='$exp' ORDER BY `issue_eqp`.`return` DESC";
        $res=mysqli_query($db,$sql);
        }
        else
        {
        $sql="SELECT user.username,issue_eqp.id,equipment.equipment_id,name,category,
        rental_price_per_day,approve,issue,issue_eqp.`return` FROM user 
        inner join issue_eqp ON user.username=issue_eqp.username 
        inner join equipment ON issue_eqp.equipment_id=equipment.equipment_id 
        WHERE issue_eqp.approve !='' and issue_eqp.approve !='Yes' ORDER BY `issue_eqp`.`return` DESC";
        $res=mysqli_query($db,$sql);
        }

        echo "<table class='table table-bordered' style='width:100%;' >";
        //Table header
        
        echo "<tr style='background-color: #6db6b9e6;'>";
        echo "<th>"; echo "Username";  echo "</th>";
        echo "<th>"; echo "ID";  echo "</th>";
        echo "<th>"; echo "Equipment ID";  echo "</th>";
        echo "<th>"; echo "Name";  echo "</th>";
        echo "<th>"; echo "Category";  echo "</th>";
        echo "<th>"; echo "Rental Price Per Day";  echo "</th>";
        echo "<th>"; echo "Status";  echo "</th>";
        echo "<th>"; echo "Issue Date";  echo "</th>";
        echo "<th>"; echo "Return Date";  echo "</th>";

      echo "</tr>"; 
      echo "</table>";

       echo "<div class='scroll'>";
        echo "<table class='table table-bordered' >";
      while($row=mysqli_fetch_assoc($res))
      {
        echo "<tr>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "<td>"; echo $row['id']; echo "</td>";
          echo "<td>"; echo $row['equipment_id']; echo "</td>";
          echo "<td>"; echo $row['name']; echo "</td>";
          echo "<td>"; echo $row['category']; echo "</td>";
          echo "<td>"; echo $row['rental_price_per_day']; echo "</td>";
          echo "<td>"; echo $row['approve']; echo "</td>";
          echo "<td>"; echo $row['issue']; echo "</td>";
          echo "<td>"; echo $row['return']; echo "</td>";
        echo "</tr>";
      }
    echo "</table>";
        echo "</div>";

    ?>
  </div>
</div>
</body>
</html>