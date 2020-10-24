<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

interface ElasticSearchPostRepository
{
    public function all(): array;
}
