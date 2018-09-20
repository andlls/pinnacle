<?php
    //include autoloader
    include('autoloader.php');
    
    $page_title = 'User Manager';
    session_start();
    
    if(isset($_SESSION['email']) && isset($_SESSION['group_id'])){
    
        $user = new User();
        
        //only an admin can use this page
        if($user -> isAdmin($_SESSION['group_id'])) {
            
            //if request is a POST request
            if($_SERVER['REQUEST_METHOD'] =='POST') {
                
                //update user details
                if(strcmp($_POST['action'],'update_details')==0) {
                    $email = $_POST['email'];
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $group_id = $_POST['group_id'];
                    echo 'groupdid:'.$group_id; 
                    echo 'name:'.$name; 
                    $success = $user -> updateUserDetails($email, $name, $surname, $group_id);
                    if($success == true) {
                       $message = 'User details updated with success!';
                       $message_class = 'success';
                    } else {
                        $message = implode(' ',$user -> errors);
                        $message_class = 'warning';
                    }
                }
                //update user password
                if(strcmp($_POST['action'],'update_password')==0) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $success = $user -> updateUserPassword($email, $password);
                    if($success == true) {
                        //show success message
                        $message = 'Password changed with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$user -> errors);
                        $message_class = 'warning';
                    }
                }
                //delete user
                if(strcmp($_POST['action'],'delete')==0) {
                    $email = $_POST['email'];
                    $success =$user->deleteUserbyEmail($email);
                    if($success == true) {
                        //show success message
                        $message = 'User deleted with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$user -> errors);
                        $message_class = 'warning';
                    }
                }
                //add user
                if(strcmp($_POST['action'],'add')==0) {
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $group_id = $_POST['group_id'];
                    $success =$user->addUser($name, $surname, $email, $password, $group_id);
                    if($success == true) {
                        //show success message
                        $message = 'User added with success!';
                        $message_class = 'success';
                    } else {
                        $message = implode(' ',$user -> errors);
                        $message_class = 'warning';
                    }
                }
            }
            $users = $user -> getUsers();
            $groups = $user -> getGroups();
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
   <?php include('includes/head.php')?>
    <body style="padding-top:64px;">
        <!-- navbar -->
        <?php include('includes/navbar.php')?>
        <div class="container-fluid row md-3 m-3">
            <?php include('includes/user.list.php')?>
        </div>
    </body>
    <footer>
    <div class = "fixed-bottom">
        <?php include('includes/footer.php')?>
    </div>
    
</footer>
</html>