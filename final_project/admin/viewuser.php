<?php
include 'admin_nav.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Users</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php render_navbar(); ?>

    <div class="container" style="margin-top: 20px;">
        <h2 class="text-center">Registered Users</h2>
        <?php
            
            include(__DIR__ . "/../dbconfig.php");
            $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);

            if (!$conn) {
                die("<h3 class='text-center text-danger'>Database Connection Failed: " . mysqli_connect_error() . "</h3>");
            }

            $qry = "SELECT * FROM users";
            $resultset = mysqli_query($conn, $qry);

            if(mysqli_num_rows($resultset) > 0){
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>User ID</th>";
                echo "<th>Full Name</th>";
                echo "<th>Email ID</th>";
                echo "<th>Password</th>";
                echo "<th>Phone No.</th>";
                echo "<th>User Type</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while($row = mysqli_fetch_array($resultset)){
                    $user_id = htmlspecialchars($row[0]);

                    echo "<tr>";
                    echo "<td>" . $user_id . "</td>";
                    echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                    echo "<td>" . htmlspecialchars($row[2]) . "</td>";
                    echo "<td>" . htmlspecialchars($row[3]) . "</td>";
                    echo "<td>" . htmlspecialchars($row[4]) . "</td>";
                    echo "<td>" . htmlspecialchars($row[5]) . "</td>";
                    echo "<td>";
                    echo "<a href='delete_user.php?id=" . $user_id . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            }
            else{
                echo "<h3 class='text-center text-warning'>No Record Found!!!!!</h3>";
            }
            mysqli_close($conn);
        ?>
    </div>

  </body>
</html>