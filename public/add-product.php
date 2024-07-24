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

// Check common required fields
    if (empty($data['sku']) || empty($data['name']) || empty($data['price']) || empty($data['type'])) {
        $response['error'] = 'SKU, Name, Price, and Type are required';
    } else {
        $response['error'] = [];

        // Check if SKU already exists
        $controller = new ProductController();
        if ($controller->checkSku($data['sku'])) {
            $response['error'][] = 'SKU already exists';
        }

        // Validate price
        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            $response['error'][] = 'Price must be a valid number';
        }

        // Validate type-specific fields
        switch ($data['type']) {
            case 'Book':
                if (empty($data['weight']) || !is_numeric($data['weight']) || $data['weight'] <= 0) {
                    $response['error'][] = 'Weight must be a valid number for Books';
                }
                break;
            case 'DVD':
                if (empty($data['size']) || !is_numeric($data['size']) || $data['size'] <= 0) {
                    $response['error'][] = 'Size must be a valid number for DVDs';
                }
                break;
            case 'Furniture':
                if (empty($data['height']) || !is_numeric($data['height']) || $data['height'] <= 0) {
                    $response['error'][] = 'Height must be a valid number for Furniture';
                }
                if (empty($data['width']) || !is_numeric($data['width']) || $data['width'] <= 0) {
                    $response['error'][] = 'Width must be a valid number for Furniture';
                }
                if (empty($data['length']) || !is_numeric($data['length']) || $data['length'] <= 0) {
                    $response['error'][] = 'Length must be a valid number for Furniture';
                }
                break;
            default:
                $response['error'][] = 'Invalid product type';
        }

        // Validate name
        if (is_numeric($data['name'])) {
            $response['error'][] = 'Name must be a string';
        }
    }

// Return response
    if (!empty($response['error'])) {
        echo json_encode($response);
        exit;
    }
    $controller->addProduct($data);
    echo json_encode(['success' => 'Product added successfully']);
} else {
    include __DIR__ . '/../src/View/add_product.php';
}
