<?php
use Tioss\core\Application;

Application::$app->view->title = 'Profile';

?>


<div>
    <div>
        <h2>Personal Details</h2>
        <div class="details" >
            <img class="profile-image" src="/<?php echo Application::$app->user->getDisplayImage() ?>">
            <div class="personal-details" >
                <h3>Name:        </h3>
                <h3>Email:       </h3>
                <h3>Products:    </h3>
                <h3>BrandName:  <?php echo Application::$app->user->getBrand()['brand_name'] ?> </h3>
            </div>
        </div>
    <div>

    </div>
    </div>
</div>
<br>
<br>
<?php
$products = Application::$app->user->getUserProduct();
?>
<?php foreach ($products as  $product): ?>
    <div class="products" >

        <img class="avater" src="/<?php echo $product['pdt_image'] ?? '' ?>">
        <h5>id:         <?php echo $product['pdt_id'] ?> </h5>
        <h5>Name:       <?php echo $product['pdt_name'] ?> </h5>
        <h5>Price:<?php echo $product['pdt_price'] ?> </h5>
        <h5>Quantity:      <?php echo $product['pdt_quantity'] ?> </h5>
        <h5>Brand:       <?php echo $product['pdt_brand'] ?></h5>
        <div>
            <form action="" method="post" >
                <input type="hidden" name="pdt_id" value="<?= $product['pdt_id'] ?> ">
                <button type="submit">Delete</button>
            </form>
            
            <a href="/update_product?d=<?php echo $product['pdt_id']?>">Edit</a>
        </div>
    </div>
<?php endforeach; ?>
