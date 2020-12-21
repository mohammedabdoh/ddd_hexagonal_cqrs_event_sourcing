<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL;

use App\Domain\Model\Post\DoctrinePostRepository as BaseDoctrinePostRepository;
use App\Domain\Model\Post\Post;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class DoctrinePostRepository implements BaseDoctrinePostRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function byId(string $postId): ?Post
    {
        $post = null;
        try {
            $post = $this->em->find(Post::class, $postId);
        } catch (Exception $e) {
        }

        return $post;
    }

    public function save(Post $post): void
    {
        $this->em->transactional(function (EntityManagerInterface $em) use ($post) {
            $em->persist($post);
            $em->flush();
        });
    }

    public function delete(Post $post): void
    {
        $this->em->transactional(function (EntityManagerInterface $em) use ($post) {
            $em->remove($post);
            $em->flush();
        });
    }
}
