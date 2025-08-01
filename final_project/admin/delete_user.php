<?php
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    
    include(__DIR__ . "/../dbconfig.php");

    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

    if (!$conn) {
        die("Database Connection Failed: " . mysqli_connect_error());
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: viewusers.php?status=deleted"); 
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: viewuser.php"); 
    exit();
}
?>