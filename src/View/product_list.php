<!-- src/View/product_list.php -->
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

<div class="container">
    <div class="d-flex justify-content-between my-4 border-bottom border-black">
        <h1>Product List</h1>
        <div>
            <a class="btn btn-primary" href="/add-product">Add Product</a>
            <button class="btn btn-danger" id="delete-product-btn" onclick="document.getElementById('delete-form').submit();">Mass Delete</button>
        </div>
    </div>
    <form id="delete-form" method="post" action="/mass-delete">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <input type="checkbox" class="delete-checkbox" name="product_ids[]" value="<?= htmlspecialchars($product['id']) ?>">
                            <p>SKU : <?= htmlspecialchars($product['sku']) ?></p>
                            <p>Name : <?= htmlspecialchars($product['name']) ?></p>
                            <p>Price : <?= htmlspecialchars($product['price']) ?>$</p>
                            <?php if ($product['type'] == 'Book'): ?>
                                <p>Weight: <?= htmlspecialchars($product['weight']) ?>kg</p>
                            <?php elseif ($product['type'] == 'DVD'): ?>
                                <p>Size: <?= htmlspecialchars($product['size']) ?>MB</p>
                            <?php elseif ($product['type'] == 'Furniture'): ?>
                                <p>Height: <?= htmlspecialchars($product['height']) ?>cm</p>
                                <p>Width: <?= htmlspecialchars($product['width']) ?>cm</p>
                                <p>Length: <?= htmlspecialchars($product['length']) ?>cm</p>
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