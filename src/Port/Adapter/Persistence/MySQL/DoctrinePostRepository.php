<?php declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\DoctrinePostRepository as BaseDoctrinePostRepository;
use App\Domain\Projector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;

class DoctrinePostRepository implements BaseDoctrinePostRepository
{
    private EntityManagerInterface $em;
    private Projector $projector;

    public function __construct(EntityManagerInterface $em, Projector $projector)
    {
        $this->em = $em;
        $this->projector = $projector;
    }

    public function byId(string $postId): Post
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

    public function delete(Post $post): void
    {
        $detachedEntity = $this->em->merge($post);
        $this->em->transactional(function(EntityManagerInterface $em) use ($detachedEntity) {
            $em->remove($detachedEntity);
            $em->flush();
        });

        $this->projector->project($post->recordedEvents());
    }
}
