<?php declare(strict_types=1);

namespace App\Application\Command\Forum;

class ChangeForumTitleCommand
{
    private string $forumId;
    private string $title;

    public function __construct(string $forumId, string $title)
    {
        $this->forumId = $forumId;
        $this->title = $title;
    }

    public function getForumId(): string
    {
        return $this->forumId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}