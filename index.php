<?php
require 'vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\ProductController;

$page = $_GET['page'] ?? 'home';

if ($page === 'home') {
    $controller = new HomeController();
    $controller->index();
} elseif ($page === 'products' || $page === 'product-list') {
    $controller = new ProductController();
    $controller->list();
} elseif ($page === 'product-detail') {
    $controller = new ProductController();
    $controller->detail();
} elseif ($page === 'product-delete') {
    $controller = new ProductController();
    $controller->delete();
} elseif ($page === 'product-add') {
    $controller = new ProductController();
    $controller->create();
} elseif ($page === 'product-store') {
    $controller = new ProductController();
    $controller->store();
} elseif ($page === 'product-edit') {
    $controller = new ProductController();
    $controller->edit();
} elseif ($page === 'product-update') {
    $controller = new ProductController();
    $controller->update();
} else {
    echo '404 - Khong tim thay trang';
}
