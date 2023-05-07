<?php 
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

class ProductsToDelete {
    protected $databaseConnection;

    public function __construct() {
        $this->databaseConnection = new DatabaseConnection();
    }

    public function massDelete($ids) {
        $database = $this->databaseConnection->getDatabase();
        $idList = implode("','", array_map([$database, 'real_escape_string'], $ids));
        $query = "DELETE FROM products WHERE id IN ($idList)";
        $result = $database->query($query);

        header ("Location: ../index.php");

        return true;
    }
}

try {
    $products = new ProductsToDelete();

    if(isset($_POST["products_ids"]) && !empty($_POST["products_ids"])) {
        $products->massDelete($_POST["products_ids"]);
    }

    header("Location: ../index.php");
} catch (Exception $e) {
    echo $e->getMessage();
}

?>