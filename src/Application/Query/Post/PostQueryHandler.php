<?php

declare(strict_types=1);

namespace App\Application\Query\Post;

use App\Application\Exception\PostNotFoundException;
use App\Application\Representation\Post\Post;
use App\Domain\Model\Post\ElasticSearchPostRepository;

class PostQueryHandler
{
    private ElasticSearchPostRepository $repository;

    public function __construct(ElasticSearchPostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PostQuery $query
     * @return Post
     * @throws PostNotFoundException
     */
    public function byId(PostQuery $query): Post
    {
        $post = $this->repository->byId($query->getId());
        if ($post) {
            return new Post(
                $post->getPostId()->id(),
                $post->getTitle(),
                $post->getContent()
            );
        }
        throw new PostNotFoundException($query->getId());
    }
}
