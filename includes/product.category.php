<?php 
$product = new Product();
$categories = $product -> getCategories();

?>
<form name="productoption-form" id="productoption-form" method="post" action="product.php">
    <div class="row">
        <h3>Select a product option!</h3>
        <?php
            foreach($categories as $item){
                $category_id = $item['category_id'];
                $category = $item['category'];
                $photo = $item['photo'];
                echo "<div class=\"row-md-4 m-1\">";
                echo "<button value=\"$category_id\" id=\"category\" name=\"category\" class=\"btn btn-info mt-2\"  type=\"submit\">$category</button>";
                echo "</div>";
            }
        ?>
   </div>
</form>