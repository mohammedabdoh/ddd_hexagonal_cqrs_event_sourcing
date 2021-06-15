<?php

declare(strict_types=1);

namespace App\Application\Command\Forum;

use App\Application\Exception\ForumNotFoundException;
use App\Domain\Model\Forum\EventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CloseForumCommandHandler implements MessageHandlerInterface
{
    private EventSourcedForumRepository $repository;
    private MessageBusInterface $bus;

    public function __construct(EventSourcedForumRepository $repository, MessageBusInterface $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    /**
     * @param CloseForumCommand $command
     *
     * @throws ForumNotFoundException
     */
    public function __invoke(CloseForumCommand $command): void
    {
        if(!$this->repository->exists($command->getForumId())) {
            throw new ForumNotFoundException($command->getForumId());
        }
        Forum::setDomainPublisher($this->bus);

        $forum = $this->repository->byId($command->getForumId());
        $forum->closeForum();

        $this->repository->save($forum);
    }
}
