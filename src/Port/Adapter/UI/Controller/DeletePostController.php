<?php declare(strict_types=1);

namespace App\Port\Adapter\UI\Controller;

use App\Application\Command\DeletePostCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreatePostController
 * @package App\Port\Adapter\UI\Controller
 * @Route("/post/{id}", methods={"DELETE"}, name="delete_post")
 */
class DeletePostController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request, string $id): Response
    {
        $this->bus->dispatch(new DeletePostCommand($id));
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
