<?php declare(strict_types=1);

namespace App\Port\Adapter\UI\Controller;

use App\Application\Exception\PostNotFoundException;
use App\Application\Query\PostQuery;
use App\Application\Query\PostQueryHandler;
use App\Application\Representation\Error;
use App\Application\Representation\Errors;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PostsController
 * @package App\Port\Adapter\UI\Controller
 * @Route("/post/{id}", methods={"GET"}, name="fetch_a_post")
 */
class PostController
{
    private PostQueryHandler $handler;
    private SerializerInterface $serializer;

    public function __construct(PostQueryHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    public function __invoke(string $id): Response
    {
        try {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(
                    $this->handler->byId(new PostQuery($id)),
                    'json'
                )
            );
        } catch (PostNotFoundException $exception) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(
                    new Errors(
                        [new Error($exception->getMessage(), Response::HTTP_NOT_FOUND)]
                    ),
                    'json'
                ),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
