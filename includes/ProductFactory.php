<?php

require_once 'Book.php';
require_once 'Furniture.php';
require_once 'DVD.php';

class ProductFactory
{
    private static $productTypes = [
        'DVD' => DVD::class,
        'Book' => Book::class,
        'Furniture' => Furniture::class,
    ];
    public static function create($type, $sku, $name, $price, $attribute1, $attribute2, $attribute3, $attribute4, $attribute5)
    {
        if (!array_key_exists($type, self::$productTypes)) {
            throw new Exception("Invalid product type: $type");
        }

        return new self::$productTypes[$type]($sku, $name, $price, $attribute1, $attribute2, $attribute3, $attribute4, $attribute5);
    }
}
