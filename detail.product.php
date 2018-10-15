<?php 
    include('autoloader.php');

    //receive get requests for produc_id
    $product_id = $_GET['product_id'];
    //print the requested id
    //echo "you requested a product with id=$productID";
    $product = new Product();
    $productDetail = $product -> getProductDetail($product_id);
    $productSize = $product -> getSizeByProductId($product_id);
    $productPhoto = $product -> getPhotosByProductId($product_id);
?>
<!doctype html>
<html>
    <?php include('includes/head.php') ?>
<body class="pt-5">
    <?php include('includes/navbar.php') ?>
    <div class="container-fluid">
        <form name="productdetail-form" id="productdetail-form" method="post" action="wishlist.php">
        <div class="row">
           <div class="row-md-3 mt-5 ml-5" style="width: 320px;">
               <?php 
                foreach($productPhoto as $item ){
                    $img = '/images/product/'.$productDetail[0]['category'].'/'.$item['photo'];
                    echo "<img class=\"img-fluid\" src=\"$img \">";
                }
               ?>
            </div>
            <div class="col-md-6 mt-5 ml-5">
               <h2>Name: <?php echo $productDetail[0]['name']; ?></h2>
               <h5 class="price">Price: <?php echo $productDetail[0]['price']; ?></h5>
               <p>Description: <?php echo $productDetail[0]['description']; ?></p>
            </div>
            <div class="col-md-6 mt-2 ml-5">
               <?php 
                if(count($productSize)>0) {
                    echo "<h2> Available Sizes: </h2>";
                    foreach($productSize as $item){
                        $size = $item['size'];
                        echo "<p> $size</p>";
                        
                    }
                }
               ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5 ml-5">
               <div class="form-group">
                   <label for="quantity">Quantity:</label>
                   <input class="form-control" type="text" name="quantity" id="quantity" placeholder="e.g. 2"/>
                   <input class="form-control" type="hidden" name="product_id" id="product_id" value="<?php echo $product_id?>"/>
               </div>
               <button value="add" id="action" name="action"  class="btn btn-info mt-2" type="submit">Add to shopping list </button>
            </div>
        </div>
        </form>
    </div>
</body>
<footer>
    <?php include('includes/footer.php')?>
</footer>
</html>