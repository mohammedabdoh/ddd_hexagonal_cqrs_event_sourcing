<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Post\DoctrinePostRepository;

class PostService
{
    private DoctrinePostRepository $repository;

    public function __construct(DoctrinePostRepository $postRepository)
    {
        $this->repository = $postRepository;
    }

    public function createPost()
    {
    }
}
