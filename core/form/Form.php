<?php
namespace Tioss\core\form;

use Tioss\core\Model;

class Form 
{
    
    public static function begin($action, $method, $enctype)
    {
        echo sprintf('<form action = "%s" method= "%s" enctype= "%s" >', $action, $method, $enctype);
        return new Form;
    }

    public static function end()
    {
        return '</form>';
    }

    public function field(Model $model, $aattribute, $value = '')
    {
        return new Field($model, $aattribute, $value);
    }   
}