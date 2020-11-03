<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Post\DoctrinePostRepository;

class PostService
{
    private DoctrinePostRepository $repository;

    // TODO: You may use as access point to ports if you are not applying CQRS
    public function __construct(DoctrinePostRepository $postRepository)
    {
        $this->repository = $postRepository;
    }

    public function createPost()
    {
    }
}
