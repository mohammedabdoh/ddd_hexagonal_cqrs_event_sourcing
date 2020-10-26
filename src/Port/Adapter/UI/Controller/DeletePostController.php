<?php declare(strict_types=1);

namespace App\Port\Adapter\UI\Controller;

use App\Application\Command\DeletePostCommand;
use App\Application\Representation\Error;
use App\Application\Representation\Errors;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CreatePostController
 * @package App\Port\Adapter\UI\Controller
 * @Route("/post/{id}", methods={"DELETE"}, name="delete_post")
 */
class DeletePostController
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
        try {
            $this->bus->dispatch(new DeletePostCommand($id));
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
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
