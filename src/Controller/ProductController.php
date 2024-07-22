<?php
namespace App\Controller;

use App\Model\Database;
use App\Model\Book;
use App\Model\DVD;
use App\Model\Furniture;
use Exception;

class ProductController {
    public function addProduct($data) {
        $db = new Database();

        switch ($data['type']) {
            case 'Book':
                $product = new Book($data['sku'], $data['name'], $data['price'], $data['weight']);
                break;
            case 'DVD':
                $product = new DVD($data['sku'], $data['name'], $data['price'], $data['size']);
                break;
            case 'Furniture':
                $product = new Furniture($data['sku'], $data['name'], $data['price'], $data['height'], $data['width'], $data['length']);
                break;
            default:
                throw new Exception('Invalid product type');
        }

        $product->save();
    }

    public function listProducts()
    {
        $db = new Database();
        return $db->getProducts();
    }

    public function deleteProducts($product_ids)
    {
        $db = new Database();
        $db->deleteProducts($product_ids);
    }

    public function checkSku($sku)
    {
        $db = new Database();
        return $db->checkSku($sku);
    }
}
