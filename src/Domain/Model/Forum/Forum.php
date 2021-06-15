<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\EventSourcedAggregateRoot;
use App\Common\Domain\EventStream;

class Forum extends EventSourcedAggregateRoot
{
    private ForumId $forumId;
    private ForumTitle $title;
    private bool $closed;

    private function __construct(ForumId $forumId)
    {
        $this->forumId = $forumId;
    }

    public static function createNewForum(ForumTitle $title, bool $closed): Forum
    {
        $forumId = ForumId::create();
        $forum = new self($forumId);
        $forum->recordApplyAndPublish(new ForumWasCreated($forumId, $title, $closed));

        return $forum;
    }

    public function closeForum(): void
    {
        if($this->closed()) {
            throw new ForumAlreadyClosed($this->forumId());
        }

        $this->recordApplyAndPublish(new ForumStatusWasChanged($this->forumId, true));
    }

    public function openForum(): void
    {
        if(!$this->closed()) {
            throw new ForumAlreadyOpened($this->forumId());
        }

        $this->recordApplyAndPublish(new ForumStatusWasChanged($this->forumId, false));
    }

    public function changeForumTitle(ForumTitle $title): void
    {
        if($this->closed()) {
            throw new ForumAlreadyClosed($this->forumId());
        }
        $this->title = $title;

        $this->recordApplyAndPublish(new ForumTitleWasChanged($this->forumId, $title));
    }

    public function applyForumWasCreated(ForumWasCreated $event): void
    {
        $this->forumId = $event->getForumId();
        $this->title = $event->getTitle();
        $this->closed = $event->getClosed();
    }

    public function applyForumStatusWasChanged(ForumStatusWasChanged $event): void
    {
        $this->closed = $event->getClosed();
    }

    public function applyForumTitleWasChanged(ForumTitleWasChanged $event): void
    {
        $this->title = $event->getTitle();
    }

    public static function reconstitute(EventStream $eventStream): self
    {
        $forum = new static(new ForumId($eventStream->getAggregateId()));
        $forum->replay($eventStream);
        return $forum;
    }

    public function forumId(): ForumId
    {
        return $this->forumId;
    }

    public function title(): ForumTitle
    {
        return $this->title;
    }

    public function closed(): bool
    {
        return $this->closed;
    }
}
