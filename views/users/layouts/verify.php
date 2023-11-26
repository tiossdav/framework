<?php
use Tioss\core\Application;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Application::$app->view->title  ?></title>
</head>
<body>
    

    <?php if (Application::isGuest()): ?>
    <div class="loginregistration">
        <a href="/">Home</a>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    </div>
    <?php else: ?>
    <nav>
        <a href="/home">Home</a>
        <a href="/contact">Contact</a>
    </nav>
    <ul>
        <li>
            <a href="/profile">Profile</a>
        </li>
      
    </ul>

    <?php endif; ?>


    <?php if(Application::$app->session->getFlash('success')): ?>
    <div class="alert">
        <?php echo Application::$app->session->getFlash('success') ?>
    </div>
 <?php endif; ?>
 
    {{content}}
</body>
<script src="/assets/app.js" >

// getVerified = document.querySelector('.verify');
// console.log(getVerified);
</script>
</html>