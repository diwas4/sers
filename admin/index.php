<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Sports Equipment Rental System
    </title>
    <link rel="stylesheet" href="style.css">
    <style>
    nav {
        float: right;
        word-spacing: 30px;
        padding: 10px;
    }
    nav li {
        display: inline-block;
        line-height: 70px;   
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <header>
            
            <div class="logo">
                <img src="images/sers1.png" alt="">
                <h1 style="color: white;">SPORTS EQUIPMENT RENTAL SYSTEM</h1>
            </div>

            <?php
            if(isset($_SESSION['login_user']))
            {
                ?>
                 <nav>
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="equipments.php">EQUIPMENTS</a></li>
                        <li><a href="logout.php">LOGOUT</a></li>
                        <li><a href="manage_admins.php">ADMINS</a></li>
                        <li><a href="user.php">USER-INFORMATION</a></li>
                        <li><a href="feedback.php">FEEDBACK</a></li>
                    </ul>
                </nav>
                <?php    
            }
            else
            {
                ?>
                <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="equipments.php">EQUIPMENTS</a></li>
                    <li><a href="adminLogin.php">LOGIN</a></li>
                    <li><a href="feedback.php">FEEDBACK</a></li>
                </ul>
                </nav>
                <?php
            }
            ?>
            
        </header>
        <section>
            <div class="sec_img">
            <br><br>
            <div class="box">
                <br><br><br>
                <h1 style="text-align: center; font-size: 35px; color: black;">Gear Up for Every Game</h1><br>
                <p style="text-align: center; font-size: 18px; text-align: justify; padding: 20px; color: black; line-height: 1.6;">
                    <b>Welcome to the Sports Equipment Rental System (SERS). We provide users and sports enthusiasts with athletic equipment for renting purposes. <br><br>
                    Whether you are training for a tournament or just playing for fun, our system makes it easy to browse, reserve, and manage your gear in real-time. Elevate your game with the right equipment, right when you need it.</b>
                </p>
            </div>
            </div>
        </section>
        <footer>
            <p style="color: white; text-align: center; font-size: 20px; padding: 2px;">
                
                Email:&nbsp sportsrental4@gmail.com <br>
                Mobile:&nbsp +977 9702000000
            </p>
        </footer>
    </div>
</body>
</html>