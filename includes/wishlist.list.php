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
            echo"<div class =\"row\">";
                echo "<div class=\"col\">
                        <div class=\"col-md-3\"  style=\"min-width:300px;\"> 
                        <h3> Shopping List Details </h3>
                            <p><b>Shopping List Number: $wishlist_id</b></p>
                            <label for=\"quantity\"><b>Shopping List Quantity:</b></label>
                            <input class=\"form-control\" style=\"max-width:160px;\" type=\"text\" 
                               name=\"quantity\" id=\"quantity\" value=\"$wishlist_quantity\"/>
                            <p><b>Shoplist user_id:</b> $wishlist_user_id</p>
                            <p><b>Shoplist email:</b> $wishlist_email</p>
                        </div>
                     <div class=\"row-md-3 ml-3\"> 
                        <p><b>Shoplist product_id:</b> $wishlist_product_id</p>
                        <p><b>Shoplist name:</b> $wishlist_product_name</p>
                        <p><b>Shoplist description:</b> $wishlist_product_description</p>
                        <p><b>Shoplist price:</b> $wishlist_product_price</p>
                    </div>
                    <div class=\"row-md-3 ml-3 m-3\"> 
                        <p><b>Shoplist unit:</b> $wishlist_product_unit</p>
                        <p><b>Shoplist category:</b> $wishlist_product_category</p>
                        
                        <input class=\"form-control\" type=\"hidden\" 
                            name=\"product_id\" id=\"product_id\" value=\"$wishlist_product_id\"/>
                        <input class=\"form-control\" type=\"hidden\" 
                               name=\"wishlist_id\" id=\"wishlist_id\" value=\"$wishlist_id\"/>
                        <input class=\"form-control\" type=\"hidden\" 
                               name=\"wishlist_user_id\" id=\"wishlist_user_id\" value=\"$wishlist_user_id\"/>
                        <button value=\"add\" style = \"background-color:black;\"id=\"action\" 
                           name=\"action\" class=\"btn btn-info mt-2\"  
                               type=\"submit\">Change
                        </button>
                        <button value=\"delete\" id=\"action\" 
                           name=\"action\" style = \"background-color:red;\" class=\"btn btn-info mt-2\"  
                               type=\"submit\">Delete
                        </button>
                        </div>
                    </div>";
            echo "</form>";
            
    }
?>