<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
try
{
    function sendGMail($title, $content, $nTo, $mTo,$diachicc='')
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";        
        $mail->Port = 587;
        $mail->Username = "huahoangduy.pro@gmail.com";
        $mail->Password = "123456";
        $address = $mTo;
        $mail->AddAddress($address, $nTo);
        $mail->AddReplyTo('admin@shop389.com', 'shop389.com');
        $mail->SetFrom("huahoangduy.pro@gmail.com","hua hoang duy");
        $mail->Subject = $title;
        $mail->MsgHTML($content);
        $mail->CharSet = 'UTF-8';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
            );
        $mail->Send();
        if(!$mail->Send())
        {
        echo "Message could not be sent. <p>";
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit;
        }
    }
}
catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>