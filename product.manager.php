<?php
//include autoloader
include('autoloader.php');

$page_title = 'Product Manager';
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){

    $user = new User();
    
    //only an admin and staff can use this page
    $isNormalUser = $user -> isNormalUser($_SESSION['group_id']);
    if(!$isNormalUser) {
        
        $product = new Product();
        $categories = $product -> getCategories();
        $units = $product -> getUnits();
        //searchbar sent a request
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if(strcmp($_POST['action'],'delete')==0){
                $product_id = $_POST['product_id'];
                $success = $product->deleteProduct($product_id);
                if($success == true) {
                    //delete wishlist
                    $wishlist = new Wishlist();
                    $success = $wishlist -> deleteWishlistByProductId($product_id);
                    //check the error code 
                    if ($success == false ){
                        $this-> errors['database'] = self::$DATABASE_ERROR;
                    } else {
                        $message = 'Product delete with success!';
                        $message_class = 'success';
                    }
                } else {
                    $message = implode(' ',$product -> errors);
                    $message_class = 'warning';
                }
            } else {
                $category_id = $_POST['category'];
                $product_name = $_POST['product_name'];
                $unit_id = $_POST['unit'];
                $max_price = $_POST['max_price'];
                $min_price = $_POST['min_price'];
                
                $products = $product -> getProductsbyFilter($category_id, $product_name, $unit_id, $min_price,$max_price);
            }
        } else {
            $products = $product -> getAllProducts();
        }
    //not an admin
    } else {
        header("location: index.php");
    }
//no session
} else{
    header("location: index.php");
} 
?>
<!doctype html>
<html>
   <?php include('includes/head.php')?>
    <body style="padding-top:64px;">
        <!-- navbar -->
        <?php include('includes/navbar.php')?>
        <div class="container">
            <?php include('includes/searchbar.php'); 
                if(strlen($message) > 0){
    				 echo "<div class=\"row\">
    				            <div class=\"col-md-4 offset-md-4\">
    								<div class=\"alert alert-$message_class alert-dismissable fade show\">
    											$message
    							    	<button class=\" close\" type=\"button\" data-dismiss=\"alert\">
    										&times;
    									</button>
    								</div>
    							</div>
    					   </div>";
    			}
			?>
			<div class="row">
                <a href="add.product.php">Add new Product</a>
            </div>
            <div class="row">
                <?php
                    if(count($products) > 0){
                        include('includes/product.manager.list.php');
                    } else {
                        echo "<div class=\"col-md-4\"> 
                                <h4>No products found!</h4>
                            </div>";
                    }
                ?>
            </div>
        </div>
    </body>
    <footer>
    <?php include('includes/footer.php')?>
</footer>
</html>