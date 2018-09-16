<?php 
    include('autoloader.php');

    session_start();
    if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){
        $user = new User();
        //only an admin and staff can use this page
        $isNormalUser = $user -> isNormalUser($_SESSION['group_id']);
        if($isNormalUser == false){
            
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
                    $size = $_POST['size'];
                    echo $name;
                    echo $description;
                    echo $category_id;
                    echo $unit_id;
                    echo $price;
                    print_r($photo_array);
                    echo $size;
                    $success = $product -> addProduct($name, $description, $category_id, $unit_id, $price, $size, $photo_array);
                    if($success == true){
                        $message = 'Product added with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$product -> errors);
                        $message_class = 'warning';
                    }
                }
            }
            
            $categories = $product -> getCategories();
            $units = $product -> getUnits();
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
        <form name="productadd-form" enctype="multipart/form-data" id="productadd-form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div class="row">
                <div class="col-md-6">
                   <input class="form-control" type="text" name="name" id="name" placeholder="Name" />
                   <input class="form-control" type="text" name="price" id="price" placeholder="Price"/>
                   <input class="form-control" type="text" name="description" id="description" placeholder="Description"/> 
                   <input class="form-control" type="text" name="size" id="size" placeholder="Size: e.g. XXL"/>
                   <?php 
                    if(count($categories)>0) {
                        echo "<select class=\"form-control custom-select\" name=\"category_id\" id=\"category_id\">
								<option value=\"\">Select a category</option>";
								foreach($categories as $item){
                                    $category_id = $item['category_id'];
                                    $category = $item['category'];
                                    echo "<option value=\"$category_id\">$category</option>";
                                }
                        echo"</select>";
                    }
                   ?>
                   <?php 
                    if(count($units)>0) {
                        echo "<select class=\"form-control custom-select\" name=\"unit_id\" id=\"unit_id\">
								<option value=\"\">Select a unit</option>";
								foreach($units as $item){
                                    $unit_id = $item['unit_id'];
                                    $unit = $item['unit'];
                                    echo "<option value=\"$unit_id\">$unit</option>";
                                }
                        echo"</select>";
                    }
                   ?>
                </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                    <input class="form-control" type="file" name="photo" id="photo"/>
                </div>
            </div>
            <button class="btn btn-info mt-2" type="submit" name="action" id="action" value="add">Add new Product</button>
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