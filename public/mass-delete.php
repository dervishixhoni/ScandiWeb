<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ProductController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productIds = $_POST['product_ids'] ?? [];
    if (!empty($productIds)) {
        $controller = new ProductController();
        $controller->deleteProducts($productIds);
    }
    header('Location: /');
    exit;
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>