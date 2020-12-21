<?php

declare(strict_types=1);

namespace App\Application\Command\Post;

use App\Domain\Model\Post\DoctrinePostRepository;
use App\Domain\Model\Post\Post;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreatePostCommandHandler implements MessageHandlerInterface
{
    private MessageBusInterface $bus;
    private DoctrinePostRepository $repository;

    public function __construct(DoctrinePostRepository $repository, MessageBusInterface $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke(CreatePostCommand $command): void
    {
        Post::setDomainPublisher($this->bus);
        $post = Post::createNewPost($command->getTitle(), $command->getContent());
        $this->repository->save($post);
    }
}
