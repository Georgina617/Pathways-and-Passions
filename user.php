<?php 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if(($_SESSION['user']['role']=='admin')){
    header("Location: dashboard.php");
}
$_SESSION['cart'] = $_SESSION['cart'] ?? [];
//script links
require "inc/header.php";
?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css">

<div class="container">
    <?php
//for header content
require 'pages/header-home.php'; 
include 'inc/process.php';
?>

    <div class="py-3">
        <h2>User Dashboard</h2>
        <br>
        <div class="row">
            <h3>Recent Orders</h3>
            <table id="myorders" class="table table-striped">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT * FROM orders WHERE user_id = ".$_SESSION['user']['id']." ORDER BY id DESC";
                    $query = mysqli_query($connection, $sql);
                    while($result = mysqli_fetch_assoc($query)){
                        ?>
                    <tr>
                        <td><?php echo $result['order_id']; ?></td>
                        <td>#<?php echo number_format($result['amount']); ?></td>
                        <td><?php echo $result['payment_method']; ?></td>
                        <td>
                            <?php
                            $pid = $result['product_id'];
                            //fetch product from database
                            $sql2 = "SELECT * FROM products WHERE id = $pid";
                            $query2 = mysqli_query($connection,$sql2);
                            $result2 = mysqli_fetch_assoc($query2);
                          ?>
                            <img src="<?php echo $result2["image"]; ?>"
                                style="height: 25px; width: 25px; object-fit: cover; object-position: center;"
                                alt=""><?php echo $result2["title"];?>
                        </td>
                        <td><?php echo $result['quantity']; ?></td>
                        <td><?php echo $result['status']; ?></td>
                        <td><?php echo $result['timestamp']; ?></td>
                    </tr>
                    <?php
                    }    
                     ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Order Id</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php 
//footer content
require 'pages/footer-home.php';
?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.js"></script>
    <script>
    new DataTable('#myorders');
    </script>
</div>
<?php
//footer script links
require 'inc/footer.php';
 ?>