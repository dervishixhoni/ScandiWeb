<?php
class ProductRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProducts($ids) {
        $query = "DELETE FROM products WHERE id IN (" . implode(',', $ids) . ")";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
?>