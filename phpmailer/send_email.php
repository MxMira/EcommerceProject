<?php
function my_email(  $body  , $from_email , $from_name  , $to_email , $to_name ,$subject)
{
    require_once('class.phpmailer.php');
    $mail = new PHPMailer(true); // defaults to using php "mail()"

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->CharSet = 'UTF-8';
    $mail->Host       = "smtp.mailtrap.io"; // SMTP server
    $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only
   // $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 2525;
    $mail->SMTPAuth   = true;
    //$mail->SMTPSecure = "tsl"; // set the SMTP port for the GMAIL server
    $mail->Username   = "56b9762c2c28b2"; // SMTP account username
    $mail->Password   = "0c4045f967285a";        // SMTP account password
    $mail->ContentType = 'text/plain';

    $mail->SetFrom($from_email, $from_name);

    $address = $to_email;
    $mail->AddAddress($address, $to_name);

    $mail->Subject    = $subject;

    $mail->MsgHTML($body);

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}