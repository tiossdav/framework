<?php

namespace Tioss\core;

use Tioss\core\middleware\BaseMiddleware;

class controller
{

    public string $layout = 'main';
    public string $action = '';
    protected array $middlewares = [];
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddleware(): array
    {
        return $this->middlewares;
    }

}