<?php
class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price, 'DVD');
        $this->size = $size;
    }

    public function getSize() { return $this->size; }
    public function setSize($size) { $this->size = $size; }

    public function save($conn) {
        $query = "INSERT INTO products (sku, name, price, type, size) VALUES (:sku, :name, :price, :type, :size)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':size', $this->size);
        $stmt->execute();
    }

    public function getSpecificAttribute() {
        return "Size: " . $this->size . " MB";
    }
}
?>