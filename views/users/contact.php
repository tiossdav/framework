<?php
//@var $this \Tioss\core\View;
use Tioss\core\Application;

$this->title = 'Contact';

?>

<h1>Contact</h1>
<form action="" method="post">
    <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" name="subject">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email">
    </div>
    <div class="form-group">
        <label for="body">Body</label>
        <textarea name="body"></textarea>
    </div>
    <button type= "submit" name = "submit" >Post</button>
</form>

<?php if(Application::$app->session->getFlash('delivered')): ?>
    <div class="alert">
        <?php echo Application::$app->session->getFlash('delivered') ?>
    </div>
    <?php endif; ?>