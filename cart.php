<?php 
session_start();
$_SESSION['cart'] = $_SESSION['cart'] ?? [];
//script links
require "inc/header.php";
?>

<div class="container">
    <?php
//for header content
require 'pages/header-home.php'; 
include 'inc/process.php';
?>

    <div class="py-3">
        <div class="row">
            <div class="col-6">
                <h2>Cart Page (<?php echo count($_SESSION['cart']); ?>)</h2>
            </div>
            <div class="col-6 text-end">
                <a href="checkout.php" class="btn btn-primary" lass>Checkout</a>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            if(isset($_SESSION['cart'])){
              foreach($_SESSION['cart'] as $product_id => $quantity){
                    $quantity = $quantity["quantity"];
                    //GET DATA
                    $sql = "SELECT * FROM products WHERE id='$product_id'";
                    $query = mysqli_query($connection, $sql);
                    $result = mysqli_fetch_assoc($query);
                    ?>
            <div class="col-3">
                <div class="card">
                    <img src="<?php echo $result['image'] ?>" style="height: 200px; width: 100%;" class="card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $result['title'] ?></h5>
                        <div class="d-flex">
                            <div class="w-100">
                                <p>Quantity: <?php echo $quantity ?></p>
                            </div>
                            <div class="w-100">
                                <p class="text-end">
                                    ₦<?php echo number_format($result["price"]* $quantity); ?>
                                </p>
                            </div>
                        </div>
                        <a href="?product_id_remove=<?php echo $result['id'] ?>" class="btn btn-primary">Remove
                            Product</a>
                    </div>
                </div>
            </div>
            <?php
                }  
            }else{
                ?>
            <h2 class="text-center">Cart is not active</h2>
            <?php
            }
                
                    ?>
        </div>
    </div>
    <?php 
//footer content
require 'pages/footer-home.php';
?>
</div>
<?php
//footer script links
require 'inc/footer.php';
 ?>