<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Forum;

use App\Application\Command\Forum\CreateForumCommand;
use App\Common\CQRSAwareControllerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Representation\Forum\ForumId;

/**
 * Class CreateForumController.
 *
 * @Route("/forum", methods={"POST"}, name="create_forum")
 */
class CreateForumController
{
    use CQRSAwareControllerTrait;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        $payload = $this->payload($request);

        /** @var ForumId $forumId */
        $forumId = $this->dispatchAndGetResults(
            new CreateForumCommand($payload['title'], $payload['closed'])
        );

        return new JsonResponse(null, Response::HTTP_CREATED, ['X-RESOURCE-ID' => $forumId->getId()]);
    }
}
