<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "connection.php";
$res = mysqli_query($db, "SHOW COLUMNS FROM fine");
while($row = mysqli_fetch_assoc($res)){
    print_r($row['Field']);
    echo "<br>";
}
?>
