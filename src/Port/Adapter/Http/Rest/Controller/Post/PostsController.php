<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Post;

use App\Application\Query\PostsQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PostsController.
 *
 * @Route("/posts", methods={"GET"}, name="all_posts")
 */
class PostsController
{
    private PostsQueryHandler $handler;
    private SerializerInterface $serializer;

    public function __construct(PostsQueryHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    public function __invoke(): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize($this->handler->all(), 'json')
        );
    }
}
