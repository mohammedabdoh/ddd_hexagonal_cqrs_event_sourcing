<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Common\Domain\DomainEvent;
use App\Common\Domain\Projection;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class PostWasCreatedProjection implements Projection, MessageHandlerInterface
{
    private Client $client;

    public function __construct(ClientBuilder $clientBuilder)
    {
        $this->client = $clientBuilder->build();
    }

    public function listenTo(): string
    {
        return PostWasCreated::class;
    }

    public function __invoke(PostWasCreated $domainEvent): void
    {
        $this->project($domainEvent);
    }

    public function project(DomainEvent $domainEvent): void
    {
        $this->client->index(
            [
                'index' => 'posts',
                'id' => $domainEvent->postId()->id(),
                'body' => [
                    'title' => $domainEvent->title(),
                    'content' => $domainEvent->content()
                ]
            ]
        );
    }
}
