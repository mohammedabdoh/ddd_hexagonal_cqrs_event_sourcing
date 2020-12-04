<?php

declare(strict_types=1);

namespace App\Application\Query\Forum;

class ForumQuery
{
    public function __construct(private string $id) {}

    public function getId(): string
    {
        return $this->id;
    }
}
