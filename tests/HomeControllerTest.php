<?php

use PHPUnit\Framework\TestCase;

// Define paths for testing
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('STORAGE_PATH', ROOT_PATH . '/storage');

class HomeControllerTest extends TestCase
{
    public function testHomeControllerIndex()
    {
        require_once SRC_PATH . '/Controllers/HomeController.php';
        
        $controller = new HomeController();
        
        // Capture the output
        ob_start();
        $controller->index();
        $output = ob_get_clean();
        
        // Assert that the output contains expected content
        $this->assertStringContains('Welcome to PHP Docker Sample', $output);
        $this->assertStringContains('Available routes:', $output);
        $this->assertStringContains('/hello', $output);
        $this->assertStringContains('/database', $output);
    }
}