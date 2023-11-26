<?php 
namespace Tioss\core\middleware;

use Tioss\core\Application;
use Tioss\core\exceptions\ForbiddenException;

class FormMiddleware extends BaseMiddleware
{
    public array $action = [];

    public function __construct(array $action = [])
    {
        $this->action = $action;
    }

    public function execute()
    {
        if(Application::isGuest())
        {
            if(empty($this->action) || in_array(Application::$app->controller->action, $this->action ) )
            {
                throw new ForbiddenException();
            }
        }
        // else{
           
        //     Application::$app->controller->render('create_product');
        //     var_dump($this->action);
        //    exit;
        //     Application::$app->controller->render('profile');
        //     Application::$app->controller->render('verify');
        // }
    }
    
}