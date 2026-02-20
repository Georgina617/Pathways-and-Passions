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
                        <a href="new-user.php" class="text-danger">Add new Users</a>
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
                    <h6>New User</h6>

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
                            <label for="">Name</label>
                            <input type="text" id="" name="name" placeholder="Enter a new name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter a new email"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" class="form-control" id="">
                                <option value="admin">Admin
                                </option>
                                <option value="user">User
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" id="" name="password" placeholder="Enter a  password"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-sm btn-primary mt-2" name="new_user_admin">Submit</button>
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