<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

use App\Common\Domain\DomainEvent;
use App\Common\Domain\Projection;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ForumTitleWasChangedProjection implements Projection, MessageHandlerInterface
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

    public function __invoke(ForumTitleWasChanged $forumWasCreated): void
    {
        $this->project($forumWasCreated);
    }

    public function project(DomainEvent $domainEvent): void
    {
        $this->client->index(
            [
                'index' => 'forums',
                'type' => 'forum',
                'id' => $domainEvent->getForumId()->getId(),
                'body' => [
                    'title' => $domainEvent->getTitle()->getTitle(),
                ],
            ]
        );
    }
}
