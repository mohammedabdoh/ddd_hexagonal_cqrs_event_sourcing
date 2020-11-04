<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\Forum\ChangeForumStatusCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ChangeForumStatusController.
 *
 * @Route("/forum/{id}", methods={"PATCH"}, name="change_forum_status")
 */
class ChangeForumStatusController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request, string $id): Response
    {
        $payload = json_decode($request->getContent(), true);

        $this->bus->dispatch(
            new ChangeForumStatusCommand($id, $payload['closed'])
        );

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
