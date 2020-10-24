<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

use Ramsey\Uuid\Uuid;

class PostId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(): self
    {
        return new self((string) Uuid::uuid4());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id();
    }
}
