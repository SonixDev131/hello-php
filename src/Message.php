<?php

class Message
{
    private string $author;
    private string $content;
    private \DateTime $createdAt;

    public function __construct(string $author, string $content)
    {
        $this->author = $author;
        $this->content = $content;
        $this->createdAt = new \DateTime();
    }


    /**
    * @return array<string,string>
    */
    public function toArray(): array
    {
        return [
            'author' => $this->author,
            'content' => $this->content,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }

}
