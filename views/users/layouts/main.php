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
   <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 -->
</head>
<body>
    
<header>
    <?php if (Application::isGuest()): ?>
    <nav class="loginregistration">
        <div class="left-nav" >
            <a href="/">Home</a>
            <a href="#">About us</a>
            <a href="contact">Contact</a>
        </div>
      
        <div class="right-nav" >
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </div>

    </nav>
    <?php else: ?>
    <nav>
        <div class="left-nav" >
            <a href="/home">Home</a>
            <a href="#">About us</a>
            <a href="/contact">Contact</a>
        </div>
        <ul>
            <li>
                <a href="/profile">Profile</a>
            </li>
            <li>
                <a href="/logout">Logout</a>
            </li>
        </ul>
    </nav>
</header>
        <div class="avater-gif" >
            <img class="avater" src="/<?php echo Application::$app->user->getDisplayImage() ?>">
            <?php echo '<h6 class="username" > Welcome ' .Application::$app->user->getDisplayName().'</h6>' ?>
    </div>

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