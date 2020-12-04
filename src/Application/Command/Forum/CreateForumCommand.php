<?php declare(strict_types=1);

namespace App\Application\Command\Forum;

class CreateForumCommand
{
    public function __construct(private string $title, private bool $closed) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getClosed(): bool
    {
        return $this->closed;
    }
}