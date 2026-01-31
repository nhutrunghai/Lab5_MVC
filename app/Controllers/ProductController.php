<?php
namespace App\Controllers;

use App\Models\Product;

class ProductController
{
    public function index(): void
    {
        $this->list();
    }

    public function list(): void
    {
        $products = (new Product())->all();
        include __DIR__ . '/../../views/product_list.php';
    }

    public function detail(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = null;
        if ($id > 0) {
            $product = (new Product())->findById($id);
        }

        include __DIR__ . '/../../views/product_detail.php';
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            (new Product())->deleteById($id);
        }

        header('Location: index.php?page=product-list&status=deleted');
        exit;
    }

    public function create(): void
    {
        $errors = [];
        $old = [
            'name' => '',
            'price' => '',
            'description' => '',
            'avatar' => '',
        ];

        include __DIR__ . '/../../views/product-add.php';
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $avatar = trim($_POST['avatar'] ?? '');

        $errors = [];
        if ($name === '') {
            $errors[] = 'Vui long nhap ten san pham.';
        }
        if ($avatar === '') {
            $errors[] = 'Vui long nhap duong dan anh (avatar).';
        }
        if ($price === '') {
            $errors[] = 'Vui long nhap gia san pham.';
        } elseif (!is_numeric($price)) {
            $errors[] = 'Gia san pham phai la so.';
        }

        $old = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'avatar' => $avatar,
        ];

        if (!empty($errors)) {
            include __DIR__ . '/../../views/product-add.php';
            return;
        }

        $created = (new Product())->insert([
            'name' => $name,
            'avatar' => $avatar,
            'price' => (float)$price,
            'description' => $description,
        ]);

        if ($created) {
            header('Location: index.php?page=product-list&status=added');
            exit;
        }

        $errors[] = 'Them san pham that bai. Vui long thu lai.';
        include __DIR__ . '/../../views/product-add.php';
    }

    public function edit(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = null;
        if ($id > 0) {
            $product = (new Product())->findById($id);
        }

        if (!$product) {
            header('Location: index.php?page=product-list');
            exit;
        }

        $errors = [];
        $old = [
            'id' => $product['id'] ?? $id,
            'name' => $product['name'] ?? '',
            'price' => $product['price'] ?? '',
            'description' => $product['description'] ?? '',
            'avatar' => $product['avatar'] ?? '',
        ];

        include __DIR__ . '/../../views/product-edit.php';
    }

    public function update(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $avatar = trim($_POST['avatar'] ?? '');

        $errors = [];
        if ($id <= 0) {
            $errors[] = 'Khong tim thay san pham can cap nhat.';
        }
        if ($name === '') {
            $errors[] = 'Vui long nhap ten san pham.';
        }
        if ($avatar === '') {
            $errors[] = 'Vui long nhap duong dan anh (avatar).';
        }
        if ($price === '') {
            $errors[] = 'Vui long nhap gia san pham.';
        } elseif (!is_numeric($price)) {
            $errors[] = 'Gia san pham phai la so.';
        }

        $old = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'avatar' => $avatar,
        ];

        if (!empty($errors)) {
            include __DIR__ . '/../../views/product-edit.php';
            return;
        }

        $updated = (new Product())->update($id, [
            'name' => $name,
            'avatar' => $avatar,
            'price' => (float)$price,
            'description' => $description,
        ]);

        if ($updated) {
            header('Location: index.php?page=product-list&status=updated');
            exit;
        }

        $errors[] = 'Cap nhat san pham that bai. Vui long thu lai.';
        include __DIR__ . '/../../views/product-edit.php';
    }
}
