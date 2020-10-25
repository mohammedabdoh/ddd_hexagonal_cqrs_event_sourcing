<?php declare(strict_types=1);

namespace App\Port\Adapter\Persistence\ElasticSearch;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostId;
use App\Domain\Model\Post\ElasticSearchPostRepository as BaseElasticSearchPostRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchPostRepository implements BaseElasticSearchPostRepository
{
    private Client $client;

    public function __construct(ClientBuilder $clientBuilder)
    {
        $this->client = $clientBuilder->build();
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
