<?php

require_once __DIR__.'/../vendor/autoload.php';

use Tioss\controllers\FormController;
use Tioss\core\Application;
use Tioss\controllers\SiteController;
use Tioss\controllers\ProductController;
use Tioss\controllers\SellersController;
use Tioss\models\Producers;
use Tioss\models\User;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [new SiteController , 'index']);

$app->router->get('/contact', [new SiteController , 'contact']);
$app->router->post('/contact', [new SiteController , 'handlingContact'] );

$app->router->get('/verify', [new SiteController , 'verify']);
$app->router->post('/verify', [new SiteController , 'verify'] );

$app->router->get('/login', [new FormController , 'login'] );
$app->router->post('/login', [new FormController , 'login'] );

$app->router->get('/register', [new FormController , 'register'] );
$app->router->post('/register', [new FormController , 'register'] );

$app->router->get('/reset_password', [new FormController , 'sendcode'] );
$app->router->post('/reset_password', [new FormController , 'sendcode'] );

$app->router->get('/password_reset', [new FormController , 'password_reset'] );
$app->router->post('/password_reset', [new FormController , 'password_reset'] );

$app->router->get('/new_password', [new FormController , 'new_password'] );
$app->router->post('/new_password', [new FormController , 'new_password'] );

$app->router->get('/home', [new FormController , 'home']);
$app->router->post('/home', [new FormController , 'home']);

$app->router->get('/create_product', [new ProductController , 'create_product']);
$app->router->post('/create_product', [new ProductController , 'create_product']);

$app->router->get('/update_product', [new ProductController , 'update']);
$app->router->post('/update_product', [new ProductController , 'update']);

$app->router->get('/delete_product', [new ProductController , 'delete']);

$app->router->get('/profile', [new FormController , 'profile'] );
$app->router->post('/profile', [new FormController , 'profile'] );

$app->router->get('/logout', [new FormController , 'logout'] );

$app->run();