<?php

class Database
{
    private static $connection = null;
    private static $connectionAttempts = 0;
    private static $maxAttempts = 5;

    public static function getConnection(): ?PDO
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    private static function createConnection(): ?PDO
    {
        $passwordFile = $_SERVER['PASSWORD_FILE_PATH'] ?? '/run/secrets/db-password';
        $host = $_SERVER['DB_HOST'] ?? 'localhost';
        $dbname = $_SERVER['DB_NAME'] ?? 'example';
        $username = $_SERVER['DB_USER'] ?? 'root';

        // Try to read password file
        if (!file_exists($passwordFile)) {
            error_log("Database password file not found: $passwordFile");
            return null;
        }

        $password = file_get_contents($passwordFile);
        if ($password === false) {
            error_log("Could not read database password from file: $passwordFile");
            return null;
        }
        $password = trim($password);

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        // Retry connection with backoff
        while (self::$connectionAttempts < self::$maxAttempts) {
            try {
                self::$connectionAttempts++;
                
                $connection = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT => 5,
                ]);

                // Test the connection
                $connection->query('SELECT 1');
                
                error_log("Database connected successfully after " . self::$connectionAttempts . " attempts");
                return $connection;

            } catch (PDOException $e) {
                error_log("Database connection attempt " . self::$connectionAttempts . " failed: " . $e->getMessage());
                
                if (self::$connectionAttempts >= self::$maxAttempts) {
                    error_log("Max database connection attempts reached");
                    break;
                }
                
                // Wait before retry (exponential backoff)
                $waitTime = pow(2, self::$connectionAttempts - 1);
                sleep($waitTime);
            }
        }

        return null;
    }

    public static function isConnected(): bool
    {
        return self::$connection !== null;
    }

    public static function resetConnection(): void
    {
        self::$connection = null;
        self::$connectionAttempts = 0;
    }
}