<?php 

namespace Tioss\core;

class View
{
    public string $title = '';

    public function renderView($view, $params = [])
    {
        $content = '{{content}}';
        $viewContent =   $this->renderOnlyView($view, $params);
        $layoutContent = $this->renderLayout();

        echo str_replace($content, $viewContent, $layoutContent);
        
    }

    public function renderContent($viewContent)
    {
        $content = '{{content}}';
        $layoutContent = $this->renderLayout();
        echo str_replace($content, $viewContent, $layoutContent);
        
    }


    protected function renderOnlyView($view, $params)
    {
        foreach($params as $key => $value)
        {
            $$key = $value;

        };
        ob_start();        
        include_once Application::$ROOT_DIR."/views/users/$view.php";
        $content = ob_get_clean();
        return $content;
    }

    protected function renderLayout()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller)
        {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/users/layouts/$layout.php";
        $content = ob_get_clean();
        return $content;
    }

    public function verifyview()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/users/verify.php";
        $content = ob_get_clean();
        return $content;        
    }

    public function switch()
    {
        $content = $this->verifyview();
        $placeholder = "{{email}}";
        $user_email = $_SESSION['user']->email;
        echo str_replace($placeholder, $user_email, $content);
        
    }

}