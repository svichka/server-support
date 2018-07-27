<?php
/**
 * Created by PhpStorm.
 * User: svc
 * Date: 27.07.2018
 * Time: 17:58
 */

namespace Svc;


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailSender
{
    private $host;
    private $username;
    private $password;
    private $secure = false;
    private $port = '25';
    private $recepient;
    private $sender;

    public function send($subject, $body)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->username;                // SMTP username
            $mail->Password = $this->password;                           // SMTP password
            $mail->SMTPSecure = $this->secure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->port;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($this->username, $this->sender);
            $mail->addAddress($this->recepient);     // Add a recipient

            //Content                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}