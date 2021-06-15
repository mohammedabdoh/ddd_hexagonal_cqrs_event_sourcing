<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\Forum\CloseForumCommand;
use App\Common\Application\Representation\Error;
use App\Common\Application\Representation\Errors;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/forum/{id}/close", methods={"PATCH"}, name="close_forum")
 */
class CloseForumController
{
    private MessageBusInterface $bus;
    private SerializerInterface $serializer;

    public function __construct(MessageBusInterface $bus, SerializerInterface $serializer)
    {
        $this->bus = $bus;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request, string $id): Response
    {
        try {
            $this->bus->dispatch(new CloseForumCommand($id));
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException $exception) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(
                    new Errors(
                        [new Error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY)]
                    ),
                    'json'
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
