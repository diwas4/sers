<?php
    include "connection.php";
    include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <section>
        <div class="log_img">
            <br>
            <div class="box1">
                <h1 style="text-align: center; font-size: 35px; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                    Sports Equipment Rental System
                </h1>
                <h1 style = "text-align: center; font-size: 25px;">Login Form</h1><br>
                <form action="" name="login" method="post"> 
                    <div class="login">
                    <input class="form-control" type="text" name="username" placeholder="Username" required=""> <br>
                    <input class="form-control" type="password" name="password" placeholder="Password" required=""> <br>
                    <div style="color: white; margin-bottom: 15px; font-size: 16px;">
                        <label style="margin-right: 20px; font-weight: normal;"><input type="radio" name="role" value="user" checked style="width: auto; height: auto; margin-right: 5px;"> User</label>
                        <label style="font-weight: normal;"><input type="radio" name="role" value="admin" style="width: auto; height: auto; margin-right: 5px;"> Admin</label>
                    </div>
                    <input type="submit" class="btn btn-success" name="submit" value="Login" 
                    style="width: 80px; height: 35px;">
                    </div>
                
                <p style="color: white;">
                    <br>
                    <a style="color: white; margin: auto 30px;" href="">Forgot Password?</a>
                    New to this website? <a style="color: white;" href="registration.php">Sign Up</a>
                </p>
                </form>
            </div>
        </div>

    </section>
    <?php
    if (isset($_POST['submit']))
    {
        $role = $_POST['role'];
        if ($role == 'admin') {
            $res=mysqli_query($db, "SELECT * FROM admin WHERE username='$_POST[username]' && password='$_POST[password]';");
            if(mysqli_num_rows($res) == 0) {
                ?>
                <script>
                    alert("The admin username and password doesn't match");
                </script>
                <?php
            } else {
                $row= mysqli_fetch_assoc($res);
                $_SESSION['login_user'] = $_POST['username'];
                $_SESSION['pic'] = $row['pic'];
                ?>
                <script type="text/javascript">
                    window.location="../admin/index.php"
                </script>
                <?php
            }
        } else {
            $res=mysqli_query($db, "SELECT * FROM user WHERE username='$_POST[username]' && password='$_POST[password]';");
            if(mysqli_num_rows($res) == 0) {
                ?>
                <script>
                    alert("The user username and password doesn't match");
                </script>
                <?php
            }
            else
            {
                $row= mysqli_fetch_assoc($res);
                if($row['status']==1)
                {
                    $_SESSION['login_user'] = $_POST['username'];
                    $_SESSION['pic'] = $row['pic'];
                ?>
                    <script type="text/javascript">
                        window.location="index.php"
                    </script>
                <?php
                }
                else
                {
                    ?>
                    <script>
                        alert("Your account is not verified. Please verify your email address.");
                    </script>
                    <?php
                }
                
            }
        }
    }
    ?>
</body>
</html>