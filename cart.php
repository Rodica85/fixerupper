<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'db.php';

$pdo = pdo_connect_mysql();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'], $_GET['quantity'])) {
    $productId = (int) $_GET['id'];
    $quantity = max(1, (int) $_GET['quantity']);

    // If already in cart, increase quantity
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    header('Location: cart.php');
    exit;
}
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $productId = (int) $_GET['id'];
    unset($_SESSION['cart'][$productId]);
    header('Location: cart.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $id = (int) $id;
        $qty = (int) $qty;
        if ($qty > 0) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
    header('Location: cart.php');
    exit;
}

?>
<?php template_header('Shopping Cart'); ?>
<div class="container mt-5">
    <h2>Your Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form action="cart.php" method="post">
            <input type="hidden" name="update_cart" value="1">
            <table class="table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
                    $stmt->execute(array_keys($_SESSION['cart']));
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($products as $product):
                        $qty = $_SESSION['cart'][$product['id']];
                        $subtotal = $product['price'] * $qty;
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td>
                                <input type="number" name="quantities[<?= $product['id'] ?>]" value="<?= $qty ?>" min="1" class="form-control w-50">
                            </td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td>
                                <a href="cart.php?action=remove&id=<?= $product['id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h4>Total: $<?= number_format($total, 2) ?></h4>
                <div>
                    <button type="submit" class="btn btn-primary">Update Cart</button>
                    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>
<?php template_footer(); ?>
