<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

use Ramsey\Uuid\Uuid;

class ForumId
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

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getId();
    }
}
