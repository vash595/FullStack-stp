<?php
include 'admin_nav.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $pwd = $_POST['password'];
    $confirm_pwd = $_POST['confirm_password'];
    $phone = htmlspecialchars(trim($_POST['phone']));
    $role = htmlspecialchars(trim($_POST['role']));

    if ($pwd !== $confirm_pwd) {
        $msg = "<h4><font color='red'>Error: Passwords do not match!</font></h4>";
    } else {
        $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);

        $conn = mysqli_connect("localhost", "root", "", "FlorifyDB");

        if (!$conn) {
            $msg = "<h4><font color='red'>Database Connection Failure: " . mysqli_connect_error() . "</font></h4>";
        } else {
            $qry = "INSERT INTO users(name, emailed, password, phoneno, role) VALUES(?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $qry);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $hashed_password, $phone, $role);

                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $msg = "<h4><font color='green'>User account created successfully!</font></h4>";
                    } else {
                        $msg = "<h4><font color='red'>Error: No rows affected. User account might not have been created.</font></h4>";
                    }
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
    <title>Add User</title>

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
            <div class="col-md-4 col-sm-6 col-xs-10" style="margin: auto;">
                <?php echo $msg; ?>
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><h3>Add New User</h3></div>
                    <div class="panel-body">
                        <form action="adduser.php" method="post" onsubmit="return validatePassword()">
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
                                <span id="password_match_error" style="color: red; display: none; font-size: 0.9em; margin-top: 5px;">Passwords do not match!</span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone No.</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="client">Client</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var error_span = document.getElementById("password_match_error");

            if (password !== confirm_password) {
                error_span.style.display = "block";
                return false;
            } else {
                error_span.style.display = "none";
                return true;
            }
        }
    </script>
</body>
</html>