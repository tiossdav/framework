<?php

namespace Tioss\core;

use Tioss\models\User;
use Tioss\models\Home;
use Tioss\core\DbModel;
use Tioss\models\LoginForm;
use Tioss\models\Profile;

class Application
{
    public static string $ROOT_DIR;
    public  string $layout = 'main';
    public  string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public SESSION $session;
    public User $userr;
    public Home $home;
    public Profile $profile;
    public LoginForm $loginForm;

    public  ?DbModel $user;
    public  ?DbModel $nulluser;
    public  View  $view;
    public Database $db;
    public static Application $app;
    public Controller $controller ;


    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->controller = new Controller();
        $this->userr = new User();
        $this->home = new Home();
        $this->profile = new Profile();
        $this->loginForm = new LoginForm();
        $this->view = new View();
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request, $this->response);
        
        $primaryValue = $this->session->getUser('users');

        if($primaryValue)
        {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([ $primaryKey => $primaryValue ]);

        }else{
            $this->user = null;
        }
        if($this->session->getUser('nulluser'))
        {
            $this->nulluser = $this->session->getUser('nulluser');
        }
    }

    public function run()
    {
        try{
            $this->router->resolve();
        } catch(\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', 
            [
                'exception' => $e
            ]
            );
        }
    }

   

    public function setController(Controller $controller)
    {
        return $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->setUser('users', $primaryValue);            
        $this->session->setUser('user', $user);            
        return true;
    }

    public static function isGuest()
    {
        $user = self::$app->user;
        if(!$user)
        {
            return true;
        }
        return false;
    }  

    public function create_code($user, $email)
    {
        $this->user = $user;
        $this->session->setUser('nulluser', $user);
        $this->user->create_code($email);
        return true;
    }

    public function get_code($user, $code)
    {
        $this->user = $user;        
        $email = $_SESSION['email_to_reset'];
        $code = $this->user->get_reset_code($email, $code);
     
       if(isset($code))
       {                    
            $expires = $this->user->get_reset_time($email, $code);//['expires_time'];
       
            if(is_array(Application::$app->user->get_reset_time($email, $code)))
            {
                $expires = Application::$app->user->get_reset_time($email, $code)['expires_time'];
                $time = time() ;
           
                
                if($expires > $time)
                {           
                    $this->response->redirect("/new_password");
                }
                $this->nulluser->addError('code', 'Code has expired.');
                return false;
            }
       }
       $this->nulluser->addError('code', 'Provide the code that was sent to your Email.');
       return false;
      

    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('users');
    }
}