<?php
/**
 * PHPUnit bootstrap file
 * This file is loaded before running tests
 */

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('STORAGE_PATH', ROOT_PATH . '/storage');

// Autoload Composer dependencies
require_once ROOT_PATH . '/vendor/autoload.php';

// Set error reporting for tests
error_reporting(E_ALL);
ini_set('display_errors', 1);