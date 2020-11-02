<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\ElasticSearch;

use App\Domain\Model\Post\ElasticSearchPostRepository as BaseElasticSearchPostRepository;
use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostId;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticSearchPostRepository implements BaseElasticSearchPostRepository
{
    private Client $client;

    public function __construct(ClientBuilder $clientBuilder)
    {
        $this->client = $clientBuilder->build();
    }

    public function byId(string $id): ?Post
    {
        $foundPost = null;

        try {
            $result = $this->client->get(
                [
                    'index' => 'posts',
                    'type' => 'post',
                    'id' => $id,
                ]
            );
            $foundPost = Post::buildAPost(
                new PostId($result['_id']),
                $result['_source']['title'],
                $result['_source']['content']
            );
        } catch (Missing404Exception $exception) {
        }

        return $foundPost;
    }

    public function all(): array
    {
        $foundPosts = [];
        $result = $this->client->search(
            [
                'index' => 'posts',
                'type' => 'post',
            ]
        );
        if (isset($result['hits']['hits'])) {
            $posts = $result['hits']['hits'];
            foreach ($posts as $post) {
                array_push($foundPosts, Post::buildAPost(
                    new PostId($post['_id']),
                    $post['_source']['title'],
                    $post['_source']['content']
                ));
            }
        }

        return $foundPosts;
    }
}
