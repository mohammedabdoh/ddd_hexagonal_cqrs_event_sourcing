<?php

declare(strict_types=1);

namespace App\Application\Command\Post;

use App\Application\Exception\PostNotFoundException;
use App\Domain\Model\Post\DoctrinePostRepository;
use App\Domain\Model\Post\Post;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeletePostCommandHandler implements MessageHandlerInterface
{
    private DoctrinePostRepository $repository;
    private MessageBusInterface $bus;

    public function __construct(DoctrinePostRepository $repository, MessageBusInterface $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    /**
     * @param DeletePostCommand $command
     * @throws PostNotFoundException
     */
    public function __invoke(DeletePostCommand $command): void
    {
        $post = $this->repository->byId($command->getId());
        if ($post) {
            Post::setDomainPublisher($this->bus);
            $this->repository->delete(Post::deletePost($post));
            return;
        }
        throw new PostNotFoundException($command->getId());
    }
}
