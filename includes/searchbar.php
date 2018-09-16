<div class="searchbar">
    <div class="row">
        <div class="col-md-4 offset-md-4 mt-4 mb-5">
            <form name="search-form" id="search-form" method="post" action="product.php">
                <h3>Filter your search by</h3>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select class="form-control custom-select" name="category" id="category">
                        <option value="">Select a category</option>
                        <?php
                            foreach($categories as $item){
                                $category_id = $item['category_id'];
                                $category = $item['category'];
                                echo "<option value=\"$category_id\">$category</option>";
                            }
                        ?>
                     </select>
                </div>
                <div class="form-group">
                    <label for="product_name">Keyword:</label>
                    <input class="form-control" type="text" value="<?php //if(strlen($_POST['product_name']) > 0) { echo $product_name; } ?>" 
                            name="product_name" id="product_name" placeholder="Keyword: e.g. Jacket"/>
                </div>
                <div class="form-group">
                    <label for="unit">Unit:</label>
                    <select class="form-control custom-select" name="unit" id="unit">
                        <option value="">Select a unit</option>
                        <?php
                            foreach($units as $item){
                                $unit_id = $item['unit_id'];
                                $unit = $item['unit'];
                                echo "<option value=\"$unit_id\">$unit</option>";
                            }
                        ?>
                     </select>
                </div>
                <div class="form-group">
                    <label for="min_price">Min Price: 
                        <output id="rangevaluemin"></output>
                    </label>
                    <input type="range" class="form-control-range" name="min_price" id="min_price"  value="0" onchange="rangevaluemin.value=value">
                </div>
                <div class="form-group">
                    <label for="max_price">Max Price: 
                        <output id="rangevaluemax"></output>
                    </label>
                    <input type="range" class="form-control-range" name="max_price" id="max_price" max="<?php echo $product->getMaxPrice() ?>"  value="0" onchange="rangevaluemax.value=value">
                </div>
                
                <button class="btn btn-warning mt-2" type="reset">Clear</button>
                <button name="btn-search" class="btn btn-info mt-2"  type="submit">Search</button>
            </form>
        </div>
    </div>
</div>