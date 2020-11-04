<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\Forum\ChangeForumStatusCommand;
use App\Application\Exception\ForumNotFoundException;
use App\Common\Application\Representation\Error;
use App\Common\Application\Representation\Errors;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ChangeForumStatusController.
 *
 * @Route("/forum/{id}", methods={"PATCH"}, name="change_forum_status")
 */
class ChangeForumStatusController
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
        $payload = json_decode($request->getContent(), true);

        try {
            $this->bus->dispatch(
                new ChangeForumStatusCommand($id, $payload['closed'])
            );
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (ForumNotFoundException $exception) {
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
