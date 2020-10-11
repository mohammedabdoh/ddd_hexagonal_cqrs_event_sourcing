<?php

namespace App\Domain;

use ReflectionClass;

class AggregateRoot
{
    /** DomainEvent[] */
    private array $recordedEvents = [];

    protected function recordApplyAndPublish(DomainEvent $event): void
    {
        $this->recordThat($event);
        $this->applyThat($event);
        $this->publishThat($event);
    }

    protected function recordThat(DomainEvent $event): void
    {
        array_push($this->recordedEvents, $event);
    }

    protected function applyThat(DomainEvent $event): void
    {
        $className = (new ReflectionClass($event))->getShortName();
        $modifier = "apply{$className}";
        $this->$modifier($event);
    }

    protected function publishThat(DomainEvent $event): void
    {
        DomainEventPublisher::instance()->publish($event);
    }

    public function recordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function clearEvents(): void
    {
        $this->recordedEvents = [];
    }
}
