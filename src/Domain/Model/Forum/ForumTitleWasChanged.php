<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\DomainEvent;

class ForumTitleWasChanged implements DomainEvent
{
    private ForumId $forumId;
    private ForumTitle $title;

    public function __construct(ForumId $forumId, ForumTitle $title)
    {
        $this->forumId = $forumId;
        $this->title = $title;
    }

    public function getForumId(): ForumId
    {
        return $this->forumId;
    }

    public function getTitle(): ForumTitle
    {
        return $this->title;
    }

    public function getVersion(): string
    {
        return '1.0';
    }
}
