<?php

if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {
    $product_id_to_delete = (int)$_GET['pid'];

    include("../dbconfig.php");
    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

    if ($conn) {
        
        $qry = "DELETE FROM products WHERE product_id = ?"; 
        $stmt = mysqli_prepare($conn, $qry);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $product_id_to_delete);
            
            if (mysqli_stmt_execute($stmt)) {
                
                header("Location: viewproduct.php?status=success");
                exit();
            } else {
               
                header("Location: viewproduct.php?status=error");
                exit();
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }
} else {
   
    header("Location: viewproduct.php?status=error");
    exit();
}
?>
