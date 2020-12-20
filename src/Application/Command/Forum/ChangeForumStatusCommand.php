<?php declare(strict_types=1);

namespace App\Application\Command\Forum;

class ChangeForumStatusCommand
{
    private string $forumId;
    private bool $closed;

    public function __construct(string $forumId, bool $closed)
    {
        $this->forumId = $forumId;
        $this->closed = $closed;
    }

    public function getForumId(): string
    {
        return $this->forumId;
    }

    public function getClosed(): bool
    {
        return $this->closed;
    }
}