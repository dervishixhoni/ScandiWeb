<?php
abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($sku, $name, $price, $type) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    public function getSku() { return $this->sku; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getType() { return $this->type; }

    public function setSku($sku) { $this->sku = $sku; }
    public function setName($name) { $this->name = $name; }
    public function setPrice($price) { $this->price = $price; }
    public function setType($type) { $this->type = $type; }

    public static function checkSku($conn, $sku) {
        $query = "SELECT COUNT(*) FROM products WHERE sku = :sku";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    abstract public function save($conn);
    abstract public function getSpecificAttribute();
}
?>
