<?php

namespace App\Domain;

final class DomainEventPublisher
{
    private static $instance;

    private function __construct(){}

    private function __clone(){}

    
    public static function instance(): self
    {
        if (self::$instance) {
            self::$instance = new self();
        };

        return self::$instance;
    }

    public function publish(DomainEvent $domainEvent): void
    {
        var_dump($domainEvent);
        printf("Domain event has been published");
    }
}
