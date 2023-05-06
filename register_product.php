<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a new product</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/new_product.css">
    <script src="import/jquery-3.6.4.min.js"></script>
    <script src="import/toastr.min.js"></script>
    <link rel="stylesheet" href="import/toastr.min.css">

</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <div class="new-product-container">
        <h1>Add Product</h1>
        <p>Register your product</p>   
        <form id="formRegisterProduct" class="form" action="add_product.php" method="POST">
            <div class="form-control">
                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" placeholder="Enter with the product name">
            </div>
            <div class="form-control">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter with the product name">
            </div>
            <div class="form-control">
                <label for="price">Price ($)</label>
                <input type="number" name="price" id="price" placeholder="Enter with the product price">
            </div>
            <div class="form-control">
                <label for="type">Type Switcher</label>
                <select name="type" id="type">
                    <option value="">Select an option</option>
                    <option value="DVD">DVD</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Book">Book</option>
                </select>
            </div>
            <div id="dvd-details" class="form-control product-details" style="display: none;">
                <label for="size">Size (MB)</label>
                <input type="number" name="size" id="size" placeholder="Please, provide size">
            </div>
            <div id="furniture-details" class="form-control product-details" style="display: none;">
                <label for="height">Height (CM)</label>
                <input type="number" name="height" id="height" placeholder="Please, provide height"><br>
                <label for="width">Width (CM)</label>
                <input type="number" name="width" id="width" placeholder="Please, provide width"><br>
                <label for="length">Length (CM)</label>
                <input type="number" name="length" id="length" placeholder="Please, provide length"><br>
            </div>
            <div id="book-details" class="form-control product-details" style="display: none;">
                <label for="weight">Weight (KG)</label>
                <input type="number" name="weight" id="weight" placeholder="Please, provide weight">
            </div>
            <div class="actions">
                <a href="home.php" type="button" class="btn-cancel">Cancel</a>
                <button class="btn-submit" type="submit">Add Product</button>
            </div>
        </form>
    </div>
    <?php
        include_once "footer.php";
    ?>
    <script>
        $(document).ready(function () {
            $("#type").on("change", function (event) {
                $(".product-details").css("display", "none");
                $(".product-details").find("p").remove();
                $("#" + event.target.value.toLowerCase() + "-details").css("display", "");
                $("#" + event.target.value.toLowerCase() + "-details").append("<p>*Product description*</p>");

            });

            $("#formRegisterProduct").on("submit", function (event) {
                event.preventDefault();

                $(".form-control input, .form-control select").each(function () {
                    if($(this).parent().css("display") != "none") {
                        validation($(this));
                    }
                });

                if($(".form-control input, .form-control select").val() != "" && $("#type").val() != "") {
                    $(this).unbind("submit").submit();
                }

            });
        });

        function validation(field) {
            if(field.val() == "") {
                toastr.warning(field.attr("name").charAt(0).toUpperCase() + field.attr("name").slice(1) + " is required!");
                field.css("border", "1px solid red");
            } else {
                field.css("border", "1px solid #222");
            }
        }
    </script>
</body>
</html>