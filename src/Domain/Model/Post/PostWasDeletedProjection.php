<?php declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Domain\DomainEvent;
use App\Domain\Projection;
use Elasticsearch\Client;

class PostWasDeletedProjection implements Projection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listenTo(): string
    {
        return PostWasDeleted::class;
    }

    public function project(DomainEvent $domainEvent): void
    {
        $this->client->delete(
            [
                'index' => 'posts',
                'type' => 'post',
                'id' => $domainEvent->postId()->id(),
            ]
        );
    }
}
