<?php

namespace Tioss\controllers;

use Tioss\core\Application;
use Tioss\core\Controller;
use Tioss\core\Request;
use Tioss\core\Response;
use Tioss\models\LoginForm;
use Tioss\models\User;
use Tioss\models\Product;
use Tioss\models\HOme;
use Tioss\core\middleware\FormMiddleware;
use Tioss\models\Password_reset;
use Tioss\models\Verify;

class FormController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware( new FormMiddleware(['home']));
        $this->registerMiddleware( new FormMiddleware([ 'profile']));
    }

    public function home(Request $request, Response $response)
    {
        $home = new Home();
        if($request->isPost())
        {
            $home->loadData($request->getBody());
            if($home->uploadPic())
            {
                $response->redirect('/home');
            }
        }
        

        echo $this->render('home', ['model' => $home]);
    }

    public function login(Request $request, Response $response)
    {

        $loginForm = new LoginForm();

        if ($request->isPost())
        {
            $loginForm->loadData($request->getBody());
           
            if ($loginForm->validate() && $loginForm->login())
            {
                $response->redirect('/home');                
            }
        }
        
        $this->setLayout('logreg');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }
    

    public function register(Request $request)
    {
        $user = new User();
            
        if($request->isPost()){
            $user->loadData($request->getBody());

            if($user->validate() && $user->register())
            {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/login');
                exit;
            }

            
            return $this->render('register', [
                'model' => $user
            ]);
        }
        $this->setLayout('logreg');
        
        return $this->render('register', ['model' => $user]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }


    public function profile(Request $request, Response $response)
    {

        $delete_product = new Product();

        // exit;
        if($request->isPost())
        {
            $delete_product->loadData($request->getBody());
            if($delete_product->delete())
            {
                return $this->render('profile');
            }

        }
     
        $this->setLayout('profile');
        echo $this->render('profile', ['model' => $delete_product]);
      
    }

   

    public function sendcode(Request $request, Response $response)
    {
        $email = new Password_reset();
           
        if($request->isPost())
        {
            $email->loadData($request->getBody());


            if($email->validate_user() && $email->send_code())
            {
                Application::$app->session->setFlash('r', 'Check your Email for verification Code');
                $response->redirect('/password_reset');
            }
            
            
        }
        $this->setLayout('form');
        echo $this->render('reset_password', ['model' => $email]);
    }

    public function password_reset(Request $request, Response $response)
    {
        $reset = new Password_reset();

        if($request->isPost())
        {
            $reset->loadData($request->getBody());


            if($reset->validateCode())
            {

                $response->redirect('/password_reset');
            }
            $this->setLayout('form');
            echo $this->render('password_reset', ['model' => $reset]);
    
            
            
        }
        $this->setLayout('form');
        echo $this->render('password_reset', ['model' => $reset]);

    }

    public function new_password(Request $request, Response $response)
    {
        $newpassword = new Password_reset();

        if($request->isPost())
        {
            $newpassword->loadData($request->getBody());

            if($newpassword->validate() && $newpassword->reset())
            {
                Application::$app->session->setFlash('p', 'Password reset successful. Proceed to Log in to your Account.');
                $response->redirect('/login');
            }
                //$response->redirect('/password_reset');
            
            
        }
        $this->setLayout('form');
        echo $this->render('new_password', ['model' => $newpassword]);

    }

}