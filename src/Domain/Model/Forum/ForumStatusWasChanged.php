<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\DomainEvent;

class ForumStatusWasChanged implements DomainEvent
{
    private ForumId $forumId;
    private bool $closed;

    public function __construct(ForumId $forumId, bool $closed)
    {
        $this->forumId = $forumId;
        $this->closed = $closed;
    }

    public function getForumId(): ForumId
    {
        return $this->forumId;
    }

    public function getClosed(): bool
    {
        return $this->closed;
    }

    public function getVersion(): string
    {
        return '1.0';
    }
}
