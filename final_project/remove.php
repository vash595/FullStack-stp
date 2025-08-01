<?php
$id = $_GET['pid']; // 17
$data = $_COOKIE['cart']; // 12,45,17,3
$arr = explode(",", $data); // [12,45,17,3]
$key = array_search($id, $arr);
array_splice($arr, $key, 1);
$data = implode(",", $arr);
setcookie("cart", $data);
header("location:mycart.php");
?>