<?php
    //include autoloader
    include('autoloader.php');
    
    $page_title = 'My Account';
    session_start();
    
    if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){
    
        $user = new User();
        $current_user = $user -> getUserByEmail($_SESSION['email']);
        if(count($current_user) > 0){
            $c_name = $current_user['name'];
            $c_surname = $current_user['surname'];
            $c_email = $current_user['email'];
            $c_last_login = $current_user['last_login'];
            $c_group = $current_user['group_name'];
        } else{
            //user does not exist
            header("location: index.php");
        }
        
        //if request is a POST request
        if($_SERVER['REQUEST_METHOD']=='POST') {
            
            //get from the session
            $email = $_SESSION['email'];
            //this is a post request
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            
            //validate user before changing the password
            $success = $user -> authenticate($email, $old_password);
            if($success == true) {
                //change password
                $success = $user -> updateUserPassword($email, $new_password);
                if($success == true) {
                    //show success message
                    $message = 'Password changed with success!';
                    $message_class = 'success';
                } else {
                    $message = implode(' ',$user -> errors);
                    $message_class = 'warning';
                }
            } else {
                $message = implode(' ',$user -> errors);
                $message_class = 'warning';
            }
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
            <div class="row">
                <div class="col-md-4 offset-md-4 mt-4 mb-4">
                    <form id="user-form" method="post" action="user.php">
                        <h3>Account details</h3>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="<?php echo $c_name ?>" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname:</label>
                            <input class="form-control" type="text" name="surname" id="surname" placeholder="<?php echo $c_surname ?>" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="<?php echo $c_email ?>" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label for="last_login">Last Login:</label>
                            <input class="form-control" type="text" name="last_login" id="last_login" placeholder="<?php echo $c_last_login ?>" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label for="group">Group:</label>
                            <input class="form-control" type="text" name="group" id="group" placeholder="<?php echo $c_group ?>" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label for ="old_password">Old Password</label>
                            <input class="form-control" type="password" name="old_password" id="old_password" placeholder="******"/>
                        </div>
                        <div class="form-group">
                            <label for ="new_password">New Password</label>
                            <input class="form-control" type="password" name="new_password" id="new_password" placeholder="minimum 6 characters"/>
                        </div>
                        <button class="btn btn-info mt-2 mb-4 " type="submit">Change Password</button>
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
    </body>
    <footer>
    <?php include('includes/footer.php')?>
</footer>
</html>