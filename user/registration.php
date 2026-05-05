<?php
    include "connection.php";
    include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <section>
        <div class="reg_img">
            <br>
            <div class="box2">
                <h1 style="text-align: center; font-size: 35px; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                    Sports Equipment Rental System
                </h1>
                <h1 style = "text-align: center; font-size: 25px;">Registration Form</h1> <br>
                <form action="" name="Registration" method="post"> 
                    <div class="login">
                        <input class="form-control" type="text" name="firstname" placeholder="Enter your first name" required="">
                        <br>
                        <input class="form-control" type="text" name="lastname" placeholder="Enter your last name" required=""> 
                        <br>
                        <input class="form-control" type="text" name="username" placeholder="Enter your username" required="">
                        <br>
                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required="">
                        <br>
                        <input class="form-control" type="number" name="mblnumber" placeholder="Enter your mobile number" required="">
                        <br>
                        <input class="form-control" type="password" name="password" placeholder="Enter your password" required=""> 
                        <br>
                        <input type="submit" class="btn btn-info" name="submit" value="Sign Up" 
                        style="width: 80px; height: 35px;">
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php
if(isset($_POST['submit']))
{
    // Sanitize inputs
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mblnumber = trim($_POST['mblnumber']);
    $password = trim($_POST['password']);

    // VALIDATIONS
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "<script>alert('Invalid Email Format');</script>";
        exit();
    }

    if(!preg_match("/^[0-9]{10}$/", $mblnumber))
    {
        echo "<script>alert('Mobile number must be 10 digits');</script>";
        exit();
    }

    if(strlen($password) < 6)
    {
        echo "<script>alert('Password must be at least 6 characters');</script>";
        exit();
    }

    // Check username already exists in user table
    $count = 0;
    
    $res = mysqli_query($db, "SELECT username FROM user WHERE username='$username'");
    $count = mysqli_num_rows($res);

    if($count == 0)
    {
        mysqli_query($db,"INSERT INTO user (firstname, lastname, username, email, status, mblnumber, password, pic) 
        VALUES ('$firstname', '$lastname', '$username', 
        '$email', '0', '$mblnumber', '$password', 
        'profileimg1.avif')");
        
        $otp = rand(10000, 99999);
        $date = date('Y-m-d H:i:s');
        mysqli_query($db, "INSERT INTO verify VALUES ('$username', '$otp', '$date')");
        
        require '../PHPMailer/Exception.php';
        require '../PHPMailer/PHPMailer.php';
        require '../PHPMailer/SMTP.php';
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lamichhanediwas7@gmail.com';
            $mail->Password   = 'iidm lexc ikpi hbpv';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            $mail->setFrom('lamichhanediwas7@gmail.com', 'SERS System');
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for SERS Registration';
            $mail->Body    = "Your OTP is: <b>$otp</b>";
            
            $mail->send();
            echo "<script>window.location='verify.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send OTP email. Please try again.');</script>";
        }
    }
    else
    {
        echo "<script>alert('Username already exists.');</script>";
    }
}
?>
</body>
</html>