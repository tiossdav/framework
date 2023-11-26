<?php
use Tioss\core\Application;
Application::$app->view->title = 'Update Product';

$product = Application::$app->user->getSelectedProduct($_GET['d']);


?>





<div class="create-form">
    <h2>Update Product</h2>
    <?php if ($product['pdt_image']): ?>
        <img src="/<?php echo $product['pdt_image'] ?>" class="thumb">
    <?php endif; ?>

    <?php $form = Tioss\core\form\Form::begin('', 'post', "multipart/form-data") ?>

<?php echo $form->field($model, 'pdt_image', $product['pdt_image'])->fileField() ?>
<?php echo $form->field($model, 'pdt_id', $product['pdt_id']) ?>
<?php echo $form->field($model, 'pdt_name', $product['pdt_name']) ?>
<?php echo $form->field($model, 'pdt_brand', $product['pdt_brand']) ?>
<?php echo $form->field($model, 'pdt_details', $product['pdt_details']) ?>
<?php echo $form->field($model, 'pdt_price', $product['pdt_price']) ?>
<?php echo $form->field($model, 'pdt_quantity', $product['pdt_quantity']) ?>
<button class="btn" type= "submit" name = "submit" >Submit</button>

<?php echo Tioss\core\form\Form::end() ?>
</div>