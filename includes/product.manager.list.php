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
        
        echo "<div class=\"col-md-2\" > 
                    <h4>$product_name</h4>
                    <img src=\"images/product/$product_category/$product_photo\" class=\"img-fluid\">
                    <h5>$product_price</h5>";
        echo "<a href=\"detail.product.php?product_id=$product_id\">View Details   / </a>";
        echo "<a href=\"edit.product.php?product_id=$product_id\">Edit Details</a>";
        echo "<form id=\"product-form\" method=\"post\" action=\"product.manager.php\">
                <input class=\"form-control\" type=\"hidden\" name=\"product_id\" id=\"product_id\" value=\"$product_id\"/>
                <button id=\"action\" name=\"action\" style = \"background-color:red;\" value=\"delete\" class=\"btn btn-info mt-2 mb-4 \" type=\"submit\"> Delete </button>
		      </form> ";
        echo "</div>";
    }
?>