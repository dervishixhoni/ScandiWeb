<?php

namespace App\Model;

use PDO;

class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=productsDB', 'root', 'password');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getProducts()
    {
        $stmt = $this->pdo->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }

    public function deleteProducts($product_ids)
    {
        $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id IN ($placeholders)");
        $stmt->execute($product_ids);
    }

    public function checkSku($sku)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM products WHERE sku = ?');
        $stmt->execute([$sku]);
        return $stmt->fetchColumn();
    }
}