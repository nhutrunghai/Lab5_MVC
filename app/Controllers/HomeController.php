<?php
namespace App\Controllers;

use App\Models\Student;
use App\Models\Product;

class HomeController
{
    public function index(): void
    {
        $studentInfo = (new Student())->getInfo();
        $products = (new Product())->getAllProducts();

        include __DIR__ . '/../../views/home.php';
    }
}
