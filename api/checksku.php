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
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
if($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $productRepo = new ProductRepository((new Database())->getConnection());
    Product::initialize();
    $sku = $input['sku'];
    $isSkuUnique = $productRepo->isSkuUnique($sku);
    echo json_encode(['isSkuUnique' => $isSkuUnique]);
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}