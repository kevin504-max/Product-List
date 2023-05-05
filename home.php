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
    <div class="projects-container">
        <div class="title-container">
            <h1>Product List</h1>
            <div class="actions">
                <a href="addProduct.php" type="button" class="btn">Add Product</a>
                <a href="deleteProduct.php" type="button" class="btn">Mass Delete</a>
            </div>
        </div>
    </div>
    <!-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
    <?php
        include_once "footer.php";
    ?>
</body>
</html>