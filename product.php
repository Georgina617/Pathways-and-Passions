  <?php
 session_start();
 require "inc/process.php";
 require "inc/header.php";
 if(isset($_GET['product_id']) && !empty($_GET['product_id'])){
    $id = $_GET['product_id'];
    //SQL
    $sql = "SELECT * FROM products WHERE id='$id'";
    //Query
    $query = mysqli_query($connection,$sql);
    //result
    $result = mysqli_fetch_assoc($query);
 }else{
    header("Location: index.php");
 }
 $_SESSION['url'] = $_GET['product_id'];
 ?>
  <div class="container">
      <?php require "pages/header-home.php"; ?>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
          integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

      <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
          integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <div class="container-fluid my-3">
          <div class="row">
              <div class="col-8">
                  <?php if(isset($error)): ?>
                  <div class="alert alert-danger text-center">
                      <?= $error ?>
                  </div>
                  <?php elseif(isset($success)): ?>
                  <div class="alert alert-success text-center">
                      <?= $success ?>
                  </div>
                  <?php endif; ?>
                  <div
                      style="background:url('<?php echo $result["image"] ?>');background-position:center;background-size:cover;background-repeat:no-repeat;">
                      <div style="background:#0000007a; padding:40px;text-align:center;opacity:0.8;">
                          <h2 class="text-white"><?php echo $result["title"] ?></h2>
                      </div>
                  </div>
                  <hr>
                  <div class="row bg-dark mb-2">
                      <div class="col-6 text-white">
                          Date Published: <?php echo date("F j Y", strtotime($result["timestamp"])) ?>
                      </div>
                      <div class="col-6 text-end text-white">
                          Category: <?php 
                        //  echo $result["category_id"] 
                        $cid = $result["category_id"];
                        $sql2 = "SELECT * FROM category WHERE id='$cid'";
                        $query2 = mysqli_query($connection,$sql2);
                        $result2 = mysqli_fetch_assoc($query2);
                        echo $result2["name"];
                        ?>
                      </div>
                  </div>

                  <div class="text-center"><img style="width:200px; height:200px;" src="<?php echo $result["image"] ?>"
                          alt="" srcset="">
                  </div>
                  <div class="content">
                      <p><?php echo $result["content"] ?></p>
                  </div>
                  <hr>
                  <div>
                      <form id="submitform" method="post">
                          <div class="form-group">
                              <label for="quantity">Quantity</label>
                              <input type="number" class="form-control w-25" name="quantity" id="" value="1" min="1"
                                  step="1">
                          </div>
                          <input type="hidden" name="product_id" value="<?php echo $id ?>">
                          <input type="hidden" name="addtocart" value="1">
                          <button type="submit" class="btn btn-primary mt-2" name="addtocart">Add to
                              Cart</button>
                      </form>
                  </div>
              </div>
              <div class="col-4">
                  <!-- sidebar -->
                  <div class="border p-3">
                      <form action="search.php" method="post">
                          <div class="form-group">
                              <h4>Search</h4>
                              <input type="text" name="search" class="form-control" placeholder="Enter Search term">
                          </div>
                          <button type="submit" class="btn btn-dark mt-2">Search</button>
                      </form>
                  </div>

                  <div class="border p-3 mt-2">
                      <h4>Categories</h4>
                      <ul>
                          <?php
                         $sql_c = "SELECT * FROM category ORDER BY id DESC"; 
                            $query_c = mysqli_query($connection, $sql_c);
                        while($result_c = mysqli_fetch_assoc($query_c)) {
                            ?>
                          <li>
                              <a
                                  href="post-category.php?post_category_id=<?php echo $result_c['id']?>"><?php echo $result_c['name']; ?></a>
                          </li>
                          <?php
                        }
                        ?>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
      <?php require "pages/footer-home.php"; ?>
  </div>
  <script>
$(document).ready(function() {
    $("#submitform").submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let formdata = form.serialize();
        //Making a jquery ajax 
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: formdata,
            success: function(response) {
                form.prepend(`
                <div class="alert alert-success">
                <strong>${response}</strong>
                </div>
                `);
                //izitoast Notification
                iziToast.success({
                    title: 'info',
                    message: 'Successfully added to Cart',
                });
            }
        });
    });
});
  </script>
  <?php
 require "inc/footer.php";

 ?>