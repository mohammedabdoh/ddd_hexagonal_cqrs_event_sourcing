<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Domain\DomainEvent;
use Elasticsearch\Client;

class PostWasCreatedProjection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listenTo(): string
    {
        return PostWasCreated::class;
    }

    public function project(PostWasCreated $domainEvent): void
    {
        $this->client->index(
            [
                'index' => 'posts',
                'type' => 'post',
                'id' => $domainEvent->postId(),
                'body' => [
                    'title' => $domainEvent->title(),
                    'content' => $domainEvent->content()
                ]
            ]
        );
    }
}
