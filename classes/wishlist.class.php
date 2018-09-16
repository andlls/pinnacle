<?php
class Wishlist extends Database{
    
    //attributes used on sql queries
    static private $numberWildCard = -1;
    static private $stringWildCard = '%';
    
    public $errors = array();
    static private $ERROR_CODE = -1;
    static private $DATABASE_ERROR = 'Database: database connection problem';
    static private $VALIDATION_ERROR = 'Validation: validation error';
        
    public function __construct(){
        parent::__construct();
    }
    
    public function updateWishlistDetails($wishlist_id, $quantity){
        
        $query = "update wishlist w set w.quantity = ?
                    where w.wishlist_id = ?";
        
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('ii', $quantity, $wishlist_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function deleteWishlist($wishlist_id, $user_id){
        
        $query = "DELETE FROM `wishlist` 
                    WHERE wishlist_id = ? and user_id = ?";
                   
        $statement = $this->connection->prepare($query); 
        $statement -> bind_param('ii', $wishlist_id, $user_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function deleteWishlistByProductId($product_id){
        
        $query = "DELETE FROM `wishlist` 
                    WHERE product_id = ?";
                   
        $statement = $this->connection->prepare($query); 
        $statement -> bind_param('i', $product_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function getWishlistId($user_id, $product_id){
        $query = "select wishlist_id from wishlist
                    where user_id = ?
                    and product_id = ?";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('ii',$user_id, $product_id);
        $statement -> execute();
        
        $result = $statement->get_result();
        if($result -> num_rows == 0){
            //we dont wishlist
            return self::$ERROR_CODE;
        } else {
            $wishlist = $result -> fetch_assoc();
            $wishlist_id = $wishlist['wishlist_id'];
            return $wishlist_id;
        }
    }
    
    public function addOrUpdateWishlist($user_id, $product_id, $quantity){
        
        if($quantity <= 0) {
            return false;
        }
        //does it exists?
        $wishlist_id = $this->getWishlistId($user_id, $product_id);
        if($wishlist_id > 0){
            $query = "update wishlist set quantity = ? where wishlist_id = ?";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('ii', $quantity, $wishlist_id);
        //no it does not    
        } else {
            $query = "INSERT INTO `wishlist`(`user_id`, `product_id`, `quantity`) 
                      VALUES (?,?,?)";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('iii', $user_id, $product_id, $quantity);
        }
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function getWishlistsByUserEmail($email){
        $wishlist = array();
        $query = "select w.wishlist_id, w.quantity, w.user_id, u.email, 
                    p.product_id, p.name, p.description, p.price, 
                    un.description unit, c.description category
                    from wishlist w
                    join `user` u on u.user_id = w.user_id
                    join `product` p on p.product_id = w.product_id
                    join `unit` un on p.unit_id = un.unit_id
                    join `category` c on c.category_id = p.category_id
                    where u.email = ?
                    order by p.name ";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('s', $email);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($wishlist, $row);
        }
        return $wishlist;
    }
    
     public function getWishlists(){
        
        $wishlist = array();
        $query = "select w.wishlist_id, w.quantity, w.user_id, u.email, 
                    p.product_id, p.name, p.description, p.price, 
                    un.description unit, c.description category
                    from wishlist w
                    join `user` u on u.user_id = w.user_id
                    join `product` p on p.product_id = w.product_id
                    join `unit` un on p.unit_id = un.unit_id
                    join `category` c on c.category_id = p.category_id
                    order by u.email, p.name ";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($wishlist, $row);
        }
        return $wishlist;
    }
}
?>