<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'db.php';
$pdo = pdo_connect_mysql();

// Validate and sanitize the product ID from the URL
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$productId) {
    exit('Product ID is invalid or not specified.');
}

// Fetch product from database
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->bindValue(':id', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// If product not found
if (!$product) {
    exit('Product does not exist!');
}

template_header($product['name']);
?>

<div class="container mt-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="img/<?= htmlspecialchars($product['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-muted">$<?= number_format($product['price'], 2) ?></p>
            <p><?= htmlspecialchars($product['description']) ?></p>

            <!-- Add to Cart Form -->
            <form action="cart.php" method="get" class="mt-4">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control w-25" value="1" min="1" max="99" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>

<?php template_footer(); ?>
