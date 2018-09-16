<?php
//include autoloader
include('autoloader.php');
$page_title = 'Home Page';

?>
<!doctype html>
<html>
    <!-- head -->
    <head>
        <title> Pinnacle Health and Fitness</title>
        <link rel='stylesheet' href='css/style.css'>
        <link rel="icon" href="/images/website/Single Logo.PNG">
    </head>
   <?php include('includes/head.php')?>
    <body style="padding-top:64px;">
        <!-- navbar -->
        <?php include('includes/navbar.php')?>
        
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
        <a href = "/product.php">
      <img class="d-block w-90" src="/images/website/productsBanner.PNG" alt="First slide">
      </a>
    </div>
    <div class="carousel-item">
        <a href = "/signup.php">
      <img class="d-block w-90" src="/images/website/SignUpBanner.PNG" alt="Second slide">
      </a>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

      
                
                
                
  </body>
     <!-- footer -->
        <?php include('includes/footer.php')?>
</html>