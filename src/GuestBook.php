<?php

class GuestBook
{
    public function __construct(private Storage $storage)
    {
    }

    public function addMessage(Message $message): void
    {
        $messages = $this->loadFromFile();
        $messages[] = $message->toArray();
        $this->storage->save($messages);
    }

    /**
     * @return array<Message>
     */
    public function loadFromFile(): array
    {
        return $this->storage->load();
    }
}
