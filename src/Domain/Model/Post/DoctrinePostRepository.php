<?php declare(strict_types=1);

namespace App\Domain\Model\Post;

interface DoctrinePostRepository
{
    public function byId(string $postId): Post;
    public function save(Post $post): void;
    public function delete(Post $post): void;
}
