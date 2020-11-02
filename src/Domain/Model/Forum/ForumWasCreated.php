<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Domain\DomainEvent;

class ForumWasCreated implements DomainEvent
{
    private ForumId $forumId;
    private string $title;
    private bool $closed;

    public function __construct(ForumId $forumId, string $title, bool $closed)
    {
        $this->forumId = $forumId;
        $this->title = $title;
        $this->closed = $closed;
    }

    /**
     * @return ForumId
     */
    public function getForumId(): ForumId
    {
        return $this->forumId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
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
