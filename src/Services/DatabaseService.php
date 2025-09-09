<?php

require_once SRC_PATH . '/Config/Database.php';

class DatabaseService
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function testConnection(): bool
    {
        try {
            $stmt = $this->pdo->query('SELECT 1');
            return $stmt !== false;
        } catch (PDOException $e) {
            error_log("Database connection test failed: " . $e->getMessage());
            return false;
        }
    }

    public function listTables(): array
    {
        try {
            $stmt = $this->pdo->query('SHOW TABLES');
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Failed to list tables: " . $e->getMessage());
            return [];
        }
    }

    public function createSampleTable(): bool
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS sample_table (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            $this->pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            error_log("Failed to create sample table: " . $e->getMessage());
            return false;
        }
    }
}