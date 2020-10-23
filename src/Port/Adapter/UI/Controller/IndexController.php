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
        $hosts = [
            'es01:9200',
        ];
        $this->client = ClientBuilder::create()->setHosts($hosts)->build();
    }
    
    /**
     * @Route("/", methods={"GET"}, name="index_route")
     */
    public function index(): JsonResponse
    {
        return new JsonResponse([]);
    }
}
