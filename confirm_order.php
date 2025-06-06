<?php
require_once 'init.php';
require 'functions.php';
require 'db.php';
$pdo = pdo_connect_mysql();
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

template_header('Checkout Confirmation');

$cart = $_SESSION['cart'];

// Prepare placeholders for IN query
$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($cart));
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
?>

<div class="container mt-5">
    <h2>Order Confirmation</h2>
    <p>Please review your order before confirming.</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): 
                $qty = $cart[$product['id']];
                $subtotal = $qty * $product['price'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= $qty ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>$<?= number_format($total, 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <form method="post" action="process_order.php">
        <button type="submit" class="btn btn-success">Confirm Order</button>
        <a href="cart.php" class="btn btn-secondary">Edit Cart</a>
    </form>
</div>

<?php template_footer(); ?>
