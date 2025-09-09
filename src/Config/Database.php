<?php

class Database
{
    private static $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    private static function createConnection(): PDO
    {
        // Read the database connection parameters from environment variables
        $db_host = getenv('DB_HOST');
        $db_name = getenv('DB_NAME');
        $db_user = getenv('DB_USER');
        
        // Read the password file path from an environment variable
        $password_file_path = getenv('PASSWORD_FILE_PATH');
        
        // Read the password from the file
        $db_pass = trim(file_get_contents($password_file_path));
        
        // Create a new PDO instance
        $db_handle = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        
        // Set PDO attributes
        $db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db_handle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $db_handle;
    }

    public static function isConnected(): bool
    {
        return self::$connection !== null;
    }

    public static function resetConnection(): void
    {
        self::$connection = null;
    }
}