<?php

namespace Tioss\models;

use Tioss\core\Application;
use Tioss\core\UserModel;
use Tioss\core\Model;


class LoginForm extends Model
{
    
    public string $email = '';
    public string $password = '';

   
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function label(): array
    {
        return [
            'email' => 'Username',
            'password' => 'Password'
        ];
    }


    public function login()
    {
        $user = User::findOne([
            'email' => $this->email
        ]);
        
        if(!$user)
        {
            $this->addError('email', 'User does not exist');
            return false;
        }
        if(!password_verify($this->password, $user->password))
        {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }

    
}