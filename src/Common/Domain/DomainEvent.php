<?php

namespace App\Common\Domain;

interface DomainEvent
{
    public function getVersion(): string;
}
