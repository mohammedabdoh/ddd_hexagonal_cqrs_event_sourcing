<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\DomainEvent;
use App\Common\Domain\Projection;
use Elasticsearch\Client;

class ForumStatusWasChangedProjection implements Projection
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
        $this->client->update(
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
