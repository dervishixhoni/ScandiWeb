<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ProductController;

$controller = new ProductController();
$products = $controller->listProducts();

include __DIR__ . '/../src/View/product_list.php';