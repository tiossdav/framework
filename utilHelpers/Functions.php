<?php
namespace Tioss\utilHelpers;

class Functions
{
    public static function randomString($n){
        $str = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        for($i = 0; $i < $n; $i++){
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
        return $str;
    }
    public static function id($n){
        $str = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_______';
        
        for($i = 0; $i < $n; $i++){
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
        return $str;
    }

    public static function randomInt()
    {
        $str = rand(10000, 99999);
        return $str;
    }
}