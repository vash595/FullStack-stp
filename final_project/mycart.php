<?php
session_start(); // Crucial: Must be at the very top
include 'home_nav.php';
include 'footer.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .place-order-button-container {
            text-align: right;
            margin-top: 20px;
        }
        .btn-place-order {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-place-order:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .table {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            vertical-align: middle !important;
            padding: 12px;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .cart-product-image {
            border-radius: 4px;
            object-fit: cover;
        }
        .glyphicon-remove {
            color: red;
            font-size: 20px;
            text-decoration: none;
        }
        .glyphicon-remove:hover {
            color: darkred;
        }
        .empty-cart-message {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <?php render_home_nav(); ?>

    <div class="container-fluid">
        <h1 class="text-center" style="margin-top: 30px; margin-bottom: 30px;">My Shopping Cart</h1>
        <div class="row" style="min-height: 550px;">
            <div class='col-sm-2'></div>
            <div class='col-sm-8'>
                <?php
                // Get user ID from session (needed for hidden field)
                $user_id_for_post = isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0;

                if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {
                    $product_ids_string = $_COOKIE['cart'];
                    $product_ids_string = preg_replace('/[^0-9,]/', '', $product_ids_string);
                    $product_ids_array = explode(',', $product_ids_string);
                    $product_ids_array = array_filter($product_ids_array);

                    if (empty($product_ids_array)) {
                        echo "<h2 class='text-center text-danger empty-cart-message'>Cart is empty!!!</h2>";
                    } else {
                        include("dbconfig.php");
                        $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

                        if (!$conn) {
                            echo "<h2 class='text-center text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h2>";
                        } else {
                            $placeholders = implode(',', array_fill(0, count($product_ids_array), '?'));
                            $qry = "SELECT product_id, product_name, product_price, product_image FROM products WHERE product_id IN ($placeholders)";

                            $stmt = mysqli_prepare($conn, $qry);

                            if ($stmt) {
                                $types = str_repeat('i', count($product_ids_array));
                                mysqli_stmt_bind_param($stmt, $types, ...$product_ids_array);

                                mysqli_stmt_execute($stmt);
                                $resultset = mysqli_stmt_get_result($stmt);

                                if (mysqli_num_rows($resultset) > 0) {
                                    // Start the form that will submit to shipping.php
                                    echo "<form action='shipping.php' method='post'>";

                                    echo "<table class='table table-striped'>";
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>Product Image</th>";
                                    echo "<th>Product Name</th>";
                                    echo "<th>Product Price</th>";
                                    echo "<th>Action</th>";
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    $total_price = 0;

                                    while ($row = mysqli_fetch_assoc($resultset)) {
                                        echo "<tr>";
                                        echo "<td><img src='admin/" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "' width='50px' height='50px' /></td>";
                                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                        echo "<td>&#8377; " . htmlspecialchars(number_format($row['product_price'], 2)) . "</td>";
                                        echo "<td><a href='remove.php?pid=" . htmlspecialchars($row['product_id']) . "' class='glyphicon glyphicon-remove' style='color:red; font-size:20px' title='Remove from Cart'></a></td>";
                                        echo "</tr>";
                                        $total_price += $row['product_price'];
                                    }
                                    echo "</tbody>";
                                    echo "<tfoot>";
                                    echo "<tr>";
                                    echo "<td colspan='2' class='text-right'><strong>Total Amount:</strong></td>";
                                    echo "<td><strong>&#8377; " . htmlspecialchars(number_format($total_price, 2)) . "</strong></td>";
                                    echo "<td></td>";
                                    echo "</tr>";
                                    echo "</tfoot>";
                                    echo "</table>";

                                    // Hidden fields to pass data to shipping.php via POST
                                    echo "<input type='hidden' name='user_id_from_cart' value='" . htmlspecialchars($user_id_for_post) . "'>";
                                    echo "<input type='hidden' name='cart_product_ids' value='" . htmlspecialchars($product_ids_string) . "'>";
                                    echo "<input type='hidden' name='order_total' value='" . htmlspecialchars($total_price) . "'>";

                                    echo "<div class='place-order-button-container'>";
                                    echo "<button type='submit' name='btnplaceorder' class='btn btn-warning btn-place-order'>Place Order</button>";
                                    echo "</div>";
                                    echo "</form>"; // End the form

                                } else {
                                    echo "<h2 class='text-center text-danger'>No products found in cart (IDs might be invalid)!</h2>";
                                }
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<h2 class='text-center text-danger'>Error preparing statement: " . mysqli_error($conn) . "</h2>";
                            }
                            mysqli_close($conn);
                        }
                    }
                } else {
                    echo "<h2 class='text-center text-danger empty-cart-message'>Cart is empty!!!</h2>";
                }
                ?>
            </div>
            <div class='col-sm-2'></div>
        </div>
    </div>

    <?php render_footer(); ?>
</body>
</html>