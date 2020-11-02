<?php declare(strict_types=1);

namespace App\Domain;

abstract class EventSourcedAggregateRoot extends AggregateRoot
{
    abstract public static function reconstitute(EventStream $eventStream): EventSourcedAggregateRoot;

    public function replay(EventStream $eventStream): void
    {
        foreach ($eventStream as $streamItem) {
            $this->applyThat($streamItem);
        }
    }
}
