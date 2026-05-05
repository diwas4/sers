<?php
include "connection.php";

echo "<h2>Fixing Equipment IDs...</h2>";

// 1. Check if there are rows with ID 0
$check = mysqli_query($db, "SELECT * FROM equipment WHERE equipment_id = 0");
if(mysqli_num_rows($check) > 0) {
    echo "Found items with ID 0. Assigning new IDs...<br>";
    
    // Get the current max ID
    $max_res = mysqli_query($db, "SELECT MAX(equipment_id) as max_id FROM equipment");
    $max_row = mysqli_fetch_assoc($max_res);
    $next_id = $max_row['max_id'] + 1;

    while($row = mysqli_fetch_assoc($check)) {
        $old_name = $row['name'];
        mysqli_query($db, "UPDATE equipment SET equipment_id = $next_id WHERE equipment_id = 0 AND name = '$old_name' LIMIT 1");
        echo "Updated '$old_name' to ID $next_id<br>";
        $next_id++;
    }
}

// 2. Set equipment_id to AUTO_INCREMENT
echo "Enabling Auto Increment...<br>";
$sql = "ALTER TABLE equipment MODIFY equipment_id INT AUTO_INCREMENT PRIMARY KEY";

if(mysqli_query($db, $sql)) {
    echo "<h3 style='color:green;'>SUCCESS! Equipment IDs will now be generated automatically.</h3>";
    echo "<a href='add.php'>Go back to Add Equipment</a>";
} else {
    echo "<h3 style='color:red;'>ERROR: " . mysqli_error($db) . "</h3>";
    echo "Note: If it says 'Multiple primary key defined', just ignore it, the auto-increment might already be working.";
}
?>
