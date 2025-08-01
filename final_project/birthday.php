<?php
session_start();
include 'home_nav.php';
?>
<?php
include 'footer.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>birthday</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      .box {
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        border-radius: 10px;
        background: #fff;
        margin: 15px 0;
        padding: 16px;
        transition: box-shadow 0.2s;
        border: 1px solid #eee;
        min-height: 350px;
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      .box:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,0.15);
      }
      .product-img {
        max-width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
      }
    </style>
    <script>
    function Search() {
        var t1 = document.getElementById("search").value;
        var obj = new XMLHttpRequest();
        obj.open("get", "search.php?data=" + encodeURIComponent(t1), true);
        obj.send();
        obj.onreadystatechange = function() {
            if (obj.status == 200 && obj.readyState == 4) {
                document.getElementById("d1").innerHTML = obj.responseText;
            }
        };
    }
    </script>
  </head>
  <body>
    <?php render_home_nav(); ?>

    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <input id="search" type="text" placeholder="Enter Text To Search" class="form-control" onkeyup="Search()"/>
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>

    <div id="d1" class="container-fluid">
      <?php
      include("dbconfig.php");
      $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      $qry = "SELECT * FROM products WHERE product_type = 'birthday'";
      $resultset = mysqli_query($conn, $qry);
      if(mysqli_num_rows($resultset)>0){
        while($row = mysqli_fetch_assoc($resultset)){
          echo "<div class='col-sm-3 mb-4'>";
          echo "<a href='desc.php?pid=" . htmlspecialchars($row['product_id']) . "'>";
          echo "<div class='box'>";
          echo "<img class='product-img' src='admin/" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' />";
          echo "<h4>" . htmlspecialchars($row['product_name']) . "</h4>";
          echo "<h4>&#8377; " . htmlspecialchars($row['product_price']) . "</h4>";
          echo "</div>";
          echo "</a>";
          echo "</div>";
        }
      } else {
        echo "<h2 class='text-center text-danger'>No Product Found!!!</h2>";
      }
      mysqli_close($conn);

      ?>

    </div>

      <?php render_footer(); ?>
  </body>
</html>