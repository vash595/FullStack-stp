<?php
include 'admin_nav.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f8f8;
            padding-top: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .table {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle !important;
            padding: 12px;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
        }
        .btn-action {
            font-size: 1.2em;
            margin-right: 5px;
        }
        .btn-edit {
            color: #007bff;
        }
        .btn-delete {
            color: red;
        }
        .status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php render_navbar(); ?>

    <div class="container">
        <h1 class="text-center" style="margin-bottom: 30px;">Manage Products</h1>

        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<div class='alert status-success text-center status-message'>Product deleted successfully!</div>";
            } else if ($_GET['status'] == 'error') {
                echo "<div class='alert status-danger text-center status-message'>Error deleting product. Please try again.</div>";
            }
        }

        include("../dbconfig.php");
        $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

        if (!$conn) {
            echo "<h3 class='text-center text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h3>";
        } else {
            $qry = "SELECT product_id, product_name, product_type, product_price, product_description, product_image FROM products ORDER BY product_id DESC";
            $resultset = mysqli_query($conn, $qry);

            if(mysqli_num_rows($resultset) > 0){
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Image</th>";
                echo "<th>Name</th>";
                echo "<th>Type</th>";
                echo "<th>Price</th>";
                echo "<th>Description</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while($row = mysqli_fetch_assoc($resultset)){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' class='product-image' /></td>";
                    echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['product_type']) . "</td>";
                    echo "<td>&#8377; " . htmlspecialchars(number_format($row['product_price'], 2)) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($row['product_description'], 0, 50)) . "...</td>";
                    echo "<td>";
                    echo "<a href='edit_product.php?pid=" . htmlspecialchars($row['product_id']) . "' class='btn-action btn-edit glyphicon glyphicon-pencil' title='Edit Product'></a>";
                    echo "<a href='delete_product.php?pid=" . htmlspecialchars($row['product_id']) . "' class='btn-action btn-delete glyphicon glyphicon-trash' title='Delete Product' onclick='return confirm(\"Are you sure you want to delete this product?\");'></a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<h3 class='text-center text-warning'>No products found.</h3>";
            }
            mysqli_close($conn);
        }
        ?>
    </div>
</body>
</html>
