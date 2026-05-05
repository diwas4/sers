<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "connection.php";
$res = mysqli_query($db, "SELECT * FROM fine");
$rows = [];
while($row = mysqli_fetch_assoc($res)){
    $rows[] = $row;
}

mysqli_query($db, "TRUNCATE TABLE fine");

foreach ($rows as $row) {
    if ($row['status'] !== 'paid' && $row['status'] !== 'not paid') {
        $real_equipment_id = $row['status'];
        $real_day = $row['returned'];
        $real_fine = $row['day'];
        $real_returned = '2026-04-23'; // fallback
        $real_status = 'not paid';
        $real_username = $row['username'];
        
        mysqli_query($db, "INSERT INTO fine (`username`, `equipment_id`, `returned`, `day`, `fine`, `status`) VALUES ('$real_username', '$real_equipment_id', '$real_returned', '$real_day', '$real_fine', '$real_status')");
    } else {
        // already fine
        $username = $row['username'];
        $equipment_id = $row['equipment_id'];
        $returned = $row['returned'];
        $day = $row['day'];
        $fine = $row['fine'];
        $status = $row['status'];
        mysqli_query($db, "INSERT INTO fine (`username`, `equipment_id`, `returned`, `day`, `fine`, `status`) VALUES ('$username', '$equipment_id', '$returned', '$day', '$fine', '$status')");
    }
}
echo "Table rebuilt and data fixed successfully.";
?>
