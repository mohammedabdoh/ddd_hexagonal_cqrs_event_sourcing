<?php

declare(strict_types=1);

namespace App\Application\Command\Forum;

use App\Application\Exception\ForumNotFoundException;
use App\Domain\Model\Forum\EventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;
use App\Domain\Model\Forum\ForumStatusWasChangedProjection;
use App\Common\Domain\Projector;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ChangeForumStatusCommandHandler implements MessageHandlerInterface
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

    /**
     * @param ChangeForumStatusCommand $command
     *
     * @throws ForumNotFoundException
     */
    public function __invoke(ChangeForumStatusCommand $command): void
    {
        if(!$this->repository->exists($command->getForumId())) {
            throw new ForumNotFoundException($command->getForumId());
        }
        $post = Forum::changeForumStatus($command->getForumId(), $command->getClosed());
        $this->repository->save($post);
    }

    private function registerProjection(): void
    {
        $this->projector->register([new ForumStatusWasChangedProjection($this->client)]);
    }
}
