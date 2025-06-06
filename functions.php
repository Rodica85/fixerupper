<?php
function template_header($title) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $logged_in = isset($_SESSION['user']);
    $user_name = $logged_in ? htmlspecialchars($_SESSION['user']['name']) : '';
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="style.css" rel="stylesheet" type="text/css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <style>
            html, body{
                height:100%;
                margin:0;
                display: flex;
                flex-direction: column;
            }
            main{
                flex:1;
            }
            </style>
            </head>
        <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand">Fixer Upper</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
    EOT;

    if ($logged_in) {
        echo <<<EOT
                    <li class="nav-item">
                        <span class="nav-link">Hello, $user_name</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
        EOT;
    } else {
        echo <<<EOT
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        EOT;
    }

    echo <<<EOT
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
    EOT;
}

    function template_footer() {
    $year = date('Y');
    echo <<<EOT
        </main>
        <!-- Footer -->
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p class="mb-0">&copy; $year, Fixer Upper Online (RM)</p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    EOT;
}
?>  