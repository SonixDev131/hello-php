<?php

use PHPUnit\Framework\TestCase;

// Define paths for testing
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH.'/src');
define('STORAGE_PATH', ROOT_PATH.'/storage');

class HelloWorldTest extends TestCase
{
    public function testHelloController()
    {
        require_once SRC_PATH.'/Controllers/HelloController.php';

        $controller = new HelloController();

        // Capture the output
        ob_start();
        $controller->hello();
        $output = ob_get_clean();

        // Assert that the output is "Hello, Docker!"
        $this->assertEquals("Hello, Docker!", $output);
    }
}
