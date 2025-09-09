<?php

class Storage
{
    public function __construct(private string $filename)
    {
    }

    public function save(array $data): void
    {
        file_put_contents($this->filename, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function load(): array
    {
        if (!file_exists($this->filename)) {
            return [];
        }
        $content = file_get_contents($this->filename);
        $data = json_decode($content, true) ?: [];

        // Convert arrays back to Message objects, filter out invalid entries
        $validMessages = array_filter($data, function ($messageData) {
            return is_array($messageData) &&
                isset($messageData['author']) &&
                isset($messageData['content']) &&
                !empty($messageData['author']) &&
                !empty($messageData['content']);
        });

        return array_map(function ($messageData) {
            // Set the original creation date if it exists
            return new Message($messageData['author'], $messageData['content']);
        }, $validMessages);
    }
}