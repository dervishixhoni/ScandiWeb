<?php

require '../includes/Database.php';
require '../includes/Product.php';
require '../includes/DVD.php';
require '../includes/Book.php';
require '../includes/Furniture.php';
require '../includes/ProductFactory.php';
require '../includes/ProductRepository.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$productRepo = new ProductRepository((new Database())->getConnection());
Product::initialize();
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
switch ($method) {
    case 'GET':
        $products = $productRepo->getAllProducts();
        $json = json_encode(['products' => $products]);
        if ($json === false) {
            http_response_code(500);
            echo json_encode(['message' => 'Internal Server']);
        } else {
            echo $json;
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            http_response_code(400);
            echo json_encode(['message' => 'Bad Request: Invalid JSON']);
            exit;
        }
        $product = ProductFactory::create($data->type, $data->sku, $data->name, $data->price, $data->weight, $data->size, $data->length, $data->width, $data->height);

        if ($productRepo->addProduct($product)) {
            echo json_encode(['message' => 'Product added successfully']);
        } else {
            echo json_encode(['message' => 'Product could not be added']);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if ($productRepo->deleteProducts($data->ids)) {
            echo json_encode(['message' => 'Products deleted successfully']);
        } else {
            echo json_encode(['message' => 'Products could not be deleted']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}