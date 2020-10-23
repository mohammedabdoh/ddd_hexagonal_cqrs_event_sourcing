<?php

namespace App\Port\Adapter\UI\Controller;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $response = $this->client->search([
            'index' => 'my_index',
        ]);
        return new JsonResponse($response['hits']['hits'][2]['_source']['Name']);
    }
}
