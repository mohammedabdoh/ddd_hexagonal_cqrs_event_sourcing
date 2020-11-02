<?php

namespace App\Common\Domain;

final class DomainEventPublisher
{
    private static ?self $instance = null;

    private function __construct(){}

    private function __clone(){}

    public static function instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function publish(DomainEvent $domainEvent): string
    {
        return "Domain event has been published {$domainEvent->getVersion()}";
    }
}
