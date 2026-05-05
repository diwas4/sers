<?php
// Include PHPMailer classes manually
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                      // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                             // Enable SMTP authentication
    $mail->Username   = 'lamichhanediwas7@gmail.com';     // SMTP username (your email)
    $mail->Password   = 'iidm lexc ikpi hbpv';         // SMTP password (use an App Password, not normal password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable implicit TLS encryption
    $mail->Port       = 587;                              // TCP port to connect to

    // Recipients
    $mail->setFrom('lamichhanediwas7@gmail.com', 'SERS System');
    $mail->addAddress('lamichhanediwas7@gmail.com');      // Add a recipient (sending to yourself for testing)

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = 'This is a test email sent using <b>PHPMailer</b>!';
    $mail->AltBody = 'This is a test email sent using PHPMailer!';

    $mail->send();
    echo 'email sent.';
} catch (Exception $e) {
    echo "not sent. Mailer Error: {$mail->ErrorInfo}";
}
?>