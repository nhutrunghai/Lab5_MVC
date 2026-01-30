<?php
namespace App\Models;

use PDO;
use PDOException;

class BaseModel
{
    protected $pdo;

    public function __construct()
    {
        $dbHost = 'localhost';
        $dbName = 'buoi2_php';
        $dbUser = 'root';
        $dbPass = '';

        $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo 'He thong dang bao tri, vui long quay lai sau';
            exit;
        }
    }
}
