<?php
/**
 * Public entry point for the application
 * All requests are routed through this file
 */

// Define paths
define("ROOT_PATH", dirname(__DIR__));
const SRC_PATH = ROOT_PATH . '/src';
const STORAGE_PATH = ROOT_PATH . '/storage';

require_once SRC_PATH . '/GuestBook.php';
require_once SRC_PATH . '/Message.php';
require_once SRC_PATH . '/Storage.php';

$guestBook = new GuestBook(new Storage(STORAGE_PATH . '/messages.json'));
$msg = new Message('Admin', 'Welcome to the guest book!');
$guestBook->addMessage($msg);

// Display all messages
foreach ($guestBook->loadFromFile() as $message) {
    $data = $message->toArray();
    echo "[{$data['createdAt']}] {$data['author']}: {$data['content']}\n";
}