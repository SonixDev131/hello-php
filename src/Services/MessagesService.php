<?php

require_once SRC_PATH . '/Config/Database.php';

class MessagesService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->initializeTable();
    }

    private function initializeTable(): void
    {
        // Create the "messages" table if it doesn't exist
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                message VARCHAR(255) NOT NULL
            )
        ");
    }

    public function createMessage(): void
    {
        // Create message
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM messages");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        
        $this->db->exec("
            INSERT INTO messages (message)
            SELECT CONCAT('message-', '$count')
            WHERE NOT EXISTS (
                SELECT 1 FROM messages WHERE message = CONCAT('message-', '$count')
            )
        ");
    }

    public function getAllMessages(): array
    {
        // Retrieve all records from the "messages" table
        $stmt = $this->db->query("SELECT * FROM messages");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageCount(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM messages");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['count'];
    }

    public function clearMessages(): void
    {
        $this->db->exec("DELETE FROM messages");
    }
}