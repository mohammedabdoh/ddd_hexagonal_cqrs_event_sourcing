<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

interface ElasticSearchPostRepository
{
    /**
     * Fetches a Post aggregate index from Elasticsearch by its ID
     * @param string $id
     * @return Post|null
     */
    public function byId(string $id): ?Post;

    /**
     * Fetch all Post aggregates into an iterable array
     * @return array
     */
    public function all(): array;
}
