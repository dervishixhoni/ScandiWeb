<?php

namespace App\Model;

abstract class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($sku, $name, $price) {
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
    }

    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function skuExists($sku)
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM products WHERE sku = ?");
        $stmt->execute([$sku]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    abstract public function save();
    abstract public function display();
}
