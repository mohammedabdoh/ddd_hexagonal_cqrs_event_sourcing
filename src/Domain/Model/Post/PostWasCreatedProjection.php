<?php declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Common\Domain\DomainEvent;
use App\Common\Domain\Projection;
use Elasticsearch\Client;

class PostWasCreatedProjection implements Projection
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

    public function project(DomainEvent $domainEvent): void
    {
        $this->client->index(
            [
                'index' => 'posts',
                'type' => 'post',
                'id' => $domainEvent->postId()->id(),
                'body' => [
                    'title' => $domainEvent->title(),
                    'content' => $domainEvent->content()
                ]
            ]
        );
    }
}
