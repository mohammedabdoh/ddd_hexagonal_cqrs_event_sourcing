<?php

namespace App\Port\Adapter\UI\Controller;

use App\Application\Command\CreatePostCommand;
use App\Application\Command\CreatePostCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class CreatePostController
 * @package App\Port\Adapter\UI\Controller
 * @Route("/post", methods={"POST"}, name="create_post")
 */
class CreatePostController extends AbstractController
{
    private Client $client;
    private CreatePostCommandHandler $handler;

    public function __construct(ClientBuilder $clientBuilder, CreatePostCommandHandler $handler)
    {
        $this->client = $clientBuilder->build();
        $this->handler = $handler;
    }

    public function __invoke(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $command = new CreatePostCommand($payload['title'], $payload['content']);
        $this->handler->createAPost($command);
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
