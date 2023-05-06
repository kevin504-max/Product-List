<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/app.css">
    <script src="import/jquery-3.6.4.min.js"></script>
</head>
<body>
    <?php
        include_once "layout/header.php";
    ?>
    <div class="products-container">
        <div class="title-container">
            <h1>Product List</h1>
            <div class="actions">
                <a href="register_product.php" type="button" class="btn">Add</a>
                <a id="btn_delete" type="button" class="btn">Mass Delete</a>
            </div>
        </div>
        <form id="formDeleteProducts" action="methods/delete_products.php" method="POST">
            <input type="hidden" name="products_ids[]" id="products_ids">
            <div class="container" style="justify-content: flex-start;">
                <?php
                    include_once "methods/products.php";
                    $productsObj = new App\Products();
                    $products = $productsObj->getProducts();

                    if ($products && count($products) > 0) {
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
                        echo "<div class='not-found'>";
                        echo "<img src='assets/Meerkats.svg' alt='There are no products registered yet.' width='400'>";
                        echo "<h2>There are no products registered yet.</h2>";
                        echo "</div>";
                    }
                ?>
            </div>
        </form>
    </div>
    <?php
        include_once "layout/footer.php";
    ?>
    <script>
        $(document).ready(function() {
            $("#btn_delete").on("click", function() {
                if ($(".delete-checkbox:checked").length > 0) {
                    $("#formDeleteProducts").find('input[name="products_ids[]"]').val($(".delete-checkbox:checked").map(function () {
                        return this.value;
                    }).get().join(","));
                    $("#formDeleteProducts").unbind("submit").submit();
                } else {
                    $(".btn[type='submit']").css("display", "none");
                }
            });
        });
    </script>
</body>
</html>