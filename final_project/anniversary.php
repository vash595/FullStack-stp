<?php
session_start();
include 'home_nav.php';
include 'footer.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Anniversary Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      .box {
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        border-radius: 10px;
        background: #fff;
        margin: 15px 0;
        padding: 16px;
        transition: box-shadow 0.2s;
        border: 1px solid #eee;
        min-height: 350px;
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      .box:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,0.15);
      }
      .product-img {
        max-width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
      }
    </style>
    <script>
    function SearchAnniversary() {
        var searchTerm = document.getElementById("anniversarySearch").value;
        var obj = new XMLHttpRequest();
        obj.open("get", "search_anniversary.php?data=" + encodeURIComponent(searchTerm), true);
        obj.send();
        obj.onreadystatechange = function() {
            if (obj.status == 200 && obj.readyState == 4) {
                document.getElementById("anniversaryProductGrid").innerHTML = obj.responseText;
            }
        };
    }

    window.onload = function() {
        SearchAnniversary();
    };
    </script>
</head>
<body>
    <?php render_home_nav(); ?>

    <div class="container-fluid">
        <h1 class="text-center" style="margin-top: 30px; margin-bottom: 30px;">Anniversary Collection</h1>

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <input id="anniversarySearch" type="text" placeholder="Search Anniversary Products" class="form-control" onkeyup="SearchAnniversary()"/>
            </div>
            <div class="col-sm-4"></div>
        </div>

        <div class="row product-grid" id="anniversaryProductGrid">
        </div>
    </div>

    <?php render_footer(); ?>
</body>
</html>