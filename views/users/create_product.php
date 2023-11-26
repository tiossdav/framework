<?php
use Tioss\core\Application;
Application::$app->view->title = 'Create Product';

$brand = $_SESSION['user']->brand_name;

var_dump($brand);
// exit;
?>

<div class="create-form">
    <h2>Create Product</h2>
    <?php $form = Tioss\core\form\Form::begin('', 'post', "multipart/form-data") ?>

<?php echo $form->field($model, 'pdt_image')->fileField() ?>
<?php echo $form->field($model, 'pdt_name') ?>

<?php echo $form->field($model, 'pdt_brand', $brand ) ?>
<?php echo $form->field($model, 'pdt_details') ?>
<?php echo $form->field($model, 'pdt_price') ?>
<?php echo $form->field($model, 'pdt_quantity') ?>
<button class="btn" type= "submit" name = "submit" >Submit</button>

<?php echo Tioss\core\form\Form::end() ?>
</div>



