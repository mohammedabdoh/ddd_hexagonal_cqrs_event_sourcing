<?php declare(strict_types=1);

namespace App\Application\Command\Forum;

class CreateForumCommand
{
    private string $title;
    private bool $closed;

    public function __construct(string $title, bool $closed)
    {
        $this->title = $title;
        $this->closed = $closed;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getClosed(): bool
    {
        return $this->closed;
    }
}