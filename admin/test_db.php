<?php require "connection.php"; $res=mysqli_query($db, "SELECT * FROM issue_eqp"); while($row=mysqli_fetch_assoc($res)) { var_dump($row); } ?>
