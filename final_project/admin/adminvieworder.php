<?php
include 'admin_nav.php'; // Assuming this is an admin page
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View All Orders</title>
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
        .container-fluid {
            padding: 0 40px;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
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
        .btn-delete {
            font-size: 1.2em;
            color: red;
            text-decoration: none;
        }
        .btn-delete:hover {
            color: darkred;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .product-details {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php render_navbar(); ?>

    <div class="container-fluid">
        <div class="row" style="min-height: 550px;">
            <div class='col-sm-12'>
                <h1 class="text-center" style="margin-bottom: 30px;">All Orders</h1>

                <?php 
                include("../dbconfig.php");
                $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

                if (!$conn) {
                    echo "<h3 class='text-center text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h3>";
                } else {
                    $qry = "SELECT orders.order_id, orders.user_id, orders.product_id, orders.address, orders.order_amount, orders.payment_mode, orders.order_status, users.name AS user_name FROM orders JOIN users ON orders.user_id = users.user_id ORDER BY orders.order_id DESC";
                    $resultset = mysqli_query($conn, $qry);

                    if (mysqli_num_rows($resultset) > 0) {
                        echo "<table class='table table-striped table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Order ID</th>";
                        echo "<th>User Name</th>";
                        echo "<th>Products</th>";
                        echo "<th>Address</th>";
                        echo "<th>Total Amount</th>";
                        echo "<th>Payment Mode</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>"; // New column for delete button
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = mysqli_fetch_assoc($resultset)) {
                            // Split product IDs to fetch images
                            $product_ids_array = explode(',', $row['product_id']);
                            $product_ids_array = array_filter($product_ids_array);
                            
                            $product_images = "";
                            if (!empty($product_ids_array)) {
                                $product_placeholders = implode(',', array_fill(0, count($product_ids_array), '?'));
                                $products_qry = "SELECT product_name, product_image FROM products WHERE product_id IN ($product_placeholders) LIMIT 3";
                                $products_stmt = mysqli_prepare($conn, $products_qry);
                                
                                if ($products_stmt) {
                                    $types = str_repeat('i', count($product_ids_array));
                                    mysqli_stmt_bind_param($products_stmt, $types, ...$product_ids_array);
                                    mysqli_stmt_execute($products_stmt);
                                    $products_result = mysqli_stmt_get_result($products_stmt);
                                    
                                    while ($product_row = mysqli_fetch_assoc($products_result)) {
                                        $product_images .= "<div class='product-details'><img src='../admin/" . htmlspecialchars($product_row['product_image']) . "' alt='" . htmlspecialchars($product_row['product_name']) . "' class='product-image' /><span>" . htmlspecialchars($product_row['product_name']) . "</span></div>";
                                    }
                                    mysqli_stmt_close($products_stmt);
                                }
                            }

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                            echo "<td>" . $product_images . "</td>";
                            echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                            echo "<td>&#8377; " . htmlspecialchars(number_format($row['order_amount'], 2)) . "</td>";
                            echo "<td>" . htmlspecialchars($row['payment_mode']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['order_status']) . "</td>";
                            echo "<td><a href='delete_order.php?order_id=" . htmlspecialchars($row['order_id']) . "' class='btn-delete glyphicon glyphicon-trash' title='Delete Order' onclick='return confirm(\"Are you sure you want to delete this order?\");'></a></td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<h3 class='text-center text-warning'>No orders found.</h3>";
                    }
                    mysqli_close($conn);
                }
                ?>
            </div>
        </div>
    </div>
    
    <?php include '../footer.php'; render_footer(); ?>
</body>
</html>