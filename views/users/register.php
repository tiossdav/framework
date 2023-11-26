<?php
 /* 
    @var $model Tioss\MvcFramework\models\User;
 */
use Tioss\core\Application;

Application::$app->view->title= 'Register';

?>



<div class="rwrapper" >

    <div class="form-box register" >
        <h2>Register</h2>
        <?php $form = Tioss\core\form\Form::begin('', 'post', "multipart/form-data") ?>

            <?php echo $form->field($model, 'pics')->fileField() ?>
            <?php echo $form->field($model, 'firstname') ?>
            <?php echo $form->field($model, 'lastname') ?>
            <?php echo $form->field($model, 'brand_name') ?>
            <?php echo $form->field($model, 'email') ?>
            <?php echo $form->field($model, 'password')->passwordField() ?>
            <?php echo $form->field($model, 'cpassword')->passwordField() ?>
            <button class="btn" type= "submit" name = "submit" >Register</button>

        <?php echo Tioss\core\form\Form::end() ?>
        <a class="login" href="login" > Login? </a>

    </div>

</div>




