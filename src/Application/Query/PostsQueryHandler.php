<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\Representation\AllPosts;
use App\Domain\Model\Post\ElasticSearchPostRepository;

class PostsQueryHandler
{
    private ElasticSearchPostRepository $repository;

    public function __construct(ElasticSearchPostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(): AllPosts
    {
        return new AllPosts($this->repository->all());
    }
}
