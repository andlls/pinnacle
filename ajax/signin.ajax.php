<?php 
//include autoloader
session_start();

include('../autoloader.php');

//check request method
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    $response = array();
    //check the POST variables
    if( $_POST['email'] == '' || $_POST['password'] == ''){
        $response['error'] = 'one of the fields is empty';
        $response['success'] = false;
        echo json_encode($response);
    } else {
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $user = new User();
        $auth = $user -> authenticate($email, $password);
        if($auth == true){
            //sucessufull
            $response['success'] = true;
            $group_id = $user -> getGroupIdByEmail($email);
            if($group_id != -1) {
                $_SESSION['group_id'] = $group_id;
                $_SESSION['email'] = $email;
            }
        } else {
            $response['error'] = 'wrong credentials supplied';
            $response['success'] = false;
        }
        echo json_encode($response);
    }
}
?>