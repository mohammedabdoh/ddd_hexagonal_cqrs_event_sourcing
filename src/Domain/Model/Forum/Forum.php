<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Domain\EventSourcedAggregateRoot;
use App\Domain\EventStream;

class Forum extends EventSourcedAggregateRoot
{
    private ForumId $forumId;
    private string $title;
    private bool $closed;

    private function __construct(ForumId $forumId)
    {
        $this->forumId = $forumId;
    }

    public static function createNewForum(string $title, bool $closed): Forum
    {
        $forumId = ForumId::create();
        $forum = new self($forumId);
        $forum->recordApplyAndPublish(new ForumWasCreated($forumId, $title, $closed));

        return $forum;
    }

    public function applyForumWasCreated(ForumWasCreated $event): void
    {
        $this->forumId = $event->getForumId();
        $this->title = $event->getTitle();
        $this->closed = $event->getClosed();
    }

    public static function reconstitute(EventStream $eventStream): self
    {
        $forum = new static(new ForumId($eventStream->getAggregateId()));
        $forum->replay($eventStream);
        return $forum;
    }

    /**
     * @return ForumId
     */
    public function forumId(): ForumId
    {
        return $this->forumId;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function closed(): bool
    {
        return $this->closed;
    }
}
