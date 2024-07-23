<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ProductController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'sku' => $_POST['sku'],
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'type' => $_POST['type'],
        'weight' => $_POST['weight'] ?? null,
        'size' => $_POST['size'] ?? null,
        'height' => $_POST['height'] ?? null,
        'width' => $_POST['width'] ?? null,
        'length' => $_POST['length'] ?? null,
    ];
    $response = [];
    if (empty($data['sku'])
        || empty($data['name'])
        || empty($data['price'])
        || empty($data['type'])
        || empty($data['weight'])
        || empty($data['size'])
        || empty($data['height'])
        || empty($data['width'])
        || empty($data['length'])) {
        $response['error'] = 'All fields are required';
    }
    $response['error'] = [];
    if (!is_numeric($data['price'] && $data['price'] <= 0)) {
        $response['error'][] = 'Price must be a valid number';
    }
    if (!is_numeric($data['weight'] && $data['weight'] <= 0)) {
        $response['error'][] = 'Weight must be a valid number';
    }
    if (!is_numeric($data['size'] && $data['size'] <= 0)) {
        $response['error'][] = 'Size must be a valid number';
    }
    if (!is_numeric($data['height'] && $data['height'] <= 0)) {
        $response['error'][] = 'Height must be a valid number';
    }
    if (!is_numeric($data['width'] && $data['width'] <= 0)) {
        $response['error'][] = 'Width must be a valid number';
    }
    if (!is_numeric($data['length'] && $data['length'] <= 0)) {
        $response['error'][] = 'Length must be a valid number';
    }
    if (is_numeric($data['name'])) {
        $response['error'][] = 'Name must be a string';
    }

    if (!empty($response['error'])) {
        echo json_encode($response);
        exit;
    }
    $controller = new ProductController();
    $controller->addProduct($data);
    header('Location: /');
    exit;
} else {
    include __DIR__ . '/../src/View/add_product.php';
}
