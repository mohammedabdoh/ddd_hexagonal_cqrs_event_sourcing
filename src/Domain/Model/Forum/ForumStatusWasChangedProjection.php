<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\DomainEvent;
use App\Common\Domain\Projection;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ForumStatusWasChangedProjection implements Projection, MessageHandlerInterface
{
    private Client $client;

    public function __construct(ClientBuilder $clientBuilder)
    {
        $this->client = $clientBuilder->build();
    }

    public function listenTo(): string
    {
        return ForumWasCreated::class;
    }

    public function __invoke(ForumStatusWasChanged $forumStatusWasChanged): void
    {
        $this->project($forumStatusWasChanged);
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
