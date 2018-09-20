<?php
class Product extends Database{
    
    public $errors = array();
    static private $DATABASE_ERROR = 'Database: database connection problem';
    static private $VALIDATION_ERROR = 'Validation: validation error';
    static private $ERROR_CODE = -1;
    //attributes used on sql queries
    static private $numberWildCard = -1;
    static private $stringWildCard = '%';
    static private $wildCardSize = 1;
    static private $wildCardPhotoArray = array('name' => 10);
        
    public function __construct(){
        parent::__construct();
    }
    
    public function getUnits(){
        
        $units = array();
        $query = "select unit_id, description as unit
                  from unit
                  order by description";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement->get_result();
        
        while($row = $result -> fetch_assoc()){
            array_push($units, $row);
        }
        
        return $units;
    }
    
    public function getCategories(){
        
        $categories = array();
        $query = "select category_id, description as category, photo
                  from category
                  order by description";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement->get_result();
        
        while($row = $result -> fetch_assoc()){
            array_push($categories, $row);
        }
        
        return $categories;
    }
    
    public function getCategoryNameById($category_id){
        
        $categories = array();
        $query = "select description as category
                  from category
                  where category_id = ?";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('i', $category_id);
        $statement -> execute();
        
        $result = $statement->get_result();
         if($result -> num_rows == 0){
            //we dont have products
            return self::$ERROR_CODE;
        } else {
            $category = $result -> fetch_assoc();
            $name = $category['category'];
            return $name;
        }
    }
    
    public function getCategoryNameByProductId($product_id){
        
        $product = array();
        $query = "select c.description category
                  from product p
                  join category c on c.category_id = p.category_id
                  where p.product_id = ?";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('i', $product_id);
        $statement -> execute();
        
        $result = $statement->get_result();
        if($result -> num_rows == 0){
            //we dont have products
            return self::$ERROR_CODE;
        } else {
            $category = $result -> fetch_assoc();
            $name = $category['category'];
            return $name;
        }
    }
    public function getMaxPrice(){
        
        $query = "select max(price) max_price
                  from product";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            //we dont have products
            return self::$ERROR_CODE;
        } else {
            $product = $result -> fetch_assoc();
            $max_price = $product['max_price'];
            return $max_price;
        }
    }
    
    public function getMinPrice(){
        
        $query = "select min(price) min_price
                  from product";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            //we dont have products
            return self::$ERROR_CODE;
        } else {
            $product = $result -> fetch_assoc();
            $min_price = $product['min_price'];
            return $min_price;
        }
    }
    
    public function getProductIdByName($product_name){
        
        $query = "select product_id
                  from product where name = ?";
                    
        $statement = $this->connection->prepare($query);                    
        $statement -> bind_param('s', $product_name);
        $statement -> execute();
        
        $result = $statement -> get_result();
        if($result -> num_rows == 0){
            //we dont have products
            return self::$ERROR_CODE;
        } else {
            $product = $result -> fetch_assoc();
            $product_id = $product['product_id'];
            return $product_id;
        }
    }
    
    public function getPhotosByProductId($product_id){
        
        $photos = array();
        $query = "select photo_id, description photo
                  from photo
                  where product_id = ? 
                  order by default_photo desc";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('i', $product_id);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($photos, $row);
        }
        return $photos;
    }
    
    public function getSizeByProductId($product_id){
        
        $sizes = array();
        $query = "select description size
                  from size
                  where product_id = ? ";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('i', $product_id);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($sizes, $row);
        }
        return $sizes;
    }
    
    public function getProductDetail($product_id){
        
        $product = array();
        $query = "select p.product_id, p.name, p.description, p.price,
                    u.description unit, 
                    c.description category,
                    p.category_id, 
                    p.unit_id
                  from product p
                  join unit u on u.unit_id = p.unit_id
                  join category c on c.category_id = p.category_id
                  where p.product_id = ?";
                    
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('i', $product_id);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($product, $row);
        }
        return $product;
    }
    
    public function getProducts(){
        
        $products = array();
        $query = "select p.product_id, p.name, p.description, p.price,
                    u.description unit, 
                    c.description category,  
                    ph.description photo
                  from product p
                  join unit u on u.unit_id = p.unit_id
                  join category c on c.category_id = p.category_id
                  join photo ph on ph.product_id = p.product_id and ph.default_photo = 1
                  order by c.category_id, p.name";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
                array_push($products, $row);
        }
        return $products;
    }
    
    public function getAllProducts(){
        
        $products = array();
        $query = "select p.product_id, p.name, p.description, p.price,
                    u.description unit, 
                    c.description category,  
                    ph.description photo
                  from product p
                  join unit u on u.unit_id = p.unit_id
                  join category c on c.category_id = p.category_id
                  join photo ph on ph.product_id = p.product_id
                  order by p.name, p.product_id";
                    
        $statement = $this->connection->prepare($query);
        $statement -> execute();
        
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
                array_push($products, $row);
        }
        return $products;
    }
    
     public function getProductsbyFilter($category_id, $product_name, $unit_id,
    $min_price,$max_price){
        
        $products = array();
        
        $query = "select p.product_id, p.name, p.description, p.price,
                    u.description unit, 
                    c.description category,  
                    ph.description photo
                  from product p
                  join unit u on u.unit_id = p.unit_id
                  join category c on c.category_id = p.category_id
                  join photo ph on ph.product_id = p.product_id and ph.default_photo = 1";
                  
        $where =  " where 1=1 ";
        
        //adding where clause according to user selection
        if(strlen($category_id) == 0) {
            $category_id = self::$numberWildCard;
            $where .= "and p.category_id >= ?";
        } else {
            $where .= " and p.category_id = ?";
        }
        $where .= " and (upper(p.name) like ? 
                            or upper(c.description) like ?
                            or upper(p.description) like ?)";
        if(strlen($product_name) == 0) {
            $product_name = self::$stringWildCard.self::$stringWildCard.self::$stringWildCard;
        } else {
            $product_name = strtoupper(self::$stringWildCard.$product_name.self::$stringWildCard);;
        }
        if(strlen($unit_id) == 0) {
            $unit_id = self::$numberWildCard;
            $where .= " and p.unit_id >= ?";
        } else {
            $where .= " and p.unit_id = ?";
        }
        $where .= " and (p.price between ? and ?)";
        if(strlen($max_price) == 0 || $max_price == 0) { 
            $max_price = $this->getMaxPrice();
        }
        if(strlen($min_price) == 0){
             $min_price = $this->getMinPrice();
        }
        
        $orderby = " order by p.category_id, p.name";
        
        
        //appending where clauses and order by
        $query .= $where;
        $query .= $orderby;
        
        $statement = $this->connection->prepare($query);
        $statement -> bind_param('isssidd', $category_id, $product_name,
                                            $product_name,$product_name, 
                                            $unit_id, $min_price, $max_price);
        $statement -> execute();
        $result = $statement->get_result();
        while($row = $result -> fetch_assoc()){
            array_push($products, $row);
        }
        return $products;
    }
    
    public function addProductPhoto($photo, $product_id){
       //check size
       if($photo['size'] < 10000) {
        //check format
        $type = exif_imagetype($photo['tmp_name']);
        $allowed = array(1,2,3);
        if(in_array($type,$allowed)==true){
                $product_category = $this -> getCategoryNameByProductId($product_id);
                if($product_category != self::$ERROR_CODE) {
                    //move file to a directory
                    $dir = 'images/product/'.$product_category.'/'.$photo['name'];
                    if(move_uploaded_file($photo['tmp_name'],$dir )==true){
                       //proceed and create account
                       $query = "INSERT INTO `photo`(`product_id`, `default_photo`, `description`) 
                       VALUES (?,0,?)";
                       $statement = $this -> connection -> prepare($query);
                       $statement -> bind_param('is', $product_id, $photo['name']);
                       $success = $statement -> execute() ? true : false;
                       //check the error code 
                       if ($success == false ){
                           $this-> errors['database'] = self::$DATABASE_ERROR;
                           return $success;
                       }
                   } else {
                       $this-> errors['file_upload'] = 'not possible to move file';
                       return false;
                   }
                } else {
                    $this-> errors['file_upload'] = 'no category found for this product';
                    return false;
                }
            } else {
               $this-> errors['file_upload'] = 'Format not accepted (use: gif,jpeg,png)';
               return false;
            }
        } else {
            $this-> errors['file_upload'] = 'File is too big!';
            return false;
        }
        return $success;
    }
    
    public function validateFields($name, $description, $category_id, $unit_id, $price, $size, $photo_array, $newProduct) {
        //validate name
        if(strlen($name) <= 0){
            $this-> errors['name'] = 'Name: name empty '.$name;
        } else if($newProduct == true) {
            //check if already exist
            $query = "SELECT name FROM product WHERE name = ?";
            
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('s', $name);
            $success = $statement -> execute() ? true : false;
            if ($success == false) {
                $this-> errors['database'] = self::$DATABASE_ERROR;
            } else  {
                $result = $statement -> get_result();
                if($result -> num_rows > 0) {
                    //name exist
                    $this-> errors['name'] = 'Name: name already used';
                }
            }
        }
        //check $description $category_id, $unit_id, $price, $size, $photo_array
        if(strlen($description) == 0){
            $this-> errors['description'] = 'description: description empty '.$description;
        }
        if(strlen($price) == 0){
            $this-> errors['price'] = 'price: price empty '.$price;
        }
        if(strlen($size) == 0){
            $this-> errors['size'] = 'size: size empty '.$size;
        }
        if(strlen($photo_array['name']) <= 0){
            $this-> errors['photo_array'] = 'photo_array: photo_array empty '.$photo_array;
        }
        if($category_id <= 0 || $category_id == null){
            $this-> errors['category_id'] = 'category_id: wrong category_id '.$category_id;
        }
        if($unit_id <= 0 || $unit_id == null){
            $this-> errors['unit_id'] = 'unit_id: wrong unit_id '.$unit_id;
        }
        
        //do we have errors?
        if(count($this-> errors)==0){
            return true;
        } else {
            return false;
        }
    }
    public function addProduct($name, $description, $category_id, $unit_id, $price, $size, $photo_array){
        
        $success = $this->validateFields($name, $description, $category_id, $unit_id, $price, $size, $photo_array, true);
        if($success == false){
            $this-> errors['validation'] = self::$DATABASE_ERROR;
            return $sucess;
        }
        //proceed and create account
        $query = "INSERT INTO `product`(`name`, `description`, `category_id`, `unit_id`, `price`) 
        VALUES (?,?,?,?,?)";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('ssiid', $name, $description, $category_id, $unit_id, $price);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
            $this-> errors['product insert'] = 'cant insert into product table';
        } else {
            $product_id = $this->getProductIdByName($name);
            //adding size
            $success = $this->addProductSize($product_id, $size);
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
                $this-> errors['product insert'] = 'cant insert into size table';
            } else {
                //adding photo
                $success = $this->addProductPhoto($photo_array, $product_id);
                if ($success == false ){
                    $this-> errors['database'] = self::$DATABASE_ERROR;
                    $this-> errors['product insert'] = 'cant insert into photo table';
                }
            }
        }
        return $success;
    }
    
    public function addProductSize($product_id, $size){
        
        $size = strtoupper($size);
        //proceed and create account
        $query = "INSERT INTO `size`(`product_id`, `description`) VALUES (?,?)";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('is', $product_id, $size);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    public function setDefaultPhoto($photo_id, $product_id){
        
        //set all photos as not default
        $query = "UPDATE `photo` SET default_photo = 0 WHERE product_id = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('i', $product_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        } else {
            //now set choosen photo as default
           $query = "UPDATE `photo` SET default_photo= 1 WHERE `photo_id` = ?";
           $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('i',$photo_id);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            } 
        }
        return $success;
    }
    
    public function updateProduct($name, $description, $category_id, $unit_id, $price, $product_id){
        
        $success = $this->validateFields($name, $description, $category_id, 
                                        $unit_id, $price, $wildCardSize, 
                                        $wildCardPhotoArray, false);
        if($success == false){
            $this-> errors['validation'] = self::$DATABASE_ERROR;
            return $sucess;
        }
        //update product
        $query = "UPDATE `product` SET `name`=?,`description`=?,
        `category_id`=?,`unit_id`=?,`price`=? WHERE `product_id` = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('ssiidi', $name, $description, $category_id, $unit_id, $price, $product_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }

    public function deleteProductPhoto($photo_id, $photo){
        
        //delete product photo
        $query = "DELETE FROM `photo` WHERE `photo_id` = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('i',$photo_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        } else {
            // deleting photo from the system
            system("find . -iname ".$photo." -delete;");
        }
        return $success;
    }
    
    public function deleteProductSize($product_id, $size){
        
        //delete product size
        $query = "DELETE FROM `pinnacle`.`size` 
                  WHERE `size`.`product_id` = ? 
                  AND `size`.`description` = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('is',$product_id, $size);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        }
        return $success;
    }
    
    
    public function deleteProduct($product_id){
        
        //delete product photo
        $photos = $this -> getPhotosByProductId($product_id); 
        if(count($photos) > 0 ) {
            foreach($photos as $photo){
                $success = $this -> deleteProductPhoto($photo['photo_id'], $photo['photo']);
                //check the error code 
                if ($success == false ){
                    $this-> errors['database'] = self::$DATABASE_ERROR;
                    return $success;
                }
            }
        }
        //delete product size
        $query = "DELETE FROM `size` WHERE `product_id` = ?";
        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('i',$product_id);
        $success = $statement -> execute() ? true : false;
        //check the error code 
        if ($success == false ){
            $this-> errors['database'] = self::$DATABASE_ERROR;
        } else {
            //delete product
            $query = "DELETE FROM `product` WHERE `product_id` = ?";
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('i',$product_id);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false ){
                $this-> errors['database'] = self::$DATABASE_ERROR;
            }
        }
        return $success;
    }
}
?>