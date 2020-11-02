<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Domain\DomainEvent;
use App\Domain\Projection;
use Elasticsearch\Client;

class ForumWasCreatedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listenTo(): string
    {
        return ForumWasCreated::class;
    }

    public function project(DomainEvent $domainEvent): void
    {
        $this->client->index(
            [
                'index' => 'forums',
                'type' => 'forum',
                'id' => $domainEvent->getForumId()->getId(),
                'body' => [
                    'title' => $domainEvent->getTitle(),
                    'closed' => $domainEvent->getClosed(),
                ],
            ]
        );
    }
}
