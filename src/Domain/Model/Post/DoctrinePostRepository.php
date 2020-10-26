<?php declare(strict_types=1);

namespace App\Domain\Model\Post;

interface DoctrinePostRepository
{
    /**
     * Fetches a Post aggregate by its ID
     * @param string $postId
     * @return Post|null
     */
    public function byId(string $postId): ?Post;

    /**
     * Saves a Post aggregate to a MYSQL persistence
     * @param Post $post
     */
    public function save(Post $post): void;

    /**
     * Deletes a Post aggregate from the persistence
     * @param Post $post
     */
    public function delete(Post $post): void;
}
