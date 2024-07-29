<?php
require_once 'Product.php';
class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price, 'Book');
        $this->weight = $weight;
    }

    public function getSpecificAttribute() {
        return $this->weight;
    }

    public function save($db) {

        $query = "INSERT INTO products (sku, name, price, type, weight) VALUES (:sku, :name, :price, :type, :weight)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':weight', $this->weight);

        if ($stmt->execute()) {
        } else {
            throw new Exception("Unable to save product.");
        }
    }
    public function getWeight() { return $this->weight; }
    public function setWeight($weight) { $this->weight = $weight; }
}
?>
