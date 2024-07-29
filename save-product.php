<?php

header('Content-Type: application/json');

require_once 'includes/Database.php';
require_once 'includes/Product.php';
require_once 'includes/ProductFactory.php';


$data = [
    'sku' => $_POST['sku'] ?? null,
    'name' => $_POST['name'] ?? null,
    'price' => $_POST['price'] ?? null,
    'type' => $_POST['type'] ?? null
];


if (!$data['sku'] || !$data['name'] || !$data['price'] || !$data['type']) {
    $response = ["message" => "Missing required fields."];
    echo json_encode($response);
    exit;
}

if ($_POST['weight']) {
    $data['attribute1'] = $_POST['weight'];
} elseif ($_POST['size']) {
    $data['attribute1'] = $_POST['size'];
} else {
    $data['attribute1'] = $_POST['height'] ?? null;
    $data['attribute2'] = $_POST['width'] ?? null;
    $data['attribute3'] = $_POST['length'] ?? null;


    if (!$data['attribute1'] || !$data['attribute2'] || !$data['attribute3']) {
        $response = ["message" => "Missing dimension fields."];
        echo json_encode($response);
        exit;
    }
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        throw new Exception("Database connection failed.");
    }

    $skuExists = Product::checkSku($db, $data['sku']);

    if (!$skuExists) {
        $product = ProductFactory::create(
            $data['type'],
            $data['sku'],
            $data['name'],
            $data['price'],
            $data['attribute1'],
            $data['attribute2'] ?? null,
            $data['attribute3'] ?? null
        );

        $product->save($db);

        $response = ["message" => "Product saved successfully."];
        echo json_encode($response);
    } else {
        $response = ["message" => "SKU already exists."];
        echo json_encode($response);
    }
} catch (Exception $e) {
    $response = ["message" => "Server error: " . $e->getMessage()];
    echo json_encode($response);
}
exit;
?>