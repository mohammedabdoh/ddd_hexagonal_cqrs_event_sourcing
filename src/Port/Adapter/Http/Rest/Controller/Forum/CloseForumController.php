<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\Forum\CloseForumCommand;
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
 * @Route("/forum/{id}/close", methods={"PATCH"}, name="close_forum")
 */
class CloseForumController
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
            $this->dispatch(new CloseForumCommand($id));
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException $exception) {
            return $this->responseFromJson(
                new Errors(
                    [new Error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY)]
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
