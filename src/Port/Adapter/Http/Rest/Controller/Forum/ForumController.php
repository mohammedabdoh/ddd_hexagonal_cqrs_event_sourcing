<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Query\Forum\ForumQuery;
use App\Common\Application\Representation\Error;
use App\Common\Application\Representation\Errors;
use App\Application\Representation\Forum\Forum;
use App\Common\CQRSAwareControllerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ForumController.
 *
 * @Route("/forum/{id}", methods={"GET"}, name="fetch_a_forum")
 */
class ForumController
{
    use CQRSAwareControllerTrait;

    public function __construct(SerializerInterface $serializer, MessageBusInterface $bus)
    {
        $this->serializer = $serializer;
        $this->bus = $bus;
    }

    public function __invoke(string $id): Response
    {
        try {
            return $this->responseFromJson(
                $this->dispatchAndGetResults(new ForumQuery($id))
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
