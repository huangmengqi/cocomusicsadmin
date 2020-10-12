<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$sql_smtp="SELECT * FROM tbl_smtp_settings where id='1'";
$smtp_res=mysqli_query($mysqli,$sql_smtp);
$smtp_row=mysqli_fetch_assoc($smtp_res);

define("SMTP_HOST",$smtp_row['smtp_host']);
define("SMTP_EMAIL",$smtp_row['smtp_email']);
define("SMTP_PASSWORD",$smtp_row['smtp_password']);
define("SMTP_SECURE",$smtp_row['smtp_secure']);
define("PORT_NO",$smtp_row['port_no']);

function send_email($recipient_email,$recipient_name,$subject,$message)
{

    $mail = new PHPMailer(false);                              // Passing `true` enables exceptions
 
    //Server settings
    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = SMTP_EMAIL;                 // SMTP username
    $mail->Password = SMTP_PASSWORD;                           // SMTP password
    $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = PORT_NO;                                      // TCP port to connect to

    //Recipients
    $mail->setFrom(SMTP_EMAIL, APP_NAME);
    $mail->addAddress($recipient_email, $recipient_name);     // Add a recipient
     
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'Message has been sent';
  
}