<?php

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$email = $_POST["email"];

$activationLink = "http://localhost:3000/email/activate.php?email=" . $email;

$body = "
<html>
    <head>
        <style type='text/css'> 
            body {
                font-family: Calibri, sans-serif;
                font-size: 16px;
                color: #000;
            }
            .link {
                font-weight: bold;
                color: #007bff;
            }
        </style>
    </head>
    <body>            
        <br><br>
        Welcome to Pocket Garage! Thank you for signing up. To activate your account and start using Pocket Garage, please click the link below:
        <br><br>
        <a class='link' href='". $activationLink ."'>Activate your account</a>
        <br><br>
        If you did not sign up for Pocket Garage, you can safely ignore this email.
        <br><br>
        Best regards,<br>
        The Pocket Garage Support Team
    </body>

</html>";

try {
    // Server settings
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host         = 'smtp.hostinger.com';                 // Specify SMTP server
    $mail->SMTPAuth     = true;                                 // Enable SMTP authentication
    $mail->Username     = 'PersonalEMPG@pocket-garage.com';     // SMTP username
    $mail->Password     = 'PocketGarage-01';                    // SMTP password
    $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;          // Enable TLS encryption
    $mail->Port = 465;                                          // TCP port to connect to

    $mail->CharSet = 'UTF-8';
    $mail->FromName = "Pocket Garage";
    $mail->Subject = "Activate Your Pocket Garage Account";
    $mail->From = "PersonalEMPG@pocket-garage.com";

    $mail->IsHTML(true);
    $mail->AddAddress($email); // To mail id                
    $mail->MsgHTML($body);
    $mail->WordWrap = 50;
   
        
    if ($mail->send()) {
        echo json_encode(['success' => true, 'message' => 'Activation email sent successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send activation email.']);
    }
    
    echo 'Message has been sent';
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
}


?>