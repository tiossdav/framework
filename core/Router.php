<?php

namespace Tioss\core;
use Tioss\core\View;
use Tioss\core\exceptions\ForbiddenException;
use Tioss\core\exceptions\NotfoundExceptions;

class Router
{
    protected array $routes = [];

    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function get($path, $callback)
    {
       $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
       $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path =  $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        
        if($callback === false){
            throw new NotfoundExceptions();
            //exit;
        }
        if(is_string($callback))
        {
            return Application::$app->view->renderView($callback);
        }

        if(is_array($callback))
        {
           
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
           
            $controller->action = $callback[1]; 
            $callback[0] = $controller;
            
            foreach($controller->getMiddleware() as $middleware )
            {                
                $middleware->execute();   
            }
        }
        
        echo call_user_func($callback, $this->request, $this->response);
       
    }

    
  

}