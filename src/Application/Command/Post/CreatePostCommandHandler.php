<?php

declare(strict_types=1);

namespace App\Application\Command\Post;

use App\Common\Domain\Projector;
use App\Domain\Model\Post\DoctrinePostRepository;
use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostWasCreatedProjection;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreatePostCommandHandler implements MessageHandlerInterface
{
    private DoctrinePostRepository $repository;
    private Projector $projector;
    private Client $client;

    public function __construct(
        DoctrinePostRepository $repository,
        Projector $projector,
        ClientBuilder $clientBuilder
    ) {
        $this->repository = $repository;
        $this->projector = $projector;
        $this->client = $clientBuilder->build();
        $this->registerProjection();
    }

    public function __invoke(CreatePostCommand $command): void
    {
        $post = Post::createNewPost($command->getTitle(), $command->getContent());
        $this->repository->save($post);
    }

    private function registerProjection(): void
    {
        $this->projector->register([new PostWasCreatedProjection($this->client)]);
    }
}
