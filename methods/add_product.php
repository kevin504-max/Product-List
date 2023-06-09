<?php
namespace App;

use Exception;
use mysqli;

class DatabaseConnection {
    private $host = "localhost";
    private $username = "root";
    private $password = "A9y9h1x!";
    private $database_name = "products_list";
    private $database;
    
    public function __construct() {
        $this->database = new mysqli($this->host, $this->username, $this->password, $this->database_name);
        
        if($this->database->connect_error) {
            throw new Exception("Connection failed: " . $this->database->connect_error);
        }
    }
    
    public function getDatabase() {
        return $this->database;
    }
}

abstract class Product {
    protected $databaseConnection;
    protected $type;
    protected $sku;
    protected $name;
    protected $price;

    
    public function __construct() {
        $this->databaseConnection = new DatabaseConnection();
    }
    
    abstract function addProduct($sku, $name, $price, $details);
    
    protected function insertProduct($sku, $name, $price, $type, $details) {
        $database = $this->databaseConnection->getDatabase();
       
        $query = "INSERT INTO products (sku, name, price, type, details) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $database->prepare($query);
        $stmt->bind_param("ssdss", $sku, $name, $price, $type, $details);

        if(!$stmt->execute()) {
            throw new Exception("Error adding product: " . $stmt->error);
        }
        
        $stmt->close();
    }

    public function checkSKU($sku) {
        $database = $this->databaseConnection->getDatabase();
    
        $query = "SELECT * FROM products WHERE sku = ?";
        $stmt = $database->prepare($query);
    
        if(!$stmt) {
            throw new Exception("Error preparing query: " . $database->error);
        }
    
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $stmt->close();
    
        return ($result->num_rows > 0) ? false : true;
    }

}

class DvdProduct extends Product {
    protected $type = "DVD";

    public function addProduct($sku, $name, $price, $details) {
        $this->insertProduct($sku, $name, $price, $this->type, $details);
    }

    public function getProductDetails($product) {
        $details = "";
        $details .= "Size: " . $product["size"] . " MB";
        return json_encode($details);
    }
}


class FurnitureProduct extends Product {
    protected $type = "Furniture";
    
    public function addProduct($sku, $name, $price, $details) {
        $this->insertProduct($sku, $name, $price, $this->type, $details);
    }

    public function getProductDetails($product) {
        $details = "";
        $details .= "Dimensions: " . $product["height"] . "x" . $product["width"] . "x" . $product["length"];
        return json_encode($details);
    }
}

class BookProduct extends Product {
    protected $type = "Book";
    
    public function addProduct($sku, $name, $price, $details) {
        $this->insertProduct($sku, $name, $price, $this->type, $details);
    }

    public function getProductDetails($product) {
        $details = "";
        $details .= "Weight: " . $product["weight"] . " KG";
        return json_encode($details);
    }
}

try {
    $typeToClassMap = [
        "DVD" => DvdProduct::class,
        "Furniture" => FurnitureProduct::class,
        "Book" => BookProduct::class
    ];
    
    $type = $_POST["type"];

    if(!array_key_exists($type, $typeToClassMap)) {
        throw new Exception("Invalid product type");
    }

    $productClass = $typeToClassMap[$type];
    $product = new $productClass();
    if($product->checkSKU($_POST["sku"])) {
        $product->addProduct(
            $_POST["sku"],
            $_POST["name"],
            $_POST["price"],
            $product->getProductDetails($_POST)
        );
    
        header("Location: ../index.php");
    } else {
        header("Location: ../register_product.php");
    }

    
} catch(Exception $e) {
    echo $e->getMessage();
}
?>