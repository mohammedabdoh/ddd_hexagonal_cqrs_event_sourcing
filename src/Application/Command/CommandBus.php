<?php declare(strict_types=1);

namespace App\Application\Command;

interface CommandBus
{
    public function handle(): void;
}