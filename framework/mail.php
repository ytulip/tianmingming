<?php
namespace MM;

class Mail{
    public function send($content)
    {
        //require 'PHPMailerAutoload.php';

        $mail = new \PHPMailer();
        $mail->CharSet = "utf-8";
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = env('MAIL');                 // SMTP username
        $mail->Password = env('MAIL_PASSWORD');                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom(env('MAIL'), 'Mailer');
        //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress(env('MAIL'));               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = '来自tianmingming.com的留言';
        $mail->Body = $content;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
//            echo 'Message has been sent';
        }
    }
}
