<?php

use Tioss\core\Application;
$error = Application::$app->user->getFirstError('code') ?? null;
?>

<div class="wrapper" >
    <div class="form-box" >   
    <h2>Verification</h2>

<div class="get_verified" id="get_verified" >
    <form action="" method="post" >
        <input type="number" name="code" placeholder="Enter your verification code" >
        <button type="submit">Verify</button>
    </form>
</div>

    <div>
        <p>A mail has been sent to Email address <!-- <b> <i> {{email}} </i></b> -->.</p>
    </div>
<br>

<?php if(isset($error)): ?>
    <div>
            <p><?= Application::$app->user->getFirstError('code') ?></p>
            <p>Click <a href="/verify">here</a> to get a new code.</p>
    </div>

<?php endif; ?>
    </div>
</div>

    