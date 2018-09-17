<?php
    //include autoloader
    include('autoloader.php');
    
    $page_title = 'Sign Up';
    
    session_start();
    
//if user is not logged
if(!isset($_SESSION['email']) && !isset($_SESSION['group_id'])){    
     
    //check request method
    //if request is a POST request
    if($_SERVER['REQUEST_METHOD']=='POST'){
        //handle sign up here
        $user = new User();
        //receive post variables from form
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        //sign user up and create as a default user (last parameter 1)
        $signup = $user -> addUser($name, $surname, $email, $password, 1);
        if($signup == true){
            echo "signup";
            //signup succeded
            $group_id = $user -> getGroupIdByEmail($email);
            if($group_id != -1) {
                echo "group ok";
                //start the session
                session_start();
                 //create session variable with user's email
                $_SESSION['group_id'] = $group_id;
                $_SESSION['email'] = $email;
                 //show success message
                $message = 'Your account has been created!';
                $message_class = 'success';
            } else {
                $message = implode(' ',$user -> errors);
                $message_class = 'warning';
            }
        } else {
            //signup failed
            $message = implode(' ',$user -> errors);
            $message_class = 'warning';
            //get the errors and show to user
        }
    }
//no session cannot see content
} else {
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
            <div class="row">
                <div class="col-md-4 offset-md-4 mb-5">
                    <form id="signup-form" method="post" action="signup.php">
                        <h3>Sign up for an account</h3>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Barry"/>
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname:</label>
                            <input class="form-control" type="text" name="surname" id="surname" placeholder="Allen"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="you@example.com"/>
                        </div>
                        <div class="form-group">
                            <label for ="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="minimum 6 characters"/>
                        </div>
                        
                        <button class="btn btn-warning mt-2" type="reset">Clear</button>
                        <button class="btn btn-info mt-2" type="submit">Sign up</button>
                    </form>
                    
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
    </body
    <footer>
    <?php include('includes/footer.php')?>
</footer>
</html>