<?php declare(strict_types=1);

namespace App\Common;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Serializer\SerializerInterface;

trait CQRSAwareControllerTrait
{
    private MessageBusInterface $bus;
    private SerializerInterface $serializer;

    /**
     * Dispatches the given message.
     *
     * @param object|Envelope  $message The message or the message pre-wrapped in an envelope
     * @param StampInterface[] $stamps
     */
    public function dispatch($message, array $stamps = []): Envelope
    {
        return $this->bus->dispatch($message, $stamps);
    }

    /**
     * Dispatches the given message and get back the last result.
     *
     * @return mixed
     */
    public function dispatchAndGetResults($message, array $stamps = [])
    {
        return $this->bus->dispatch($message, $stamps)
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function payload(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }

    public function responseFromJson(object $response, int $statusCode = Response::HTTP_OK): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize($response,'json'),
            $statusCode
        );
    }
}