<?php 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if(($_SESSION['user']['role']=='user')){
    header("Location: index.php");
};
//script links
require "inc/header.php";
?>
<div class="container">
    <?php
//for header content
require 'pages/header-home.php';  
include 'inc/process.php';
if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    //GET DATA
    $sql = "SELECT * FROM category WHERE id='$edit_id'";
    $query = mysqli_query($connection, $sql);
    $result = mysqli_fetch_assoc($query);
}else{
    header("Location: category.php");
}
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
                        <a href="comments.php">Comments</a>
                    </li>
                    <li>
                        <a href="new-post.php">Add new Posts</a>
                    </li>
                    <li>
                        <a href="category.php" class="text-danger">Categories</a>
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
                    <h6>Edit Category</h6>

                    <?php if(isset($error)): ?>
                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>
                    <?php elseif(isset($success)): ?>
                    <div class="alert alert-success text-center">
                        <?= $success ?>
                    </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" id="" name="name" value="<?= $result['name'] ?>"
                                placeholder="Enter a new category" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-sm btn-primary mt-2" name="edit_category">Update</button>
                        </div>
                    </form>

                </div>
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