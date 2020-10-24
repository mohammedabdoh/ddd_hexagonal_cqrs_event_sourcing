<?php declare(strict_types=1);

namespace App\Application\Representation;

class Post
{
    private string $id;
    private string $title;
    private string $content;

    public function __construct(string $id, string $title, string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}