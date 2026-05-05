<?php
    include "connection.php";
    include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
        .user-list {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .search-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!--___________Add User Form________-->
                <div class="form-container">
                    <h2>Add New User</h2>
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
                        <button type="submit" name="add_user" class="btn btn-success">Create User Account</button>
                    </form>

                    <?php
                    if(isset($_POST['add_user'])) {
                        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
                        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
                        $username = mysqli_real_escape_string($db, $_POST['username']);
                        $email = mysqli_real_escape_string($db, $_POST['email']);
                        $mblnumber = mysqli_real_escape_string($db, $_POST['mblnumber']);
                        $password = mysqli_real_escape_string($db, $_POST['password']);

                        $check = mysqli_query($db, "SELECT username FROM user WHERE username='$username'");
                        if(mysqli_num_rows($check) > 0) {
                            echo "<div class='alert alert-danger' style='margin-top:10px;'>Username already exists!</div>";
                        } else {
                            $sql = "INSERT INTO user (firstname, lastname, username, email, mblnumber, password, pic) 
                                    VALUES ('$firstname', '$lastname', '$username', '$email', '$mblnumber', '$password', 'profileimg1.avif')";
                            if(mysqli_query($db, $sql)) {
                                echo "<div class='alert alert-success' style='margin-top:10px;'>User added successfully!</div>";
                                echo "<script>setTimeout(function(){ window.location='user.php'; }, 1000);</script>";
                            }
                        }
                    }

                    // Handling User Deletion
                    if(isset($_GET['del_id'])) {
                        $del_id = mysqli_real_escape_string($db, $_GET['del_id']);
                        
                        // 1. Get the username of the user being deleted (needed for related tables)
                        $user_query = mysqli_query($db, "SELECT username FROM user WHERE id='$del_id'");
                        if($user_row = mysqli_fetch_assoc($user_query)) {
                            $username = $user_row['username'];
                            
                            // 2. Force delete from related tables first to avoid constraint errors
                            mysqli_query($db, "DELETE FROM issue_eqp WHERE username='$username'");
                            mysqli_query($db, "DELETE FROM fine WHERE username='$username'");
                            
                            // 3. Now delete the user account
                            if(mysqli_query($db, "DELETE FROM user WHERE id='$del_id'")) {
                                echo "<script>alert('User and all related records deleted successfully.'); window.location='user.php'</script>";
                            } else {
                                echo "<div class='alert alert-danger'>Error deleting user: " . mysqli_error($db) . "</div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-8">
                <div class="user-list">
                    <!--___________Search Bar________-->
                    <div class="search-box">
                        <form action="" class="navbar-form" method="post" name="form1">
                            <input class="form-control" type="text" name="search" placeholder="Search Username..." required="">
                            <button style="background-color: #54ca2d;" type="submit" name="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </form>
                    </div>

                    <h2>List Of Users</h2>
                    <table class='table table-bordered table-hover'>
                        <tr style='background-color: #54ca2d; color: white;'>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        if(isset($_POST['submit'])) {
                            $search = mysqli_real_escape_string($db, $_POST['search']);
                            $q = mysqli_query($db, "SELECT id, firstname, lastname, username, email, mblnumber FROM user WHERE username LIKE '%$search%'");
                        } else {
                            $q = mysqli_query($db, "SELECT id, firstname, lastname, username, email, mblnumber FROM user ORDER BY firstname ASC");
                        }

                        if(mysqli_num_rows($q) == 0) {
                            echo "<tr><td colspan='7' style='text-align:center;'>No User Found!</td></tr>";
                        } else {
                            while($row = mysqli_fetch_assoc($q)) {
                                echo "<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['firstname']."</td>";
                                echo "<td>".$row['lastname']."</td>";
                                echo "<td>".$row['username']."</td>";
                                echo "<td>".$row['email']."</td>";
                                echo "<td>".$row['mblnumber']."</td>";
                                echo "<td><a href='user.php?del_id=".$row['id']."' class='btn btn-danger btn-xs' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>