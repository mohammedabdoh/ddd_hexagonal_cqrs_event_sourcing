<?php

namespace App\Domain;

interface DomainEvent
{
    public function getVersion(): string;
}
