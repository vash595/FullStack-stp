<?php
session_start();
include 'home_nav.php';
?>
<?php
include 'footer.php';
$msg = "";
if(isset($_POST['btnlogin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    include 'dbconfig.php';
    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);
    $qry = "select * from users where emailed='$username' and password='$password' and role='client'";
    $resultset = mysqli_query($conn, $qry);
    if(mysqli_num_rows($resultset)>0){
            $row = mysqli_fetch_array($resultset);
            $_SESSION['uid'] = $row[0];
            $_SESSION['name'] = $row[1];
        header("location:index.php");
    } else {
        $msg = "Invalid Username & Password!!!!!";
    }
    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      
    </style>
  </head>
  <body>
    <?php render_home_nav(); ?>

    <div class="container-fluid">
        <div class="row" style="height: 750px; display: flex; align-items: center; justify-content: center;">
            <div class="col-md-4 col-sm-6 col-xs-10" style="float: none; margin: auto;">
                <div class="panel panel-default">
                    <h3 class="text-center text-danger"><?php echo $msg; ?></h3>
                    <div class="panel-heading text-center"><h3>Login</h3></div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember"> Remember me</label>
                            </div>
                            <button type="submit" name="btnlogin" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="register.php">Create new account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




     <?php render_footer(); ?>
  </body>
</html>