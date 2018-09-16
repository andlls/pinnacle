<?php 
class User extends Database{
    
    public $errors = array();
    static private $DATABASE_ERROR = 'Database: database connection problem';
    static private $VALIDATION_ERROR = 'Validation: validation error';
    static private $ERROR_CODE = -1;
    
    //attributes used just to pass through validation
    static private $wildCardName = 'Name';
    static private $wildCardSurname = 'Surname';
    static private $wildCardEmail = 'Email@email.com';
    static private $wildCardPassword = 'Password';
    static private $wildCardGroupId = 1;
    
    public function __construct(){
        parent::__construct();
    }
    
    public function validateFields($name, $surname, $email, $password, $group_id, $newUser) {
        //validate email
        if(filter_var($email,FILTER_VALIDATE_EMAIL) == false){
            $this-> errors['email']='Email: invalid email address';
        } else if($newUser == true) {
            //check if already exist
            $query = "SELECT email FROM user WHERE email = ?";
            
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('s', $email);
            $success = $statement -> execute() ? true : false;
            
            if ($success == false) {
                $this-> errors['database'] = self::$DATABASE_ERROR;
            } else  {
                $result = $statement -> get_result();
                if($result -> num_rows > 0) {
                    //email exist
                    $this-> errors['email'] = 'Email: email address already used';
                }
            }
        }
        //check password length
        if(strlen($password)<6){
            $this-> errors['password'] = 'Password: minimum 6 characters ';
        }
        //check $name, $surname and $group_id length
        if(strlen($name) == 0){
            $this-> errors['name'] = 'Name: name empty '.$name;
        }
        if(strlen($surname) == 0){
            $this-> errors['surname'] = 'Surname: surname empty '.$surname;
        }
        if($group_id <= 0 || $group_id == null){
            $this-> errors['group_id'] = 'Group: wrong group_id '.$group_id;
        }
        
        //do we have errors?
        if(count($this-> errors)==0){
            return true;
        } else {
            return false;
        }
    }
    
    public function addUser($name, $surname, $email, $password, $group_id){
        
        //check if there are no errors
        $validation = $this->validateFields($name, $surname, $email, $password, $group_id, true);
        if($validation == true) {
            //proceed and create account
            $query = "INSERT INTO user (name, surname, email, password, last_login, group_id)
            VALUES (?,?,?,?,NOW(),?)";
            
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('ssssi', $name, $surname, $email, $hash, $group_id);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
            return $success;
        }
        else {
            $this-> errors['validation'] = self::$VALIDATION_ERROR;
            return false;
        }
    }
    
    public function deleteUserbyUserId($user_id){
        
        //delete user
        $query = "DELETE FROM `pinnacle`.`user` WHERE `user`.`user_id` = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('i', $user_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function deleteUserbyEmail($email){
        
        //delete user
        $query = "DELETE FROM `pinnacle`.`user` WHERE `user`.`email` = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $email);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function updateUser($name, $surname, $email, $password, $group_id, $user_id){
        
        //check if there are no errors
        $validation = $this->validateFields($name, $surname, $email, $password, $group_id, false);
        if($validation == true) {
            //proceed and create account
            $query = "UPDATE `user` SET `name`= ?,`surname`= ?,
                    `email`= ?,`password`=?,`group_id`=? 
                    WHERE `user_id` = ?";
            
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('ssssii', $name, $surname, $email, $hash, $group_id, $user_id);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
            return $success;
        } else {
            $this-> errors['validation'] = self::$VALIDATION_ERROR;
            return false;
        }
    }
        
     public function updateUserLastLogin($email){
        
        //check if there are no errors
        $validation = $this->validateFields(self::$wildCardName, self::$wildCardSurname, $email,
        self::$wildCardPassword, self::$wildCardGroupId, false);
        if($validation == true) {
            //updating last login with current time
            $query = "UPDATE user SET last_login = NOW() WHERE email = ?";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('s', $email);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
            return $success;
        } else {
            $this-> errors['validation'] = self::$VALIDATION_ERROR;
            return false;
        }
    }
    
     public function updateUserPassword($email, $password){
        
        //check if there are no errors
        $validation = $this->validateFields(self::$wildCardName, self::$wildCardSurname, $email,
        $password, self::$wildCardGroupId, false);
        if($validation == true) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            //updating password
            $query = "UPDATE user SET password = ? WHERE email = ?";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('ss', $hash, $email);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
            return $success;
        } else {
            $this-> errors['validation'] = self::$VALIDATION_ERROR;
            return false;
        }
    }
    
    public function updateUserDetails($email, $name, $surname, $group_id){
        //check if there are no errors
        $validation = $this->validateFields($name, $surname, $email,
        self::$wildCardPassword, $group_id, false);
        if($validation) {
            //updating password
            $query = "UPDATE `user` SET `name`=?,`surname`=?,`email`=?, `group_id`=? WHERE email = ?";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('sssis', $name, $surname, $email, $group_id, $email);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
            return $success;
        } else {
            $this-> errors['validation'] = self::$VALIDATION_ERROR;
            return false;
        }
    }
    
    public function updateUserGroup($group_id, $email){
        
        //check if there are no errors
        $validation = $this->validateFields(self::$wildCardName, self::$wildCardSurname, $email,
        self::$wildCardPassword, $group_id, false);
        if($validation) {
            //updating password
            $query = "UPDATE user SET group_id = ? WHERE email = ?";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('is', $group_id, $email);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
            return $success;
        } else {
            $this-> errors['validation'] = self::$VALIDATION_ERROR;
            return false;
        }
    }
        
    public function authenticate($email, $password){
        $query = 'SELECT email, password, group_id
        from user 
        WHERE email = ?';
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $email);
        $statement -> execute();
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            //user does not exist
            $this->errors['user'] = 'User: User do not exist';
            return false;
        } else {
            $user = $result -> fetch_assoc();
            $email = $user['email'];
            $hash = $user['password'];
            $group_id = $user['group_id'];
            $match = password_verify($password, $hash);
            if($match == true){
                //pasword is correct 
                return true;
            } else {
                //wrong password
                $this->errors['credential'] = 'Credential: Wrong credentials supplied';
                return false;
            }
        }
    }
    
    public function getGroupIdByEmail($email){
        $query = 'SELECT group_id
        from user
        WHERE email = ?';
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $email);
        $statement -> execute();
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            //user does not exist
            $this->errors['group_id'] = 'Group: Group does not exist';
            return self::$ERROR_CODE;
        } else {
            $user = $result -> fetch_assoc();
            $group_id = $user['group_id'];
            return $group_id;
        }
    }
    
    public function getUserIdByEmail($email){
        $query = 'SELECT user_id
        from user
        WHERE email = ?';
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $email);
        $statement -> execute();
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            //user does not exist
            $this->errors['user_id'] = 'User: user_id does not exist';
            return self::$ERROR_CODE;
        } else {
            $user = $result -> fetch_assoc();
            $user_id = $user['user_id'];
            return $user_id;
        }
    }
    
    public function getUserByEmail($email){
        $query = 'SELECT u.user_id, u.name, u.surname, u.email, u.last_login, g.description as group_name
        from user u
        join `group` g on u.group_id = g.group_id
        WHERE email = ?';
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $email);
        $statement -> execute();
        $result = $statement -> get_result();
        $user = $result -> fetch_assoc();
        return $user;
    }
    
    public function getUsers(){
        $users = array();
        $query = 'SELECT u.user_id, u.name, u.surname, u.email, u.last_login, u.password, g.description as group_name
        from user u
        join `group` g on u.group_id = g.group_id
        order by u.name, u.surname, u.email';
        $statement = $this -> connection -> prepare($query);
        $statement -> execute();
        $result = $statement -> get_result();
        while($row = $result -> fetch_assoc()){
            array_push($users, $row);
        }
        return $users;
    }
    
    public function getGroups(){
        $groups = array();
        $query = "select group_id, description as group_name
                  from `group`
                  order by description";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($groups, $row);
        }
        return $groups;
    }
    
    public function isStaff($group_id){
        $groups = array();
        $query = "select group_id from `group` where group_id = ? and description = 'staff'";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $group_id);
        $statement -> execute();
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            return false;
        } else {
            return true;
        }
    }
    
    public function isAdmin($group_id){
        $query = "select group_id from `group` where group_id = ? and description = 'admin'";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $group_id);
        $statement -> execute();
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            return false;
        } else {
            return true;
        }
    }
    
    public function isNormalUser($group_id){
        $query = "select group_id from `group` where group_id = ? and description = 'user'";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('s', $group_id);
        $statement -> execute();
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            return false;
        } else {
            return true;
        }
    }
}
?>