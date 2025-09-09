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
        echo "</ul>";
    }
}