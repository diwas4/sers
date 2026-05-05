<?php
    include "connection.php";
    include "navbar.php";

    // Security check: Only logged-in admins can access this page
    if(!isset($_SESSION['login_user'])) {
        echo "<script>window.location='adminLogin.php'</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <style>
        .container {
            margin-top: 20px;
        }
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .admin-list {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="form-container">
                    <h2>Add New Admin</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" name="mblnumber" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="add_admin" class="btn btn-success">Create Admin Account</button>
                    </form>

                    <?php
                    if(isset($_POST['add_admin'])) {
                        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
                        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
                        $username = mysqli_real_escape_string($db, $_POST['username']);
                        $email = mysqli_real_escape_string($db, $_POST['email']);
                        $mblnumber = mysqli_real_escape_string($db, $_POST['mblnumber']);
                        $password = mysqli_real_escape_string($db, $_POST['password']);

                        // Check if username already exists in admin table
                        $check = mysqli_query($db, "SELECT username FROM admin WHERE username='$username'");
                        if(mysqli_num_rows($check) > 0) {
                            echo "<div class='alert alert-danger' style='margin-top:10px;'>Username already exists!</div>";
                        } else {
                            $sql = "INSERT INTO admin (firstname, lastname, username, email, mblnumber, password, pic) 
                                    VALUES ('$firstname', '$lastname', '$username', '$email', '$mblnumber', '$password', 'profileimg1.avif')";
                            if(mysqli_query($db, $sql)) {
                                echo "<div class='alert alert-success' style='margin-top:10px;'>Admin added successfully!</div>";
                                echo "<script>setTimeout(function(){ window.location='manage_admins.php'; }, 1000);</script>";
                            } else {
                                echo "<div class='alert alert-danger' style='margin-top:10px;'>Error: " . mysqli_error($db) . "</div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="admin-list">
                    <h2>Current Administrators</h2>
                    <table class="table table-bordered table-hover">
                        <tr style="background-color: #54ca2d; color: white;">
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Contact</th>
                        </tr>
                        <?php
                        $res = mysqli_query($db, "SELECT id, firstname, lastname, username, email, mblnumber FROM admin ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['firstname']." ".$row['lastname']."</td>";
                            echo "<td>".$row['username']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['mblnumber']."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
