<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\Forum\CreateForumCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Representation\Forum\ForumId;

/**
 * Class CreateForumController.
 *
 * @Route("/forum", methods={"POST"}, name="create_forum")
 */
class CreateForumController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        $envelop = $this->bus->dispatch(new CreateForumCommand($payload['title'], $payload['closed']));

        /** @var ForumId $forumId */
        $forumId = $envelop->last(HandledStamp::class)->getResult();

        return new JsonResponse(null, Response::HTTP_CREATED, ['X-RESOURCE-ID' => $forumId->getId()]);
    }
}
