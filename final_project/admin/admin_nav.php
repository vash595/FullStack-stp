<?php
function render_navbar() {
    echo '  
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="adduser.php">Add New User</a></li>
              <li><a href="viewuser.php">View All Users</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Products <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="addproduct.php">Add New Product</a></li>
              <li><a href="viewproduct.php">View All Products</a></li>
            </ul>
          </li>
          <li><a href="adminvieworder.php">Orders</a></li>
          
        </ul>
      </div>
    </nav>';
}
