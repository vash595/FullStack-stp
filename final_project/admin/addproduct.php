<?php
include 'admin_nav.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = htmlspecialchars(trim($_POST['product_name']));
    $product_type = htmlspecialchars(trim($_POST['product_type']));
    $product_price = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);
    $product_description = htmlspecialchars(trim($_POST['product_description']));

    $target_dir = "products/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));

    $new_file_name = uniqid('product_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    if (empty($_FILES["product_image"]["tmp_name"])) {
        $msg .= "No image file uploaded or an upload error occurred.";
        $uploadOk = 0;
    } else {
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check === false) {
            $msg .= "File is not an image.";
            $uploadOk = 0;
        }
    }

    if ($_FILES["product_image"]["size"] > 5000000) {
        $msg .= "Sorry, your file is too large (max 5MB).";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $msg .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $msg = "<h4><font color='red'>Sorry, your file was not uploaded. " . $msg . "</font></h4>";
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $product_image_path_to_store = $target_file;

            $conn = mysqli_connect("localhost", "root", "", "FlorifyDB");

            if (!$conn) {
                $msg = "<h4><font color='red'>Database Connection Failure: " . mysqli_connect_error() . "</font></h4>";
            } else {
                $qry = "INSERT INTO products(product_name, product_type, product_price, product_description, product_image) VALUES(?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $qry);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ssdss", $product_name, $product_type, $product_price, $product_description, $product_image_path_to_store);

                    if (mysqli_stmt_execute($stmt)) {
                        if (mysqli_stmt_affected_rows($stmt) > 0) {
                            $msg = "<h4><font color='green'>Product added successfully!</font></h4>";
                        } else {
                            $msg = "<h4><font color='red'>Error: No rows affected. Product might not have been added.</font></h4>";
                            unlink($target_file);
                        }
                    } else {
                        $msg = "<h4><font color='red'>Error executing statement: " . mysqli_stmt_error($stmt) . "</font></h4>";
                        unlink($target_file);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $msg = "<h4><font color='red'>Error preparing statement: " . mysqli_error($conn) . "</font></h4>";
                    unlink($target_file);
                }

                mysqli_close($conn);
            }
        } else {
            $msg = "<h4><font color='red'>Sorry, there was an error uploading your file. Please check server logs for details.</font></h4>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .form-container {
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
    </style>
</head>
<body>
    <?php render_navbar(); ?>

    <div class="container-fluid">
        <div class="row form-container">
            <div class="col-md-5 col-sm-8 col-xs-12" style="margin: auto;">
                <?php echo $msg; ?>
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h3>Add New Product</h3></div>
                    <div class="panel-body">
                        <form action="addproduct.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_type">Product Type</label>
                                <select class="form-control" id="product_type" name="product_type" required>
                                    <option value="birthday">Birthday</option>
                                    <option value="anniversary">Anniversary</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price</label>
                                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea class="form-control" id="product_description" name="product_description" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Image</label>
                                <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>