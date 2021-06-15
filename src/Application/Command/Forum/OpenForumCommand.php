<?php declare(strict_types=1);

namespace App\Application\Command\Forum;

class OpenForumCommand
{
    private string $forumId;

    public function __construct(string $forumId)
    {
        $this->forumId = $forumId;
    }

    public function getForumId(): string
    {
        return $this->forumId;
    }
}