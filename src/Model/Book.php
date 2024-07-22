<?php

namespace App\Model;

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->setWeight($weight);
        $this->setType('Book');
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function save() {
        $db = new Database();
        $stmt = $db->getPdo()->prepare("INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->getWeight()]);
    }

    public function display(): string
    {
        return "{$this->getSku()} - {$this->getName()} - {$this->getPrice()}$ - Weight: {$this->getWeight()}kg";
    }
}
