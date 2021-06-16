<?php

declare(strict_types=1);

namespace App\Application\Query\Post;

use App\Application\Exception\PostNotFoundException;
use App\Application\Representation\Post\Post;
use App\Domain\Model\Post\ElasticSearchPostRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostQueryHandler implements MessageHandlerInterface
{
    private ElasticSearchPostRepository $repository;

    public function __construct(ElasticSearchPostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws PostNotFoundException
     */
    public function __invoke(PostQuery $query): Post
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
