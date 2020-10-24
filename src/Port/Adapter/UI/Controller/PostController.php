<?php

namespace App\Port\Adapter\UI\Controller;

use App\Application\Query\PostQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class PostController
 * @package App\Port\Adapter\UI\Controller
 * @Route("/posts", methods={"GET"}, name="all_posts")
 */
class PostController extends AbstractController
{
    private Client $client;
    private PostQueryHandler $handler;

    public function __construct(ClientBuilder $clientBuilder, PostQueryHandler $handler)
    {
        $this->client = $clientBuilder->build();
        $this->handler = $handler;
    }

    public function __invoke(): Response
    {
        // TODO: Use JSM Serializer
        $posts = $this->handler->all()->getPosts();
        return new JsonResponse($posts, Response::HTTP_CREATED);
    }
}
