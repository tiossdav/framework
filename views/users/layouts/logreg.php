<?php
use Tioss\core\Application;
use Tioss\core\View;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/app.css">
    <title><?php echo Application::$app->view->title ?></title>
   
</head>
<body>

    <?php if(Application::$app->session->getFlash('success')): ?>
    <div class="alert">
        <?php echo Application::$app->session->getFlash('success') ?>
    </div>
    <?php endif; ?>
    <?php if(Application::$app->session->getFlash('p')): ?>
    <div class="alert">
        <?php echo Application::$app->session->getFlash('p') ?>
    </div>
    <?php endif; ?>
    {{content}}

    <?php if(Application::$app->session->getFlash('r')): ?>
        <div class="alert">
           
            <?php echo Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
</body>
<script src="/assets/app.js" ></script>
</html>