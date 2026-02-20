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
                        <a href="comments.php">Comments</a>
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
                        <a href="new-product.php" class="text-danger">New Product</a>
                    </li>
                    <li>
                        <a href="orders.php">Orders</a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <div class="container">
                    <h6>Add new Product</h6>

                    <?php if(isset($error)): ?>
                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>
                    <?php elseif(isset($success)): ?>
                    <div class="alert alert-success text-center">
                        <?= $success ?>
                    </div>
                    <?php endif; ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Select Thumbnail</label>
                            <input type="file" name="image" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" id="" name="title" placeholder="Enter title" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="1">Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category_id" class="form-control" id="">
                                        <?php 
                                        $sql = "SELECT * FROM category ORDER BY id DESC";
                                        $query =  mysqli_query($connection, $sql);
                                        //print down category
                                        while($result = mysqli_fetch_assoc($query)) {
                                            ?>
                                        <option value="<?php echo $result ["id"]?>">
                                            <?php echo $result ["name"]?>
                                        </option>
                                        <?php  
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" id="" name="price" placeholder="Enter product price"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" placeholder="Enter post content" class="form-control" id=""
                                cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-sm btn-primary mt-2" name="new_product">Publish</button>
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