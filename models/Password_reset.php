<?php

namespace Tioss\models;

use Tioss\core\Application;
use Tioss\core\Request;
use Tioss\utilHelpers\Functions;
use Tioss\core\Model;


 class Password_reset extends Model
{
    
    public string $code = '';
    public string $email = '';
    public string $password = '';
    public string $cpassword = '';
  
    public function rules(): array
    {
        return [
            'password'  =>  [self::RULE_REQUIRED, [self::RULE_MIN, 'min'=> 8], [self::RULE_MAX, 'max' => 34]],
            'cpassword' =>  [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=> 'password']]
        ];
    }

    public function validate_user()
    {
        $user = User::findOne(['email' => $this->email]);
        $_SESSION['email_to_reset'] = $this->email;
        if(!$user)
        {
            $this->addError('user', 'User with this Email not found.');
            return false;
        }
          
        return true;
    } 

    public function send_code()
    {
        $email = $this->email;
        if($email)
        {
            $user = User::findOne(['email'=> $email]);
           Application::$app->create_code($user, $email);
            return true;
        }
    }
   
    public function validateCode()
    {
        $email = $_SESSION['email_to_reset'];
      
        $user = User::findOne(['email'=> $email]);
       if( Application::$app->get_code($user, $this->code))
       {
        return true;
       }
       return false;
    }
     
    public function reset()
    {
        $email = $_SESSION['email_to_reset'];
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return User::reset_password($email, $this->password);
    }
}