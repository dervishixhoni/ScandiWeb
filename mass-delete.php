<?php
require_once 'includes/Database.php';
require_once 'includes/ProductRepository.php';

$database = new Database();
$db = $database->getConnection();
$productRepository = new ProductRepository($db);

$product_ids=$_POST['product_ids'] ?? [];
if (!empty($product_ids)) {
    $productRepository->deleteProducts($product_ids);
}
header('Location:/')
?>