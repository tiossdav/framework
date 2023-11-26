<?php

namespace Tioss\controllers;


use Tioss\core\Application;
use Tioss\core\Controller;
use Tioss\core\Request;
use Tioss\core\Response;
use Tioss\core\middleware\FormMiddleware;
use Tioss\models\Verify;

class SiteController extends Controller
{ 

    public function __construct()
    {
        $this->registerMiddleware( new FormMiddleware(['verify']));
    }
    public function index()
    {
        echo $this->render('index');
    }

    public function contact()
    {
        echo $this->render('contact');
    }

    public function handlingContact(Request $request)
    {

        $body = $request->getBody();
        
        Application::$app->session->setFlash('delivered', 'Thanks for contacting us. We would get back to you.');
        Application::$app->response->redirect('/home');
        exit;        
    }

    public function verify(Request $request, Response $response)
    {
        $verify = new Verify();
           
        if($request->isPost())
        {
            $verify->loadData($request->getBody());


            if($verify->validateCode() && $verify->notexpire())
            {
                if(Application::$app->user->verified())
                {
                    $response->redirect('/home');
                }
            }
            
            Application::$app->user->addError('code', 'Wrong code');
            $this->setLayout('verify');
            echo $this->render('verify', ['model' => $verify]);
            return false;
        }

        Application::$app->user->verify_code();               // Application::$app->view->switch();
        $this->setLayout('verify');
        echo $this->render('verify', ['model' => $verify]);
    }
}