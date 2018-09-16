<?php 
    include('autoloader.php');

    session_start();
    if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){
        $user = new User();
        //only an admin and staff can use this page
        $isNormalUser = $user -> isNormalUser($_SESSION['group_id']);
        if($isNormalUser == false){
            
            //receive get requests for produc_id
            $product_id = $_GET['product_id'];
            $product = new Product();
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
                //what was the user action?
                $action = $_POST['action'];
                
                if(strcmp($action,'add') ==0){
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $category_id = $_POST['category_id'];
                    $unit_id = $_POST['unit_id'];
                    $price = $_POST['price'];
                    $photo_array = $_FILES['photo'];
                    $success = $product -> addProduct($name, $description, $category_id, $unit_id, $price, $photo_array);
                    if($success == true){
                        $message = 'Product added with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'delete') ==0){
                    $success = $product -> deleteProduct($product_id);
                    if($success == true){
                        $message = 'Product deleted with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'delete_photo') ==0){
                    $photo_id = $_POST['photo_id'];
                    $photo_name = $_POST['photo_name'];
                    $success = $product -> deleteProductPhoto($photo_id,$photo_name);
                    if($success == true){
                        $message = 'Product photo deleted with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'default_photo') ==0){
                    $photo_id = $_POST['photo_id'];
                    $success = $product -> setDefaultPhoto($photo_id, $product_id);
                    if($success == true){
                        $message = 'Photo set as default with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'add_photo') ==0){
                    $photo_array = $_FILES['photo'];
                    print_r($photo_array);
                    echo $photo_array;
                    $success = $product -> addProductPhoto($photo_array, $product_id);
                    if($success == true){
                        $message = 'Product photo deleted with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'delete_size') ==0){
                    $size = $_POST['size'];
                    $success = $product -> deleteProductSize($product_id, $size);
                    if($success == true){
                        $message = 'Product size deleted with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'add_size') ==0){
                    $size = $_POST['add_size'];
                    $success = $product -> addProductSize($product_id, $size);
                    if($success == true){
                        $message = 'Product size added with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
                if(strcmp($action,'update') ==0){
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $category_id = $_POST['category_id'];
                    $unit_id = $_POST['unit_id'];
                    $price = $_POST['price'];
                    $success = $product -> updateProduct($name, $description, $category_id, $unit_id, $price, $product_id);
                    if($success == true){
                        $message = 'Product updated with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
            }
            
            $productDetail = $product -> getProductDetail($product_id);
            $productPhoto = $product -> getPhotosByProductId($product_id);
            $productSize = $product -> getSizeByProductId($product_id);
            
        //not an admin
        } else{
            header("location: index.php");
        }
    //no session    
    } else{
        header("location: index.php");
    }
?>
<!doctype html>
<html>
    <?php include('includes/head.php') ?>
<body class="pt-5">
    <?php include('includes/navbar.php') ?>
    <div class="container-fluid">
        <form name="productedit-form" enctype="multipart/form-data" id="productedit-form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?product_id=";echo $product_id;?>">
            <div class="row">
                <div class="col-md-6">
                   <input class="form-control" type="text" name="name" id="name" value="<?php echo $productDetail[0]['name'] ?>"/>
                   <input class="form-control" type="text" name="price" id="price" value="<?php echo $productDetail[0]['price'] ?>"/>
                   <input class="form-control" type="text" name="description" id="description" value="<?php echo $productDetail[0]['description'] ?>"/>
                   <input class="form-control" type="text" name="category" id="category" value="<?php echo $productDetail[0]['category'] ?>" disabled/>
                   <input class="form-control" type="hidden" name="category_id" id="category_id" value="<?php echo $productDetail[0]['category_id'] ?>"/>
                   <input class="form-control" type="text" name="unit" id="unit" value="<?php echo $productDetail[0]['unit'] ?>" disabled/>
                   <input class="form-control" type="hidden" name="unit_id" id="unit_id" value="<?php echo $productDetail[0]['unit_id'] ?>"/>
                </div>
            </div>
            <button class="btn btn-info mt-2" type="submit" name="action" id="action" value="update">Update</button>
            <button class="btn btn-info mt-2" type="submit" name="action" id="action" value="delete">Delete</button>
            <div class="row">
               <div class="col-md-6">
                   <?php 
                    foreach($productPhoto as $item ){
                        $img = '/images/product/'.$productDetail[0]['category'].'/'.$item['photo'];
                        $photo_id = $item['photo_id'];
                        $photo_name = $item['photo'];
                        echo "<img class=\"img-fluid\" src=\"$img\">";
                        echo "<input class=\"form-control\" type=\"hidden\" name=\"photo_id\" id=\"photo_id\" value=\"$photo_id\"/>
                              <input class=\"form-control\" type=\"hidden\" name=\"photo_name\" id=\"photo_name\" value=\"$photo_name\"/>
                                <button class=\"btn btn-info mt-2\" type=\"submit\" 
                                    name=\"action\" id=\"action\" value=\"delete_photo\">Delete Photo
                               </button>
                               <button class=\"btn btn-info mt-2\" type=\"submit\" 
                                    name=\"action\" id=\"action\" value=\"default_photo\">Set Default
                               </button>";
                    }
                   ?>
                </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                    <label for="photo" class="btn btn-primary">Add new photo</label>
                    <input class="form-control" type="file" name="photo" id="photo" style="display:none;"/>
                    <button class="btn btn-info mt-2" type="submit" name="action" id="action" value="add_photo">Upload Photo</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                   <?php 
                    if(count($productSize)>0) {
                        echo "<h2> Available Sizes: </h2>";
                        foreach($productSize as $item){
                            $size = $item['size'];
                            echo "<p>$size 
                                    <input class=\"form-control\" type=\"hidden\" name=\"size\" id=\"size\" value=\"$size\"/>
                                    <button class=\"btn btn-info mt-2\" type=\"submit\" 
                                        name=\"action\" id=\"action\" value=\"delete_size\">Delete size
                                    </button>
                                  </p>";
                        }
                    }
                   ?>
                </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                    <input class="form-control" type="text" name="add_size" id="add_size" placeholder="e.g. XXL"/>
                    <button class="btn btn-info mt-2" type="submit" name="action" id="action" value="add_size">Add Size</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-6">
                   <?php
                    if(strlen($message) > 0){
                        echo "<div class=\"alert alert-$message_class alert-dismissable fade show\">
                            $message
                            <button class=\" close\" type=\"button\" data-dismiss=\"alert\">
                            &times;
                            </button>
                        </div>";
                    }
                    ?>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php include('includes/footer.php')?>
</footer>
</html>