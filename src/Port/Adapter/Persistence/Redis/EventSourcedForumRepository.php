<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\Redis;

use App\Domain\EventStream;
use App\Domain\Model\Forum\EventSourcedForumRepository as BaseEventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;
use App\Domain\Model\Forum\ForumId;
use App\Domain\Projector;

class EventSourcedForumRepository implements BaseEventSourcedForumRepository
{
    private EventStore $eventStore;
    private Projector $projector;

    /**
     * EventSourcedForumRepository constructor.
     * @param EventStore $eventStore
     * @param Projector $projector
     */
    public function __construct(EventStore $eventStore, Projector $projector)
    {
        $this->eventStore = $eventStore;
        $this->projector = $projector;
    }

    public function byId(ForumId $forumId): ?Forum
    {
        return Forum::reconstitute($this->eventStore->fromVersion($forumId->getId()));
    }

    public function save(Forum $forum): void
    {
        $events = $forum->recordedEvents();

        $this->eventStore->append(new EventStream($forum->forumId()->getId(), $events));
        $forum->clearEvents();

        $this->projector->project($events);
    }
}
