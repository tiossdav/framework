<?php

namespace Tioss\models;

use Tioss\core\DbModel;
use Tioss\core\Model;
use Tioss\core\UserModel;
use Tioss\utilHelpers\Functions;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    public ?string $pics = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $brand_name = '';
    public string $email = '';
    public ?int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $cpassword = '';
    
     
    public static  function tablename(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function register()
    {    
        $image = $_FILES['pics'] ?? null;
 
        if(!is_dir('images'))
        {
            mkdir('images');
        }

        if($image && $image['tmp_name'])
        {
            $imagePath = 'assets/images/'.Functions::randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        $this->pics = $imagePath;
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return[
            'firstname' =>  [self::RULE_REQUIRED],
            'lastname'  =>  [self::RULE_REQUIRED],
            'brand_name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'email'     =>  [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password'  =>  [self::RULE_REQUIRED, [self::RULE_MIN, 'min'=> 8], [self::RULE_MAX, 'max' => 34]],
            'cpassword' =>  [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=> 'password']]
        ];
    }

    public function aattribute(): array
    {
        return [ 'pics', 'brand_name', 'firstname', 'lastname', 'email', 'status', 'password'];
    }

    public function label(): array
    {
        return [
            'pics' => 'Avater',
            'firstname' =>  'First name',
            'lastname' =>   'Last name',
            'brand_name' =>   'Brand name',
            'email' =>      'E-mail',
            'password' =>   'Password',
            'cpassword' =>  'Confirm Password'
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname;
    }   

    public function getDisplayEmail(): string
    {
        return $this->email;
    }   
    public function getBrandname(): string
    {
        return $this->brand_name;
    }   

    // public function getDisplayName(): string
    // {
    //     return $this->firstname;
    // }   

    // public function getDisplayName(): string
    // {
    //     return $this->firstname;
    // }   

    public function getDisplayImage(): string
    {
        $myImage = $this->pics ?? '';
        return $myImage;
    }

}