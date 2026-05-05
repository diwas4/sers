<?php
include "connection.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Email Address</title>
    <style>
        .boxa
        {
            width: 350px;
            height: 450px;
            margin: 0px auto;
            opacity: .8;
            color: white;
            padding-top: 200px;
        }
    </style>
</head>
<body style="background-color: #00695c">
    <div class="boxa">
        <h2>Enter the OTP:-</h2>
        <form method="post">
            <input style="width: 300px; height: 50px;" 
            name="otp" type="text" class="form-control" 
            required="" placeholder="Enter the OTP here...">
            <br>
            <button class="btn btn-default" type="submit" 
            name="submit_v" style="font-weight: 700;">Verify</button>

        </form>
    </div>
    <?php
        $ver1=0;
        if(isset($_POST['submit_v']))
        {
            $ver2=mysqli_query($db, "SELECT * FROM verify;");
            while($row=mysqli_fetch_assoc($ver2))
            {
                if($_POST['otp']==$row['otp'])
                {
                    mysqli_query($db, "UPDATE user SET 
                    status='1' WHERE username='$row[username]';");
                    $ver1=$ver1+1;
                }
            }
            if($ver1 >= 1)
            {
                echo "<script>window.location='userLogin.php';</script>";
            }
            else
            {
                echo "<script>alert('Invalid OTP. Please try again.');</script>";
            }
        }
    ?>

</body>
</html>