<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

interface ElasticSearchPostRepository
{
    public function byId(string $id): ?Post;
    public function all(): array;
}
