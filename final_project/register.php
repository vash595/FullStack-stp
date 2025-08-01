<?php
$msg = "";
if(isset($_POST['btn_register'])){
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $pwd = $_POST['password'];
    $confirm_pwd = $_POST['confirm_password'];
    $phone = htmlspecialchars(trim($_POST['phone']));

    if ($pwd !== $confirm_pwd) {
        $msg = "<h4><font color='red'>Error: Passwords do not match!</font></h4>";
    } else {
        $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
        $conn = mysqli_connect("localhost", "root", "", "FlorifyDB");
        if (!$conn) {
            $msg = "<h4><font color='red'>Database Connection Failure: " . mysqli_connect_error() . "</font></h4>";
        } else {
            $qry = "INSERT INTO users(name, emailed, password, phoneno, role) values(?, ?, ?, ?, 'client')";
            $stmt = mysqli_prepare($conn, $qry);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashed_password, $phone);
                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_affected_rows($conn)>0)
                        $msg = "<h4><font color='green'>Account created successfully</font></h4>";
                    else
                        $msg = "<h4><font color='red'>Error in creating account!!!!!!</font></h4>";
                } else {
                    $msg = "<h4><font color='red'>Error executing statement: " . mysqli_stmt_error($stmt) . "</font></h4>";
                }
                mysqli_stmt_close($stmt);
            } else {
                $msg = "<h4><font color='red'>Error preparing statement: " . mysqli_error($conn) . "</font></h4>";
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
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f8f8;
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
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
        }
    </style>
  </head>
  <body>
    <?php include 'home_nav.php'; render_home_nav(); ?>

    <div class="container-fluid">
        <div class="row form-container">
            <div class="col-md-4 col-sm-6 col-xs-10" style="float: none; margin: auto;">
                <?php echo $msg; ?>
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h3>Create New Account</h3></div>
                    <div class="panel-body">
                        <form method="post" onsubmit="return validate()">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <span id="password_error" class="error-message">Passwords do not match!</span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone No.</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <button type="submit" name="btn_register" class="btn btn-success btn-block">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validate() {
            var passwordInput = document.getElementById("password");
            var confirmPasswordInput = document.getElementById("confirm_password");
            var errorMessage = document.getElementById("password_error");

            if (passwordInput.value !== confirmPasswordInput.value) {
                errorMessage.style.display = "block";
                passwordInput.style.borderColor = "red";
                confirmPasswordInput.style.borderColor = "red";
                return false;
            } else {
                errorMessage.style.display = "none";
                passwordInput.style.borderColor = "";
                confirmPasswordInput.style.borderColor = "";
                return true;
            }
        }
    </script>

    <?php include 'footer.php'; render_footer(); ?>
  </body>
</html>