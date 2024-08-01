<?php

class ProductRepository
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllProducts()
    {
        return Product::getAll();
    }

    public function deleteProducts($ids)
    {
        return Product::delete($ids);
    }

    public function addProduct($product)
    {
        return $product->save($this->conn);
    }

    public function isSkuUnique($sku)
    {
        return Product::isSkuUnique($this->conn, $sku);
    }
}

