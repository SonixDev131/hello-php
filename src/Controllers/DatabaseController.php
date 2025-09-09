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
        echo "<h2>Database Connection Test</h2>";
        
        $connectionInfo = $this->databaseService->getConnectionInfo();
        
        echo "<h3>Connection Configuration:</h3>";
        echo "<ul>";
        echo "<li><strong>Host:</strong> " . htmlspecialchars($connectionInfo['host']) . "</li>";
        echo "<li><strong>Database:</strong> " . htmlspecialchars($connectionInfo['database']) . "</li>";
        echo "<li><strong>User:</strong> " . htmlspecialchars($connectionInfo['user']) . "</li>";
        echo "<li><strong>Password File:</strong> " . htmlspecialchars($connectionInfo['password_file']) . "</li>";
        echo "<li><strong>Password File Exists:</strong> " . (file_exists($connectionInfo['password_file']) ? 'Yes' : 'No') . "</li>";
        echo "</ul>";

        try {
            $result = $this->databaseService->testConnection();
            echo "<p><strong>Status:</strong> <span style='color: " . ($result ? 'green' : 'red') . "'>";
            echo ($result ? 'Connected ✓' : 'Failed ✗') . "</span></p>";
        } catch (Exception $e) {
            echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>";
            echo "<strong>Database Connection Error</strong><br>";
            echo "Error: " . htmlspecialchars($e->getMessage()) . "<br><br>";
            echo "This could be because:<br>";
            echo "<ul>";
            echo "<li>The database service is not running or not ready</li>";
            echo "<li>The password file is missing or unreadable</li>";
            echo "<li>The connection parameters are incorrect</li>";
            echo "<li>Network connectivity issues</li>";
            echo "</ul>";
            echo "<p><strong>Tip:</strong> Make sure to run <code>docker compose up -d</code> to start all services.</p>";
            echo "</div>";
            return;
        }
        
        if ($result) {
            echo "<h3>Available Tables:</h3>";
            $tables = $this->databaseService->listTables();
            
            if (empty($tables)) {
                echo "<p><em>No tables found. The database is empty.</em></p>";
                echo "<p>Try the working example: <a href='/messages'><strong>Messages Demo</strong></a></p>";
                echo "<p>Or create a sample table: <a href='/database/create-sample'>Create Sample Table</a></p>";
            } else {
                echo "<ul>";
                foreach ($tables as $table) {
                    echo "<li>" . htmlspecialchars($table) . "</li>";
                }
                echo "</ul>";
            }
        }
    }

    public function createSample()
    {
        echo "<h2>Create Sample Table</h2>";
        
        try {
            $result = $this->databaseService->createSampleTable();
            
            if ($result) {
                echo "<p style='color: green;'>Sample table created successfully! ✓</p>";
            } else {
                echo "<p style='color: red;'>Failed to create sample table. ✗</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error creating sample table: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        echo "<p><a href='/database'>← Back to Database Test</a></p>";
    }
}