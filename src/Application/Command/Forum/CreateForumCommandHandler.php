<?php

declare(strict_types=1);

namespace App\Application\Command\Forum;

use App\Application\Representation\Forum\ForumId;
use App\Domain\Model\Forum\EventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;
use App\Domain\Model\Forum\ForumTitle;
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

    public function __invoke(CreateForumCommand $command): ForumId
    {
        Forum::setDomainPublisher($this->bus);

        $forum = Forum::createNewForum(ForumTitle::create($command->getTitle()), $command->getClosed());

        $this->repository->save($forum);

        return new ForumId($forum->forumId()->getId());
    }
}
