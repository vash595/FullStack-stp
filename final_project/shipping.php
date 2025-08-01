<?php
session_start();
if(!isset($_SESSION['name']) || !isset($_SESSION['uid'])) {
    header("location:login.php");
    exit();
}

include 'home_nav.php';
include 'footer.php';

$msg = "";

$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : '';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
$phone = '';
$address_input = '';
$payment_method = 'cod';

$user_id = isset($_POST['user_id_from_cart']) ? (int)$_POST['user_id_from_cart'] : (isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0);
$product_ids_in_cart = isset($_POST['cart_product_ids']) ? $_POST['cart_product_ids'] : '';
$order_amount = isset($_POST['order_total']) ? (float)$_POST['order_total'] : 0.00;

if (isset($_POST['btnplaceorder'])) {
    $_SESSION['temp_user_id'] = $user_id;
    $_SESSION['temp_cart_product_ids'] = $product_ids_in_cart;
    $_SESSION['temp_order_total'] = $order_amount;
} 
else if (isset($_POST['btnorder'])) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $address_input = htmlspecialchars(trim($_POST['address'] ?? ''));
    $payment_method = htmlspecialchars(trim($_POST['payment_method'] ?? ''));

    $full_address = "$name, $address_input, $email, $phone";
    
    $user_id = isset($_SESSION['temp_user_id']) ? (int)$_SESSION['temp_user_id'] : (isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0);
    $product_ids_in_cart = isset($_SESSION['temp_cart_product_ids']) ? $_SESSION['temp_cart_product_ids'] : '';
    $order_amount = isset($_SESSION['temp_order_total']) ? (float)$_SESSION['temp_order_total'] : 0.00;

    if ($user_id === 0 || empty($product_ids_in_cart) || $order_amount === 0.00) {
        $msg = "<h3 class='text-danger'>Error: Missing order details. Please go back to cart and try again.</h3>";
    } else {
        include "dbconfig.php";
        $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

        if (!$conn) {
            $msg = "<h3 class='text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h3>";
        } else {
            $qry = "INSERT INTO orders(user_id, product_id, address, order_amount, payment_mode, order_status) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $qry);

            if ($stmt) {
                $order_status = 'Pending';
                mysqli_stmt_bind_param($stmt, "isdsss", $user_id, $product_ids_in_cart, $full_address, $order_amount, $payment_method, $order_status);

                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $msg = "<h3 class='text-success'>Order placed successfully !!!</h3>";
                        setcookie('cart', '', time() - 3600, "/");
                        unset($_SESSION['temp_user_id']);
                        unset($_SESSION['temp_cart_product_ids']);
                        unset($_SESSION['temp_order_total']);
                    } else {
                        $msg = "<h3 class='text-danger'>Error: No rows affected. Order might not have been placed.</h3>";
                    }
                } else {
                    $msg = "<h3 class='text-danger'>Error executing statement: " . mysqli_stmt_error($stmt) . "</h3>";
                }
                mysqli_stmt_close($stmt);
            } else {
                $msg = "<h3 class='text-danger'>Error preparing statement: " . mysqli_error($conn) . "</h3>";
            }
            mysqli_close($conn);
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shipping Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f8f8;
        }
        .shipping-container {
            height: 750px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .panel {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .panel-heading {
            background-color: #f8f8f8;
            border-bottom: 1px solid #eee;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            padding: 15px;
        }
        .panel-body {
            padding: 25px;
        }
        .form-group label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px 12px;
            height: auto;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php render_home_nav(); ?>

    <div class="container-fluid">
        <div class="row shipping-container">
            <div class="col-md-5 col-sm-8 col-xs-12" style="float: none; margin: auto;">
                <?php if (!empty($msg)): ?>
                    <div class="alert <?php echo (strpos($msg, 'success') !== false) ? 'alert-success' : 'alert-danger'; ?> text-center" role="alert">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h3>Shipping Details</h3></div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($name); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required value="<?php echo htmlspecialchars($phone); ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required value="<?php echo htmlspecialchars($address_input); ?>">
                            </div>
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="cod" <?php echo ($payment_method == 'cod') ? 'selected' : ''; ?>>Cash on Delivery</option>
                                    <option value="online" <?php echo ($payment_method == 'online') ? 'selected' : ''; ?>>Online Payment</option>
                                </select>
                            </div>
                            <button type="submit" name="btnorder" class="btn btn-success btn-block">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php render_footer(); ?>
</body>
</html>