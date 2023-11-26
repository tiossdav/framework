<?php
 /* 
    @var $model Tioss\models\User
 */
use Tioss\core\Application;
use Tioss\models\Home;
 
Application::$app->view->title = 'Login';


?>


<div class="wrapper" >

    <div class="form-box login" >
        <h2>Login</h2>
        <?php $login = Tioss\core\form\Form::begin('', 'post', "") ?>

        <?php echo $login->field($model, 'email') ?>
        <?php echo $login->field($model, 'password')->passwordField() ?>
        <button class="btn" type= "submit" name = "submit" >Log in</button>

        <?php echo Tioss\core\form\Form::end() ?>
    
        <a class="reset" href="reset_password" > Forgot password? </a>
    
        <a class="signup" href="register" class="signup" > Sign up </a>
      
    </div>

</div>






