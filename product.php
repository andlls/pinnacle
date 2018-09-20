<?php
//include autoloader
include('autoloader.php');

$page_title = 'Products';

//check the user which is logged 
$isNormalUser = true;
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){
    $user = new User();
    //only an admin and staff can use this page
    $isNormalUser = $user -> isNormalUser($_SESSION['group_id']);
}
//searchbar sent a request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $product = new Product();
    $categories = $product -> getCategories();
    $units = $product -> getUnits();
    
    $category_id = $_POST['category'];
    $product_name = $_POST['product_name'];
    $unit_id = $_POST['unit'];
    $max_price = $_POST['max_price'];
    $min_price = $_POST['min_price'];
    
    $products = $product -> getProductsbyFilter($category_id, $product_name, $unit_id, $min_price,$max_price);
}

?>
<!doctype html>
<html>
   <?php include('includes/head.php')?>
    <body style="padding-top:64px;">
        <!-- navbar -->
        <?php include('includes/navbar.php')?>
        <div class="container mt-4 mb-4">
            <?php if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
                    include('includes/searchbar.php'); 
            }?>
            <div class="row">
                <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(count($products) > 0){
                        include('includes/product.list.php');
                    } else {
                        echo "<div class=\"col-md-3\"> 
                                <h4>No products found!</h4>
                            </div>";
                    }
                } else {
                    include('includes/product.category.php');
                }
                ?>
            </div>
        </div>
    </body>
    <footer>
    <div class = "sticky-bottom">
        <?php include('includes/footer.php')?>
    </div>
    
</footer>
</html>