<?php
require_once 'init.php';
require 'functions.php';

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

if (!isset($_SESSION['user'])) {
    
    template_header('Login Required');

    echo '<div class="container mt-5">';
    echo '<p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to proceed with your order.</p>';
    echo '</div>';
    template_footer();
} else {
    header("Location: confirm_order.php");
    exit;
}
