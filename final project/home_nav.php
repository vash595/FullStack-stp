<?php
function render_home_nav() {
    echo '  
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#" style="border-right:1px solid #ccc; padding-right:20px;">Get Floword</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="#">Home</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Occasion <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Anniversary</a></li>
              <li><a href="#">Birthday</a></li>
            </ul>
          </li>
          <li><a href="#">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Account <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Login</a></li>
              <li><a href="#">Register</a></li>
              <li><a href="#">View Order</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Log Out</a></li>
            </ul>
          </li>
          <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
        </ul>
      </div>
    </nav>';
}
