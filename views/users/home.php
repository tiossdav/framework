<?php

 /* 
    @var $model Tioss\MvcFramework\models\User;
 */
use Tioss\core\Application;
use Tioss\utilHelpers\Functions;
       
$products = Application::$app->user->getProduct();


Application::$app->view->title = 'Home';
?>


<h3>Edit avater</h3>

<form  method="post" enctype="multipart/form-data">
    <input type="file" name="pics" > <br>
    <button type="submit" name="submit"> Upload </button>
</form>

<br> <br>
<p></p>
<p>Kindly get verified, to get to sell your products.</p>
<?php if(Application::$app->home->verify()) : ?>
<h3>we give our customers the oppourtunity to sell their product</h3>
<p>To do so, click <a href="create_product" >here.</a> </p>
   
<?php endif; ?>
<?php if(!Application::$app->home->verify()) : ?>

    <p class="not-verified" >You are not a verified user. <br> To get verified by e-mail, click 
        <a href="/verify" >here.</a>
    </p><br>
<?php endif; ?>



<?php foreach ($products as $product): ?>
    <div class="products" >

        <img class="avater" src="/<?php echo $product['pdt_image'] ?>">
        <h5>Name:       <?php echo $product['pdt_name'] ?> </h5>
        <h5>Price: <?php echo $product['pdt_price'] ?> </h5>
        <h5>Quantity:      <?php echo $product['pdt_quantity'] ?> </h5>
        <h5>Brand:       <?php echo $product['pdt_brand'] ?> </h5>
       
    </div>
<br>
<?php endforeach; ?>