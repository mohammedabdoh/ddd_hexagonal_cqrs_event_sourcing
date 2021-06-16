<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Post;

use App\Application\Command\Post\DeletePostCommand;
use App\Common\Application\Representation\Error;
use App\Common\Application\Representation\Errors;
use App\Common\CQRSAwareControllerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CreatePostController.
 *
 * @Route("/post/{id}", methods={"DELETE"}, name="delete_post")
 */
class DeletePostController
{
    use CQRSAwareControllerTrait;

    public function __construct(MessageBusInterface $bus, SerializerInterface $serializer)
    {
        $this->bus = $bus;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request, string $id): Response
    {
        try {
            $this->dispatch(new DeletePostCommand($id));

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
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
