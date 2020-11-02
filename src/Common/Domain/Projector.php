<?php

declare(strict_types=1);

namespace App\Common\Domain;

class Projector
{
    /** @var Projection[] */
    private array $projections;

    /**
     * @param Projection[] $projections
     */
    public function register(array $projections): void
    {
        foreach ($projections as $projection) {
            $this->projections[$projection->listenTo()] = $projection;
        }
    }

    public function project(array $events): void
    {
        foreach ($events as $event) {
            if (isset($this->projections[get_class($event)])) {
                $this->projections[get_class($event)]->project($event);
            }
        }
    }
}
