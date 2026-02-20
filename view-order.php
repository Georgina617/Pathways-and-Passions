<?php 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if(($_SESSION['user']['role']=='user')){
    header("Location: user.php");
}
//script links
require "inc/header.php";
if(isset($_GET['order_id']) && !empty($_GET['order_id'])){
    $order_id_data = $_GET['order_id'];
   $sql_get = "SELECT * FROM orders WHERE order_id = '$order_id_data'";
    $query_get = mysqli_query($connection, $sql_get);
    $result_get = mysqli_fetch_assoc($query_get);
}
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
        <hr>
        <?php if(isset($error)): ?>
        <div class="alert alert-danger text-center">
            <?= $error ?>
        </div>
        <?php elseif(isset($success)): ?>
        <div class="alert alert-success text-center">
            <?= $success ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <?php if(isset($order_id_data) && $order_id_data): ?>
            <h3>Order ID :: <?php echo $order_id_data; ?></h3>
            <?php endif; ?>
            <?php if(isset($result_get) && $result_get): ?>
            <h5>Order Status:: <?php echo $result_get['status']; ?></h5>
            <div class="form-group">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Change status</label>
                        <select name="order_status" id="" class="form-control w-25">
                            <option value="Processing"
                                <?php echo ($result_get['status'] == 'Processing') ? ' selected' : ''; ?>>Processing
                            </option>
                            <option value="Completed"
                                <?php echo ($result_get['status'] == 'Completed') ? ' selected' : ''; ?>>Completed
                            </option>
                            <option value="Cancelled"
                                <?php echo ($result_get['status'] == 'Cancelled') ? ' selected' : ''; ?>>Cancelled
                            </option>
                        </select>
                    </div>
                    <button class="btn btn-primary my-2">Change Status</button>
                </form>
            </div>
            <?php endif; ?>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(isset($order_id_data) && $order_id_data) {
                        $sql = "SELECT * FROM orders WHERE order_id = '$order_id_data' ORDER BY id DESC";
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
                        <td>
                            <a href="view-order.php?order_id=<?php echo $result['order_id']; ?>">View Order</a>
                    </tr>
                    <?php
                        }
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
                        <th>Action</th>
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