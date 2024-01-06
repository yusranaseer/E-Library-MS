<html>
  <head>
    <title>Test</title>
    <script src="js/sweetalert.min.js"></script>
  </head>
  <body>
    

<?php
session_start();
include('dbcon.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_GET["email"];

require 'Mailer/PHPMailer-master/src/Exception.php'; 
require 'Mailer/PHPMailer-master/src/PHPMailer.php'; 
require 'Mailer/PHPMailer-master/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
//ast_123_
try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mercyeducationinstitute@gmail.com';                     //SMTP username
    $mail->Password   = 'lizqvaxonrsowtzf';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mercyeducationinstitute@gmail.com');
    $mail->addAddress($email);     //Add a recipient             //Name is optional


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Innovation Confirmation';
    $mail->Body    = 'Your Innovation has been accepted and 50 insite coins added to your account.';

    $mail->send();
    ?>
    <script type="text/javascript">
        swal({
            title: "Mailer Says,",
            text: "Email Sent successfully!!!",
            icon: "success"
        }).then(function() {
            window.location = "innovations.php";
        });
    </script>
    <?php

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    ?>
    <script type="text/javascript">
        swal({
            title: "Mailer Says,",
            text: "Email could not be sent. Mailer Error!!!",
            icon: "error"
        }).then(function() {
            window.location = "pendingInno.php";
        });
    </script>
    <?php
}
?>

  </body>
</html>