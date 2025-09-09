<?php

require_once SRC_PATH . '/Services/MessagesService.php';

class MessagesController
{
    private $messagesService;

    public function __construct()
    {
        $this->messagesService = new MessagesService();
    }

    public function index()
    {
        echo "<h2>Messages Demo</h2>";
        echo "<p>This demonstrates the working database connection code integrated into the template structure.</p>";
        
        // Create a new message
        $this->messagesService->createMessage();
        
        // Get message count
        $count = $this->messagesService->getMessageCount();
        echo "<p><strong>Total messages:</strong> $count</p>";
        
        // Get all messages and display them
        $messages = $this->messagesService->getAllMessages();
        
        echo "<h3>All Messages:</h3>";
        if (empty($messages)) {
            echo "<p><em>No messages found.</em></p>";
        } else {
            echo "<div style='font-family: monospace; background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
            foreach ($messages as $row) {
                echo htmlspecialchars($row['id']) . " " . htmlspecialchars($row['message']) . "<br>";
            }
            echo "</div>";
        }
        
        echo "<p style='margin-top: 20px;'>";
        echo "<a href='/messages/clear'>Clear All Messages</a> | ";
        echo "<a href='/'>← Back to Home</a>";
        echo "</p>";
    }

    public function clear()
    {
        $this->messagesService->clearMessages();
        
        echo "<h2>Messages Cleared</h2>";
        echo "<p>All messages have been deleted from the database.</p>";
        echo "<p><a href='/messages'>← Back to Messages</a></p>";
    }
}