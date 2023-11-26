<?php

namespace Tioss\controllers;
use Tioss\core\controller;
use Tioss\core\MyCustomMailer;

class AccountController extends Controller 
{


    public static function sendSecurityCode($user_email, $name, $mail_subject, $html_body, $mail_body)
    {
        $mailer = new MyCustomMailer(true);
        $send = $mailer->sendSecurityCodeEmail($user_email, $name, $mail_subject, $html_body, $mail_body);
        if($send)
        {
            echo 'Sent';
            return true ;
        }
       
        else 
        echo 'Not Sent';

        return false;

    }

}