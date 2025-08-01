<?php
session_start();
include 'home_nav.php';
include 'footer.php';
?>

<?php
$product = null;
$msg = "";

include('dbconfig.php');
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

if (!$conn) {
    $msg = "<h2 class='text-center text-danger'>Database Connection Failure: " . mysqli_connect_error() . "</h2>";
} else {
    if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])) {
        header("location:index.php");
        exit();
    } else {
        $pid = $_GET['pid'];

        $qry = "SELECT product_name, product_price, product_description, product_image FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $qry);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $pid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);
            } else {
                $msg = "<h2 class='text-center text-warning'>Product not found.</h2>";
            }
            mysqli_stmt_close($stmt);
        } else {
            $msg = "<h2 class='text-center text-danger'>Error preparing statement: " . mysqli_error($conn) . "</h2>";
        }
    }
    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $product ? htmlspecialchars($product['product_name']) : 'Product Details'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f8f8;
        }
        .product-detail-section {
            padding: 60px 0;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .product-image-container {
            text-align: center;
            padding: 20px;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .product-info {
            padding: 20px;
        }
        .product-info h3 {
            font-size: 2.2em;
            font-weight: bold;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .product-info .price {
            font-size: 1.8em;
            color: #28a745;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .product-info h4 {
            font-size: 1.4em;
            font-weight: 600;
            color: #555;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .product-info p {
            font-size: 1.1em;
            color: #666;
            line-height: 1.6;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #333;
        }
    </style>
</head>
<body>
    <?php render_home_nav(); ?>

    <div class="container-fluid">
        <?php if ($msg): ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <?php echo $msg; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($product): ?>
            <div class="row product-detail-section">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 product-image-container">
                    <?php
                    $image_path = 'admin/' . htmlspecialchars($product['product_image']);
                    ?>
                    <img class="img-rounded product-image" src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" />
                </div>
                <div class="col-sm-5 product-info">
                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    <h3 class="price">&#8377; <?php echo htmlspecialchars(number_format($product['product_price'], 2)); ?></h3>
                    <h4>Description</h4>
                    <p><?php echo htmlspecialchars($product['product_description']); ?></p>
                   <a href="cart.php?action=add&pid=<?php echo htmlspecialchars($pid); ?>" class="btn btn-warning">Add To Cart</a>
                </div>
                <div class="col-sm-1"></div>
            </div>
        <?php endif; ?>
    </div>

    <?php render_footer(); ?>
</body>
</html>
