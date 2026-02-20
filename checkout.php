<?php 
session_start();
//script links
require "inc/header.php";
?>

<div class="container">
    <?php
//for header content
require 'pages/header-home.php'; 
include 'inc/process.php';
if(isset($_SESSION["cart"])){
    $total_price = 0;
    foreach($_SESSION["cart"] as $key => $value){
        $product_id = $key; 
        //get product price
        $sql = "SELECT * FROM products WHERE id='$product_id'";
        $query = mysqli_query($connection, $sql);
        $result = mysqli_fetch_assoc($query);
        //splitting the details
        $price = intval($result["price"]);
        $quantity = intval($value["quantity"]);
        $total1 = $price * $quantity;
        $total_price += $total1;
    }
}
?>

    <div class="py-3">
        <h2>Checkout</h2>
        <hr>
        <div class="row">
            <div class="col">
                <?php
                 if(isset($_SESSION["user"])){
                    ?>
                <h2 class="text-center">Make Payment of ₦<?php echo number_format ($total_price ?? 0); ?></h2>
                <hr>
                <div class="row">
                    <div class="col-12" id="message" style="display:none">
                        <div class="alert alert-success">
                            <strong>verify payment please wait...</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <!-- Flutterwave Payment -->
                        <h2>Pay with</h2>
                        <img src="assets/img/flutterwave.jpg" id="flutterpay" onclick="makePayment()" alt=""
                            style="height: 70px;">
                    </div>
                    <div class="col-6">
                        <!-- Paystack Payment -->
                        <h2>Pay with</h2>
                        <img src="assets/img/paystack.png" alt="" id="paystackpay" onclick="payWithPaystack()"
                            style="height: 70px;">
                    </div>
                </div>
                <?php
                 }else{
                    ?>
                <h2 class="text-center"><a href="login.php">Login</a> to Checkout</h2>
                <?php
                 }
                 ?>
            </div>
        </div>
    </div>
    <?php 
//footer content
require 'pages/footer-home.php';
?>
</div>
<?php 
if(isset($_SESSION["user"])){
 ?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<script src="https://js.paystack.co/v2/inline.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
function payWithPaystack() {
    let handler = PaystackPop.setup({
        key: 'pk_test_c63dd302debc96cb6aa5978f7c3084d985bfcc01',

        email: '<?php echo $_SESSION["user"]["email"];?>',
        amount: <?php echo $total_price ?? 0 ?> * 100,
        ref: '' + Math.floor((Math.random() * 1000000000) + 1),
        onClose: function() {
            alert('Payment cancelled');
        },
        callback: function(response) {
            let reference = response.reference;
            //Ajax
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    "paystack": reference,
                },
                beforeSend: function() {
                    $("#message").fadeIn();
                    $("#paystackpay").fadeOut();
                },
                success: function(response) {
                    if (response.code === 200) {
                        $("#message").find("strong").html(
                            "Payment Successfully made!<br> Now redirecting to orders page..."
                        );
                        //Redirect to orders page
                        window.location.href = "user.php";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            });
        }
    });
    handler.openIframe();
};

function makePayment() {
    var p = FlutterwaveCheckout({
        public_key: 'FLWPUBK_TEST-465b475c7484b523040b9162773c60a5-X',
        tx_ref: '<?php echo "PHP_" . substr(rand(0, time()), 0, 6);?>',
        amount: <?php echo $total_price ?? 0; ?>,
        currency: 'NGN',
        payment_options: '',

        customer: {
            email: '<?php echo $_SESSION["user"]["email"];?>',
            phone_number: '',
            name: '<?php echo $_SESSION["user"]["name"];?>',
        },
        callback: function(data) {
            console.log(data);
            p.close();
            // Make ajax request
            var tx_id = data.transaction_id;
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    "tx_id": tx_id,
                },
                beforeSend: function() {
                    $("#message").fadeIn();
                    $("#flutterpay").fadeOut();
                },
                success: function(response) {
                    if (response.code === 200) {
                        $("#message").find("strong").html(
                            "Payment Successfully made!<br> Now redirecting to orders page..."
                        );
                        //Redirect to orders page
                        window.location.href = "user.php";
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            });
        },
        onclose: function() {
            // close modal
            alert('Payment canceled');
        },
        customizations: {
            title: 'Product Purchase',
            description: 'Payment for items in cart',
            logo: 'https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg',
        },
    });
}
</script>
<?php
 }

//footer script links
require 'inc/footer.php';
 ?>