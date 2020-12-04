<?php declare(strict_types=1);

namespace App\Application\Command\Forum;

class ChangeForumStatusCommand
{
    public function __construct(private string $forumId, private bool $closed) {}

    public function getForumId(): string
    {
        return $this->forumId;
    }

    public function getClosed(): bool
    {
        return $this->closed;
    }
}