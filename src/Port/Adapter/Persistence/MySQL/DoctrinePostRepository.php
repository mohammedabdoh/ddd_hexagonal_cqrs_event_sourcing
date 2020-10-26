<?php declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\DoctrinePostRepository as BaseDoctrinePostRepository;
use App\Domain\Projector;
use Doctrine\ORM\EntityManagerInterface;

class DoctrinePostRepository implements BaseDoctrinePostRepository
{
    private EntityManagerInterface $em;
    private Projector $projector;

    public function __construct(EntityManagerInterface $em, Projector $projector)
    {
        $this->em = $em;
        $this->projector = $projector;
    }

    public function byId(string $postId): ?Post
    {
        $post = null;
        try {
            $post = $this->em->find(Post::class, $postId);
        } catch (\Exception $e) {

        }
        return $post;
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
        $this->em->transactional(function(EntityManagerInterface $em) use ($post) {
            $em->remove($post);
            $em->flush();
        });

        $this->projector->project($post->recordedEvents());
    }
}
