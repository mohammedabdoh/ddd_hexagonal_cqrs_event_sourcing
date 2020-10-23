<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Post\PostRepository;

class PostService
{
    private PostRepository $repository;

    public function __construct(PostRepository $postRepository)
    {
        $this->repository = $postRepository;
    }

    public function createPost()
    {
    }
}
