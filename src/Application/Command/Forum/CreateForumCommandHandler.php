<?php

declare(strict_types=1);

namespace App\Application\Command\Forum;

use App\Domain\Model\Forum\EventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateForumCommandHandler implements MessageHandlerInterface
{
    private EventSourcedForumRepository $repository;
    private MessageBusInterface $bus;

    public function __construct(EventSourcedForumRepository $repository, MessageBusInterface $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke(CreateForumCommand $command): void
    {
        Forum::setDomainPublisher($this->bus);
        $this->repository->save(
            Forum::createNewForum($command->getTitle(), $command->getClosed())
        );
    }
}
