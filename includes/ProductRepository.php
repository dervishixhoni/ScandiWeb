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

    public function addProduct($product) {
        $query = "INSERT INTO products (sku, name, price, type, size, weight, height, width, length) VALUES (:sku, :name, :price, :type, :size, :weight, :height, :width, :length)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sku', $product->getSku());
        $stmt->bindParam(':name', $product->getName());
        $stmt->bindParam(':price', $product->getPrice());
        $stmt->bindParam(':type', $product->getType());

        // Bind specific attributes based on product type
        $null = null;
        if ($product instanceof DVD) {
            $stmt->bindParam(':size', $product->getSize());
            $stmt->bindParam(':weight', $null);
            $stmt->bindParam(':height', $null);
            $stmt->bindParam(':width', $null);
            $stmt->bindParam(':length', $null);
        } elseif ($product instanceof Book) {
            $stmt->bindParam(':size', $null);
            $stmt->bindParam(':weight', $product->getWeight());
            $stmt->bindParam(':height', $null);
            $stmt->bindParam(':width', $null);
            $stmt->bindParam(':length', $null);
        } elseif ($product instanceof Furniture) {
            $stmt->bindParam(':size', $null);
            $stmt->bindParam(':weight', $null);
            $stmt->bindParam(':height', $product->getHeight());
            $stmt->bindParam(':width', $product->getWidth());
            $stmt->bindParam(':length', $product->getLength());
        }

        return $stmt->execute();
    }
}
?>