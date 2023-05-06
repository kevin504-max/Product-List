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

class Products {
    protected $databaseConnection;

    public function __construct() {
        $this->databaseConnection = new DatabaseConnection();
    }

    public function getProducts() {
        $database = $this->databaseConnection->getDatabase();
        $query = "SELECT * FROM products ORDER BY id DESC";
        $result = $database->query($query);
        $products = [];

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        } else {
            return false;
        }

        return $products;
    }
}

?>