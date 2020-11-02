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

            $this->client->set(
                'events:'.$eventStream->getAggregateId(),
                $this->serializer->serialize([
                    'type' => get_class($event),
                    'created_on' => $date,
                    'data' => $data,
                ], 'json')
            );
        }
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
                'array',
                'json'
            );
            $eventStream[] = $this->serializer->deserialize(
                $eventData['data'],
                'array',
                'json'
            );
        }

        return new EventStream($forumId, $eventStream);
    }
}
