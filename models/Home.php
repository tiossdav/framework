<?php

namespace Tioss\models;

use Tioss\core\Application;
use Tioss\core\Request;
use Tioss\utilHelpers\Functions;
use Tioss\core\Model;


 class Home extends Model
{
    
    public string $pics = '';
    public ?string $email = '';
  
    public function rules(): array
    {
        return [
            'pics' => [self::RULE_REQUIRED],
        ];
    }

    public function uploadPic ()
    {               
        $image = $_FILES['pics'] ?? null;
        $imagePath = '';
      
        if($image && $image['tmp_name'])
        {
            $imagePath = 'assets/images/'.Functions::randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        $this->pics = $imagePath;
               

        return Application::$app->user->update($this->pics);
    }

    public function verify()
    {
        
        $email = Application::$app->user->email()['email'];
        $email_verify = Application::$app->user->emailVerify()['email_verify'];
        $this->email = $email;
        
        if($this->email !== $email_verify)
        {
            return false;

        }
       return true;
    }

    public function getProduct()
    {
        // var_dump(Application::$app->user->getProduct());
        // exit;
        return Application::$app->user->getProduct();
    }

    public function getUserProduct()
    {
        $pdt_brand = $_SESSION['pdt_brand'] ?? '';

        return Application::$app->user->getUserProduct();
    }
    
}