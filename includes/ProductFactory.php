<?php
require_once 'Book.php';
require_once 'Furniture.php';
require_once 'DVD.php';
class ProductFactory {
    public static function create($type, $sku, $name, $price, $attribute1, $attribute2 = null, $attribute3 = null) {
        try {
            switch ($type) {
                case 'Book':
                    try {
                        $product = new Book($sku, $name, $price, $attribute1);
                    } catch (Exception $e) {
                        throw $e;
                    }
                    break;
                case 'DVD':
                    $product = new DVD($sku, $name, $price, $attribute1);
                    break;
                case 'Furniture':
                    $product = new Furniture($sku, $name, $price, $attribute1, $attribute2, $attribute3);
                    break;
                default:
                    throw new Exception("Invalid product type: $type");
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $product;
    }
}
?>