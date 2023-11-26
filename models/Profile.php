<?php
namespace Tioss\models;

use Tioss\core\Application;
use Tioss\core\model;
use Tioss\core\UserModel;
use Tioss\core\ProductModel;
use Tioss\utilHelpers\Functions;



class Profile extends model
{
    public string $pdt_id = '';

    
    public static  function tablename(): string
    {
        return 'products';
    }

    public static function primaryKey(): string
    {
        return 'pdt_id';
    }

    public function rules(): array
    {
        return [
            'pdt_name' => [self::RULE_REQUIRED],
            'pdt_details' => [self::RULE_REQUIRED]
        ];
    }

    public function aattribute(): array
    {
        return [ 'pdt_id'];
    }

    public function getProductId()
    {
        var_dump($this->pdt_id);
        return Application::$app->user->getSelectedProduct($this->pdt_id);
    }



    public function delete()
    {
        return Application::$app->user->delete_product($this->pdt_id);       
    }

}