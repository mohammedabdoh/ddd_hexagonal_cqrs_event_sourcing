<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostWasCreatedProjection;
use App\Domain\Projector;
use App\Port\Adapter\Persistence\MySQL\DoctrinePostRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class CreatePostCommandHandler
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

    public function createAPost(CreatePostCommand $command): void
    {
        $post = Post::createNewPost($command->getTitle(), $command->getContent());
        $this->repository->save($post);
    }

    public function registerProjection(): void
    {
        $this->projector->register([new PostWasCreatedProjection($this->client)]);
    }
}