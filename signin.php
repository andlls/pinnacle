<?php
//include autoloader
include('autoloader.php');

$page_title = 'Sign In';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $user = new User();
    $success = $user -> authenticate($email, $password);
    if ($success == true){
        $success = $user->updateUserLastLogin($email);
        if($success == true){
            //sign successful
            session_start();
            $group_id = $user -> getGroupIdByEmail($email);
            if($group_id != -1) {
                $_SESSION['group_id'] = $group_id;
                $_SESSION['email'] = $email;
            }
            //redirect user to homepage
            header("location: index.php");
        } else{
             $message = implode(' ',$user -> errors);
              $message_class = 'warning';
        }
    }
    else{
         $message = implode(' ',$user -> errors);
        $message_class = 'warning';
    }
}

?>
<!doctype html>
<html>
   <?php include('includes/head.php')?>
    <body style="padding-top:64px;">
        <!-- navbar -->
        <?php include('includes/navbar.php')?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 mt-5">
                    <form name="signin-form" id="signin-form" method="post" action="signin.php">
                        <h3>Sign in to your user</h3>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="you@example.com"/>
                        </div>
                        <div class="form-group">
                            <label for ="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Your password"/>
                            
                        </div>
                        
                        <button class="btn btn-warning mt-2" type="reset">Clear</button>
                        <button name="btn-signin" class="btn btn-info mt-2"  type="submit">Sign In</button>
                    </form>
                    
                    <?php
                    if($message){
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
            <div class="row md-4 offset-md-4 mt-5 mb-5"> 
                <div class=\"col-md-3\"> 
                     <h6>Still don't have an account?</h6>
                    <a href=\signup.php>Register now!</a>
                </div>
            </div>
        </div>
        <script src="js/signin.js"></script>
    </body>
    <footer>
    <div class = "fixed-bottom">
        <?php include('includes/footer.php')?>
    </div>
    
</footer>
</html>