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

        if (!$this->databaseService->isAvailable()) {
            echo "<div style='color: red; padding: 10px; border: 1px solid red; margin: 10px 0;'>";
            echo "<strong>Database Not Available</strong><br>";
            echo "The database connection could not be established. This could be because:<br>";
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

        $result = $this->databaseService->testConnection();
        echo "<p><strong>Status:</strong> <span style='color: " . ($result ? 'green' : 'red') . "'>";
        echo ($result ? 'Connected ✓' : 'Failed ✗') . "</span></p>";
        
        if ($result) {
            echo "<h3>Available Tables:</h3>";
            $tables = $this->databaseService->listTables();
            
            if (empty($tables)) {
                echo "<p><em>No tables found. The database is empty.</em></p>";
                echo "<p>You can create a sample table by visiting: <a href='/database/create-sample'>/database/create-sample</a></p>";
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
        
        if (!$this->databaseService->isAvailable()) {
            echo "<p style='color: red;'>Database is not available. Cannot create table.</p>";
            echo "<p><a href='/database'>← Back to Database Test</a></p>";
            return;
        }

        $result = $this->databaseService->createSampleTable();
        
        if ($result) {
            echo "<p style='color: green;'>Sample table created successfully! ✓</p>";
        } else {
            echo "<p style='color: red;'>Failed to create sample table. ✗</p>";
        }
        
        echo "<p><a href='/database'>← Back to Database Test</a></p>";
    }
}