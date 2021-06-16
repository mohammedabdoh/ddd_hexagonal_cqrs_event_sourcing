<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Post;

use App\Application\Query\Post\PostQuery;
use App\Common\Application\Representation\Error;
use App\Common\Application\Representation\Errors;
use App\Common\CQRSAwareControllerTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PostsController.
 *
 * @Route("/post/{id}", methods={"GET"}, name="fetch_a_post")
 */
class PostController
{
    use CQRSAwareControllerTrait;

    public function __construct(MessageBusInterface $bus, SerializerInterface $serializer)
    {
        $this->bus = $bus;
        $this->serializer = $serializer;
    }

    public function __invoke(string $id): Response
    {
        try {
            return $this->responseFromJson(
                $this->dispatchAndGetResults(new PostQuery($id))
            );
        } catch (HandlerFailedException $exception) {
            return $this->responseFromJson(
                new Errors(
                    [new Error($exception->getMessage(), Response::HTTP_NOT_FOUND)]
                ),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
