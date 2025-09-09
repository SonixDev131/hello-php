<?php
/**
 * Public entry point for the application
 * All requests are routed through this file
 */

// Define paths
define('ROOT_PATH', dirname(__DIR__));
const SRC_PATH = ROOT_PATH.'/src';
const STORAGE_PATH = ROOT_PATH.'/storage';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simple router
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove any trailing slash and query parameters
$path = rtrim($path, '/') ?: '/';

// Route requests
switch ($path) {
    case '/':
        require_once SRC_PATH.'/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case '/hello':
        require_once SRC_PATH.'/Controllers/HelloController.php';
        $controller = new HelloController();
        $controller->hello();
        break;

    case '/database':
        require_once SRC_PATH.'/Controllers/DatabaseController.php';
        $controller = new DatabaseController();
        $controller->test();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}