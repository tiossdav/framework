<?php

namespace Tioss\models;

use Tioss\core\Application;
use Tioss\core\Request;
use Tioss\utilHelpers\Functions;
use Tioss\core\Model;


 class Verify extends Model
{
    
    public string $code = '';
    public string $pdt_id = '';
  
    public function rules(): array
    {
        return [
            'code' => [self::RULE_REQUIRED],
        ];
    }


    public function validateCode()
    {
        $code = Application::$app->user->get_code($this->code);

        if(!empty($code))
        {          
            return true;
        }
        return false;
    }

    public function notexpire()
    {
        $code = Application::$app->user->get_code($this->code);
        $expires = is_array(Application::$app->user->get_time($code));//['expires_time'];

        if(is_array(Application::$app->user->get_time($code)))
        {
            $expires = Application::$app->user->get_time($code)['expires_time'];
            $time = time() ;

            if($expires > $time)
            {
                return true;
            }
            Application::$app->user->addError('code', 'Code has expired.');
            return false;
            
        }
    }
    
}