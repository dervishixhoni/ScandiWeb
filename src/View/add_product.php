<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link href="/css/styles.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between my-4 border-3 border-black border-bottom">
        <h1>Add Product</h1>
        <div>
            <button class="btn btn-primary" type="submit" form="product_form">Save</button>
            <a class="btn btn-danger" href="/">Cancel</a>
        </div>
    </div>
    <form id="product_form" method="POST" class="">
        <div class="mb-3">
            <label for="sku" class="form-label">SKU:</label>
            <input type="text" class="form-control w-auto" id="sku" name="sku" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control w-auto" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="text" class="form-control w-auto" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="productType" class="form-label">Type:</label>
            <select class="form-select w-auto" id="productType" name="type" required>
                <option value="">Select Type</option>
                <option value="Book">Book</option>
                <option value="DVD">DVD</option>
                <option value="Furniture">Furniture</option>
            </select>
        </div>
        <div class="mb-3 d-none" id="weight-field">
            <label for="weight" class="form-label">Weight (Kg):</label>
            <input type="text" class="form-control w-auto" id="weight" name="weight">
            <label for="weight" class="form-label">Please provide weight in Kg</label>
        </div>
        <div class="mb-3 d-none" id="size-field">
            <label for="size" class="form-label">Size (MB):</label>
            <input type="text" class="form-control w-auto" id="size" name="size">
            <label for="size" class="form-label">Please provide size in Megabytes</label>
        </div>
        <div class="mb-3 d-none" id="height-field">
            <label for="height" class="form-label">Height (cm):</label>
            <input type="text" class="form-control w-auto" id="height" name="height">
        </div>
        <div class="mb-3 d-none" id="width-field">
            <label for="width" class="form-label">Width (cm):</label>
            <input type="text" class="form-control w-auto" id="width" name="width">
        </div>
        <div class="mb-3 d-none" id="length-field">
            <label for="length" class="form-label">Length (cm):</label>
            <input type="text" class="form-control w-auto" id="length" name="length">
            <label for="length" class="form-label">Please provide dimensions in HxWxL format</label>
        </div>
    </form>
</div>
<div id="notification" class="notification"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('productType');
        const weightField = document.getElementById('weight-field');
        const sizeField = document.getElementById('size-field');
        const heightField = document.getElementById('height-field');
        const widthField = document.getElementById('width-field');
        const lengthField = document.getElementById('length-field');

        function updateFields() {
            const type = typeSelect.value;
            switch (type) {
                case 'Book':
                    weightField.classList.remove('d-none');
                    sizeField.classList.add('d-none');
                    heightField.classList.add('d-none');
                    widthField.classList.add('d-none');
                    lengthField.classList.add('d-none');
                    break;
                case 'DVD':
                    sizeField.classList.remove('d-none');
                    weightField.classList.add('d-none');
                    heightField.classList.add('d-none');
                    widthField.classList.add('d-none');
                    lengthField.classList.add('d-none');
                    break;
                case 'Furniture':
                    heightField.classList.remove('d-none');
                    widthField.classList.remove('d-none');
                    lengthField.classList.remove('d-none');
                    weightField.classList.add('d-none');
                    sizeField.classList.add('d-none');
                    break;
                default:
                    weightField.classList.add('d-none');
                    sizeField.classList.add('d-none');
                    heightField.classList.add('d-none');
                    widthField.classList.add('d-none');
                    lengthField.classList.add('d-none');
                    break;
            }
        }

        typeSelect.addEventListener('change', updateFields);
        updateFields();
    });
    document.getElementById('product_form').addEventListener('submit', function (event) {
        event.preventDefault();
        const form = event.target;
        const data = new FormData(form);
        fetch('/add-product.php', {
            method: 'POST',
            body: data
        })
            .then(response => response.json())
            .then(data => {
                if (data.success === undefined) {
                    showNotification(data.error);
                } else {
                    console.log(data.success);
                    window.location.href = '/';
                }
            });
    });

    function showNotification(message) {

        const notification = document.getElementById('notification');
        message.forEach(msg => {
            const p = document.createElement('p');
            p.textContent = msg;
            notification.appendChild(p);
        });
        notification.classList.add('show');

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.textContent = '';
            }, 500);
        }, 5000);
    }
</script>
</body>
</html>