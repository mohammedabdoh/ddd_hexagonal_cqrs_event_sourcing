<?php declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Common\Domain\DomainEvent;

class PostWasDeleted implements DomainEvent
{
    private PostId $postId;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function getVersion(): string
    {
        return '1.0';
    }
}
