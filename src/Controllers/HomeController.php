<?php

class HomeController
{
    public function index()
    {
        echo "<h1>Welcome to PHP Docker Sample</h1>";
        echo "<p>Available routes:</p>";
        echo "<ul>";
        echo "<li><a href='/hello'>Hello World</a></li>";
        echo "<li><a href='/database'>Database Test</a></li>";
        echo "<li><a href='/database/create-sample'>Create Sample Table</a></li>";
        echo "<li><a href='/messages'><strong>Messages Demo</strong> (Working Database Code)</a></li>";
        echo "</ul>";
        
        echo "<h2>Project Structure</h2>";
        echo "<p>This project follows modern PHP conventions:</p>";
        echo "<ul>";
        echo "<li><strong>public/</strong> - Web root with index.php router</li>";
        echo "<li><strong>src/</strong> - Application source code</li>";
        echo "<li><strong>storage/</strong> - File uploads and logs</li>";
        echo "<li><strong>tests/</strong> - PHPUnit tests</li>";
        echo "</ul>";
    }
}