<?php
namespace App\Models;

use PDOException;

class Product extends BaseModel
{
    public function getAllProducts(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM products');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
