<?php
use Tioss\core\Application;


?>


<div class="wrapper" >
     <div class="form-box" >
     <h2>
     Create new password.
        </h2>
        <p>An email will be sent to you with instruction on how to reset your password.</p>

        <form action="" method="post">
            <div class="input-box" >
            <input type="password" name="password" placeholder="Enter new password" ><br>
                    <?php if(Application::$app->nulluser->getFirstError('password')): ?>
                        <div class= "invalid-feedback">
                            <?php echo Application::$app->nulluser->getFirstError('password'); ?>
                        </div>
                    <?php endif ?>
                <input type="password" name="cpassword" placeholder="Repeat password" >
                    <?php if(Application::$app->nulluser->getFirstError('cpassword')): ?>
                        <div class= "invalid-feedback">
                            <?php echo Application::$app->nulluser->getFirstError('cpassword'); ?>
                        </div>
                    <?php endif ?>
                    <button type="submit" name="reset_submit"> Submit </button>
            </div>
        </form>
     </div>
    
    </div>