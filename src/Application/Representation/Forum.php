<?php declare(strict_types=1);

namespace App\Application\Representation;

class Forum
{
    private string $id;
    private string $title;
    private bool $closed;

    public function __construct(string $id, string $title, bool $closed)
    {
        $this->id = $id;
        $this->title = $title;
        $this->closed = $closed;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isClosed(): bool
    {
        return $this->closed;
    }
}