<?php 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if(($_SESSION['user']['role']=='user')){
    header("Location: index.php");
}
//script links
require "inc/header.php";
?>
<div class="container">
    <?php
//for header content
require 'pages/header-home.php';  
include 'inc/process.php';
?>
    <div class="container p-3">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <h4>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h4>
                    </div>
                    <div class="col-6">
                        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <h6>Navigations</h6>
                <ul>
                    <li>
                        <a href="posts.php">Posts</a>
                    </li>
                    <li>
                        <a href="comments.php" class="text-danger">Comments</a>
                    </li>
                    <li>
                        <a href="new-post.php">Add new Posts</a>
                    </li>
                    <li>
                        <a href="category.php">Categories</a>
                    </li>
                    <li>
                        <a href="users.php">Users</a>
                    </li>
                    <li>
                        <a href="new-user.php">Add new Users</a>
                    </li>
                    <li>
                        <a href="products.php">All Products</a>
                    </li>
                    <li>
                        <a href="new-product.php">New Product</a>
                    </li>
                    <li>
                        <a href="orders.php">Orders</a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <div class="container">
                    <h6>All Comments</h6>
                    <?php if(isset($error)): ?>
                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>
                    <?php elseif(isset($success)): ?>
                    <div class="alert alert-success text-center">
                        <?= $success ?>
                    </div>
                    <?php endif; ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">Comment</th>
                                <th scope="col">status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * FROM comments ORDER BY id DESC";
                            $query = mysqli_query($connection, $sql);
                            while($result = mysqli_fetch_assoc($query)){
                            ?>
                            <tr>
                                <td scope="row">1</td>
                                <td scope="row">
                                    <?php 
                                    $user_id = $result['user_id'];

                                    $sql_user = "SELECT * FROM users WHERE id='$user_id'";
                                    $query_user = mysqli_query($connection, $sql_user);
                                    $result2 = mysqli_fetch_assoc($query_user);
                                    ?>
                                    <?php echo $result2['name']; ?>
                                </td>
                                <td>
                                    <?php echo $result['message'] ?>
                                </td>
                                <td>
                                    <?php 
                                    if($result["status"]){
                                        ?>
                                    Active
                                    <?php
                                    }else{
                                        ?>
                                    Not Active
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $result ["timestamp"]?>
                                </td>
                                <td>
                                    <?php 
                                    if(!$result["status"]){
                                        ?>
                                    <a href="?approve_comment=<?php echo $result['id'] ?>">Approve</a>
                                    |
                                    <?php
                                    }
                                    ?>
                                    <a href="?delete_comment=<?php echo $result['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
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