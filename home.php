<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <div class="products-container">
        <div class="title-container">
            <h1>Product List</h1>
            <div class="actions">
                <a href="register_product.php" type="button" class="btn">Add</a>
                <a href="delete_product.php" type="button" class="btn">Mass Delete</a>
            </div>
        </div>
        <div class="container" style="justify-content: flex-start;">
            <?php
                include_once "products.php";
                $productsObj = new App\Products();
                $products = $productsObj->getProducts();

                if (count($products) > 0) {
                    foreach ($products as $product) {
                        echo "<div class='product-card'>";
                        echo "<input type='checkbox' class='delete-checkbox' value='" . $product["id"] . "'/>"; 
                        echo "<h4>" . $product["name"] . "</h4>";
                        echo "<p><span>SKU: </span>" . $product["sku"] . "</p>";
                        echo "<p><span>Price: </span>" . $product["price"] . "</p>";
                        echo "<p class='type-text'><span class='" . strtolower($product["type"]) . "'></span>" . $product["type"] . "</p>";
                        echo "<p class='details-text'><span>Details: </span>" . $product["details"] . "</p>";
                        echo "</div>";

                    }
                } else {
                    echo "<h2>No products found</h2>";
                }
            ?>
        </div>
    </div>
    <?php
        include_once "footer.php";
    ?>
</body>
</html>