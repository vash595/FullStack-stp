<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function render_home_nav() {
    echo '
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#" style="border-right:1px solid #ccc; padding-right:20px;">Get Floword</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Occasion <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="anniversary.php">Anniversary</a></li>
              <li><a href="birthday.php">Birthday</a></li>
            </ul>
          </li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">';

if(isset($_SESSION['name'])) {
    echo htmlspecialchars($_SESSION['name']);
} else {
    echo "My Account";
}

    echo '<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="login.php">Login</a></li>
              <li><a href="register.php">Register</a></li>
              <li><a href="vieworderclient.php">View Order</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Log Out</a></li> 
            </ul>
          </li>
          <li><a href="mycart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
        </ul>
      </div>
    </nav>';
}
?>