<?php
session_start();

if(!isset($_SESSION['name']) || !isset($_SESSION['uid'])) {
    header("location:login.php");
    exit();
}

include 'home_nav.php';
include 'footer.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f8f8;
        }
        .order-container {
            padding: 30px 0;
        }
        .order-panel {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            overflow: hidden;
        }
        .order-header {
            background-color: #f2f2f2;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            color: #333;
        }
        .order-body {
            padding: 20px;
        }
        .order-details p {
            margin-bottom: 5px;
            font-size: 1.1em;
        }
        .order-details strong {
            color: #555;
        }
        .product-list-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .product-list-table th, .product-list-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: middle;
        }
        .product-list-table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }
        .product-list-table tr:last-child td {
            border-bottom: none;
        }
        .product-list-table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 10px;
        }
        .order-total-footer {
            background-color: #f2f2f2;
            padding: 15px 20px;
            border-top: 1px solid #eee;
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }
        .no-orders-message {
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <?php render_home_nav(); ?>

    <div class="container order-container">
        <h1 class="text-center" style="margin-bottom: 40px;">My Orders</h1>

        <?php
        $user_id = $_SESSION['uid'];
        include("dbconfig.php");
        $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

        if (!$conn) {
            echo "<h2 class='text-center text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h2>";
        } else {
            $orders_qry = "SELECT order_id, product_id, address, order_amount, payment_mode, order_status FROM orders WHERE user_id = ? ORDER BY order_id DESC";
            $orders_stmt = mysqli_prepare($conn, $orders_qry);

            if ($orders_stmt) {
                mysqli_stmt_bind_param($orders_stmt, "i", $user_id);
                mysqli_stmt_execute($orders_stmt);
                $orders_result = mysqli_stmt_get_result($orders_stmt);

                if (mysqli_num_rows($orders_result) > 0) {
                    while ($order = mysqli_fetch_assoc($orders_result)) {
                        echo "<div class='order-panel'>";
                        echo "<div class='order-header'>";
                        echo "<span>Order ID: #" . htmlspecialchars($order['order_id']) . "</span>";
                        echo "<span>Status: <span style='color: " . ($order['order_status'] == 'Pending' ? 'orange' : 'green') . ";'>" . htmlspecialchars($order['order_status']) . "</span></span>";
                        echo "</div>";

                        echo "<div class='order-body'>";
                        echo "<div class='order-details'>";
                        echo "<p><strong>Shipping Address:</strong> " . htmlspecialchars($order['address']) . "</p>";
                        echo "<p><strong>Payment Method:</strong> " . htmlspecialchars($order['payment_mode']) . "</p>";
                        echo "</div>";

                        $product_ids_string = $order['product_id'];
                        $product_ids_array = explode(',', $product_ids_string);
                        $product_ids_array = array_filter($product_ids_array);

                        if (!empty($product_ids_array)) {
                            $product_placeholders = implode(',', array_fill(0, count($product_ids_array), '?'));
                            $products_qry = "SELECT product_id, product_name, product_price, product_image FROM products WHERE product_id IN ($product_placeholders)";
                            $products_stmt = mysqli_prepare($conn, $products_qry);

                            if ($products_stmt) {
                                $types = str_repeat('i', count($product_ids_array));
                                mysqli_stmt_bind_param($products_stmt, $types, ...$product_ids_array);
                                mysqli_stmt_execute($products_stmt);
                                $products_result = mysqli_stmt_get_result($products_stmt);

                                if (mysqli_num_rows($products_result) > 0) {
                                    echo "<table class='product-list-table'>";
                                    echo "<thead><tr><th>Product</th><th>Price</th></tr></thead>";
                                    echo "<tbody>";
                                    while ($product = mysqli_fetch_assoc($products_result)) {
                                        echo "<tr>";
                                        echo "<td>";
                                        echo "<img src='admin/" . htmlspecialchars($product['product_image']) . "' alt='" . htmlspecialchars($product['product_name']) . "' />";
                                        echo htmlspecialchars($product['product_name']);
                                        echo "</td>";
                                        echo "<td>&#8377; " . htmlspecialchars(number_format($product['product_price'], 2)) . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "<p class='text-warning'>No product details found for this order.</p>";
                                }
                                mysqli_stmt_close($products_stmt);
                            } else {
                                echo "<p class='text-danger'>Error preparing product query: " . mysqli_error($conn) . "</p>";
                            }
                        } else {
                            echo "<p class='text-warning'>No products listed in this order.</p>";
                        }
                        echo "</div>";

                        echo "<div class='order-total-footer'>";
                        echo "Order Total: &#8377; " . htmlspecialchars(number_format($order['order_amount'], 2));
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<h2 class='text-center text-info no-orders-message'>You have not placed any orders yet.</h2>";
                }
                mysqli_stmt_close($orders_stmt);
            } else {
                echo "<h2 class='text-center text-danger'>Error preparing orders query: " . mysqli_error($conn) . "</h2>";
            }
            mysqli_close($conn);
        }
        ?>
    </div>

    <?php render_footer(); ?>
</body>
</html>