<?php 
$product = new Product();
$categories = $product -> getCategories();

?>
<form name="productoption-form" id="productoption-form" method="post" action="product.php">
    <div class = "col mb-4 mt-2 offset-4 ">
     <h3><u> Select a product category! </u></h3>
     </div>
    <div class="row" id="product-categories">
        <?php
            foreach($categories as $item){
                $category_id = $item['category_id'];
                $category = $item['category'];
                $photo = $item['photo'];

                echo "<div class=\"col-md-4\">";
                echo "<img src=\"images/website/$photo\" class=\"img-fluid\" data-category=\"$category_id\" style=\"cursor: pointer;\">";
                //echo "<button value=\"$category_id\" id=\"category\" name=\"category\" class=\"btn btn-info mt-2\"  type=\"submit\"> $category </button>";
                echo "<input type=\"hidden\" name=\"category\">";
                echo "</div>";
            }
        ?>
   </div>
</form>

<script>
    $(document).ready( () => {
        $('#product-categories').on('click', (event) =>{
            //get the category id
            if( $(event.target).data('category') ){
                $('input[name="category"]').val( $(event.target).data('category') );
                $('#productoption-form').submit();
            }
        });
    });
</script>