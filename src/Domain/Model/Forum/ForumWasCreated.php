<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\DomainEvent;

class ForumWasCreated implements DomainEvent
{
    private ForumId $forumId;
    private ForumTitle $title;
    private bool $closed;

    public function __construct(ForumId $forumId, ForumTitle $title, bool $closed)
    {
        $this->forumId = $forumId;
        $this->title = $title;
        $this->closed = $closed;
    }

    public function getForumId(): ForumId
    {
        return $this->forumId;
    }

    public function getTitle(): ForumTitle
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function getClosed(): bool
    {
        return $this->closed;
    }

    public function getVersion(): string
    {
        return '1.0';
    }
}
