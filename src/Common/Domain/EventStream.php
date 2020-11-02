<?php

declare(strict_types=1);

namespace App\Common\Domain;

use ArrayObject;

class EventStream extends ArrayObject
{
    private string $aggregateId;

    /** @var DomainEvent[] */
    private array $events;

    /**
     * EventStream constructor.
     *
     * @param string $aggregateId
     * @param DomainEvent[] $events
     */
    public function __construct(string $aggregateId, array $events)
    {
        parent::__construct($events);
        $this->aggregateId = $aggregateId;
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }
}
