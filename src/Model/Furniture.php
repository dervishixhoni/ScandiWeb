<?php

namespace App\Model;

class Furniture extends Product {
    private $length;
    private $height;
    private $width;

    public function __construct($sku, $name, $price, $length, $height, $width) {
        parent::__construct($sku, $name, $price);
        $this->setLength($length);
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setType('Furniture');
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function save() {
        $db = new Database();
        $stmt = $db->getPdo()->prepare("INSERT INTO products (sku, name, price, type, length, height, width) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->getSku(), $this->getName(), $this->getPrice(), $this->getType(), $this->getLength(), $this->getHeight(), $this->getWidth()]);
    }

    public function display() {
        return "{$this->getSku()} - {$this->getName()} - {$this->getPrice()}$ - Dimensions: {$this->getLength()}x{$this->getHeight()}x{$this->getWidth()}";
    }
}