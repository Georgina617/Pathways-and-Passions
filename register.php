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
?>

    <div class="d-flex align-items-center justify-content-center py-3">
        <div class="col-md-6 col-lg-4">
            <form action="" method="post">
                <h3 class="text-center mb-4">Register</h3>

                <?php if(isset($error)): ?>
                <div class="alert alert-danger text-center">
                    <?= $error ?>
                </div>
                <?php elseif(isset($success)): ?>
                <div class="alert alert-success text-center">
                    <?= $success ?>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <p>
                    if already registered? <a href="login.php">Login here</a>
                </p>
                <button type="submit" name="register" class="btn btn-primary w-100 my-3">
                    Register
                </button>
            </form>
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