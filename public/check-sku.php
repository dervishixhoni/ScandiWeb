<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ProductController;

$sku = $_GET['sku'] ?? '';

if ($sku) {
    $controller = new ProductController();
    $result = $controller->checkSku($sku);
    echo json_encode(['exists' => $result > 0]);
} else {
    echo json_encode(['error' => 'SKU is required']);
}
exit;
?>