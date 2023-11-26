<?php
namespace Tioss\core;
require_once __DIR__.'/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class MyCustomMailer extends PHPMailer

{
    private $_host = 'smtp-relay.brevo.com';
    private $_hostname = 'smtp-relay.brevo.com';
    private $_user = 'tiossdav@gmail.com';
    private $_password = 'h0WFRsCmtBDL4wzy';

    public function __construct($exceptions=true)
    {
      
        $this->SMTPDebug = 1;
        $this->Host = $this->_host;
        $this->Hostname = $this->_hostname;
        $this->Port = 587;
        $this->Username = $this->_user;
        $this->Password = $this->_password;
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'tls'; 
       

       
        parent::__construct($exceptions);
    }

    //   send security code email
    public function sendSecurityCodeEmail( $email, $name, $mail_subject, $html_body, $mail_body) 
    {

        $email_sent = self::sendEmail($email, $name, $mail_subject, $html_body, $mail_body);
        return $email_sent;
    }

   
    public static function sendEmail($to_email, $to_name, $subject, $html_body, $email_body){
        $mail_sent = false;
        try{
            $mail = new PHPMailer(true);
            $mail->isSMTP();
       
            $mail->setFrom("tiossdav@gmail.com", "Nesthub");
            $mail->addAddress($to_email,$to_name);
           
            $mail->Subject = $subject;

            
            if(!empty($html_body)) {
                $mail->isHTML(true);
                $mail->AltBody = $email_body;
                $mail->Body    = $html_body;
           
            } else{
                $mail->Body    = $email_body;            
            }

        
            if($mail->send())
            {
            $mail_sent = true;
            
            }
            
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // echo "hi";
            // exit;
        }

        return $mail_sent;
    }
}