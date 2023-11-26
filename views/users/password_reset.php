<?php
use Tioss\core\Application;
?>


<div>
<h2>Verify your identity</h2>

<div class="get_verified" id="get_verified" >
    <form action="" method="post" >
        <input type="number" name="code" placeholder="Enter your verification code" >
        <button type="submit">Submit</button>
    </form>
    <?php if(Application::$app->nulluser->getFirstError('code')): ?>
            <div class= "invalid-feedback">
                <?php echo Application::$app->nulluser->getFirstError('code'); ?>
            </div>
    <?php endif; ?>
</div>
</div>


<div class="wrapper" >

    <div class="form-box login" >
        <h2>Verify your identity</h2>
        <div class="get_verified" id="get_verified" >
            <form action="" method="post" >
                <input type="number" name="code" placeholder="Enter your verification code" >
                <button type="submit">Submit</button>
            </form>
            <?php if(Application::$app->nulluser->getFirstError('code')): ?>
                    <div class= "invalid-feedback">
                        <?php echo Application::$app->nulluser->getFirstError('code'); ?>
                    </div>
            <?php endif; ?>
        </div>
    </div>

</div>