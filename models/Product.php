<?php
namespace Tioss\models;

use Tioss\core\Application;
use Tioss\core\UserModel;
use Tioss\core\ProductModel;
use Tioss\utilHelpers\Functions;



class Product extends ProductModel
{
    public string $pdt_id = '';
    public string $pdt_name = '';
    public string $pdt_brand = '';
    public string $pdt_details = '';
    public string $pdt_image = '';
    public string $pdt_price = '';
    public string $pdt_quantity = '';


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
        return [ 'pdt_id','pdt_name', 'pdt_brand', 'pdt_image','pdt_details', 'pdt_price', 'pdt_quantity'];
    }

    public function label(): array
    {
        return [
            'pdt_image' => 'Product Image',
            'pdt_name' =>  'Product Name',
            'pdt_brand' =>  'Brand Name',
            'pdt_details' =>  'Product details',
            'pdt_price' =>      'Price',
            'pdt_quantity' =>   'Quantity',
        ];
    }


    public function create()
    {
        $image = $_FILES['pdt_image'] ?? '';
        $imagePath = '';
 
        if(!is_dir('assets/pdt_images'))
        {
            mkdir('assets/pdt_images');
        }

        if($image && $image['tmp_name'])
        {
            $imagePath = 'assets/pdt_images/'.Functions::randomString(11).'/'.$image['name'];
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }      
        $this->pdt_image = $imagePath; 
        $this->pdt_id = Functions::id(12);
        $_SESSION['pdt_id'] = $this->pdt_id;
        return parent::save();
       
    }

    public function getProductId(): string
    {
        return Application::$app->user->getSelectedProduct($this->pdt_id);
    }

    public function update_product()
    {

        // $this->pdt_image= $product['pdt_image'];
        // $this->pdt_name= $product['pdt_name'];
        // $this->pdt_details= $product['pdt_details'];
        // $this->pdt_price= $product['pdt_price'];
        //$this->pdt_quantity= $product['pdt_quantity'];
        $product = Application::$app->user->getSelectedProduct($_GET['d']);
        

        $imagePath = $product['pdt_image'];
        
        $image = $_FILES['pdt_image'] ?? '';
        if(!is_dir('assets/pdt_images'))
        {
            mkdir('assets/pdt_images');
        }

        if($image && $image['tmp_name'])
        {

            if(isset($imagePath))
            {
                unlink(__DIR__.'/../public/'.$imagePath);
            }
            $imagePath = 'assets/pdt_images/'.Functions::randomString(11).'/'.$image['name'];
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }      
        echo '<pre>';
        var_dump($imagePath);
        echo '</pre>';
        //exit;
        
        $this->pdt_image = $imagePath; 
        return parent::saveUpdate($this->pdt_id);
       
    }


    public function delete()
    {
        return parent::delete_product($this->pdt_id);       
    }


    public function getbrandname(): string
    {
        return Application::$app->user->getBrand()['brand_name'];
    }

}