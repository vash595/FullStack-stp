<?php
include 'home_nav.php';
?>
<?php
include 'footer.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      
    </style>
  </head>
  <body>
    <?php render_home_nav(); ?>
    
    <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
      <div class="banner-image text-center">
        
        <img src="banner1.jpg" alt="Banner" class="img-responsive center-block" style="width:100%; max-height:300px; object-fit:cover; border-radius:8px;" />
      </div>
    </div>
    
 
    <div class="container">
      <div class="row">
        
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-body text-center">
              <img src="rose.jpg" alt="Flower 1" class="img-responsive center-block" style="width:100%; max-height:500px; object-fit:cover; border-radius:8px; margin-bottom:15px;" />
              <p>Beautiful roses, perfect for expressing love and admiration. Freshly picked and elegantly arranged.</p>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-body text-center">
              <img src="lilies.jpg" alt="Flower 2" class="img-responsive center-block" style="width:100%; max-height:400px; object-fit:cover; border-radius:8px; margin-bottom:15px;" />
              <p>Charming lilies that symbolize purity and refined beauty. Ideal for any special occasion or celebration.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php render_footer(); ?>


  
  
  </body>
</html>