<?php
$val = $_GET['data'];
include("dbconfig.php");

$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

$qry = "select * from products where product_type='birthday' and product_name like '%$val%'";
      $resultset = mysqli_query($conn, $qry);
      if(mysqli_num_rows($resultset)>0){
        while($row = mysqli_fetch_assoc($resultset)){
          echo "<div class='col-sm-3 mb-4'>";
          echo "<a href='desc.php?pid=$row[product_id]'>";
          echo "<div class='box'>";
          echo "<img class='product-img' src='admin/" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' />";
          echo "<h4>$row[product_name]</h4>";
          echo "<h4>&#8377; $row[product_price]</h4>";
          echo "</div>";
          echo "</a>";
          echo "</div>";
        }

      }
      else{
        echo "<h2 class='text-center text-danger'>No Product Found!!!</h2>";

      }
      mysqli_close($conn);

      ?>