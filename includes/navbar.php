<?php 
session_start();

if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){
    
    $user = new User();
    
    $navs = array('Home' => 'index.php',
                  'My Account' => 'user.php',
                  'Sign out' => 'signout.php',
                  'Products' => 'product.php',
                  'Shopping List' => 'wishlist.php');
     
    //staff && admin
    if ($user->isNormalUser($_SESSION['group_id'])==false){
        $navs['Manage Products'] = 'product.manager.php';
    }
    //admin
    if($user->isAdmin($_SESSION['group_id'])){
        $navs['Manage Users'] = 'user.manager.php';
    }
} else{
    $navs = array('Home' => 'index.php',
                  'Sign Up' => 'signup.php',
                  'Sign In' => 'signin.php',
                  'Products' => 'product.php');
}

?>


<nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-lg">
        <div class = "navbarImg">
            <a href = "index.php"><img src = "/images/website/Single Logo.PNG">
            </a>
            
        </div>
        
        </div>
            <a href="/" class="navbar-brand"> Pinnacle Health and Fitness </a>
            <button class="navbar-toggler order-sm-5" type ="button" data-toggle="collapse" data-target="#main-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="main-menu">
            
                <ul class="navbar-nav ">
                    <?php
                        foreach($navs as $key => $value){
                            echo "<li class=\"nav-item\">
                                <a href=\"$value\" class=\"nav-link\">$key</a>
                            </li>";
                        }
                    ?>
                </ul>
            <form class="form-inline ml-auto" method="post" action="product.php">
                <input type="text" class="form-control" placeholder="Product Search" id="product_name" name="product_name">
                <button button name="btn-search" type="submit" class="btn btn-primary ml-2">Search</button>
            </form>
            </div>
        </nav>