<?php
session_start();
require "inc/process.php";
require "inc/header.php";

if(isset($_GET['post_id']) && !empty($_GET['post_id'])){
    $id = $_GET['post_id'];

    // SQL
    $sql = "SELECT * FROM posts WHERE id='$id'";
    $query = mysqli_query($connection,$sql);

    // Fetch post
    $result = mysqli_fetch_assoc($query);

    if(!$result){
        $_SESSION['error'] = "Post not found";
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

$_SESSION['url'] = $_GET['post_id'];
?>
<div class="container">
    <?php require "pages/header-home.php"; ?>

    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-8">

                <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
                <?php endif; ?>

                <!-- Post Thumbnail -->
                <div style="background:url('<?= $result['thumbnail'] ?? 'default.jpg' ?>'); 
                            background-position:center;background-size:cover;background-repeat:no-repeat;">
                    <div style="background:#0000007a; padding:40px;text-align:center;opacity:0.8;">
                        <h2 class="text-white"><?= $result['title'] ?? "No Title" ?></h2>
                    </div>
                </div>

                <hr>

                <!-- Date & Category -->
                <div class="row bg-dark mb-2 text-white">
                    <div class="col-6">
                        Date Published:
                        <?= !empty($result['timestamp']) ? date("F j Y", strtotime($result['timestamp'])) : "N/A" ?>
                    </div>
                    <div class="col-6 text-end">
                        Category:
                        <?php
                        $cid = $result['category_id'] ?? null;
                        if($cid){
                            $sql2 = "SELECT * FROM category WHERE id='$cid'";
                            $query2 = mysqli_query($connection, $sql2);
                            $result2 = mysqli_fetch_assoc($query2);
                            echo $result2['name'] ?? "Uncategorized";
                        } else {
                            echo "Uncategorized";
                        }
                        ?>
                    </div>
                </div>

                <!-- Post Image -->
                <div class="text-center">
                    <img style="width:200px; height:200px;" src="<?= $result['thumbnail'] ?? 'default.jpg' ?>" alt="">
                </div>

                <!-- Post Content -->
                <div class="content">
                    <p><?= $result['content'] ?? "No content available" ?></p>
                </div>
                <hr>

                <!-- Comments Section -->
                <div>
                    <h5>Comments</h5>
                    <?php
                    $sql_comments = "SELECT * FROM comments WHERE post_id='$id' AND status=1";
                    $query_comments = mysqli_query($connection, $sql_comments);

                    if(mysqli_num_rows($query_comments) > 0){
                        while($comment = mysqli_fetch_assoc($query_comments)){
                            $user_id = $comment['user_id'];
                            $sql_user = "SELECT * FROM users WHERE id='$user_id'";
                            $query_user = mysqli_query($connection, $sql_user);
                            $user = mysqli_fetch_assoc($query_user);
                            ?>
                    <div class="row">
                        <div class="col-6">
                            <p><?= $user['name'] ?? "Unknown User" ?><br>
                                <small><?= !empty($comment['timestamp']) ? date("F j Y", strtotime($comment['timestamp'])) : "" ?></small>
                            </p>
                        </div>
                        <div class="col-6">
                            <?= $comment['message'] ?? "" ?>
                        </div>
                    </div>
                    <hr>
                    <?php
                        }
                    } else {
                        echo "<p>No comments yet.</p>";
                    }
                    ?>

                    <!-- Add Comment Form -->
                    <?php if(isset($_SESSION['user'])): ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>New Comment</label>
                            <textarea name="comment_new" class="form-control" rows="5"
                                placeholder="Enter comment"></textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                        </div>
                    </form>
                    <?php else: ?>
                    <a href="login.php">Login to comment</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-4">
                <div class="border p-3">
                    <form action="search.php" method="post">
                        <h4>Search</h4>
                        <input type="text" name="search" class="form-control" placeholder="Enter Search term">
                        <button type="submit" class="btn btn-dark mt-2">Search</button>
                    </form>
                </div>

                <div class="border p-3 mt-2">
                    <h4>Categories</h4>
                    <ul>
                        <?php
                        $sql_c = "SELECT * FROM category ORDER BY id DESC";
                        $query_c = mysqli_query($connection, $sql_c);
                        while($cat = mysqli_fetch_assoc($query_c)){
                            ?>
                        <li><a href="post-category.php?post_category_id=<?= $cat['id'] ?>"><?= $cat['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php require "pages/footer-home.php"; ?>
</div>
<?php require "inc/footer.php"; ?>