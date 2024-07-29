<?php
require_once 'includes/Database.php';
require_once 'includes/Product.php';
require_once 'includes/DVD.php';
require_once 'includes/Book.php';
require_once 'includes/Furniture.php';
require_once 'includes/ProductRepository.php';

$database = new Database();
$db = $database->getConnection();
$productRepository = new ProductRepository($db);
$products = $productRepository->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="d-flex justify-content-between align-items-center border-3 border-black border-bottom pb-2 mb-4">
        <h1>Product List</h1>
        <div>
            <button class="btn btn-primary me-2" onclick="window.location.href='/add-product'">ADD</button>
            <button class="btn btn-danger" onclick="document.getElementById('delete-form').submit();" id="delete-product-btn">MASS DELETE</button>
        </div>
    </div>
    <form id="delete-form" method="POST" action="/mass-delete.php">
        <div class="row g-3">
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="card border-3 border-black rounded-2 h-100">
                        <div class="card-body text-center p-4">
                            <input type="checkbox" class="delete-checkbox" name="product_ids[]" value="<?= $product['id'] ?>">
                            <p class="mb-1 fs-5 fw-bold">SKU: <?= $product['sku'] ?></p>
                            <p class="mb-1 fs-5 fw-bold">Name: <?= $product['name'] ?></p>
                            <p class="mb-1 fs-5 fw-bold">Price: $<?= $product['price'] ?></p>
                            <p class="mb-1 fs-5 fw-bold"><?= ($product['type'] == 'DVD') ? 'Size: ' . $product['size'] . ' MB' : '' ?></p>
                            <p class="mb-1 fs-5 fw-bold"><?= ($product['type'] == 'Book') ? 'Weight: ' . $product['weight'] . ' Kg' : '' ?></p>
                            <p class="mb-1 fs-5 fw-bold"><?= ($product['type'] == 'Furniture') ? 'Dimensions: ' . $product['height'] . 'x' . $product['width'] . 'x' . $product['length'] : '' ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>
</body>
</html>