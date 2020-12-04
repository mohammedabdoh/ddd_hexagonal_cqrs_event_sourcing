<?php declare(strict_types=1);

namespace App\Application\Query\Post;

class PostQuery
{
    public function __construct(private string $id) {}

    public function getId(): string
    {
        return $this->id;
    }
}