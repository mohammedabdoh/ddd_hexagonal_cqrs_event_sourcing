<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Post;

use App\Application\Command\Post\CreatePostCommand;
use App\Common\CQRSAwareControllerTrait;
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
    use CQRSAwareControllerTrait;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        $payload = $this->payload($request);

        $this->dispatch(
            new CreatePostCommand($payload['title'], $payload['content'])
        );

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
