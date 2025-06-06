<?php
require_once 'init.php';
// Include the template functions
require_once 'functions.php';
require_once 'db.php';
// Output the header
template_header('Products');
?>
<?php
// Define number of products to show per page
$productsPerPage = 8;

// Connect to the database
$pdo = pdo_connect_mysql();
if (!$pdo) {
    exit('Failed to connect to the database.');
}

// Get the current page number from the query string
$currentPage = filter_input(INPUT_GET, 'page_num', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1]
]);

// Calculate the OFFSET for the SQL LIMIT clause
$offset = ($currentPage - 1) * $productsPerPage;

// Prepare SQL query to fetch products
$sql = 'SELECT * FROM products ORDER BY id DESC LIMIT :offset, :limit';
$stmt = $pdo->prepare($sql);

// Bind parameters
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $productsPerPage, PDO::PARAM_INT);

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Optional: get total number of products for pagination
$totalProducts = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();

$totalPages = ceil($totalProducts / $productsPerPage);
?>

<div class="container mt-4">
    <div class="row">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="img/<?= htmlspecialchars($product['image']) ?>" class="card-img-top product-card-img" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted">$<?= number_format($product['price'], 2) ?></p>
                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary mt-auto">View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p>No products found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Page content ends here -->
<?php if ($totalPages > 1): ?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mt-4">
        <!-- Previous Page -->
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page_num=<?= $currentPage - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <!-- Page Numbers -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?page_num=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next Page -->
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page_num=<?= $currentPage + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?php endif; ?>
<?php
// Output the footer
template_footer();
?>
