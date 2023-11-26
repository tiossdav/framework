<?php

namespace Tioss\core;

class Session 
{
    protected const LIGHT_KEY = 'bp_messages';
    public function __construct()
    {
        session_start();
        $bpmessages = $_SESSION[self::LIGHT_KEY] ?? [];
        if(!empty($bpmessages)) {
            foreach($bpmessages as $key => &$bpmessage )
            {
                $bpmessage['remove'] = true;
            }

            $_SESSION[self::LIGHT_KEY][$key] = $bpmessage;
        }
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::LIGHT_KEY][$key] = 
        [
            'remove' => false,
            'value' => $message
        ];
      
       
       // exit;
    }

    public function getFlash($key)
    {
        echo $_SESSION[self::LIGHT_KEY][$key][$key]['value'] ?? false; 
    }


    public function setUser($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public function getUser($key)
    {
       
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $beepmessages = $_SESSION[self::LIGHT_KEY] ?? [];
        foreach($beepmessages as $key => $beepmessage )
        {
            if($beepmessages)
            {
                unset($beepmessages[$key]);
            }
        }

        $_SESSION[self::LIGHT_KEY][$key] = $beepmessages;

        // if(isset($_SESSION['usders']))
        // {
        //     if((time(). $_SESSION['last_login_timestamp']) > 900 )
        //     {
        //         Application::$app->response->redirect('/logout');
        //     }else
        //     {
        //         $_SESSION['last_login_timastamp'] = time();
        //     }
        // }else{
        //     Application::$app->response->redirect('/login');
        // }

        // session_destroy();
        
    }

}