<?php declare(strict_types=1);

namespace App\Application\Query\Forum;

use App\Application\Exception\ForumNotFoundException;
use App\Application\Representation\Forum\Forum;
use App\Domain\Model\Forum\EventSourcedForumRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ForumQueryHandler implements MessageHandlerInterface
{
    private EventSourcedForumRepository $repository;

    public function __construct(EventSourcedForumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ForumNotFoundException
     */
    public function __invoke(ForumQuery $query): Forum
    {
        $forum = $this->repository->byId($query->getId());
        if ($forum) {
            return new Forum(
                $forum->forumId()->getId(),
                $forum->title()->getTitle(),
                $forum->closed()
            );
        }
        throw new ForumNotFoundException($query->getId());
    }
}
