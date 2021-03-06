<?php

namespace App\Common\Domain;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Messenger\MessageBusInterface;

class AggregateRoot
{
    protected static MessageBusInterface $bus;

    /** @var DomainEvent[] */
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
        try {
            $className = (new ReflectionClass($event))->getShortName();
            $modifier = "apply{$className}";
            $this->$modifier($event);
        } catch (ReflectionException $e) {

        }
    }

    protected function publishThat(DomainEvent $event): void
    {
        self::$bus->dispatch($event);
    }

    public function recordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function clearEvents(): void
    {
        $this->recordedEvents = [];
    }

    public static function setDomainPublisher(MessageBusInterface $bus): void
    {
        self::$bus = $bus;
    }
}
