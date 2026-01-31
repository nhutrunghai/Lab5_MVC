<?php
namespace App\Models;

use PDOException;

class Product extends BaseModel
{
    public function all(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM products');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
            $stmt->execute([$id]);
            $product = $stmt->fetch();
            return $product ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function deleteById(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = ?');
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insert(array $data): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO products (name, avatar, price, description) VALUES (?, ?, ?, ?)'
            );
            return $stmt->execute([
                $data['name'],
                $data['avatar'],
                $data['price'],
                $data['description'],
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE products SET name = ?, avatar = ?, price = ?, description = ? WHERE id = ?'
            );
            return $stmt->execute([
                $data['name'],
                $data['avatar'],
                $data['price'],
                $data['description'],
                $id,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
