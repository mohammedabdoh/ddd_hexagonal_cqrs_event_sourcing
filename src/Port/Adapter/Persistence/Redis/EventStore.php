<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\Redis;

use App\Common\Domain\EventStream;
use Predis\Client;
use Symfony\Component\Serializer\SerializerInterface;

class EventStore
{
    private Client $client;
    private SerializerInterface $serializer;

    /**
     * EventStream constructor.
     *
     * @param Client $client
     * @param SerializerInterface $serializer
     */
    public function __construct(Client $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function append(EventStream $eventStream): void
    {
        foreach ($eventStream as $event) {
            $data = $this->serializer->serialize($event, 'json');

            $date = (new \DateTimeImmutable())->format('YmdHis');

            $this->client->rpush(
                'events:'.$eventStream->getAggregateId(),
                $this->serializer->serialize(
                    new RedisForumEvent(
                        get_class($event),
                        $date,
                        $data
                    ),
                    'json'
                )
            );
        }
    }

    public function hasItem(string $forumId): bool
    {
        return (bool) $this->client->exists('events:'.$forumId);
    }

    public function fromVersion(string $forumId, int $version = 0): EventStream
    {
        $serializedEvents = $this->client->lrange(
            'events:'.$forumId,
            $version,
            -1
        );

        $eventStream = [];

        foreach ($serializedEvents as $serializedEvent) {
            $eventData = $this->serializer->deserialize(
                $serializedEvent,
                RedisForumEvent::class,
                'json'
            );
            $eventStream[] = $this->serializer->deserialize(
                $eventData->getDataRepresentation(),
                $eventData->getClassName(),
                'json'
            );
        }

        return new EventStream($forumId, $eventStream);
    }
}
