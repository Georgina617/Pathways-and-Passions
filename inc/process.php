<?php

require "connection.php";

if(isset($_POST["register"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $encrypt_password = md5($password);

    // Check if user already exists
    $sql_check = "SELECT * FROM users WHERE email='$email'";
    $query_check = mysqli_query($connection, $sql_check);
    if(mysqli_fetch_assoc($query_check)){
        $error = "User with this email already exists.";
    } else {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$encrypt_password')";
        $query = mysqli_query($connection, $sql) or die("Can't save data");
        $success = "Registration successful.";
    }
}

if(isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $encrypt_password = md5($password);

    // Check if user exists
    $sql_check2 = "SELECT * FROM users WHERE email='$email'";
    $query_check2 = mysqli_query($connection, $sql_check2);
    if(mysqli_fetch_assoc($query_check2)){
        // Check email and password
        $sql_check = "SELECT * FROM users WHERE email='$email' AND password='$encrypt_password'";
        $query_check = mysqli_query($connection, $sql_check);
        if($result = mysqli_fetch_assoc($query_check)){
            $_SESSION['user'] = $result;
            if($result['role'] == 'user'){
                if(isset($_SESSION['url'])){
                    $redirect_url = $_SESSION['url'];
                    header("Location: post.php?post_id=$redirect_url");
                } else {
                    header("Location: user.php");
                }
            }else {
                header("Location: dashboard.php");
            }
            $success = "User logged in successfully.";
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User email not found.";
    }
}
if(isset($_POST["category"])){
    $name = $_POST["name"];

    $sql = "INSERT INTO category (name) VALUES ('$name')";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "Category added successfully.";
    } else {
        $error = "Failed to add category.";
    }
}

if(isset($_GET['delete_category']) && !empty($_GET['delete_category'])){
    $id = $_GET['delete_category'];

    //SQL
     $sql = "DELETE FROM category WHERE id='$id'";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "Category deleted successfully.";
    } else {
        $error = "Failed to delete category.";
    }
}

if(isset($_POST['edit_category'])){
   if (!isset($_GET['edit_id'])) {
        $error = "Invalid category ID.";
        return;
    }

    $name = $_POST['name'];
    $edit_id = $_GET['edit_id'];

    //SQL
    $sql = "UPDATE category SET name='$name' WHERE id='$edit_id'";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "Category updated successfully.";
    } else {
        $error = "Failed to update category.";
    }
}

if (isset($_POST['new_post'])){
    //uploading to upload folder
    $target_dir = "uploads/";
    $basename = basename($_FILES["thumbnail"]["name"]);
    $upload_file = $target_dir.$basename;
    //move uploaded file
    $move = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $upload_file);

    if($move){
        $url = $upload_file;
        $title = mysqli_real_escape_string($connection, $_POST["title"]);
        $content = mysqli_real_escape_string($connection, $_POST["content"]);
        $status = mysqli_real_escape_string($connection, $_POST["status"]);
        $category_id = mysqli_real_escape_string($connection, $_POST["category_id"]);
        $thumbnail = $url;
        //sql
        $sql = "INSERT INTO posts(title,content,status,category_id,thumbnail) VALUES('$title','$content','$status','$category_id','$thumbnail')";
        //Query
        $query = mysqli_query($connection, $sql);
        //Check if its stored
        if($query){
            //Success message
            $success = "Post published"; 
        }else{
        $error = "unable to post content";
    }
    }else{
        $error = "unable to upload image";
    }
}

if (isset($_POST["update_post"])) {

    $id = (int)$_GET["edit_post_id"];

    $title = mysqli_real_escape_string($connection, $_POST["title"]);
    $content = mysqli_real_escape_string($connection, $_POST["content"]);
    $status = mysqli_real_escape_string($connection, $_POST["status"]);
    $category_id = mysqli_real_escape_string($connection, $_POST["category_id"]);

    $sql = "UPDATE posts SET 
            title='$title',
            content='$content',
            status='$status',
            category_id='$category_id'";

    if (!empty($_FILES["thumbnail"]["name"])) {
        $target_dir = "uploads/";
        $thumbnail = $target_dir . basename($_FILES["thumbnail"]["name"]);

        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail)) {
            $sql .= ", thumbnail='$thumbnail'";
        }
    }

    $sql .= " WHERE id='$id'";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        $success = "Post updated successfully";
    } else {
        $error = mysqli_error($connection);
    }
}
    
if (isset($_GET["delete_post"]) && !empty($_GET["delete_post"])){
    $id = $_GET ["delete_post"];
    //sql
    $sql = "DELETE FROM posts WHERE id = '$id'";
    //Query
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "Post deleted successfully";
    }else{
        $error = "Unable to delete post";
    }
}

if(isset($_POST["edit_user"])){
    if(isset($_POST["change_password"]) && $_POST["change_password"] == "on"){
        //change Password
        $id = $_GET["edit_user_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = $_POST["role"];
        $password = md5($_POST["password"]);
        //SQL
        $sql = "UPDATE users 
        SET name='$name', email='$email', role='$role', password='$password' 
        WHERE id='$id'";
        //QUERY
        $query = mysqli_query($connection, $sql);
        //check if
        if($query){
            $success = "User data updated";
        }else{
            $error = "unable to update user";
        }
    }else{
        //Just update data
        $id = $_GET["edit_user_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = $_POST["role"];
        //SQL
        $sql = "UPDATE users 
        SET name='$name', email='$email', role='$role' 
        WHERE id='$id'";
        //QUERY
        $query = mysqli_query($connection, $sql);
        //check if
        if($query){
            $success = "User data updated";
        }else{
            $error = "unable to update user";
        }
    }
};

if(isset($_GET['delete_user']) && !empty($_GET['delete_user'])){
    $id = $_GET['delete_user'];

    //SQL
     $sql = "DELETE FROM users WHERE id='$id'";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "User deleted successfully.";
    } else {
        $error = "Failed to delete user.";
    }
}

   if(isset($_POST["new_user_admin"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = md5($_POST["password"]);

    // Check if user already exists
    $sql_check = "SELECT * FROM users WHERE email='$email'";
    $query_check = mysqli_query($connection, $sql_check);
    if(mysqli_fetch_assoc($query_check)){
        $error = "User with this email already exists.";
    } else {
        //if User not found
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        $query = mysqli_query($connection, $sql);

        if($query){
            $success = "New user added successfully.";
        }else{
            $error = "Unable to add new user.";
        }
    }
   }

   if(isset($_POST["comment_new"])){
    $comment = $_POST["comment_new"];
    $user_id = $_SESSION["user"]["id"];
    $post_id = $_GET["post_id"];
    //SQL
    $sql = "INSERT INTO comments (user_id, message, post_id) VALUES ('$user_id', '$comment', '$post_id')";
    //Query
    $query = mysqli_query($connection, $sql);
    //Check if its stored
    if($query){
        //Success message
        $success = "Comment added,waiting moderation."; 
    }else{
        $error = "unable to add comment";
    }
   }

   if(isset($_GET['approve_comment']) && !empty($_GET['approve_comment'])){
    $id = $_GET['approve_comment'];

    //SQL
     $sql = "UPDATE comments SET status=1 WHERE id='$id'";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "Comment approved successfully.";
    } else {
        $error = "Failed to approve comment.";
    }
}

if(isset($_GET['delete_comment']) && !empty($_GET['delete_comment'])){
    $id = $_GET['delete_comment'];

    //SQL
     $sql = "DELETE FROM comments WHERE id='$id'";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "Comment deleted successfully.";
    } else {
        $error = "Failed to delete comment.";
    }
}

if(isset($_POST["new_product"])){
   //uploading to upload folder
    $target_dir = "uploads/";
    $basename = basename($_FILES["image"]["name"]);
    $upload_file = $target_dir.$basename;
    //move uploaded file
    $move = move_uploaded_file($_FILES["image"]["tmp_name"], $upload_file);

    if($move){
        $url = $upload_file;
        $title = mysqli_real_escape_string($connection, $_POST["title"]);
        $content = mysqli_real_escape_string($connection, $_POST["content"]);
        $price = mysqli_real_escape_string($connection, $_POST["price"]);
        $status = mysqli_real_escape_string($connection, $_POST["status"]);
        $category_id = mysqli_real_escape_string($connection, $_POST["category_id"]);
        $image = $url;
        //sql
        $sql = "INSERT INTO products(title,content,status,category_id,image,price) VALUES('$title','$content','$status','$category_id','$image','$price')";
        //Query
        $query = mysqli_query($connection, $sql);
        //Check if its stored
        if($query){
            //Success message
            $success = "Product published"; 
        }else{
        $error = "unable to publish product";
    }
    }else{
        $error = "unable to upload image";
    }
}

if (isset($_POST["edit_product"])) {
    $id = $_GET["edit_product_id"];
  //update image
    if ($_FILES["image"]["name"] != "") {
        $target_dir = "uploads/";
        $basename = basename($_FILES["image"]["name"]);
        $upload_file = $target_dir.$basename;
        //move uploaded file
        $move = move_uploaded_file($_FILES["image"]["tmp_name"], $upload_file);

        if($move){
            $url = $upload_file;
            $title = mysqli_real_escape_string($connection, $_POST["title"]);
            $content = mysqli_real_escape_string($connection, $_POST["content"]);
            $price = mysqli_real_escape_string($connection, $_POST["price"]);
            $status = mysqli_real_escape_string($connection, $_POST["status"]);
            $category_id = mysqli_real_escape_string($connection, $_POST["category_id"]);
            $image = $url;
            //sql
            $sql = "UPDATE products SET
            title='$title',content='$content',price='$price',status='$status',category_id='$category_id',image='$image' WHERE id='$id'";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if its stored
            if($query){
                //Success message
                $success = "Product updated"; 
            }else{
            $error = "Unable to update product";
            }
        }else{
            $error = "Unable to upload a new image";
        }
    } else {
            //Do not update image
            $title = mysqli_real_escape_string($connection, $_POST["title"]);
            $content = mysqli_real_escape_string($connection, $_POST["content"]);
            $price = mysqli_real_escape_string($connection, $_POST["price"]);
            $status = mysqli_real_escape_string($connection, $_POST["status"]);
            $category_id = mysqli_real_escape_string($connection, $_POST["category_id"]);
            //sql
            $sql = "UPDATE products SET
                    title='$title',
                    content='$content',
                    price='$price',
                    status='$status',
                    category_id='$category_id' 
                    WHERE id='$id'";
            //Query
            $query = mysqli_query($connection, $sql);
            //Check if its stored
            if ($query) {
                $success = "Product updated"; 
            } else {
                $error = "Unable to update product: " . mysqli_error($connection);
            }
        }

}


if(isset($_GET["delete_product"]) && !empty($_GET["delete_product"])){
    $id = $_GET ["delete_product"];
    //sql
    $sql = "DELETE FROM products WHERE id = '$id'";
    //Query
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "Product deleted successfully";
    }else{
        $error = "Unable to delete product";
    }
}    

if(isset($_POST["addtocart"])){
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    // Check if the product is already in the cart
    $query = $_SESSION['cart'][$product_id] = [
        "quantity" => $quantity
    ];
    if($query){
        echo "Product added to cart successfully <a href='cart.php'>Go to cart</a>";
    }else{
        echo "Unable to add product to cart";
    }
}

if(isset($_GET["product_id_remove"]) && !empty($_GET["product_id_remove"])){
    $product_id = $_GET["product_id_remove"];

    //Remove from cart

    unset($_SESSION['cart'][$product_id]);
    $success = "Product removed from cart successfully";
    
}


if (isset($_POST["tx_id"])){
    $tx_id = $_POST["tx_id"]; 
        $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$tx_id/verify",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: Bearer FLWSECK_TEST-9060597fee8788484a244f3ed0977292-X"
    ),
    ));
    $response = curl_exec($curl);

    
    $jsondata = json_decode($response);
    header("Content-Type: application/json");
    //check if the payment is valid
    if($jsondata->status == "success" && $jsondata->data->status == "successful"){
        //loop through section cart
        foreach($_SESSION["cart"] as $pid =>$value){
            //Pass the product data
            $order_id = $jsondata->data->tx_ref;
            $amount = $jsondata->data->amount;
            $user_id = $_SESSION["user"]["id"];
            $product_id = $pid;
            $quantity = $value["quantity"];
            $status = "processing";
            $payment_status = "paid";
            $payment_method = "flutterwave";
            //Insert into orders table
            $sql = "INSERT INTO orders(order_id, amount, user_id, product_id, quantity, status,payment_status, payment_method) VALUES ('$order_id', '$amount', '$user_id', '$product_id', '$quantity', '$status', '$payment_status', '$payment_method')";
            //query
            $query = mysqli_query($connection, $sql);
            if (!$query) {
                die("Insert failed: " . mysqli_error($connection));
            }
            //Empty cart
            unset($_SESSION["cart"]);
            
        }
            //return message 
            $response2 = ["code" => 200];
            echo json_encode($response2);
    }else{
         $response2 = ["code" => 401];
         echo json_encode($response2);
    }
}

if(isset($_POST["paystack"])){
    $reference = $_POST["paystack"];
    $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_50237448d1f5907272c09ccabd55be1226c8a785",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
  
  $jsondata = json_decode($response);
    header("Content-Type: application/json");
    //check if the payment is valid
    if($jsondata->status == "true"){
        //loop through section cart
        foreach($_SESSION["cart"] as $pid =>$value){
            //Pass the product data
            $order_id = $jsondata->data->reference;
            $amount = $jsondata->data->amount;
            $user_id = $_SESSION["user"]["id"];
            $product_id = $pid;
            $quantity = $value["quantity"];
            $status = "processing";
            $payment_status = "paid";
            $payment_method = "paystack";
            //Insert into orders table
            $sql = "INSERT INTO orders(order_id, amount, user_id, product_id, quantity, status,payment_status, payment_method) VALUES ('$order_id', '$amount', '$user_id', '$product_id', '$quantity', '$status', '$payment_status', '$payment_method')";
            //query
            $query = mysqli_query($connection, $sql);
            if (!$query) {
                die("Insert failed: " . mysqli_error($connection));
            }
            //Empty cart
            unset($_SESSION["cart"]);
            
        }
            //return message 
            $response2 = ["code" => 200];
            echo json_encode($response2);
    }else{
         $response2 = ["code" => 401];
         echo json_encode($response2);
    }
}
if(isset($_POST["order_status"])){
    $order_id = $_GET["order_id"];
    $status = $_POST["order_status"];
    //SQL
    $sql = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
    $query = mysqli_query($connection, $sql);
    if($query){
        $success = "Order status updated successfully.<br> <a href='view-order.php?order_id=$order_id'>Reload Page</a>";
    } else {
        $error = "Failed to update order status.";
    }
}
?>