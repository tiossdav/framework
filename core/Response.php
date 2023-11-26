<?php

namespace Tioss\core;


class Response
{
    public function setStatusCode(?int $code)
    {
        try{
            http_response_code($code);
        } catch(\Exception $e){
            echo Application::$app->view->renderView('_error', 
            [
                'exception' => $e
            ]
            );
        }
    }

    public function redirect(string $url)
    {
        header('Location: '.$url);
    }
//
}