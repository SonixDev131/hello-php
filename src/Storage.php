<?php

class Storage
{
    public function __construct(private string $filename)
    {
    }

    /**
    * @param array<Message> $data
    */
    public function save(array $data): void
    {
        file_put_contents($this->filename, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
    * @return array<Message>
    */
    public function load(): array
    {
        if (!file_exists($this->filename)) {
            return [];
        }
        $content = file_get_contents($this->filename) ?: "";
        $data = json_decode($content, true);

        // Đảm bảo $data là array
        if (!is_array($data)) {
            $data = [];
        }

        // Convert arrays back to Message objects, filter out invalid entries
        $validMessages = array_filter(
            $data,
            fn ($messageData) =>
            is_array($messageData) &&
            isset($messageData['author']) &&
            isset($messageData['content']) &&
            is_string($messageData['author']) &&
            is_string($messageData['content']) &&
            !empty($messageData['author']) &&
            !empty($messageData['content'])
        );

        return array_map(
            fn ($messageData) =>
            new Message($messageData['author'], $messageData['content']),
            $validMessages
        );
    }
}
