<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\CreateForumCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreatePostController.
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
        $this->bus->dispatch(
            new CreateForumCommand($payload['title'], $payload['closed'])
        );

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
