<?php

class Database
{
    private static $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $passwordFile = $_SERVER['PASSWORD_FILE_PATH'] ?? '/run/secrets/db-password';
            $password = file_get_contents($passwordFile);
            if ($password === false) {
                throw new Exception("Could not read database password from file: $passwordFile");
            }
            $password = trim($password);

            $host = $_SERVER['DB_HOST'] ?? 'localhost';
            $dbname = $_SERVER['DB_NAME'] ?? 'example';
            $username = $_SERVER['DB_USER'] ?? 'root';

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            try {
                self::$connection = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}