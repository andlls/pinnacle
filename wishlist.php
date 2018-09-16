<?php
//include autoloader
include('autoloader.php');

$page_title = 'Wishlist';

session_start();

if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){    
    
    $wishlist = new Wishlist();
    $user = new User();
    $email = $_SESSION['email'];
    $group_id = $_SESSION['group_id'];
    
    //request to add/update new wishlit
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $user_id = $user->getUserIdByEmail($email);
        $wishlist_user_id = $_POST['wishlist_user_id'];
        
        //if is admin we let delete without verification
        if(strcmp($user_id,$wishlist_user_id) == 0 || $user->isAdmin($group_id) == true) {
            
            $delete = $_POST['delete'];
           //not a delete request
            if( strlen($delete) <= 0){
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $wishlist->addOrUpdateWishlist($wishlist_user_id, $product_id, $quantity);
            } else {
                //deleting
                $wishlist_id = $_POST['wishlist_id'];
                $result = $wishlist->deleteWishlist($wishlist_id, $wishlist_user_id);
                if(!$result){
                    $message = implode(' ',$wishlist -> errors);
                    $message_class = 'warning';
                }
            }
        } else{
            $message = 'User does not have rights to alter wishlist';
            $message_class = 'warning';
        }
    }

    if($user->isNormalUser($group_id) == true){
        $wishlists = $wishlist -> getWishlistsByUserEmail($email);
    } else {
        $wishlists = $wishlist -> getWishlists();
    }
//no session cannot see content
} else {
    header("location: signin.php");
}

?>
<!doctype html>
<html>
   <?php include('includes/head.php')?>
    <body style="padding-top:64px;">
        <!-- navbar -->
        <?php include('includes/navbar.php')?>
        <div class="container">
            
            <?php
                if(count($wishlists) > 0){
                    include('includes/wishlist.list.php');
                } else {
                    echo "<div class=\"row\">
                            <div class=\"col-md-3\"> 
                                <h4>No wishlist found!</h4>
                            </div>
                        </div>";
                }
            ?>
            <?php
                if(strlen($message) > 0){
                    echo "<div class= \"alert alert-$message_class alert-dismissable fade show\">
                        $message
                        <button class=\" close\" type=\"button\" data-dismiss=\"alert\">
                        &times;
                        </button>
                    </div>";
                }
            ?>
        </div>
    </body>
    <footer>
    <?php include('includes/footer.php')?>
</footer>
</html>