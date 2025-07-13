<?php
function render_navbar() {
    echo '  
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="#">Dashboard</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Add New User</a></li>
              <li><a href="#">View All Users</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Products <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Add New Product</a></li>
              <li><a href="#">View All Products</a></li>
            </ul>
          </li>
          <li><a href="#">Orders</a></li>
          <li><a href="#">Legends</a></li>
        </ul>
      </div>
    </nav>';
}
