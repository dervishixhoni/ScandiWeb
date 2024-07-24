<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center border-3 border-black border-bottom pb-2 mb-4">
        <h1 class="h3">Product List</h1>
        <div>
            <a class="btn btn-primary me-2" href="/add-product.php">Add Product</a>
            <button class="btn btn-danger" id="delete-product-btn" onclick="document.getElementById('delete-form').submit();">Mass Delete</button>
        </div>
    </div>
    <form id="delete-form" method="post" action="/mass-delete.php">
        <div class="row g-3">
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="card border-3 border-black rounded-2 h-100">
                        <div class="card-body text-center p-4"> <!-- Bootstrap padding class -->
                            <input type="checkbox" class="delete-checkbox form-check-input mb-3" style="transform: scale(1.2);" name="product_ids[]" value="<?= htmlspecialchars($product['id']) ?>">
                            <p class="mb-1 fs-5 fw-bold">SKU: <?= htmlspecialchars($product['sku']) ?></p> <!-- Bootstrap font size class -->
                            <p class="mb-1 fs-5 fw-bold">Name: <?= htmlspecialchars($product['name']) ?></p>
                            <p class="mb-1 fs-5 fw-bold">Price: <?= htmlspecialchars($product['price']) ?>$</p>
                            <p class="mb-1 fs-5 fw-bold">Type: <?= htmlspecialchars($product['type']) ?></p>
                            <?php if ($product['type'] == 'Book'): ?>
                                <p class="mb-1 fs-5 fw-bold">Weight: <?= htmlspecialchars($product['weight']) ?>kg</p>
                            <?php elseif ($product['type'] == 'DVD'): ?>
                                <p class="mb-1 fs-5 fw-bold">Size: <?= htmlspecialchars($product['size']) ?>MB</p>
                            <?php elseif ($product['type'] == 'Furniture'): ?>
                                <p class="mb-1 fs-5 fw-bold">Height: <?= htmlspecialchars($product['height']) ?>cm</p>
                                <p class="mb-1 fs-5 fw-bold">Width: <?= htmlspecialchars($product['width']) ?>cm</p>
                                <p class="mb-1 fs-5 fw-bold">Length: <?= htmlspecialchars($product['length']) ?>cm</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>
</div>

</body>
</html>
