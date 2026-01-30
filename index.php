<?php
require 'vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\ProductController;

$page = $_GET['page'] ?? 'home';

if ($page === 'home') {
    $controller = new HomeController();
    $controller->index();
} elseif ($page === 'products') {
    $controller = new ProductController();
    $controller->index();
} else {
    echo '404 - Khong tim thay trang';
}
