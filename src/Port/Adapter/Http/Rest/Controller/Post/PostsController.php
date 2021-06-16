<?php

declare(strict_types=1);

namespace App\Port\Adapter\Http\Rest\Controller\Post;

use App\Application\Query\Post\PostsQuery;
use App\Common\CQRSAwareControllerTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PostsController.
 *
 * @Route("/posts", methods={"GET"}, name="all_posts")
 */
class PostsController
{
    use CQRSAwareControllerTrait;

    public function __construct(MessageBusInterface $bus, SerializerInterface $serializer)
    {
        $this->bus = $bus;
        $this->serializer = $serializer;
    }

    public function __invoke(): Response
    {
        return $this->responseFromJson(
            $this->dispatchAndGetResults(new PostsQuery())
        );
    }
}
