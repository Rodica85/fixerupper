<?php
require_once 'init.php';
require 'functions.php';
require 'db.php';
$pdo = pdo_connect_mysql();

if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, NOW())");
$stmt->execute([$user_id]);
$order_id = $pdo->lastInsertId();

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$order_id, $product_id, $quantity]);
}

unset($_SESSION['cart']);
?>

<?php template_header('Order Confirmation'); ?>
<div class="container mt-5">
    <h2>Thank you for your order!</h2>
    <p>Your order number is <strong>#<?= $order_id ?></strong>.</p>
    <a href="index.php" class="btn btn-primary">Return to Home</a>
</div>
<?php template_footer(); ?>
