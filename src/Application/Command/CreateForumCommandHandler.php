<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Forum\EventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;
use App\Domain\Model\Forum\ForumWasCreatedProjection;
use App\Common\Domain\Projector;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateForumCommandHandler implements MessageHandlerInterface
{
    private EventSourcedForumRepository $repository;
    private Projector $projector;
    private Client $client;

    public function __construct(
        EventSourcedForumRepository $repository,
        Projector $projector,
        ClientBuilder $clientBuilder
    ) {
        $this->repository = $repository;
        $this->projector = $projector;
        $this->client = $clientBuilder->build();
        $this->registerProjection();
    }

    public function __invoke(CreateForumCommand $command): void
    {
        $post = Forum::createNewForum($command->getTitle(), $command->getClosed());
        $this->repository->save($post);
    }

    private function registerProjection(): void
    {
        $this->projector->register([new ForumWasCreatedProjection($this->client)]);
    }
}
