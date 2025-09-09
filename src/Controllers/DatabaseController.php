<?php

require_once SRC_PATH . '/Services/DatabaseService.php';

class DatabaseController
{
    private $databaseService;

    public function __construct()
    {
        $this->databaseService = new DatabaseService();
    }

    public function test()
    {
        try {
            $result = $this->databaseService->testConnection();
            echo "<h2>Database Connection Test</h2>";
            echo "<p>Status: " . ($result ? 'Connected' : 'Failed') . "</p>";
            
            if ($result) {
                $tables = $this->databaseService->listTables();
                echo "<h3>Available Tables:</h3>";
                echo "<ul>";
                foreach ($tables as $table) {
                    echo "<li>" . htmlspecialchars($table) . "</li>";
                }
                echo "</ul>";
            }
        } catch (Exception $e) {
            echo "<h2>Database Error</h2>";
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}