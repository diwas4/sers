<?php
include "connection.php";
$res = mysqli_query($db, "UPDATE fine SET day = @temp := day, day = fine, fine = @temp;");
echo "Existing fine data fixed!";
?>
