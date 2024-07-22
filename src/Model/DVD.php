<?php

namespace App\Model;

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->setSize($size);
        $this->setType('DVD');
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function save() {
        $db = new Database();
        $stmt = $db->getPdo()->prepare("INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->getSize()]);
    }

    public function display(): string
    {
        return "{$this->getSku()} - {$this->getName()} - {$this->getPrice()}$ - Size: {$this->getSize()}MB";
    }
}
