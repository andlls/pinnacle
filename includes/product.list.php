<?php 
    foreach($products as $item){
        $product_id = $item['product_id'];
        $product_name = $item['name'];
        //will not be displayed
        //$product_description = TextUtility::summarize($item['description'],15);
        $product_price = $item['price'];
        $product_unit = $item['unit'];
        $product_category = $item['category'];
        $product_photo = $item['photo'];
        
        echo "<div class=\"col-md-3\" > 
                    <h4>$product_name</h4>
                    <img src=\"images/product/$product_category/$product_photo\" class=\"img-fluid\">
                    <p><h5>Price: $ $product_price</h5></p>";
                    
        echo "<a href=\"detail.product.php?product_id=$product_id\">View Details</a>";
        
        echo "</div>";
    }
?>