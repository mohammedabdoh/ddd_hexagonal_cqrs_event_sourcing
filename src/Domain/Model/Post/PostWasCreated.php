<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Domain\DomainEvent;

class PostWasCreated implements DomainEvent
{
    private PostId $postId;
    private string $title;
    private string $content;
    
    public function __construct(PostId $postId, string $title, string $content)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->content = $content;
    }
    
    public function content(): string
    {
        return $this->content;
    }

    public function postId(): string
    {
        return $this->postId->id();
    }

    public function title(): string
    {
        return $this->title;
    } 
}
