<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostRepository;
use App\Domain\Projector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;

class DoctrinePostRepository implements PostRepository
{
    private EntityManagerInterface $em;
    private Projector $projector;

    public function __construct(EntityManagerInterface $em, Projector $projector)
    {
        $this->em = $em;
        $this->projector = $projector;
    }

    public function byId(int $postId): Post
    {
        try {
            return $this->em->find(Post::class, $postId);
        } catch (OptimisticLockException $e) {
        } catch (TransactionRequiredException $e) {
        } catch (ORMException $e) {
        }
    }

    public function save(Post $post): void
    {
        $this->em->transactional(function(EntityManagerInterface $em) use ($post) {
            $em->persist($post);
            $em->flush();
            // TODO: save events here
        });

        $this->projector->project($post->recordedEvents());
    }
}
