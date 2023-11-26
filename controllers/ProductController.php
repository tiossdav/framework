<?php


namespace Tioss\controllers;

use Tioss\core\Application;
use Tioss\core\Controller;
use Tioss\core\Request;
use Tioss\core\Response;
use Tioss\models\LoginForm;
use Tioss\models\User;
use Tioss\models\HOme;
use Tioss\models\Product;
use Tioss\core\middleware\FormMiddleware;
use Tioss\models\Password_reset;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware( new FormMiddleware(['create_product']));
    }
   
    public function create_product( Request $request, Response $response)
    {
        $product = new Product();

        if ($request->isPost())
        {
            $product->loadData($request->getBody());
        //    exit;
            if ($product->validate() && $product->create())
            {
                Application::$app->session->setFlash('product_added', 'Your product has been successfully created.');
                $response->redirect('/home');
            }
        }
        
        $this->setLayout('main');
        return $this->render('create_product', ['model' => $product]);

    }

    public function update( Request $request, Response $response)
    {
        $product = new Product();

        if ($request->isPost())
        {
            $product->loadData($request->getBody());
            if ($product->validate() && $product->update_product())
            {
                Application::$app->session->setFlash('product_updated', 'Your product has been successfully updated.');
                $response->redirect('/profile');
            }
        }
        
        $this->setLayout('main');
        return $this->render('update_product', ['model' => $product]);

    }


  



}