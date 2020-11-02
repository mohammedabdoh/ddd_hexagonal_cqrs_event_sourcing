<?php

namespace App\Common\Domain;

interface Projection
{
    public function listenTo(): string;
    public function project(DomainEvent $domainEvent): void;
}
