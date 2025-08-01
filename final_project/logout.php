<?php
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $parms = session_get_cookie_params();
    setcookie(session_name(), '', time() - 4000, $parms["path"], $parms["domain"], $parms["secure"], $parms["httponly"]);
}
session_destroy();
header("location:index.php");
?>