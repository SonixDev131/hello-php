<?php

use PHPUnit\Framework\TestCase;

// Define paths for testing
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('STORAGE_PATH', ROOT_PATH . '/storage');

class MessagesControllerTest extends TestCase
{
    public function testMessagesControllerExists()
    {
        require_once SRC_PATH . '/Controllers/MessagesController.php';
        
        $this->assertTrue(class_exists('MessagesController'), 'MessagesController class should exist');
        
        // Test that controller has required methods
        $reflectionClass = new ReflectionClass('MessagesController');
        $this->assertTrue($reflectionClass->hasMethod('index'), 'MessagesController should have index method');
        $this->assertTrue($reflectionClass->hasMethod('clear'), 'MessagesController should have clear method');
    }
}