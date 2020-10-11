<?php

namespace App\Domain;

interface Projection
{
    public function listenTo(): string;
    public function project(DomainEvent $domainEvent): void;
}
