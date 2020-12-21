<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\Redis;

use App\Common\Domain\EventStream;
use App\Domain\Model\Forum\EventSourcedForumRepository as BaseEventSourcedForumRepository;
use App\Domain\Model\Forum\Forum;

class EventSourcedForumRepository implements BaseEventSourcedForumRepository
{
    private EventStore $eventStore;

    /**
     * EventSourcedForumRepository constructor.
     *
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function exists(string $forumId): bool
    {
        return $this->eventStore->hasItem($forumId);
    }

    public function byId(string $forumId): ?Forum
    {
        return $this->exists($forumId) ?
            Forum::reconstitute($this->eventStore->fromVersion($forumId)) : null;
    }

    public function save(Forum $forum): void
    {
        $events = $forum->recordedEvents();

        $this->eventStore->append(new EventStream($forum->forumId()->getId(), $events));
        $forum->clearEvents();
    }
}
