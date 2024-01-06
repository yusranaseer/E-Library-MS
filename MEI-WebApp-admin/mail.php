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

$id = $_GET["id"];

$admin_table = 'Admin';
$getData = $firestore->collection($admin_table)->document($id)->snapshot()->data();

$email = $getData['Email'];

$v1=rand(1111,9999);
$v2=rand(1111,9999);
   
$v3=($v1.$v2)/100;
$code=intval($v3);

$_SESSION['code'] = $code;


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
    $mail->Subject = 'Verification Code';
    $mail->Body    = $code;

    $mail->send();
    ?>
    <script type="text/javascript">
        swal({
            title: "Mailer Says,",
            text: "Verification Code has been sended to <?php echo $email; ?>",
            icon: "success"
        }).then(function() {
            window.location = "verify.php?id=<?php echo $id; ?>";
        });
    </script>
    <?php

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    ?>
    <script type="text/javascript">
        swal({
            title: "Mailer Says,",
            text: "Verification Code could not be sent. Mailer Error!!!",
            icon: "error"
        }).then(function() {
            window.location = "forget_pwd.php";
        });
    </script>
    <?php
}
?>

  </body>
</html>