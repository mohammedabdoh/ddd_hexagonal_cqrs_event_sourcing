<?php

declare(strict_types=1);

namespace App\Application\Query\Post;

use App\Application\Representation\Post\AllPosts;
use App\Domain\Model\Post\ElasticSearchPostRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostsQueryHandler implements MessageHandlerInterface
{
    private ElasticSearchPostRepository $repository;

    public function __construct(ElasticSearchPostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(PostsQuery $postsQuery): AllPosts
    {
        return new AllPosts($this->repository->all());
    }
}
