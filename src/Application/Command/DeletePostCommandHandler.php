<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\DoctrinePostRepository;
use App\Domain\Model\Post\PostId;
use App\Domain\Model\Post\PostWasDeletedProjection;
use App\Domain\Projector;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class DeletePostCommandHandler implements MessageHandlerInterface
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

    public function __invoke(DeletePostCommand $command): void
    {
        $this->repository->delete(
            Post::deletePost(
                new PostId($command->getId())
            )
        );
    }

    private function registerProjection(): void
    {
        $this->projector->register([new PostWasDeletedProjection($this->client)]);
    }
}