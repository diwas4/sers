<?php
  include "connection.php";
  include "navbar.php";
  require '../PHPMailer/Exception.php';
  require '../PHPMailer/PHPMailer.php';
  require '../PHPMailer/SMTP.php';
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Equipment Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">

		.srch
		{
			padding-left: 850px;

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
.container
{
	height: 600px;
	background-color: black;
	opacity: .8;
	color: white;
}
.scroll
{
  width: 100%;
  height: 500px;
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
    <form action="" style="padding-top: 20px;" method="post">
      <button class="btn btn-default" style="float: left;" name="submit_m">Send Email</button>
    </form>
    <h3 style="text-align: center;">Information of Borrowed Equipments</h3><br>
    <?php
    $c=0;

        $sql="SELECT user.username,issue_eqp.id,equipment.equipment_id,
        name,category,rental_price_per_day,
        issue,issue_eqp.`return` FROM user 
        inner join issue_eqp ON user.username=issue_eqp.username inner join equipment 
        ON issue_eqp.equipment_id=equipment.equipment_id 
        WHERE issue_eqp.approve ='Yes' ORDER BY `issue_eqp`.`return` ASC";
        $res=mysqli_query($db,$sql);
        
        
        echo "<table class='table table-bordered' style='width:100%;' >";
        //Table header
        
        echo "<tr style='background-color: #6db6b9e6;'>";
        echo "<th>"; echo "Username";  echo "</th>";
        echo "<th>"; echo "ID";  echo "</th>";
        echo "<th>"; echo "Equipment ID";  echo "</th>";
        echo "<th>"; echo "Equipment Name";  echo "</th>";
        echo "<th>"; echo "Category";  echo "</th>";
        echo "<th>"; echo "Rental Price Per Day";  echo "</th>";
        echo "<th>"; echo "Issue Date";  echo "</th>";
        echo "<th>"; echo "Return Date";  echo "</th>";
        echo "<th>"; echo "Current Fine"; echo "</th>";

      echo "</tr>"; 
      echo "</table>";

       echo "<div class='scroll'>";
        echo "<table class='table table-bordered' >";
      while($row=mysqli_fetch_assoc($res))
      {
        $d=date("Y-m-d");
        $fine = 0;
        if($d > $row['return'])
        {
          $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';

          mysqli_query($db,"UPDATE issue_eqp SET approve='$var' where username='$row[username]' and equipment_id='$row[equipment_id]' and `return`='$row[return]' and approve='Yes' limit 1;");
          
          $diff = strtotime($d) - strtotime($row['return']);
          $days = floor($diff / (60*60*24));
          $fine = $days * 10;
        }

        echo "<tr>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "<td>"; echo $row['id']; echo "</td>";
          echo "<td>"; echo $row['equipment_id']; echo "</td>";
          echo "<td>"; echo $row['name']; echo "</td>";
          echo "<td>"; echo $row['category']; echo "</td>";
          echo "<td>"; echo $row['rental_price_per_day']; echo "</td>";
          echo "<td>"; echo $row['issue']; echo "</td>";
          echo "<td>"; echo $row['return']; echo "</td>";
          echo "<td>"; echo ($fine > 0) ? "Rs. ".$fine : "Rs. 0"; echo "</td>";
        echo "</tr>";
      }
    echo "</table>";
        echo "</div>";
       
        if(isset($_POST['submit_m']))
        {
          $t=mysqli_query($db, "SELECT * FROM issue_eqp WHERE approve LIKE '%EXPIRED%';");
          if($t) {
            while ($row=mysqli_fetch_assoc($t))
            {
              $name_m=$row['username'];
              $eid_m=$row['equipment_id'];
              $sql_m=mysqli_query($db, "SELECT * FROM user where username='$name_m';");
              $to=mysqli_fetch_assoc($sql_m);
              
              if(!$to || empty($to['email'])) continue;
              
              $mail = new PHPMailer(true);
              try {
                  $mail->isSMTP();
                  $mail->Host       = 'smtp.gmail.com';
                  $mail->SMTPAuth   = true;
                  $mail->Username   = 'lamichhanediwas7@gmail.com';
                  $mail->Password   = 'iidm lexc ikpi hbpv';
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                  $mail->Port       = 587;

                  $mail->setFrom('lamichhanediwas7@gmail.com', 'SERS System');
                  $mail->addAddress($to['email']);

                  $mail->isHTML(true);
                  $mail->Subject = 'URGENT: Equipment Return Overdue';
                  $mail->Body    = "Hello $name_m,<br><br>This is an urgent reminder that your equipment rental with ID <b>$eid_m</b> has <b>expired</b>. Please return it immediately to avoid accumulating any further late fees.<br><br>Thank you,<br>SERS Admin";
                  $mail->AltBody = "Hello $name_m,\n\nThis is an urgent reminder that your equipment rental with ID $eid_m has expired. Please return it immediately to avoid accumulating any further late fees.\n\nThank you,\nSERS Admin";

                  $mail->send();
                  echo "<script type='text/javascript'>alert('Overdue email sent successfully to $name_m');</script>";
              } catch (\Throwable $e) {
                  echo "<script type='text/javascript'>alert('Failed to send email to $name_m. Error: " . addslashes($e->getMessage()) . "');</script>";
              }
            }
          }
        }
    ?>
  </div>
</div>
</body>
</html>