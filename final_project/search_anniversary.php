<?php
include("dbconfig.php");

$val = '';
if (isset($_GET['data'])) {
    $val = $_GET['data'];
}

$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

if (!$conn) {
    echo "<h2 class='text-center text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h2>";
    exit();
}

if (!empty($val)) {
    $qry = "SELECT * FROM products WHERE product_type='anniversary' AND product_name LIKE '%" . mysqli_real_escape_string($conn, $val) . "%'";
} else {
    $qry = "SELECT * FROM products WHERE product_type='anniversary'";
}

$resultset = mysqli_query($conn, $qry);

if ($resultset) {
    if (mysqli_num_rows($resultset) > 0) {
        while ($row = mysqli_fetch_assoc($resultset)) {
            echo "<div class='col-sm-3'>";
            echo "<a href='desc.php?pid=" . htmlspecialchars($row['product_id']) . "'>";
            echo "<div class='box'>";
            echo "<div class='card-img-top-wrap'>";
            echo "<img src='admin/" . htmlspecialchars($row['product_image']) . "' class='product-img' alt='" . htmlspecialchars($row['product_name']) . "' />";
            echo "<a href='#' class='heart-icon'>&#x2665;</a>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "<h2>" . htmlspecialchars($row['product_name']) . "</h2>";
            echo "<h2 class='price'>&#8377; " . htmlspecialchars(number_format($row['product_price'], 2)) . "</h2>";
            echo "</div>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<h2 class='text-center text-danger'>No Anniversary Products Found!</h2>";
    }
    mysqli_free_result($resultset);
} else {
    echo "<h2 class='text-center text-danger'>Error in query: " . mysqli_error($conn) . "</h2>";
}
mysqli_close($conn);
?>