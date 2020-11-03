<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Controller\Post;

use App\Application\Command\CreatePostCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreatePostController.
 *
 * @Route("/post", methods={"POST"}, name="create_post")
 */
class CreatePostController
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
            new CreatePostCommand($payload['title'], $payload['content'])
        );

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
