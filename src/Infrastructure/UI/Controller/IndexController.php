<?php

namespace App\Infrastructure\UI\Controller;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }
    
    /**
     * @Route("/", methods={"GET"}, name="index_route")
     */
    public function index(): JsonResponse
    {
        $response = $this->client->index([
            'index' => 'my_index',
            'id' => (string) Uuid::uuid4(),
            'body' => ['Name' => 'Mohammed Abdoh', 'id' => 'reserved']
        ]);
        return new JsonResponse($response);
    }

    public function show(Request $request): JsonResponse
    {
        return new JsonResponse($request->headers);
    }
}
