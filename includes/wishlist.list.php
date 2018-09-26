<?php 
    foreach($wishlists as $item){
            $wishlist_id = $item['wishlist_id'];
            $wishlist_quantity = $item['quantity'];
            $wishlist_user_id = $item['user_id'];
            $wishlist_email = $item['email'];
            $wishlist_product_id = $item['product_id'];
            $wishlist_product_name = $item['name'];
            $wishlist_product_description = TextUtility::summarize($item['description'],15);;
            $wishlist_product_price = $item['price'];
            $wishlist_product_unit = $item['unit'];
            $wishlist_product_category= $item['category'];
            
            echo "<form name=\"wishlist-form\" id=\"wishlist-form\" method=\"post\" action=\"wishlist.php\">";
                echo "<div class=\"col\">
                        <div class=\"col-md-3\"> 
                        <h3> Shop List Details </h3>
                            <p>Wishlist number: $wishlist_id</p>
                            <label for=\"quantity\">Wishlist quantity:</label>
                            <input class=\"form-control\" type=\"text\" 
                               name=\"quantity\" id=\"quantity\" value=\"$wishlist_quantity\"/>
                            <p>Wishlist user_id: $wishlist_user_id</p>
                            <p>Wishlist email: $wishlist_email</p>
                        </div>
                     <div class=\"row-md-3 ml-3\"> 
                        <p>Wishlist product_id: $wishlist_product_id</p>
                        <p>Wishlist name: $wishlist_product_name</p>
                        <p>Wishlist description: $wishlist_product_description</p>
                        <p>Wishlist price: $wishlist_product_price</p>
                    </div>
                    <div class=\"row-md-3 ml-3 m-3\"> 
                        <p>Wishlist unit: $wishlist_product_unit</p>
                        <p>Wishlist category: $wishlist_product_category</p>
                        
                        <input class=\"form-control\" type=\"hidden\" 
                            name=\"product_id\" id=\"product_id\" value=\"$wishlist_product_id\"/>
                        <input class=\"form-control\" type=\"hidden\" 
                               name=\"wishlist_id\" id=\"wishlist_id\" value=\"$wishlist_id\"/>
                        <input class=\"form-control\" type=\"hidden\" 
                               name=\"wishlist_user_id\" id=\"wishlist_user_id\" value=\"$wishlist_user_id\"/>
                        <button value=\"add\" id=\"action\" 
                           name=\"action\" class=\"btn btn-info mt-2\"  
                               type=\"submit\">Change
                        </button>
                        <button value=\"delete\" id=\"action\" 
                           name=\"action\" class=\"btn btn-info mt-2\"  
                               type=\"submit\">Delete
                        </button>
                    </div>";
            echo "</form>";
            
    }
?>